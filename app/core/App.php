<?php

namespace App\Core;

use App\Core\Abstract\AbstractController;
use App\Core\Abstract\AbstractRepository;
use App\Core\Abstract\AbstractEntity;
use App\Core\Database;
use App\Core\Session;
use App\Core\Validator;
use App\Core\Router;

use App\Repository\UsersRepository;
use App\Repository\CompteRepository;
use App\Repository\TransactionRepository;
use App\Repository\TelephoneRepository;

use App\Service\SecurityService;
use App\Service\CompteService;
use App\Service\TransactionService; 

class App
{
    private static  array $dependencies = [];

    public static function  init(){
        self::$dependencies = [
            'core' => [
                'database' => Database::class,
                'session' => Session::class,
                'validator' => Validator::class,
                'router' => Router::class,
                'imageServ' => ImageService::class,
            ],
            'abstract' => [
                'abstractRepo' => AbstractRepository::class,
                'abstractController' => AbstractController::class,
                'abstractEntity' => AbstractEntity::class,
            ],
            'services' => [
                'securityServ' => SecurityService::class,
                'compteServ' => CompteService::class,
                'transactionServ' => TransactionService::class,
            ],
            'repositories' => [
                'usersRepo' => UsersRepository::class,
                'compteRepo' => CompteRepository::class,
                'transactionRepo' => TransactionRepository::class,
                'telephoneRepo' => TelephoneRepository::class,
            ]
            ];
    }

    public static function getDependency(string $key){
        if(empty(self::$dependencies)){
            self::init();
        }

        foreach(self::$dependencies as $dependencie){
            if(is_array($dependencie) && isset($dependencie[$key])){
                $class =  $dependencie[$key];
                if(method_exists($class, 'getInstance')){
                    return $class::getInstance();
                }
                return new $class();
            }
            
        }
    }

}
