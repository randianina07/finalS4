<?php

namespace App\Controllers;
use App\Models\BaremesFrais;
class OperateurController extends Controller{
    public function index(){}

    public function compteClient(){
       $db = \Config\Database::connect();
       $builder = $db->table('clients c');
       $builder->select('c.*');
       $clients = $builder->get()->getResultArray();
    
        return view('admin/clients', ['clients' => $clients]);
    }
    
    public function gains(){
        $db = \Config\Database::connect();
        $builder = $db->table('mouvements m');
       $builder->select('t.type_operation_id, sum(t.frais_appliques) as total_frais');
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

        return view('admin/gains', $data);
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
        $baremes = $baremeModel->orderBy('type_operation_id', 'ASC')->orderBy('montant_min', 'ASC')->findAll();

        return view('admin/baremes', ['baremes' => $baremes]);
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

        return redirect()->to('/admin/baremes')->with('success', $msg);
    }

    public function supprimerBareme($id)
    {
        $baremeModel = new BaremesFrais();
        $baremeModel->delete($id);

        return redirect()->back()->with('success', "Tranche de barème supprimée.");
    }
}