<?php
namespace Controllers;
use Models\Utilisateur;

class AdminController {
    // Ce contrôleur gère toutes les opérations liées à la gestion des administrateurs


    private $utilisateurModel; // Instance du modèle Utilisateur pour interagir avec la base de données


    public function __construct() {
        // Initialisation du modèle Utilisateur
        $this->utilisateurModel = new Utilisateur();
    }

    // Affiche la vue de gestion des administrateurs
    public function manageAdmins() {
        // Vérifier si l'utilisateur est un master admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'master_admin') {
            echo '<script>alert("Oups ! Seuls les super-héros peuvent passer par là !"); </script>';
            echo '<script>window.history.back()</script>';
            exit;
        }
        // Récupère tous les administrateurs depuis la base de données
        $admins = $this->utilisateurModel->getAllAdmins();

        include 'src/views/admin/manage_admins.php';
    }

    // Crée un nouvel administrateur dans le système
    public function createAdmin() {
        // Vérifie que la requête est de type POST

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom_utilisateur = $_POST['nom_utilisateur'] ?? '';
            $mot_de_passe = $_POST['mot_de_passe'] ?? '';

            // Vérifie que tous les champs obligatoires sont remplis
            if (empty($nom_utilisateur) || empty($mot_de_passe)) {
                $_SESSION['error'] = "Veuillez remplir tous les champs.";

                echo '<script>window.history.back()</script>';
                
            }

            if ($this->utilisateurModel->createAdmin($nom_utilisateur, $mot_de_passe)) {
                $_SESSION['success'] = "Administrateur créé avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la création de l'administrateur.";
            }
            echo '<script>window.history.back()</script>';
            
        }
    }

    // Met à jour les informations d'un administrateur existant
    public function updateAdmin($id) {
        // Vérifie que la requête est de type POST

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom_utilisateur = $_POST['nom_utilisateur'] ?? '';
            $mot_de_passe = $_POST['mot_de_passe'] ?? '';

            // Vérifie que le nom d'utilisateur est fourni
            if (empty($nom_utilisateur)) {
                $_SESSION['error'] = "Le nom d'utilisateur est requis.";

                echo '<script>window.history.back()</script>';
                exit;
            }

            if ($this->utilisateurModel->updateAdmin($id, $nom_utilisateur, $mot_de_passe)) {
                $_SESSION['success'] = "Administrateur mis à jour avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la mise à jour de l'administrateur.";
            }
            echo '<script>window.history.back()</script>';
            exit;
        }
    }
    // Supprime un administrateur du système
    public function deleteAdmin($id) {
        // Tente de supprimer l'administrateur et gère le résultat

        if ($this->utilisateurModel->deleteAdmin($id)) {
            $_SESSION['success'] = "Administrateur supprimé avec succès.";
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression de l'administrateur.";
        }
        echo '<script>window.history.back();
</script>';
        exit;
    }
}
