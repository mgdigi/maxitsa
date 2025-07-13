<?php

namespace App\Controller;
use App\Core\Abstract\AbstractController;
use App\Core\App;
use App\Core\Validator;
use App\Service\SecurityService;
use App\Core\ImageService;
use App\Service\CompteService;
use App\Service\TransactionService;
use App\Service\TwilioService;

class CompteController extends AbstractController{

    private Validator $validator;
    private SecurityService $securityService;
    private ImageService $imageService;
    private CompteService $compteService;
    private TransactionService $transactionService;
    

    public function __construct(){
           parent::__construct();
          $this->validator = App::getDependency('core.validator');
          $this->securityService = App::getDependency('services.securityServ');
          $this->imageService = App::getDependency('core.imageServ');
          $this->compteService = App::getDependency('services.compteServ');
          $this->transactionService = App::getDependency('services.transactionServ');
    }
     public function index(){

        $comptes = $this->compteService->compteClient($this->session->get('user', 'id'));
        $transactions = $this->transactionService->getTransactionByClient($_SESSION['user']['id']);
        $this->render('compte/home.php', [
            'transactions' => $transactions,
            'comptes' => $comptes, ]);
     }
     public function create(){
        $this->layout = 'security';
        $this->render('compte/form.principal.php');
     }
     public function store(){}
     public function edit(){}
     public function show(){
        $comptes = $this->compteService->compteClient($this->session->get('user', 'id'));
        $this->render('compte/form.secondaire.php', [
            'comptes' => $comptes, ]);
     }

     private function validateForm(array &$data): array {
    $this->validator->validate($data, [
        'nom' => ['required', ['minLength', 3]],
        'prenom' => ['required', ['minLength', 3]] ,
        'login' => ['required', ['minLength', 4], 'isMail'],
        'password' => ['required', ['minLength', 4], 'isPassword'],
        'adresse' => ['required'],
        'telephone' => ['required', 'isPhone'],
        'numeroCNI' => ['required', 'isCNI']
    ]);

    return $this->validator->getErrors();
}

private function uploadPhotos(array $files): string|false {
    try {
        $uploads = ImageService::uploadMultipleImages([
            'photoRecto' => $files['photoRecto'] ?? null,
            'photoVerso' => $files['photoVerso'] ?? null
        ], __DIR__ . '/../../public/images/uploads/');

        return json_encode([
            'recto' => $uploads['photoRecto']['url'],
            'verso' => $uploads['photoVerso']['url']
        ]);
    } catch (\Exception $e) {
        return false;
    }
}

private function buildUserData(array $data, string $photoPath): array {
    return [
        'nom' => $data['nom'],
        'prenom' => $data['prenom'],
        'login' => $data['login'],
        'password' => $data['password'],
        'adresse' => $data['adresse'],
        'numeroCNI' => $data['numeroCNI'],
        'photoIdentite' => $photoPath,
        'type_user_id' => 3
    ];
}




public function createComptePrincipal() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = $_POST;
        $numeroTelephone = $data['telephone'];    
        $errors = $this->validateForm($data);
    $this->session->set('errors', []);


        if (empty($errors)) {
            $photoPath = $this->uploadPhotos($_FILES);
            if (!$photoPath) {
                $this->session->set('errors', ['photoIdentite' => "Erreur lors de l'envoi des photos."]);
            } else {
                $userData = $this->buildUserData($data, $photoPath);

                $result = $this->compteService->creerComptePrincipal($userData, $numeroTelephone);
                if ($result === true) {
                    header("Location: ".APP_URL."/");

                    $twilioService = new TwilioService();
                    $message = "Bonjour {$userData['prenom']} {$userData['nom']}, votre compte principal a été  créé avec succès sur Maxit SA}.";
                    $smsResult = $twilioService->sendSMS($numeroTelephone, $message);

                    if ($smsResult !== true) {
                        error_log("Erreur SMS Twilio : " . $smsResult);
                    }
                    exit;
                }
                 else {
                    $this->session->set('errors', ['compte' => $result]);
                }

            }
        } else {
            $this->session->set('errors', $errors);
        }
    }

    $this->layout = 'security';
    $this->render("compte/form.principal.php");
}

// public function createCompteSecondaire(){
//      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//         $data = $_POST;

//         $rules = [
//             'telephone' => ['required', 'isPhone'],
//         ];
//         $errors = $this->validator->validate($data, $rules);

//         $userId = $this->session->get('user', 'id');
//         $numeroTel = $data['telephone'];
//         $soldeInitial  = $data['solde'];

//         if(empty($errors)) {
//         $newCompteSecondaire = $this->compteService->creerCompteSecondaire($userId, $numeroTel, $soldeInitial);
//         if ($newCompteSecondaire) {
//             $this->session->set('success', 'Compte secondaire créé avec succès.');
//             header("Location: ".APP_URL."/compte");
//             exit;
//         } else {
//              $this->session->set('errors', $errors);
//             header("Location: ".APP_URL."/compte");
//             exit;
//         }

//     } 

// }
//     $this->render('compte/home.php');


// }


public function createCompteSecondaire() {  
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $this->session->unset('errors');
            $data = $_POST;

             $rules = [
            'telephone' => ['required', 'isPhone'],
             ];

             $errors = $this->validator->validate($data, $rules);
            if (!$errors) {
                $this->session->set('errors', $errors);
                header("Location: " . APP_URL . "/compteSecondaire");
                exit;
            }

            $userId = $this->session->get('user', 'id');
            if (!$userId) {
                $this->session->set('errors', ['general' => 'Utilisateur non connecté']);
                header("Location: " . APP_URL . "/compteSecondaire");
                exit;
            }

            $numeroTel = trim($data['telephone']);
            $soldeInitial = isset($data['solde']) && $data['solde'] !== '' ? (float)$data['solde'] : 0;

            $result = $this->compteService->creerCompteSecondaire($userId, $numeroTel, $soldeInitial);
            if ($result === true) {
                $this->session->set('success', 'Compte secondaire créé avec succès !');
                header("Location: " . APP_URL . "/compte");
                exit;
            } else {
                $this->session->set('errors', ['general' => $result]);
                header("Location: " . APP_URL . "/compteSecondaire");
                exit;
            }
        } catch (Exception $e) {
            $this->session->set('errors', ['general' => 'Erreur interne: ' . $e->getMessage()]);
            header("Location: " . APP_URL . "/compteSecondaire");
            exit;
        }
    }
    header("Location: " . APP_URL . "/compteSecondaire");
    exit;
}


}