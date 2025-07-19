<?php

namespace App\Controller;

use App\Core\App;
use App\Service\CompteService;
use App\Service\TransactionService;
use App\Core\Abstract\AbstractController;

class TransactionController extends AbstractController{

    private TransactionService $transactionService;
    private CompteService $compteService;
    public function __construct(){
        parent::__construct();
        $this->transactionService = App::getDependency('transactionServ');
        $this->compteService = App::getDependency('compteServ');

    }
    public function index(){
        $this->render('transaction/index.php');
    }
    public function create(){
        $comptes = $this->compteService->comptesClient($this->session->get('user', 'id'));
        $this->render('transaction/form.php', [
            'comptes' => $comptes,
        ]);
    }

public function store(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $data = $_POST;
            
            $compteExpediteurId = (int) $data['compte_expediteur_id'];
            $compteDestinataireId = (int) $data['compte_destinataire_id'];
            $montant = (float) $data['montant'];
            $libelle = $data['libelle'] ?? 'depot compte';

            
            if ($compteExpediteurId <= 0) {
                throw new \Exception("Compte expéditeur invalide");
            }
            
            if ($compteDestinataireId <= 0) {
                throw new \Exception("Compte destinataire invalide");
            }
            
            if ($montant <= 0) {
                throw new \Exception("Le montant doit être supérieur à 0");
            }
            
            if ($compteExpediteurId === $compteDestinataireId) {
                throw new \Exception("Les comptes expéditeur et destinataire doivent être différents");
            }

            $result = $this->transactionService->depotTransaction(
                $compteExpediteurId,
                $compteDestinataireId,
                $montant,
                $libelle
            );

            if ($result) {
                $_SESSION['success_message'] = "Dépôt de " . number_format($montant, 0, ',', ' ') . " FCFA effectué avec succès";
                header('Location: /listTransactions');
                exit; 
            }

        } catch (\Exception $e) {
            error_log("Erreur transaction: " . $e->getMessage());
            $_SESSION['error_message'] = $e->getMessage();
            $_SESSION['form_data'] = $data ?? [];
        }
    }
    
    header('Location: /transactionForm');
    exit;
}


public function edit(){
    }
    public function show(){
    }
}