<?php

namespace App\Repository;
use App\Entity\User;
use App\Core\Abstract\AbstractRepository;

use PDO;

class UsersRepository extends AbstractRepository{


    private static UsersRepository|null $instance = null;

    public static function getInstance():UsersRepository{
        if(self::$instance == null){
            self::$instance = new UsersRepository();
        }
        return self::$instance;
    }

    public function __construct(){
        parent::__construct();
    }

    private string $table = 'users';

    public function selectAll(){}
     public function insert($userData){
        $sql = "INSERT INTO $this->table (nom, prenom,login, password, adresse, numeros, numeroCNI, photoIdentite, type_user_id) values (:nom, :prenom, :login, :password, :adresse, :numeros, :numeroCNI, :photoIdentite, :type_user_id)";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute($userData);
        
        if($result){
            return $this->pdo->lastInsertId();
        }else{
            return false;
        }
     }



     



     public function update(){}
     public function delete(){}
     public function selectById(){}
     public function selectBy(array $filter){}

}