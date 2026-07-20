<?php

namespace App\Controllers;
use App\Models\Clients;
use App\Models\Operateurs;
use App\Models\Configurations;

class AuthController extends BaseController
{
    public function accueil()
    {
        return view('auth/accueil');
    }

    public function loginOperateur()
    {
        return view('auth/login_operateur');
    }

    public function loginClient()
    {
        return view('auth/login_client');
    }

    public function authenticateOperateur()
    {
        $username = $this->request->getPost('nom');
        $password = $this->request->getPost('mot_de_passe');

        $mot_de_passe_hash = password_hash($password, PASSWORD_DEFAULT);

        $operateurModel = new Operateurs();

        $operateur = $operateurModel
            ->getOperateurByNomAndPassword($username, $mot_de_passe_hash);


        if ($operateur) {

            session()->set([
                'operateur_id' => $operateur->id,
                'operateur' => $operateur
            ]);

            return redirect()->to('/dashboard/operateur');
        }


        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Identifiants opérateur incorrects.');
    }

    public function authenticateClient()
    {
        $telephone = $this->request->getPost('telephone');

        $clientModel = new Clients();
        $confirmationModel = new Configurations();

        $prefixe = $confirmationModel->prefixeValide($telephone);
        
        if($prefixe === null) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Le numéro de téléphone n\'est pas valide.');
        }

        $client = $clientModel
            ->getClientByNumeroTelephone($telephone);

        if (!$client) {
            $client = $clientModel->createClient($telephone);
        }

        session()->set([
            'client_id' => $client->id,
            'client' => $client
        ]);

        return redirect()->to('/client/dashboard');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/');
    }
}