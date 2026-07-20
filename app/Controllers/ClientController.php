<?php

namespace App\Controllers;

class ClientController extends BaseController{

    public function getHistorique(){
     $db = \Config\Database::connect();
     
    }

    public function dashboard(){
        return view('client/dashboard');
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