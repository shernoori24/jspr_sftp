<?php
namespace Controllers;

use Models\Utilisateur;

class AuthController {
    // Ce contrôleur gère l'authentification des utilisateurs (connexion/déconnexion)
    

    private $utilisateurModel; // Instance du modèle Utilisateur pour interagir avec la base de données


    public function __construct() {
        // Initialisation du modèle Utilisateur
        $this->utilisateurModel = new Utilisateur();
    }

    // methode pour afficher page login 
    public function afficheLoginPage() {
        include_once 'src/views/admin/login.php';
        }
    // Gère le processus de connexion d'un utilisateur
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom_utilisateur = $_POST['username'] ?? '';
            $mot_de_passe = $_POST['password'] ?? '';
            header('Content-Type: application/json');
            if (empty($nom_utilisateur) || empty($mot_de_passe)) {
                
                echo(json_encode(['success' => false, 'message' => "Veuillez remplir tous les champs."]));
                
            }else {
                $user = $this->utilisateurModel->validateLogin($nom_utilisateur, $mot_de_passe);

                if ($user) {
                    // $_SESSION['user'] = $user['nom_utilisateur'];
                    $_SESSION['user'] = $user;
                    
                   
                    echo(json_encode(['success' => true, 'role' => $user['role']]));
                    
                } else {
                    
                    echo(json_encode(['success' => false, 'message' => "Nom d'utilisateur ou mot de passe incorrect."]));
                    
                }
            }  
        }
    }

    // Gère le processus de déconnexion d'un utilisateur
    public function logout() {

        // Nettoie les données de session et détruit la session
        // session_unset();
        // session_destroy();

        echo "<script>window.location.href = 'accueil'</script>";
        exit;
    }
}