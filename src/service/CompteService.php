<?php
namespace App\Service;
use App\Repository\CompteRepository;
use App\Repository\TelephoneRepository;
use App\Repository\TransactionRepository;
use App\Repository\UsersRepository;
use App\Core\App;
use \PDO;
use \Exception;

class CompteService{
    private CompteRepository $compteRepository;
    private UsersRepository $userRepository;

    private PDO $pdo;

    private TelephoneRepository $telephoneRepository;
    private TransactionRepository $transactionRepository;

    private static CompteService|null $instance = null;

    public static function getInstance():CompteService{
        if(self::$instance == null){
            self::$instance = new CompteService();
        }
        return self::$instance;
    }

    public function __construct(){
        $this->compteRepository = App::getDependency('repositories.compteRepo');
        $this->userRepository = App::getDependency('repositories.usersRepo');
        $this->telephoneRepository = App::getDependency('repositories.telephoneRepo');
        $this->transactionRepository = App::getDependency('repositories.transactionRepo');
        $this->pdo = App::getDependency('core.database')->getConnection();

    }

    // public function creerComptePrincipal(array $userData, array $compteData): bool|string {
    // $existing = $this->compteRepository->findPrincipalByUserId($userData['id_user'] ?? 0);
    // if ($existing) return "Un compte principal existe déjà pour cet utilisateur.";

    // $userId = $this->userRepository->insert($userData);
    
    // $numeroCompte = "CPR-" . time();

    // $compteData['numero'] = $numeroCompte;
    // $compteData['typeCompte'] = "Principal";
    // $compteData['solde'] = 0;
    // $compteData['dateCreation'] = date('Y-m-d');
    // $compteData['id_user'] = $userId;

    // return $this->compteRepository->insert($compteData);
    // }

   
     public function creerComptePrincipal(array $userData, $numeroTelephone): bool|string {
        $existingNumero = $this->telephoneRepository->findByNumero($numeroTelephone);
        if ($existingNumero) {
            return "Ce numéro de téléphone est déjà associé à un compte.";
        }

        $this->pdo->beginTransaction();

        try {
            $userId = $this->userRepository->insert($userData);
            if (!$userId) {
                throw new Exception("Erreur lors de la création de l'utilisateur.");
            }

            $numeroCompte = "CPR-" . time();
            $compteData = [
                'numero' => $numeroCompte,
                'typeCompte' => 'Principal',
                'solde' => 0,
                'dateCreation' => date('Y-m-d'),
                'id_user' => $userId
            ];

            $compteId = $this->compteRepository->insert($compteData);
            if (!$compteId) {
                throw new Exception("Erreur lors de la création du compte.");
            }

            $numeroData = [
                'numero' => $numeroTelephone,
                'user_id' => $userId,
                'compte_id' => $compteId
            ];

            $numeroCreated = $this->telephoneRepository->insert($numeroData);
            if (!$numeroCreated) {
                throw new Exception("Erreur lors de l'association du numéro de téléphone.");
            }

            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            return "Erreur : " . $e->getMessage();
        }
    }

    //  public function creerCompteSecondaire($userId, $numeroTelephone, $soldeInitial = 0): bool|string {
    //     $user = $this->userRepository->selectById($userId);
    //     if (!$user) return "Utilisateur non trouvé.";

    //     $existingNumero = $this->telephoneRepository->findByNumero($numeroTelephone);
    //     if ($existingNumero) {
    //         return "Ce numéro de téléphone est déjà associé à un compte.";
    //     }

    //     $comptePrincipal = $this->compteRepository->findPrincipalByUserId($userId);
    //     if (!$comptePrincipal) {
    //         return "Vous devez d'abord créer un compte principal.";
    //     }

    //     if ($soldeInitial > 0 && $soldeInitial > $comptePrincipal['solde']) {
    //         return "Solde insuffisant sur le compte principal.";
    //     }

    //     $this->pdo->beginTransaction();

    //     try {
    //           $numeroCompte = "CPR-" . time();

    //         $compteData = [
    //             'numero' => $numeroCompte,
    //             'typeCompte' => 'Secondaire',
    //             'solde' => $soldeInitial,
    //             'dateCreation' => date('Y-m-d'),
    //             'id_user' => $userId
    //         ];

    //         $compteId = $this->compteRepository->insert($compteData);
    //         if (!$compteId) {
    //             throw new Exception("Erreur lors de la création du compte.");
    //         }

    //         $numeroData = [
    //             'numero' => $numeroTelephone,
    //             'user_id' => $userId,
    //             'compte_id' => $compteId
    //         ];

    //         $numeroCreated = $this->telephoneRepository->insert($numeroData);
    //         if (!$numeroCreated) {
    //             throw new Exception("Erreur lors de l'association du numéro de téléphone.");
    //         }

    //         if ($soldeInitial > 0) {
    //             $nouveauSoldePrincipal = $comptePrincipal['solde'] - $soldeInitial;
    //             $this->compteRepository->updateSolde($comptePrincipal['id'], $nouveauSoldePrincipal);

    //             $this->transactionRepository->insert([
    //                 'compte_id' => $comptePrincipal['id'],
    //                 'datetransaction' => date('Y-m-d H:i:s'),
    //                 'montant' => $soldeInitial,
    //                 'libelle' => "Transfert vers compte secondaire {$numeroCompte}",
    //                 'typetransaction' => 'DEPOT',
    //                 'client_id' => $userId,
    //             ]);

    //             $this->transactionRepository->insert([
    //                 'compte_id' => $compteId,
    //                 'datetransaction' => date('Y-m-d H:i:s'),
    //                 'montant' => $soldeInitial,
    //                 'libelle' => "Transfert depuis compte principal",
    //                 'typetransaction' => 'RETRAIT',
    //                 'client_id' => $userId,
                    
    //             ]);
    //         }

    //         $this->pdo->commit();
    //         return true;

    //     } catch (Exception $e) {
    //         $this->pdo->rollBack();
    //         return "Erreur : " . $e->getMessage();
    //     }
    // }


    public function creerCompteSecondaire($userId, $numeroTelephone, $soldeInitial = 0): bool|string {
    $user = $this->userRepository->selectById($userId);
    if (!$user) return "Utilisateur non trouvé.";
    
    $existingNumero = $this->telephoneRepository->findByNumero($numeroTelephone);
    if ($existingNumero) {
        return "Ce numéro de téléphone est déjà associé à un compte.";
    }
    
    $comptePrincipal = $this->compteRepository->findPrincipalByUserId($userId);
    if (!$comptePrincipal) {
        return "Vous devez d'abord créer un compte principal.";
    }
    
    if ($soldeInitial > 0 && $soldeInitial > $comptePrincipal['solde']) {
        return "Solde insuffisant sur le compte principal.";
    }
    
    $this->pdo->beginTransaction();
    
    try {
        $numeroCompte = "CPR-" . time();
        $compteData = [
            'numero' => $numeroCompte,
            'typeCompte' => 'Secondaire',
            'solde' => $soldeInitial,
            'dateCreation' => date('Y-m-d'),
            'id_user' => $userId
        ];
        
        $compteId = $this->compteRepository->insert($compteData);
        if (!$compteId) {
            throw new Exception("Erreur lors de la création du compte.");
        }
        
        $numeroData = [
            'numero' => $numeroTelephone,
            'user_id' => $userId,
            'compte_id' => $compteId
        ];
        
        $numeroCreated = $this->telephoneRepository->insert($numeroData);
        if (!$numeroCreated) {
            throw new Exception("Erreur lors de l'association du numéro de téléphone.");
        }
        
        if ($soldeInitial > 0) {
            $nouveauSoldePrincipal = $comptePrincipal['solde'] - $soldeInitial;
            $this->compteRepository->updateSolde($comptePrincipal['id'], $nouveauSoldePrincipal);
            
            // Transaction RETRAIT pour le compte principal
            $this->transactionRepository->insert([
                'compte_id' => $comptePrincipal['id'],
                'datetransaction' => date('Y-m-d H:i:s'),
                'montant' => $soldeInitial,
                'libelle' => "Transfert vers compte secondaire {$numeroCompte}",
                'typetransaction' => 'RETRAIT', // CORRIGÉ : RETRAIT pour le compte principal
                'client_id' => $userId,
            ]);
            
            // Transaction DEPOT pour le compte secondaire
            $this->transactionRepository->insert([
                'compte_id' => $compteId,
                'datetransaction' => date('Y-m-d H:i:s'),
                'montant' => $soldeInitial,
                'libelle' => "Transfert depuis compte principal",
                'typetransaction' => 'DEPOT', // CORRIGÉ : DEPOT pour le compte secondaire
                'client_id' => $userId,
            ]);
        }
        
        $this->pdo->commit();
        return true;
        
    } catch (Exception $e) {
        $this->pdo->rollBack();
        return "Erreur : " . $e->getMessage();
    }
}
    public function changerEnComptePrincipal($userId, $compteSecondaireId): bool|string {
        $comptePrincipalActuel = $this->compteRepository->findPrincipalByUserId($userId);
        if (!$comptePrincipalActuel) return "Aucun compte principal trouvé.";

        $compteSecondaire = $this->compteRepository->selectById($compteSecondaireId);
        if (!$compteSecondaire || $compteSecondaire['user_id'] != $userId) {
            return "Compte secondaire non trouvé ou non autorisé.";
        }

        if ($compteSecondaire['typecompte'] !== 'Secondaire') {
            return "Ce compte n'est pas un compte secondaire.";
        }

        $this->pdo->beginTransaction();

        try {
            $this->compteRepository->updateTypeCompte($comptePrincipalActuel['id'], 'Secondaire');
            
            $this->compteRepository->updateTypeCompte($compteSecondaireId, 'Principal');

            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            return "Erreur lors du changement : " . $e->getMessage();
        }
    }

    public function getComptesByUserId($userId): array {
        return $this->telephoneRepository->findByUserId($userId);
    }

    public function rechercherCompteParNumero($numeroTelephone): ?array {
        return $this->telephoneRepository->findByNumero($numeroTelephone);
    }

    public function compteClient($user_id){
        return $this->compteRepository->selectByClient($user_id);
    }


}