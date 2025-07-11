<?php

namespace App\Service;

use App\Core\App;
use App\Repository\TransactionRepository;

class TransactionService{
    private static TransactionService|null $instance = null;

    private TransactionRepository $transactionRepository;

    public static function getInstance():TransactionService{
        if(self::$instance == null){
            self::$instance = new TransactionService();
        }
        return self::$instance;
    }

    public function __construct(){
        $this->transactionRepository = App::getDependency('repositories', 'transactionRepo');

    }

    public function getTransactionByClient($client_id){
        return $this->transactionRepository->selectByClient($client_id);
    }

}