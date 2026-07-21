<?php

namespace App\Controllers;

use App\Models\BaremesFrais;
use App\Models\Reseaux;

class OperationsController extends BaseController
{
      public function estNumeroValide($telephone)
    {
        
        $telephone = trim($telephone);

        if (!is_numeric($telephone) || strlen($telephone) !== 10) {
            return false;
        }

        $prefixe = substr($telephone, 0, 3);

        $db = \Config\Database::connect();
        $config = $db->table('configurations')
                     ->where('prefixe', $prefixe)
                     ->get()
                     ->getRowArray();

        return $config !== null;
    }
    public function depot()
    {
        $montant = (float) $this->request->getPost('montant');
        $clientId = session()->get('client_id');

        if (empty($montant) || $montant <= 0) {
            return redirect()->back()->with('error', 'Le montant doit être supérieur à 0.');
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        $db->table('clients')
            ->where('id', $clientId)
            ->increment('solde', $montant);

        $dataTransaction = [
            'type_operation_id'      => 1, // 1 = Dépôt
            'client_source_id'       => null,
            'client_destination_id'  => $clientId,
            'montant_brut'           => $montant,
            'frais'        => 0,
            'date_creation'          => date('Y-m-d H:i:s')
        ];
        $db->table('mouvements')->insert($dataTransaction);

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
        $clientId = session()->get('client_id');

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
            'frais'        => $frais,
            'date_creation'          => date('Y-m-d H:i:s')
        ];
        $db->table('mouvements')->insert($dataTransaction);

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
        $clientSourceId = session()->get('client_id');

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
            'frais'        => $frais,
            'date_creation'          => date('Y-m-d H:i:s')
        ];
        $db->table('mouvements')->insert($dataTransaction);


        if ($db->transStatus() === false) {
            $db->transRollback();
            return redirect()->back()->with('error', 'Une erreur réseau est survenue lors du transfert.');
        } else {
            $db->transCommit();
            return redirect()->back()->with('success', "Transfert de {$montant} vers le {$numeroDestinataire} effectué avec succès. Frais : {$frais}.");
        }
    }
    
   public function effectuerTransfert()
{
    $clientId = session()->get('client_id');
    $db = \Config\Database::connect();

    $numerosDest = $this->request->getPost('numero_destinataire');
    $montantGlobal = (float) $this->request->getPost('montant');
    
    if (!is_array($numerosDest)) {
        $numerosDest = [$numerosDest];
    }

    // Nettoyage des numéros
    $numerosDest = array_filter(array_map('trim', $numerosDest));

    if (empty($numerosDest) || $montantGlobal <= 0) {
        return redirect()->back()->with('error', 'Veuillez renseigner au moins un numéro et un montant valide.');
    }

    $nombreDestinataires = count($numerosDest);
    $estEnvoiMultiple = $nombreDestinataires > 1;

    // L'option frais de retrait est disponible uniquement pour un envoi unique
    $caseRetraitCochee = !$estEnvoiMultiple && ($this->request->getPost('retrait') === '1');

    // On divise le montant global par le nombre de destinataires
    $montantParDestinataire = $montantGlobal / $nombreDestinataires;

    $baremeModel = new BaremesFrais();
    $reseau = new Reseaux();

    $coutTotalEmetteur = 0;
    $detailsTransferts = [];

    foreach ($numerosDest as $numero) {

        // 1. Vérification du préfixe
        if (!$this->estNumeroValide($numero)) {
            return redirect()->back()->with('error', "Le numéro '{$numero}' n'a pas un préfixe réseau valide.");
        }

        // 2. Vérification réseau local ou externe
        $estLocal = ($reseau->estNumeroLocal($numero) == 1);
        $dest = $db->table('clients')->where('numero_telephone', $numero)->get()->getRowArray();

        // Numéro local mais introuvable en BDD
        if ($estLocal && !$dest) {
            return redirect()->back()->with('error', "Le numéro local {$numero} n'est attribué à aucun client.");
        }

        // Sécurité auto-transfert
        if ($dest && $clientId == $dest['id']) {
            return redirect()->back()->with('error', "Vous ne pouvez pas effectuer un transfert vers votre propre numéro.");
        }

        // 3. Calcul des frais selon la part individuelle
        $fraisTransfert = (float) $baremeModel->getFrais(3, $montantParDestinataire);
        if($estLocal){
            $pourcentage = (float) $reseau->getCommissionTransfert($numero);
            $reduction = $fraisTransfert * ($pourcentage / 100);
            $fraisTransfert =  $fraisTransfert - $reduction;
        }
        
        
        $fraisRetraitOptionnel = 0;
        if ($caseRetraitCochee && $estLocal ) {
            $fraisRetraitOptionnel = (float) $baremeModel->getFrais(2, $montantParDestinataire);
        }


        $commission = 0;
        if (!$estLocal) {
            $pourcentage = (float) $reseau->getCommissionTransfert($numero);
            $commission = $montantParDestinataire * ($pourcentage / 100);
        }

        // if ($estLocal) {
        //     $pourcentage = (float) $reseau->getCommissionTransfert($numero);
        //     $reduction = $fraisTransfert * ($pourcentage / 100);
        //     $fraisTransfert =  $fraisTransfert - $reduction;
        // }

        // Cumul des frais pour cette part
        $fraisTotaux = $fraisTransfert + $fraisRetraitOptionnel + $commission;
        $coutPourCeDest = $montantParDestinataire + $fraisTotaux;
        
        $coutTotalEmetteur += $coutPourCeDest;

        $montantPourDestinataire = $montantParDestinataire + $fraisRetraitOptionnel;

        $detailsTransferts[] = [
            'destinataire'        => $dest,
            'numero'              => $numero,
            'est_local'           => $estLocal,
            'montant_brut'        => $montantParDestinataire,
            'frais_totaux'        => $fraisTransfert,
            'montant_recu_solde'  => $montantPourDestinataire,
            'total_debit'         => $coutPourCeDest
        ];
    }

    // 4. Vérification de la provision globale
    $emetteur = $db->table('clients')->where('id', $clientId)->get()->getRowArray();
    if (!$emetteur || $emetteur['solde'] < $coutTotalEmetteur) {
        return redirect()->back()->with('error', "Solde insuffisant. Il vous faut un total de {$coutTotalEmetteur} Ar (montant + frais/commissions) pour effectuer cette opération.");
    }

    // 5. Transaction BDD
    $db->transBegin();

    // Débit global sur l'émetteur
    $db->table('clients')->where('id', $clientId)->decrement('solde', $coutTotalEmetteur);

    foreach ($detailsTransferts as $transfert) {
        // Crédit du destinataire s'il est local
        if ($transfert['est_local'] && $transfert['destinataire'] !== null) {
            $db->table('clients')
               ->where('id', $transfert['destinataire']['id'])
               ->increment('solde', $transfert['montant_recu_solde']);
        }

        // Historisation
        $db->table('mouvements')->insert([
            'type_operation_id'     => 3,
            'client_source_id'      => $clientId,
            'client_destination_id' => $transfert['est_local'] ? $transfert['destinataire']['id'] : null,
            'montant_brut'          => $transfert['montant_brut'],
            'frais'                 => $transfert['frais_totaux'],
            'date_creation'         => date('Y-m-d H:i:s')
        ]);
    }

    if ($db->transStatus() === false) {
        $db->transRollback();
        return redirect()->back()->with('error', 'Une erreur est survenue lors de la validation du transfert.');
    }

    $db->transCommit();

    $message = $estEnvoiMultiple 
        ? "Multi-transfert réussi ! Le montant de {$montantGlobal} Ar a été divisé ({$montantParDestinataire} Ar/personne). Avec commission : {$commission} et frais de transfert : {$fraisTransfert} "
        : "Transfert effectué avec succès ! Avec commission : {$commission} et frais de transfert : {$fraisTransfert} et frais de retrait : {$fraisRetraitOptionnel} ";

    return redirect()->back()->with('success', $message);
}
}