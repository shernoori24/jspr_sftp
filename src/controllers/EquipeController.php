<?php 
namespace Controllers;

use Models\Equipe;

class EquipeController {
    protected $equipeModel;

    public function __construct() {
        $this->equipeModel = new Equipe();
    }


    public function getBenevoles() {
        return $this->equipeModel->getMembresByCategorie(1); // ID 1 = bénévoles
    }

    public function getSalaries() {
        return $this->equipeModel->getMembresByCategorie(3); // ID 2 = salariés
    }
    /**
     * Gère l'ajout ou la sélection d'un poste
     */
    public function handlePoste($posteInput) {
        // Si c'est un ID numérique, on le retourne directement
        if (is_numeric($posteInput)) {
            return (int)$posteInput;
        }
        
        // Sinon, vérifie si le poste existe déjà
        $existingPoste = $this->equipeModel->posteExists($posteInput);
        
        if ($existingPoste) {
            return $existingPoste['id'];
        } else {
            // Ajoute le nouveau poste
            return $this->equipeModel->addPoste($posteInput);
        }
    }

    /**
     * Récupère tous les membres
     */
    public function getAllMembre() {
        return $this->equipeModel->getAllMembre();
    }

    /**
     * Récupère tous les postes
     */
    public function getAllPostes() {
        return $this->equipeModel->getAllPostes();
    }

    /**
     * Récupère toutes les catégories
     */
    public function getAllCategories() {
        return $this->equipeModel->getAllCategories();
    }

    /**
     * Ajoute un nouveau membre
     */
    public function addMembre($nom, $description, $poste_id, $categorie_id) {
        return $this->equipeModel->addMembre($nom, $description, $poste_id, $categorie_id);
    }

    /**
     * Met à jour un membre existant
     */
    public function updateMembre($id, $nom, $description, $poste_id, $categorie_id) {
        return $this->equipeModel->updateMembre($id, $nom, $description, $poste_id, $categorie_id);
    }

    /**
     * Supprime un membre
     */
    public function deleteMembre($id) {
        return $this->equipeModel->deleteMembre($id);
    }

    /**
     * Affiche la page d'administration des membres
     */
    public function affichePageAdminEquipe() {
        // Récupération des données nécessaires
        $membres = $this->getAllMembre();
        $categories = $this->getAllCategories();
        $postes = $this->getAllPostes();

        // Gestion des requêtes POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['add_membre'])) {
                $nom = trim($_POST['nom']);
                $description = trim($_POST['description']);
                $categorie_id = (int)$_POST['categorie_id'];
                
                // Gestion du poste (existant ou nouveau)
                $posteInput = $_POST['poste_select'] === 'new' 
                    ? trim($_POST['new_poste'])
                    : $_POST['poste_select'];
                
                // Validation
                if (empty($nom) || empty($description) || empty($posteInput) || $categorie_id <= 0) {
                    $_SESSION['error'] = "Tous les champs sont obligatoires";
                    echo '<script>window.location.href = window.location.href;</script>';
                    exit();
                }
                
                // Traitement du poste
                $poste_id = $this->handlePoste($posteInput);
                
                // Ajout du membre
                $this->addMembre($nom, $description, $poste_id, $categorie_id);
                $_SESSION['message'] = "Votre membre a été ajouté avec succès";
                echo '<script>window.location.href = window.location.href;</script>';
                exit();
            }
            elseif (isset($_POST['edit_membre'])) {
                    $id = (int)$_POST['id'];
                    $nom = trim($_POST['nom']);
                    $description = trim($_POST['description']);
                    $categorie_id = (int)$_POST['categorie_id'];
                    
                    // Gestion du poste (existant ou nouveau)
                    $posteInput = $_POST['poste_select'] === 'new' 
                        ? trim($_POST['new_poste'])
                        : $_POST['poste_select'];
                    
                    // Validation
                    if (empty($nom) || empty($description) || empty($posteInput) || $categorie_id <= 0) {
                        $_SESSION['error'] = "Tous les champs sont obligatoires";
                        header('Location: ' . $_SERVER['PHP_SELF']);
                        exit();
                    }
                    
                    // Traitement du poste
                    $poste_id = $this->handlePoste($posteInput);
                    
                    // Mise à jour du membre
                    $this->updateMembre($id, $nom, $description, $poste_id, $categorie_id);
                    $_SESSION['message'] = "Votre membre a été mis à jour avec succès";
                    
                
                echo '<script>window.location.href = window.location.href;</script>';
                exit();
            }
            elseif (isset($_POST['delete_membre'])) {
                $id = (int)$_POST['id'];
                $this->deleteMembre($id);
                $_SESSION['message'] = "Votre membre a été supprimé avec succès";
                echo '<script>window.location.href = window.location.href;</script>';
                exit();
            }
        }

        // Inclusion de la vue
        include_once 'src/views/admin/equipe.php';
    }
}
