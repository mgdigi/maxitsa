<?php

require_once  __DIR__ .  '/../vendor/autoload.php';
use Dotenv\Dotenv;


$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


class Migration
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

    public static function up()
    {
        self::connect();

        $queries = [
            "CREATE TABLE IF NOT EXISTS typeUser (
    id SERIAL PRIMARY KEY,
    libelle VARCHAR(50) NOT NULL
);",
    "CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    login VARCHAR(100) UNIQUE NOT NULL,
    password TEXT NOT NULL,
    typeUserId INTEGER NOT NULL,
    adresse TEXT,
    numeroCNI VARCHAR(20) UNIQUE,
    photoIdentite TEXT,
    Foreign Key (typeUserId) REFERENCES typeUser(id)
); ",
    
            "CREATE TABLE IF NOT EXISTS compte (
               id SERIAL PRIMARY KEY,
    numero VARCHAR(20) NOT NULL UNIQUE,
    datecreation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    solde DECIMAL(15, 2) DEFAULT 0.00,
    typecompte VARCHAR(20) NOT NULL CHECK (typecompte IN ('principal', 'secondaire'))
            )",
            "CREATE TABLE IF NOT EXISTS numeroTelephone(
            id SERIAL PRIMARY KEY,
            numero VARCHAR(20) NOT NULL UNIQUE,
            user_id INTEGER NOT NULL,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            compte_id INTEGER NOT NULL,
            FOREIGN KEY (compte_id) REFERENCES compte(id) ON DELETE CASCADE
            );",
            "CREATE TABLE IF NOT EXISTS transactions (
    id SERIAL PRIMARY KEY,
    dateTransaction TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    typeTransaction VARCHAR(50) NOT NULL CHECK (typeTransaction IN ('depot', 'retrait', 'paiement')),
    montant NUMERIC(15,2) NOT NULL CHECK (montant >= 0),
    client_id INTEGER NOT NULL,
    compte_id INTEGER NOT NULL,
    FOREIGN KEY (client_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (compte_id) REFERENCES compte(id) ON DELETE CASCADE
)"
        ];


        foreach ($queries as $sql) {
            self::$pdo->exec($sql);
        }

        echo "Migration terminée avec succès.\n";
    }
}

Migration::up();

