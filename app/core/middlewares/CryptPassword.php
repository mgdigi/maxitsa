<?php

namespace App\Core\Middlewares;
class CryptPassword{

    public function __invoke($password){
        if(isset($POST['password'])){
        $_POST['password'] =  password_hash($password, PASSWORD_DEFAULT);
        }
    }

}