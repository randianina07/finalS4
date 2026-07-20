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

    $routes->get('historique', 'ClientController::getHistorique');
});

$routes->group('operateur', ['filter' => 'operateur'], function($routes){
    $routes->get('dashboard', 'OperateurController::dashboard');

    $routes->get('clients', 'OperateurController::compteClient');

    $routes->get('gains', 'OperateurController::gains');

    $routes->get('baremes', 'OperateurController::baremes');
    $routes->post('baremes/enregistrer', 'OperateurController::enregistrerBareme');
    $routes->get('baremes/supprimer/(:num)', 'OperateurController::supprimerBareme/$1');

    $routes->get('prefixes', 'OperateurController::prefixes');
    $routes->post('prefixes/ajouter', 'OperateurController::ajouterPrefixe');
    $routes->get('prefixes/supprimer/(:num)', 'OperateurController::supprimerPrefixe/$1');

    $routes->get('reseaux', 'ReseauController::listerReseaux');
    $routes->post('reseaux/ajouter', 'ReseauController::ajouterReseau');
    $routes->get('reseaux/supprimer/(:num)', 'ReseauController::supprimerReseau/$1');
    $routes->post('reseaux/modifier/(:num)', 'ReseauController::modifierReseau/$1');
});