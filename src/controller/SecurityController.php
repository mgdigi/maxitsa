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
        $this->securityService = App::getDependency('services', 'securityServ');
        $this->validator = App::getDependency('core','validator');
    }
    public function index(){
        // $errors = $this->validator->getErrors();
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

   

    public function logout(){
        // self::destroy();
        header("Location:". $_ENV['APP_URL']);
    }
    

   
    
}