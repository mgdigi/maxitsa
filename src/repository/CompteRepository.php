<?php

namespace App\Repository;
use App\Core\Abstract\AbstractRepository;

class CompteRepository extends AbstractRepository{

    private string $table = 'compte';

    private static CompteRepository|null $instance = null;

    public static function getInstance():CompteRepository{
        if(self::$instance == null){
            self::$instance = new CompteRepository();
        }
        return self::$instance;
    }

    public function __construct(){
        parent::__construct();
    }

     public function selectAll(){}
   

     public function insert(array $data): bool|int {
    $query = "INSERT INTO compte (numero, typeCompte, solde, dateCreation, id_user) 
              VALUES (:numero, :typeCompte, :solde, :dateCreation, :id_user)";
    $stmt = $this->pdo->prepare($query);
    if ($stmt->execute($data)) {
        return $this->pdo->lastInsertId();      
    }
    return false;
    }



    public function findPrincipalByUserId($userId): ?array {
    $query = "SELECT * FROM compte WHERE id_user = :id_user AND typeCompte = 'Principal'";
    $stmt = $this->pdo->prepare($query);
    $stmt->execute(['id_user' => $userId]);
    return $stmt->fetch() ?: null;
    }


     public function update(){}
     public function delete(){}
     public function selectById($id){
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
     }

     public function selectByClient($user_id){
        $sql = "SELECT * from $this->table where id_user = :user_id and typeCompte = 'Principal'";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute(['user_id' => $user_id]);
        if($result){
            return $stmt->fetchAll();
        }
        return null;
     }

     public function updateSolde($compteId, $newSolde): bool {
        $query = "UPDATE {$this->table} SET solde = :solde WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            'solde' => $newSolde,
            'id' => $compteId
        ]);
    }

    public function updateTypeCompte($compteId, $newType): bool {
        $query = "UPDATE {$this->table} SET typecompte = :typecompte WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            'typecompte' => $newType,
            'id' => $compteId
        ]);
    }
     public function selectBy(array $filter){}

}