<?php

namespace App\Service;

use App\Core\App;
use App\Repository\TransactionRepository;
use App\Core\Singleton;

class TransactionService extends Singleton{

    private TransactionRepository $transactionRepository;


    protected function __construct(){
        $this->transactionRepository = App::getDependency('transactionRepo');
       
        

    }

    public function getTransactionByClient($client_id){
        return $this->transactionRepository->selectByClient($client_id);
    }

  public function depotTransaction($compteExpediteurId, $compteDestinataireId, $montant, $libelle){
    try {
        return $this->transactionRepository->depotEntreComptes($compteExpediteurId, $compteDestinataireId, $montant, $libelle);
    } catch (\Exception $e) {
        error_log("Erreur dans depotTransaction: " . $e->getMessage());
        throw $e; // Relancer l'exception
    }
}


}