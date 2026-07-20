<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::accueil');

$routes->get('/login/operateur', 'AuthController::loginOperateur');
$routes->post('/login/operateur', 'AuthController::authenticateOperateur');

$routes->get('/login/client', 'AuthController::loginClient');
$routes->post('/login/client', 'AuthController::authenticateClient');

$routes->get('/logout', 'AuthController::logout');

$routes->group('client', ['filter' => 'client'], function($routes){
    $routes->get('dashboard', 'ClientController::dashboard');

    $routes->get('depot','ClientController::depot');
    $routes->post('depot','OperationsController::depot');

    $routes->get('retrait','ClientController::retrait');
    $routes->post('retrait','OperationsController::retrait');

    $routes->get('transfert','ClientController::transfert');
    $routes->post('transfert','OperationsController::transfert');
});

$routes->group('operateur', ['filter' => 'operateur'], function($routes){
    $routes->get('dashboard', 'OperateurController::dashboard');
});