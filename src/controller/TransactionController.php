<?php

namespace App\Controller;

use App\Core\App;
use App\Core\Session;
use App\Core\Validator;
use App\Service\CompteService;
use App\Service\TransactionService;
use App\Core\Abstract\AbstractController;

class TransactionController extends AbstractController{

    private Validator $validator;
    private TransactionService $transactionService;
    private CompteService $compteService;
    public function __construct(
        Validator $validator, 
        Session $session,
        TransactionService $transactionService,
        CompteService $compteService
    ){
        parent::__construct(

            $this->session = $session
        );
        $this->validator = $validator;
        $this->transactionService = $transactionService;
        $this->compteService = $compteService;

    }
  
    public function create(){
        $comptesClient = $this->compteService->comptesClient($this->session->get('user', 'id'));
        $allComptes = $this->compteService->allComptes();
        $this->render('transaction/form.php', [
            'comptesClient' => $comptesClient,
            'allComptes' => $allComptes,
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

            if ($result['success']) {
                $data = $result['data'];
                $message = "Transfert de " . number_format($data['montant_transfere'], 0, ',', ' ') . " FCFA effectué avec succès";
                
                if ($data['frais'] > 0) {
                    $message .= " (Frais: " . number_format($data['frais'], 0, ',', ' ') . " FCFA)";
                }
                
                $_SESSION['success_message'] = $message;
                header('Location: /listTransactions');
                exit;
            } else {
                throw new \Exception($result['message']);
            }

        } catch (\Exception $e) {
            error_log("Erreur transaction: " . $e->getMessage());
            $this->session->set('error_message', $e->getMessage());
            $this->session->set('form_data', $data ?? []);
        }
    }
    
    header('Location: /transactionForm');
    exit;
}

public function calculerFrais() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $compteExpediteurId = (int) ($_POST['compte_expediteur_id'] ?? 0);
        $compteDestinataireId = (int) ($_POST['compte_destinataire_id'] ?? 0);
        $montant = (float) ($_POST['montant'] ?? 0);
        
        $preview = $this->transactionService->calculerFraisPreview($compteExpediteurId, $compteDestinataireId, $montant);
        
        header('Content-Type: application/json');
        echo json_encode($preview);
        exit;
    }
}



public function edit(){
    }
    public function show(){
    }


    public function index() {
    try {
        $userId = $this->session->get('user', 'id');
        
        if (!$userId) {
            throw new \Exception("Utilisateur non connecté");
        }
        
        $dateFilter = !empty($_POST['date_filter']) ? $_POST['date_filter'] : null;
        $typeFilter = !empty($_POST['type_filter']) ? $_POST['type_filter'] : null;
        
        
        $transactions = $this->transactionService->rechercherTransactions($userId, $dateFilter, $typeFilter);
        
        $typesDisponibles = $this->transactionService->getTypesTransactionDisponibles($userId);
        
        
        $this->render('transaction/index.php', [
            'transactions' => $transactions,
            'typesDisponibles' => $typesDisponibles,
            'dateFilter' => $dateFilter,
            'typeFilter' => $typeFilter
        ]);
        
    } catch (\Exception $e) {
        error_log("Erreur TransactionController::index: " . $e->getMessage());
        echo "Erreur: " . $e->getMessage(); 
        exit;
    }
}



private function isValidDate($date): bool {
    $d = \DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

public function annuler() {
    try {
        $transactionId = (int) ($_GET['id'] ?? 0);
        $userId = $this->session->get('user', 'id');
        
        if ($transactionId <= 0) {
            $this->session->set('error_message','Id introuvable');    
            header('Location: /listTransactions');
            exit;
        }
        
        if (!$userId) {
            $this->session->set('error_message','message');
            header('Location: /listTransactions');
            exit;
        }
        
        $result = $this->transactionService->annulerTransaction($transactionId, $userId);
        
        if ($result['success']) {
            $this->session->set('success_message','message');
        } else {
            $this->session->set('error_message','message');
        }
        
    } catch (\Exception $e) {
        error_log("Erreur annulation transaction: " . $e->getMessage());
        $_SESSION['error_message'] = "Erreur: " . $e->getMessage();
    }
    
    header('Location: /listTransactions');
    exit;
}


    public function woyofalForm(){
        $this->render('transaction/paiement.php');
    }

    public function achatWoyofal()
    {
        try {
            $validation = $this->validateAchatData($_POST);
            if (!$validation['valid']) {
                $_SESSION['errors'] = $validation['errors'];
                $this->redirect('/woyofal'); 
                return;
            }

            $numeroCompteur = trim($_POST['numero_compteur']);
            $montant = floatval($_POST['montant']);

            $compteurInfo = $this->verifyCompteur($numeroCompteur);
            if (!$compteurInfo['success']) {
                $this->
                $_SESSION['errors']['numero_compteur'] = $compteurInfo['message'];
                $this->redirect('/woyofal');
                return;
            }

            $achatResult = $this->processAchat($numeroCompteur, $montant);
            if (!$achatResult['success']) {
                $_SESSION['errors']['general'] = $achatResult['message'];
                $this->redirect('/woyofal');
                return;
            }

            

            $this->generateReceipt($compteurInfo['data'], $achatResult['data']);

        } catch (\Exception $e) {
            $_SESSION['errors']['general'] = "Une erreur est survenue: " . $e->getMessage();
            $this->redirect('/woyofal');
        }
    }


private function validateAchatData($data)
{
    $errors = [];
    
    if (empty($data['numero_compteur'])) {
        $errors['numero_compteur'] = 'Le numéro de compteur est obligatoire';
    } elseif (strlen(trim($data['numero_compteur'])) < 5) {
        $errors['numero_compteur'] = 'Le numéro de compteur doit contenir au moins 5 caractères';
    }
    
    if (empty($data['montant']) || !is_numeric($data['montant'])) {
        $errors['montant'] = 'Le montant est obligatoire et doit être numérique';
    } elseif (floatval($data['montant']) <= 0) {
        $errors['montant'] = 'Le montant doit être supérieur à 0';
    } elseif (floatval($data['montant']) < 100) {
        $errors['montant'] = 'Le montant minimum est de 100 FCFA';
    }
    
    return [
        'valid' => empty($errors),
        'errors' => $errors
    ];
}


private function verifyCompteur($numeroCompteur)
{
    $apiUrl = "https://appwoyofal-6cfi.onrender.com/api/achat/verifier/" . urlencode($numeroCompteur);
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $apiUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Accept: application/json'
        ]
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_error($ch)) {
        curl_close($ch);
        return [
            'success' => false,
            'message' => 'Erreur de connexion à l\'API: ' . curl_error($ch)
        ];
    }
    
    curl_close($ch);
    
    $data = json_decode($response, true);
    
    if ($httpCode !== 200 || !$data['success']) {
        return [
            'success' => false,
            'message' => $data['message'] ?? 'Compteur non trouvé'
        ];
    }
    
    return [
        'success' => true,
        'data' => $data['data']['data'] 
    ];
}


private function processAchat($numeroCompteur, $montant)
{
    $apiUrl = "https://appwoyofal-6cfi.onrender.com/api/achat";
    
    $postData = json_encode([
        'numero_compteur' => $numeroCompteur,
        'montant' => $montant
    ]);
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $apiUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Accept: application/json'
        ]
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_error($ch)) {
        curl_close($ch);
        return [
            'success' => false,
            'message' => 'Erreur de connexion à l\'API: ' . curl_error($ch)
        ];
    }
    
    curl_close($ch);
    
    $data = json_decode($response, true);
    
    if ($httpCode !== 200 || $data['statut'] !== 'Success') {
        return [
            'success' => false,
            'message' => $data['message'] ?? 'Erreur lors de l\'enregistrement de l\'achat'
        ];
    }
    
    return [
        'success' => true,
        'data' => $data['data']
    ];
}


private function generateReceipt($compteurInfo, $achatInfo)
{
    $receiptData = [
        'client_nom' => $compteurInfo['client'],
        'numero_compteur' => $compteurInfo['numero_compteur'],
        'code_recharge' => $achatInfo['code'],
        'nombre_kwh' => $achatInfo['nbreKwt'],
        'date_heure' => $achatInfo['date'],
        'tranche' => $achatInfo['tranche'],
        'prix_unitaire' => $achatInfo['prix'],
        'montant_paye' => $achatInfo['prix'] * $achatInfo['nbreKwt'],
        'reference' => $achatInfo['reference']
    ];
    
    $_SESSION['receipt'] = $receiptData;
    $_SESSION['success'] = "Achat effectué avec succès!";
    
    $this->redirect('/recu-woyofal');
}

public function showReceipt()
{
    $this->render('transaction/recu.woyofal.php');
}


}