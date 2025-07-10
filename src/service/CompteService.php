<?php
namespace App\Service;
use App\Repository\CompteRepository;
use App\Repository\UsersRepository;
use App\Core\App;

class CompteService{
    private CompteRepository $compteRepository;
    private UsersRepository $userRepository;

    public function __construct(){
        $this->compteRepository = App::getDependency('repositories', 'compteRepo');
        $this->userRepository = App::getDependency('repositories', 'usersRepo');
    }

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