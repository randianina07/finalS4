<?php

namespace App\Controllers;

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

        $operateurModel = new \App\Models\Operateurs();

        $operateur = $operateurModel
            ->getOperateurByNomAndPassword($username, $password);


        if ($operateur) {

            session()->set([
                'operateur_id' => $operateur['id'],
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

        $clientModel = new \App\Models\Clients();

        $client = $clientModel
            ->getClientByNumeroTelephone($telephone);

        if (!$client) {
            $client = $clientModel->createClient($telephone);
        }

        session()->set([
            'client_id' => $client['id'],
            'client' => $client
        ]);

        return redirect()->to('/dashboard/client');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/');
    }
}