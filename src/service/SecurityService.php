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
        $this->userRepository = App::getDependency('repositories', 'usersRepo');
        $this->compteRepository = App::getDependency('repositories', 'compteRepo');
    }

    // public function seConnecter($login, $password):User|null{
    //     return $this->userRepository->selectByLoginAndPassword($login, $password);

    // }

    


    public function creerComptePrincipal(array $userData, array $compteData): bool|string {
    $existing = $this->compteRepository->findPrincipalByUserId($userData['id_user'] ?? 0);
    if ($existing) return "Un compte principal existe déjà pour cet utilisateur.";

    $userId = $this->userRepository->insert($userData);
    
    $numeroCompte = "CPR-" . time();

    $compteData['numero'] = $numeroCompte;
    $compteData['typeCompte'] = "Principal";
    $compteData['solde'] = 0;
    $compteData['dateCreation'] = date('Y-m-d');
    $compteData['id_user'] = $userId;

    return $this->compteRepository->insert($compteData);
}


}