<?php

namespace App\Controller;
use App\Core\Abstract\AbstractController;
use App\Core\App;
use App\Core\Validator;
use App\Service\SecurityService;
use App\Core\ImageService;

class CompteController extends AbstractController{

    private Validator $validator;
    private SecurityService $securityService;

    private ImageService $imageService;
    

    public function __construct(){
           parent::__construct();
          $this->validator = App::getDependency('core','validator');
          $this->securityService = App::getDependency('services', 'securityServ');
          $this->imageService = App::getDependency('core', 'imageServ');
    }
     public function index(){
        $this->render('compte/home.php');
     }
     public function create(){
        $this->layout = 'security';
        $this->render('compte/form.principal.php');
     }
     public function store(){}
     public function edit(){}
    // abstract public function destroy();
     public function show(){}



public function createComptePrincipal() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = $_POST;
        $files = $_FILES;

        $this->validator->isEmpty('nom', $data['nom']);
        $this->validator->isEmpty('prenom', $data['prenom']);
        $this->validator->isEmpty('login', $data['login']);
        $this->validator->isEmpty('password', $data['password']);
        $this->validator->isEmpty('adresse', $data['adresse']);
        $this->validator->isEmpty('numeros', $data['numeros']);
        $this->validator->isEmpty('numeroCNI', $data['numeroCNI']);

        $photoPath = '';
        try {
    $uploads = ImageService::uploadMultipleImages([
        'photoRecto' => $_FILES['photoRecto'],
        'photoVerso' => $_FILES['photoVerso']
    ], __DIR__ . '/../../public/images/uploads/');

    $photoPath = json_encode([
        'recto' => $uploads['photoRecto']['url'],
        'verso' => $uploads['photoVerso']['url']
    ]);
} catch (\Exception $e) {
    $this->validator->addError('photoIdentite', $e->getMessage());
}


        

        if ($this->validator->isValid()) {
            $userData = [
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'login' => $data['login'],
                'password' => password_hash($data['password'], PASSWORD_BCRYPT),
                'adresse' => $data['adresse'],
                'numeros' => $data['numeros'],
                'numeroCNI' => $data['numeroCNI'],
                'photoIdentite' => $photoPath,
                'type_user_id' => 3,
            ];

            $compteData = []; 

            $result = $this->securityService->creerComptePrincipal($userData, $compteData);
            if ($result === true) {
                header("Location: ".$_ENV['APP_URL']."/login");
                exit;
            } else {
                $this->session->set('errors', ['compte' => $result]);
            }
        } else {
            $this->session->set('errors', $this->validator->getErrors());
        }

        $this->render("compte/form.principal.php");
    } else {
        $this->render("compte/form.principal.php");
    }
}

}