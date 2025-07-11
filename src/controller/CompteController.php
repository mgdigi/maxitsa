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
          $this->validator = App::getDependency('core','validator');
          $this->securityService = App::getDependency('services', 'securityServ');
          $this->imageService = App::getDependency('core', 'imageServ');
          $this->compteService = App::getDependency('services', 'compteServ');
          $this->transactionService = App::getDependency('services', 'transactionServ');
    }
     public function index(){

        $comptes = $this->compteService->compteClient($_SESSION['user']['id']);
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
     public function show(){}

     private function validateForm(array &$data): array {
    $this->validator->validate($data, [
        'nom' => ['required', ['minLength', 3]],
        'prenom' => ['required', ['minLength', 3]],
        'login' => ['required', ['minLength', 4], 'isMail'],
        'password' => ['required', ['minLength', 4], 'isPassword'],
        'adresse' => ['required'],
        'numeros' => ['required', 'isSenegalPhone'],
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
        'password' => password_hash($data['password'], PASSWORD_BCRYPT),
        'adresse' => $data['adresse'],
        'numeros' => $data['numeros'],
        'numeroCNI' => $data['numeroCNI'],
        'photoIdentite' => $photoPath,
        'type_user_id' => 3
    ];
}




public function createComptePrincipal() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = $_POST;
        $errors = $this->validateForm($data);

        if (empty($errors)) {
            $photoPath = $this->uploadPhotos($_FILES);
            if (!$photoPath) {
                $this->session->set('errors', ['photoIdentite' => "Erreur lors de l'envoi des photos."]);
            } else {
                $userData = $this->buildUserData($data, $photoPath);
                $compteData = [];

                $result = $this->compteService->creerComptePrincipal($userData, $compteData);
                if ($result === true) {
                    $twilioService = new TwilioService();
                    $message = "Bonjour {$userData['prenom']} {$userData['nom']}, votre compte principal a été  créé avec succès sur Maxit SA}.";
                    $smsResult = $twilioService->sendSMS($userData['numeros'], $message);

                    if ($smsResult !== true) {
                        error_log("Erreur SMS Twilio : " . $smsResult);
                    }
                    header("Location: ".$_ENV['APP_URL']."/");
                    exit;
                } else {
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


}