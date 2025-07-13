<?php
namespace App\Repository;

use App\Core\Abstract\AbstractRepository;

class TelephoneRepository extends AbstractRepository{

    private string $table = 'numeroTelephone';

    private static TelephoneRepository|null $instance = null;

    public static function getInstance():TelephoneRepository{
        if(self::$instance == null){
            self::$instance = new TelephoneRepository();
        }
        return self::$instance;
    }

    public function __construct(){
        parent::__construct();
    }

    public function selectAll(){}

    public function insert(array $data): bool {
        $query = "INSERT INTO {$this->table} (numero, user_id, compte_id)
                  VALUES (:numero, :user_id, :compte_id)";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($data);
    }
    

     public function update(){}
     public function delete(){}
     public function selectById($id){}
     public function selectBy(array $filter){}

        public function findByNumero($numero): ?array {
        $query = "SELECT nt.*, c.*, u.nom, u.prenom FROM {$this->table} nt
                  JOIN compte c ON nt.compte_id = c.id
                  JOIN users u ON nt.user_id = u.id
                  WHERE nt.numero = :numero";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['numero' => $numero]);
        return $stmt->fetch() ?: null;
    }

    public function findByUserId($userId): array {
        $query = "SELECT nt.*, c.numero as numero_compte, c.typecompte, c.solde, c.datecreation
                  FROM {$this->table} nt
                  JOIN comptes c ON nt.compte_id = c.id
                  WHERE nt.user_id = :id_user
                  ORDER BY c.typecompte DESC, c.datecreation ASC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id_user' => $userId]);
        return $stmt->fetchAll();
    }

    public function findByCompteId($compteId): ?array {
        $query = "SELECT * FROM {$this->table} WHERE compte_id = :id_compte";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id_compte' => $compteId]);
        return $stmt->fetch() ?: null;
    }

}