<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class OperateurFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->has('operateur_id')) {

            return redirect()
                ->to('/login/operateur')
                ->with('error', 'Veuillez vous connecter.');
        }
    }


    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) 
    {
        // Rien
    }
}