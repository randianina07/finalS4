<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::accueil');
$routes->get('/login/operateur', 'AuthController::loginOperateur');
$routes->get('/login/client', 'AuthController::loginClient');
$routes->post('/login/operateur', 'AuthController::authenticateOperateur');
$routes->post('/login/client', 'AuthController::authenticateClient');
$routes->get('/logout', 'AuthController::logout');
