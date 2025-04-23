<?php 
namespace Models;

use PDOException;

class Utilisateur extends Bdd {

    // Récupérer un utilisateur par son nom_utilisateur
    public function getByNomUtilisateur($nom_utilisateur) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT u.*, r.role 
                FROM utilisateurs u
                JOIN roles_utilisateurs r ON u.role_id = r.id
                WHERE u.nom_utilisateur = ?
            ");
            $stmt->execute([$nom_utilisateur]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de l'utilisateur : " . $e->getMessage());
            return null;
        }
    }

    // Valider la connexion d'un utilisateur
    public function validateLogin($nom_utilisateur, $mot_de_passe) {
        try {
            $user = $this->getByNomUtilisateur($nom_utilisateur);
            if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
                return $user;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur lors de la validation de la connexion : " . $e->getMessage());
            return false;
        }
    }

    // Récupérer un utilisateur par son ID
    public function getUserById($id) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT u.*, r.role 
                FROM utilisateurs u
                JOIN roles_utilisateurs r ON u.role_id = r.id
                WHERE u.id = ?
            ");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de l'utilisateur par ID : " . $e->getMessage());
            return null;
        }
    }

    // Mettre à jour le mot de passe d'un utilisateur
    public function updatePassword($id, $newPassword) {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE utilisateurs 
                SET mot_de_passe = ? 
                WHERE id = ?
            ");
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            return $stmt->execute([$hashedPassword, $id]);
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour du mot de passe : " . $e->getMessage());
            return false;
        }
    }

    // Mettre à jour le rôle d'un utilisateur (seulement pour master_admin)
    public function updateRole($masterAdminId, $userId, $newRoleId) {
        try {
            // Vérifier si l'utilisateur est un master_admin
            $masterAdmin = $this->getUserById($masterAdminId);
            if ($masterAdmin['role'] !== 'master_admin') {
                throw new \Exception("Seul le master admin peut modifier les rôles.");
            }

            // Mettre à jour le rôle
            $stmt = $this->pdo->prepare("
                UPDATE utilisateurs 
                SET role_id = ? 
                WHERE id = ?
            ");
            return $stmt->execute([$newRoleId, $userId]);
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour du rôle : " . $e->getMessage());
            return false;
        }
    }

    // Modifier le nom d'utilisateur et le mot de passe du master admin
    public function updateMasterAdmin($id, $nom_utilisateur, $mot_de_passe = null) {
        return $this->updateAdmin($id, $nom_utilisateur, $mot_de_passe);
    }


    // Récupérer tous les administrateurs (sauf les utilisateurs normaux)
    public function getAllAdmins() {
        try {
            $stmt = $this->pdo->prepare("
                SELECT u.*, r.role 
                FROM utilisateurs u
                JOIN roles_utilisateurs r ON u.role_id = r.id
                WHERE r.role IN ('master_admin', 'admin')
            ");
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des administrateurs : " . $e->getMessage());
            return [];
        }
    }

    // Créer un nouvel administrateur
    public function createAdmin($nom_utilisateur, $mot_de_passe, $role_id = 2) { // Par défaut, rôle "admin"
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO utilisateurs (nom_utilisateur, mot_de_passe, role_id) 
                VALUES (?, ?, ?)
            ");
            $hashedPassword = password_hash($mot_de_passe, PASSWORD_DEFAULT);
            return $stmt->execute([$nom_utilisateur, $hashedPassword, $role_id]);
        } catch (PDOException $e) {
            error_log("Erreur lors de la création de l'administrateur : " . $e->getMessage());
            return false;
        }
    }

    // Modifier un administrateur
    public function updateAdmin($id, $nom_utilisateur, $mot_de_passe = null) {
        try {
            if ($mot_de_passe) {
                $stmt = $this->pdo->prepare("
                    UPDATE utilisateurs 
                    SET nom_utilisateur = ?, mot_de_passe = ? 
                    WHERE id = ?
                ");
                $hashedPassword = password_hash($mot_de_passe, PASSWORD_DEFAULT);
                return $stmt->execute([$nom_utilisateur, $hashedPassword, $id]);
            } else {
                $stmt = $this->pdo->prepare("
                    UPDATE utilisateurs 
                    SET nom_utilisateur = ? 
                    WHERE id = ?
                ");
                return $stmt->execute([$nom_utilisateur, $id]);
            }
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour de l'administrateur : " . $e->getMessage());
            return false;
        }
    }

    // Supprimer un administrateur
    public function deleteAdmin($id) {
        try {
            $stmt = $this->pdo->prepare("
                DELETE FROM utilisateurs 
                WHERE id = ?
            ");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression de l'administrateur : " . $e->getMessage());
            return false;
        }
    }


}