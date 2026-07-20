<?php

namespace App\Controllers;

use App\Models\BaremesFrais;

class OperationsController extends BaseController
{
    public function depot()
    {
        $montant = (float) $this->request->getPost('montant');
        $clientId = session()->get('user_id');

        if (empty($montant) || $montant <= 0) {
            return redirect()->back()->with('error', 'Le montant doit être supérieur à 0.');
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        $db->table('clients')
            ->where('id', $clientId)
            ->increment('solde', $montant);

        $dataTransaction = [
            'type_operation_id'      => 1, 
            'client_source_id'       => null,
            'client_destination_id'  => $clientId,
            'montant_brut'           => $montant,
            'frais_appliques'        => 0,
            'montant_net'            => $montant,
            'date_creation'          => date('Y-m-d H:i:s')
        ];
        $db->table('transactions')->insert($dataTransaction);

        if ($db->transStatus() === false) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Une erreur est survenue lors du dépôt.');
        } else {
            $db->transCommit();
            return redirect()->back()->with('success', 'Dépôt de ' . $montant . ' effectué avec succès !');
        }
    }

    public function retrait()
    {
        $montant = (float) $this->request->getPost('montant');
        $clientId = session()->get('user_id');

        if (empty($montant) || $montant <= 0) {
            return redirect()->back()->with('error', 'Le montant doit être supérieur à 0.');
        }

        $baremeModel = new BaremesFrais();
        $frais = $baremeModel->getFrais(2, $montant); 
        $totalAObtenir = $montant + $frais;

        $db = \Config\Database::connect();

    
        $client = $db->table('clients')->where('id', $clientId)->get()->getRowArray();
        
        if (!$client || $client['solde'] < $totalAObtenir) {
            return redirect()->back()->with('error', "Solde insuffisant. Il vous faut un total de {$totalAObtenir} (Montant: {$montant} + Frais: {$frais}) pour effectuer cette opération.");
        }

    
        $db->transBegin();

    
        $db->table('clients')
            ->where('id', $clientId)
            ->decrement('solde', $totalAObtenir);

        $dataTransaction = [
            'type_operation_id'      => 2, 
            'client_source_id'       => $clientId,
            'client_destination_id'  => null,
            'montant_brut'           => $montant,
            'frais_appliques'        => $frais,
            'date_creation'          => date('Y-m-d H:i:s')
        ];
        $db->table('transactions')->insert($dataTransaction);

        if ($db->transStatus() === false) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Une erreur est survenue lors du retrait.');
        } else {
            $db->transCommit();
            return redirect()->back()->with('success', "Retrait de {$montant} effectué. Frais appliqués : {$frais}. Total débité : {$totalAObtenir}.");
        }
    }

    public function transfert()
    {
        $numeroDestinataire = $this->request->getPost('numero_destinataire');
        $montant = (float) $this->request->getPost('montant');
        $clientSourceId = session()->get('user_id');

        if (empty($montant) || $montant <= 0) {
            return redirect()->back()->with('error', 'Le montant doit être supérieur à 0.');
        }

        if (empty($numeroDestinataire)) {
            return redirect()->back()->with('error', 'Le numéro du destinataire est obligatoire.');
        }

        $db = \Config\Database::connect();
        $destinataire = $db->table('clients')->where('numero_telephone', $numeroDestinataire)->get()->getRowArray();
        if (!$destinataire) {
            return redirect()->back()->with('error', "Le numéro destinataire n'existe pas chez cet opérateur.");
        }

        $clientDestinationId = $destinataire['id'];

        if ($clientSourceId == $clientDestinationId) {
            return redirect()->back()->with('error', "Vous ne pouvez pas effectuer un transfert vers votre propre numéro.");
        }

        $baremeModel = new BaremesFrais();
        $frais = $baremeModel->getFrais(3, $montant); 
        $totalADebiter = $montant + $frais;

        $source = $db->table('clients')->where('id', $clientSourceId)->get()->getRowArray();
        if (!$source || $source['solde'] < $totalADebiter) {
            return redirect()->back()->with('error', "Solde insuffisant. Il vous faut un total de {$totalADebiter} (Montant: {$montant} + Frais: {$frais}) pour ce transfert.");
        }

        $db->transBegin();

        $db->table('clients')
            ->where('id', $clientSourceId)
            ->decrement('solde', $totalADebiter);

        $db->table('clients')
            ->where('id', $clientDestinationId)
            ->increment('solde', $montant);

        $dataTransaction = [
            'type_operation_id'      => 3, 
            'client_source_id'       => $clientSourceId,
            'client_destination_id'  => $clientDestinationId,
            'montant_brut'           => $montant,
            'frais_appliques'        => $frais,
            'montant_net'            => $totalADebiter,
            'date_creation'          => date('Y-m-d H:i:s')
        ];
        $db->table('transactions')->insert($dataTransaction);

        if ($db->transStatus() === false) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Une erreur réseau est survenue lors du transfert.');
        } else {
            $db->transCommit();
            return redirect()->back()->with('success', "Transfert de {$montant} vers le {$numeroDestinataire} effectué avec succès. Frais : {$frais}.");
        }
    }
}