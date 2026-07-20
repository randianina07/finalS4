<?php

namespace App\Controllers;

class ClientController extends BaseController
{
    public function getHistorique()
    {
        $clientId = session()->get('client_id');
        $db = \Config\Database::connect();
        
        $builder = $db->table("mouvements t");
        
        $builder->select('t.*, source_c.numero_telephone as num_source, dest_c.numero_telephone as num_dest');
        
        $builder->join('clients source_c', 'source_c.id = t.client_source_id', 'left');
        $builder->join('clients dest_c', 'dest_c.id = t.client_destination_id', 'left');
        
        $builder->groupStart()
                ->where("t.client_source_id", $clientId)
                ->orWhere("t.client_destination_id", $clientId)
                ->groupEnd();
                
        $builder->orderBy("t.date_creation", "DESC");

        $pager = \Config\Services::pager();
        $page = $this->request->getVar('page') ? (int)$this->request->getVar('page') : 1;
        $parPage = 5; 
        
        $total = $builder->countAllResults(false);
        $historique = $builder->get($parPage, ($page - 1) * $parPage)->getResultArray();
        $pager->makeLinks($page, $parPage, $total, 'default_full');

        return view("client/historique", [
            "mouvements" => $historique,
            "pager"      => $pager
        ]);
    }

    public function getSolde()
    {
        $clientId = session()->get('client_id');
        $db = \Config\Database::connect();
        
        $client = $db->table('clients')
                     ->select('solde')
                     ->where('id', $clientId)
                     ->get()
                     ->getRowArray();
        
        return $client ? (float)$client['solde'] : 0.0;
    }

    public function dashboard()
    {
        $data = [
            'solde'  => $this->getSolde(),
            'numero' => session()->get('numero')
        ];
        return view('client/dashboard', $data);
    }

    public function depot(){
        return view('client/depot');
    }

    public function retrait(){
        return view('client/retrait');
    }

    public function transfert(){
        return view('client/transfert');
    }
}