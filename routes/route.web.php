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
        'method' => 'create'
        // 'middlewares' => ['isLoggedIn', 'isClient'] 
    ],
    '/compte' => [
        'controller' => CompteController::class,
        'method' => 'index'
        // 'middlewares' => ['isLoggedIn', 'isClient']
    ],
    "/login" => [
        'controller' => SecurityController::class, 
        'method' => 'login'
    ],
    "/principalCreated" => [
        'controller' => CompteController::class,
        'method' => 'createComptePrincipal'
    ],
    "/logout" => [
        'controller' => SecurityController::class, 
        'method' => 'logout'
    ],
];