<?php

namespace App\Core;

use App\Core\Database;
use App\Service\SecurityService;
use App\Service\CommandeService;
use App\Repository\PersonRepository;
use App\Repository\CommandeRepository;
use App\Repository\ProduitRepository;

class App
{
    private static array $dependencies = [];
    private static bool $initialized = false;

    private static function initialize(): void
    {
        if (self::$initialized) {
            return;
        }

        // self::$dependencies = [
        //     Database::class => fn() => Database::getInstance(),
        //     Session::class => fn() => Session::getInstance(),
        //     Validator::class => fn() => Validator::getInstance(),
        //     PersonRepository::class => fn() => PersonRepository::getInstance(),
        //     CommandeRepository::class => fn() => CommandeRepository::getInstance(),
        //     ProduitRepository::class => fn() => ProduitRepository::getInstance(),
        // ];

        self::$dependencies = [
            'core' => [
               'abstractController' => AbstractController::getInstance(),
               'abstractEntity' => AbstractEntity::getInstance(),
               'AbstractRepository' => AbstractRepository::getInstance(),
               'Database' => Database::getInstance(),
               
            ],
            'services' => [

            ],
            'repositories' => [

            ]
        ];

        self::$initialized = true;
    }

    public static function getDependency(string $key)
    {
        self::initialize();
        
        if (!isset(self::$container[$key])) {
            throw new \Exception("Dependency '{$key}' not found in container");
        }

        $factory = self::$container[$key];
        
        if (is_callable($factory)) {
            self::$container[$key] = $factory();
        }

        return self::$container[$key];
    }
}
