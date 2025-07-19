<?php

require_once  __DIR__ .  '/../vendor/autoload.php';
use Dotenv\Dotenv;


$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
class Seeder
{
    private static ?\PDO $pdo = null;

    private static function connect()
    {
        if (self::$pdo === null) {
          
            self::$pdo = new \PDO($_ENV['dsnLocal'],
            $_ENV['DB_USER'],
              $_ENV['DB_PASSWORD']);
        }
    }

    public static function run()
    {
        self::connect();

        self::$pdo->exec("INSERT INTO typeUser (libelle) VALUES
            ('client'),
            ('serviceCommercial')");
        self::$pdo->exec("INSERT INTO users (nom, prenom, login, password, typeUserId, adresse, numeroCNI, photoIdentite) VALUES (
            'Diop',
            'sigi',
            'sidi@gmail.com',
            'Sidi@2024',
            1,
            'Dakar',
            '1234567890123',
            'photo_identite.jpg'
        );");
        self::$pdo->exec("INSERT INTO compte(numero, dateCreation,solde,typecompte) VALUES ('1234567890', '2023-01-01', 1000.00, 'principal');");
        self::$pdo->exec("INSERT INTO numeroTelephone(numero,user_id, compte_id) VALUES ('771234567',1, 1);");

        self::$pdo->exec("INSERT INTO transactions(dateTransaction,typeTransaction,montant,client_id,compte_id) VALUES ('2023-01-01', 'depot', 500.00, 1, 1);");


        

        echo "✅ Données de test insérées avec succès.\n";
    }
}

Seeder::run();
