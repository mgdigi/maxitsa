<?php 

use App\Controller\CompteController;
use App\Controller\SecurityController;


$routes = [
    '/' => [
        'controller' => SecurityController::class, 
        'method' => 'index'
    ],
    '/comptePrincipal' => [
        'controller' => CompteController::class, 
        'method' => 'create',
    ],
    '/compteSecondaire' => [
        'controller' => CompteController::class,
        'method' => 'show',
        'middlewares' => ['auth']

    ],
    '/compte' => [
        'controller' => CompteController::class,
        'method' => 'index',
        'middlewares' => ['auth']

    ],
    "/login" => [
        'controller' => SecurityController::class, 
        'method' => 'login'
    ],
    "/principalCreated" => [
        'controller' => CompteController::class,
        'method' => 'createComptePrincipal',
        'middlewares' => ['cryptPassword']
    ],
    "/secondaireCreated" => [
        'controller' => CompteController::class,
        'method' => 'createCompteSecondaire'
    ],
    "/logout" => [
        'controller' => SecurityController::class, 
        'method' => 'logout'
    ],
];