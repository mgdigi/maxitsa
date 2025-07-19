<?php

namespace App\Service;
use App\Core\App;
use App\Entity\User;
use App\Core\Singleton;
use App\Repository\UsersRepository;
use App\Repository\CompteRepository;
use App\Repository\TelephoneRepository;


class SecurityService extends Singleton{
    private UsersRepository $userRepository;
    private TelephoneRepository $telephoneRepository;
    private CompteRepository $compteRepository;
    


    protected function __construct(){
        $this->userRepository = App::getDependency('usersRepo');
        $this->compteRepository = App::getDependency('compteRepo');
        $this->telephoneRepository = App::getDependency('telephoneRepo');
    }

    public function seConnecter(string $login, string $password): ?User {
    $user = $this->userRepository->selectByLogin($login);
    if ($user && password_verify($password, $user->getPassword())) {
        return $user;
    }
    return null;
}

   public function creerComptePrincipal(array $userData, $numeroTelephone): bool|string {
    $existingNumero = $this->telephoneRepository->findByNumero($numeroTelephone);
    if ($existingNumero) {
        return "Ce numéro de téléphone est déjà associé à un compte.";
    }
    return $this->telephoneRepository->insertPrincipale($userData, $numeroTelephone);

}

}