<?php 

use App\Controller\CompteController;
use App\Controller\SecurityController;
use App\Controller\TransactionController;


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
        'method' => 'store',
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
        'controller' => SecurityController::class,
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

    '/changerTypeCompte' => [
    'controller' => CompteController::class,
    'method' => 'changerTypeCompte',
    'middlewares' => ['auth'] 
],
  '/getComptesSecondaires' => [
    'controller' => CompteController::class,
    'method' => 'getComptesSecondaires',
    'middlewares' => ['auth']
  ],
  '/changerEnComptePrincipal' => [
    'controller' => CompteController::class,
    'method' => 'changerEnComptePrincipal',
    'middlewares' => ['auth']
  ],
  '/listComptes' => [
    'controller' => CompteController::class,
    'method' => 'show',
    'middlewares' => ['auth']
  ],
  '/listTransactions' => [
    'controller' => TransactionController::class,
    'method' => 'index',
    'middlewares' => ['auth']
  ],
  '/transactionForm' => [
    'controller' => TransactionController::class,
    'method' => 'create',
    'middlewares' => ['auth']
  ],
  '/createTransaction' => [
    'controller' => TransactionController::class,
    'method' => 'store',
    'middlewares' => ['auth']
  ]


];