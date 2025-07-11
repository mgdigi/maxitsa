<?php

namespace App\Repository;

use App\Core\Abstract\AbstractRepository;

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
     public function insert(array $data){}
     public function update(){}
     public function delete(){}
     public function selectById(){}
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