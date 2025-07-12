<?php

namespace App\Service;
use App\Core\App;
use App\Entity\User;
use App\Repository\CompteRepository;
use App\Repository\UsersRepository;


class SecurityService{
    private UsersRepository $userRepository;
    private CompteRepository $compteRepository;
    private static SecurityService|null $instance = null;

    public static function getInstance():SecurityService{
        if(self::$instance == null){
            self::$instance = new SecurityService();
        }
        return self::$instance;
    }


    public function __construct(){
        $this->userRepository = App::getDependency('repositories.usersRepo');
        $this->compteRepository = App::getDependency('repositories.compteRepo');
    }

    public function seConnecter(string $login, string $password): ?User {
    $user = $this->userRepository->selectByLogin($login);
    if ($user && password_verify($password, $user->getPassword())) {
        return $user;
    }
    return null;
}



}