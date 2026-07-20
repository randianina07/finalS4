<?php

namespace App\Controllers;
use App\Models\BaremesFrais;
use App\Models\Clients;
use App\Models\Mouvements;
use App\Models\Reseaux;

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
    
    // public function gains(){
    //     $db = \Config\Database::connect();
    //     $builder = $db->table('mouvements t');
    //     $builder->select('t.type_operation_id, sum(t.frais) as total_frais');
    //     $builder->whereIn('t.type_operation_id', [2, 3]);
    //     $builder->groupBy('t.type_operation_id');
        
    //     $gainsParType = $builder->get()->getResultArray();

    //     $gainsParReseau = [];

    //     $totalGeneral = 0;
    //     foreach ($gainsParType as $gain) {
    //         $totalGeneral += (float) $gain['total_frais'];
    //     }

    //     $data = [
    //         'gains' => $gainsParType,
    //         'total_general' => $totalGeneral
    //     ];

    //     return view('operateur/gains', $data);
    // }

    public function gains()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('mouvements m');
        $builder->select('t.nom, SUM(m.frais) as total_frais');
        $builder->join(
            'type_operations t',
            't.id = m.type_operation_id'
        );
        $builder->whereIn(
            'm.type_operation_id',
            [2,3]
        );
        $builder->groupBy('t.nom');

        $gainsParType = $builder->get()->getResultArray();

        $builder = $db->table('mouvements m');
        $builder->select('
            r.nom as reseau,
            SUM(m.frais) as gain
        ');
        $builder->join(
            'clients c',
            'c.id = m.client_destination_id',
            'left'
        );
        $builder->join(
            'configurations conf',
            "conf.prefixe = substr(c.numero_telephone,1,3)",
            'left'
        );
        $builder->join(
            'reseaux r',
            'r.id = conf.reseau_id',
            'left'
        );
        $builder->where(
            'm.type_operation_id',
            3
        );
        $builder->groupBy('r.nom');

        $gainsParReseau = $builder->get()->getResultArray();

        $totalGeneral = 0;

        foreach($gainsParType as $gain)
        {
            $totalGeneral += $gain['total_frais'];
        }

        return view(
            'operateur/gains',
            [
                'gains' => $gainsParType,
                'gains_reseaux' => $gainsParReseau,
                'total_general' => $totalGeneral
            ]
        );
    }
    
    public function ajouterPrefixe()
    {
        $prefixe = trim($this->request->getPost('prefixe'));
        $reseau_id = $this->request->getPost('reseau');

        if (empty($prefixe) || !is_numeric($prefixe)) {
            return redirect()->back()->with('error', 'Le préfixe doit être numérique (ex: 037).');
        }

        $db = \Config\Database::connect();
        $db->table('configurations')->insert(['prefixe' => $prefixe, 'reseau_id' => $reseau_id]);

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
        $prefixes = $builder->select('configurations.*, reseaux.nom as nom_reseau')
            ->join('reseaux', 'configurations.reseau_id = reseaux.id')
            ->get()
            ->getResultArray();
        
        $reseauxModel = new Reseaux();
        $reseaux = $reseauxModel->getAllReseaux();

        return view('operateur/prefixes', ['prefixes' => $prefixes, 'reseaux' => $reseaux]);
    }
}