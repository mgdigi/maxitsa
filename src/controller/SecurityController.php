<?php

namespace App\Controller;
use App\Core\App;
use App\Core\Abstract\AbstractController;


use App\Core\Validator;
use App\Service\SecurityService;


class SecurityController extends AbstractController{

    private SecurityService $securityService;
    private Validator $validator;


    public function __construct(){
        parent::__construct();
        $this->layout = 'security';
        $this->securityService = App::getDependency('services.securityServ');
        $this->validator = App::getDependency('core.validator');
    }
    public function index(){
        $this->unset('errors');
        $this->render("login/login.php");
    }
    public function show(){}
    public function create(){
    }

   public function store(){
    }

    public function edit(){
    }

    // public function destroy(){}

    public function login(){

        

        $loginData = [
            'email' => $_POST['login'] ?? '',
            'password' => $_POST['password'] ?? ''
        ];
      

        $rules = [
            'email' => [
                'required',
                ['minLength', 4, "L'email doit contenir au moins 4 caractères"],
                'isMail'
            ],
            'password' => [
                'required',
                ['minLength', 4, "Le mot de passe doit contenir au moins 5 caractères"]
            ]
        ];

        

        if($this->validator->validate($loginData, $rules)){
        $user = $this->securityService->seConnecter($loginData['email'], $loginData['password']);  
         if($user){
             $this->session->set("user", $user->toArray());
            header("Location:". APP_URL. "/compte");
            exit();
         }else{
            $this->validator->addError('password', "Identifiant incorrect");
            $this->session->set('errors', $this->validator->getErrors());
            $this->render("login/login.php");
         }
        }else{
            $this->session->set('errors', $this->validator->getErrors());
            $this->render("login/login.php");
        }
    }

    public function logout(){
        session_destroy();
        header("Location:". APP_URL);
    }
    

   
    
}