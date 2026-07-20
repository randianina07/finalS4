<?php

namespace App\Controllers;
use App\Models\BaremesFrais;
use App\Models\Clients;
use App\Models\Mouvements;

class OperateurController extends BaseController{
    public function index(){}

    public function compteClient(){
       $db = \Config\Database::connect();
       $builder = $db->table('clients c');
       $builder->select('c.*');
       $clients = $builder->get()->getResultArray();
       $clientModel = new Clients();
       $data = [
            'clients' => $clientModel->paginate(10),
            'pager'   => $clientModel->pager
        ];
    
        return view('operateur/clients', $data);
    }
    
    public function gains(){
        $db = \Config\Database::connect();
        $builder = $db->table('mouvements t');
       $builder->select('t.type_operation_id, sum(t.frais) as total_frais');
        $builder->whereIn('t.type_operation_id', [2, 3]);
        $builder->groupBy('t.type_operation_id');
        
        $gainsParType = $builder->get()->getResultArray();

        $totalGeneral = 0;
        foreach ($gainsParType as $gain) {
            $totalGeneral += (float) $gain['total_frais'];
        }

        $data = [
            'gains' => $gainsParType,
            'total_general' => $totalGeneral
        ];

        return view('operateur/gains', $data);
    }
    
    public function ajouterPrefixe()
    {
        $prefixe = trim($this->request->getPost('prefixe'));

        if (empty($prefixe) || !is_numeric($prefixe)) {
            return redirect()->back()->with('error', 'Le préfixe doit être numérique (ex: 037).');
        }

        $db = \Config\Database::connect();
        $db->table('configurations')->insert(['prefixe' => $prefixe]);

        return redirect()->back()->with('success', "Préfixe {$prefixe} ajouté !");
    }

    public function supprimerPrefixe($id)
    {
        $db = \Config\Database::connect();
        $db->table('configurations')->where('id', $id)->delete();

        return redirect()->back()->with('success', "Préfixe supprimé avec succès.");
    }


    public function baremes()
    {
        $baremeModel = new BaremesFrais();
        $baremes = $baremeModel->select('baremes_frais.*, type_operations.nom as nom_operation')
            ->join('type_operations', 'baremes_frais.type_operation_id = type_operations.id')
            ->orderBy('type_operations.nom', 'ASC')
            ->orderBy('baremes_frais.montant_min', 'ASC')
            ->findAll();

        return view('operateur/baremes', ['baremes' => $baremes]);
    }

    public function enregistrerBareme()
    {
        $baremeModel = new BaremesFrais();

        $id = $this->request->getPost('id');
        $data = [
            'type_operation_id' => $this->request->getPost('type_operation_id'),
            'montant_min'       => (float)$this->request->getPost('montant_min'),
            'montant_max'       => (float)$this->request->getPost('montant_max'),
            'frais'             => (float)$this->request->getPost('frais'),
        ];

        if ($id) {
            $baremeModel->update($id, $data);
            $msg = "Tranche modifiée !";
        } else {
            $baremeModel->insert($data);
            $msg = "Nouvelle tranche ajoutée !";
        }

        return redirect()->to('/operateur/baremes')->with('success', $msg);
    }

    public function supprimerBareme($id)
    {
        $baremeModel = new BaremesFrais();
        $baremeModel->delete($id);

        return redirect()->back()->with('success', "Tranche de barème supprimée.");
    }

    public function dashboard()
    {
        $clientModel = new Clients();
        $transactionModel = new Mouvements();

        $nbClients = $clientModel->countAll();


        $nbOperations = $transactionModel->countAll();

        $totalGains = $transactionModel
            ->selectSum('frais')
            ->first();


        $data = [

            'title' => 'Dashboard Opérateur',

            'nbClients' => $nbClients,

            'nbOperations' => $nbOperations,

            'totalGains' => $totalGains['frais'] ?? 0

        ];


        return view('operateur/dashboard', $data);
    }

    public function prefixes()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('configurations');
        $prefixes = $builder->get()->getResultArray();

        return view('operateur/prefixes', ['prefixes' => $prefixes]);
    }
}