<?php

namespace App\Repository;

use \PDO;
use App\Core\App;
use NumeroTelephone;
use App\Core\Abstract\AbstractRepository;

class TransactionRepository extends AbstractRepository{
    private string $table = 'transactions';

    private CompteRepository $compteRepository;
    private TelephoneRepository $telephoneRepository;

    private static TransactionRepository|null $instance = null;

    protected function __construct(){
        parent::__construct();
        $this->compteRepository = App::getDependency('compteRepo');
        $this->telephoneRepository = App::getDependency('telephoneRepo');
    }

    public static function getInstance():TransactionRepository{
        if(self::$instance == null){
            self::$instance = new TransactionRepository();
        }
        return self::$instance;
    }



      public function selectAll(){
        $query = "SELECT * FROM $this->table ";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll();
      }
     public function insert(array $data){
        $query = "INSERT INTO $this->table (datetransaction, typetransaction, montant, client_id, compte_id, status, libelle) VALUES (:datetransaction, :typetransaction, :montant, :client_id, :compte_id, :status, :libelle)";
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute($data);
        return $result;
     }


private function verifierContraintesDepot($compteExpediteurId, $compteDestinataireId): bool {
    $compteExpediteur = $this->compteRepository->selectById($compteExpediteurId);
    $compteDestinataire = $this->compteRepository->selectById($compteDestinataireId);

    if (!$compteExpediteur || !$compteDestinataire) {
        return false;
    }

    return $compteExpediteur['typecompte'] === 'principal';
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


     public function depotEntreComptes($compteExpediteurId, $compteDestinataireId, $montant, $libelle = 'Dépôt entre comptes') {
    error_log("Début depotEntreComptes - Exp: $compteExpediteurId, Dest: $compteDestinataireId, Montant: $montant");
    
    $this->pdo->beginTransaction();
    
    try {
        if (!$this->verifierContraintesDepot($compteExpediteurId, $compteDestinataireId)) {
            throw new \Exception("Dépôt non autorisé entre ces types de comptes");
        }

        $compteExpediteur = $this->compteRepository->selectById($compteExpediteurId);
        if (!$compteExpediteur || $compteExpediteur['solde'] < $montant) {
            throw new \Exception("Solde insuffisant");
        }

        $nouveauSoldeExpediteur = $compteExpediteur['solde'] - $montant;
        $this->compteRepository->updateSolde($compteExpediteurId, $nouveauSoldeExpediteur);

        $compteDestinataire = $this->compteRepository->selectById($compteDestinataireId);
        $nouveauSoldeDestinataire = $compteDestinataire['solde'] + $montant;
        $this->compteRepository->updateSolde($compteDestinataireId, $nouveauSoldeDestinataire);

        $userIdExp = $this->telephoneRepository->findUserIdByCompteId($compteExpediteurId);
        $userIdDest = $this->telephoneRepository->findUserIdByCompteId($compteDestinataireId);
        
        if (!$userIdExp || !$userIdDest) {
            throw new \Exception("Impossible de trouver les utilisateurs associés aux comptes");
        }

        $insertExp = $this->insert([
            'datetransaction' => date('Y-m-d H:i:s'),
            'typetransaction' => 'depot',
            'montant' => $montant, 
            'client_id' => $userIdExp,
            'compte_id' => $compteExpediteurId,
            'status' => 0,
            'libelle' => $libelle . ' - Envoyé'
        ]);

        $insertDest = $this->insert([
            'datetransaction' => date('Y-m-d H:i:s'),
            'typetransaction' => 'depot', 
            'montant' => $montant, 
            'client_id' => $userIdDest,
            'compte_id' => $compteDestinataireId,
            'status' => 0,
            'libelle' => $libelle . ' - Reçu'
        ]);

        $this->pdo->commit();
        return true;

    } catch (\Exception $e) {
        $this->pdo->rollBack();
        throw $e;
    }
}


}