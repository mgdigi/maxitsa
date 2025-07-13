<?php

namespace App\Repository;

use App\Core\Abstract\AbstractRepository;
use \PDO;

class TransactionRepository extends AbstractRepository{
    private string $table = 'transaction';

    private static TransactionRepository|null $instance = null;

    public function __construct(){
        parent::__construct();
    }

    public static function getInstance():TransactionRepository{
        if(self::$instance == null){
            self::$instance = new TransactionRepository();
        }
        return self::$instance;
    }



      public function selectAll(){}
     public function insert(array $data){
        $sql = "INSERT INTO $this->table (datetransaction, typetransaction, montant, client_id, compte_id, libelle) VALUES (:datetransaction, :typetransaction, :montant, :client_id, :compte_id, :libelle)";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute($data);
        return $result;
     }

      public function getLastTransactions($compteId, $limit = 10): array {
        $query = "SELECT * FROM {$this->table} 
                  WHERE compte_id = :id_compte 
                  ORDER BY datetransaction DESC 
                  LIMIT :limit";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id_compte', $compteId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
     public function update(){}
     public function delete(){}
     public function selectById($id){}
     public function selectBy(array $filter){}

     public function selectByClient(string $id_client){ 
        $sql = "SELECT * from $this->table where client_id = :id_client limit 10";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(['id_client' => $id_client]);
        if($result){
            return $stmt->fetchAll();
        }
        return [];
     }

}