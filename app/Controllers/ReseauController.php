<?php

namespace App\Controllers;
use App\Models\Reseaux;
use App\Models\Configurations;

class ReseauController extends BaseController
{
    public function ajouterReseau()
    {
        $reseauModel = new Reseaux();
        $nom = $this->request->getPost('nom');
        $commission_transfert = $this->request->getPost('commission_transfert');

        if (empty($nom) || !is_numeric($commission_transfert)) {
            return redirect()->back()->with('error', 'Nom du réseau ou commission invalide.');
        }

        $reseauModel->insert([
            'nom' => $nom,
            'commission_transfert' => $commission_transfert
        ]);

        return redirect()->back()->with('success', "Réseau {$nom} ajouté !");
    }

    public function supprimerReseau($id)
    {
        $configurationModel = new Configurations();
        $configurationModel->delete(['reseau_id' => $id]);
        $reseauModel = new Reseaux();
        $reseauModel->delete($id);

        return redirect()->back()->with('success', "Réseau supprimé !");
    }

    public function listerReseaux()
    {
        $reseauModel = new Reseaux();
        $reseaux = $reseauModel->findAll();

        return view('operateur/reseaux', ['reseaux' => $reseaux]);
    }

    public function modifierReseau($id)
    {
        $reseauModel = new Reseaux();
        $reseau = $reseauModel->find($id);

        if (!$reseau) {
            return redirect()->back()->with('error', 'Réseau introuvable.');
        }

        $nom = $this->request->getPost('nom');
        $commission_transfert = $this->request->getPost('commission_transfert');

        $reseauModel->update($id, [
            'nom' => $nom,
            'commission_transfert' => $commission_transfert
        ]);

        return redirect()->back()->with('success', "Réseau {$nom} modifié !");
    }
}