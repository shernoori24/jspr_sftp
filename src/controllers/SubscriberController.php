<?php
namespace Controllers;

use Models\SubscriberModel;
use Models\EmailModel;

class SubscriberController {
    // Ce contrôleur gère les opérations liées aux abonnés de la newsletter

    protected $subscriberModel; // Modèle pour gérer les abonnés
    protected $emailModel; // Modèle pour gérer l'envoi d'emails


    public function __construct() {
        // Initialisation des modèles nécessaires
        $this->subscriberModel = new SubscriberModel();
        $this->emailModel = new EmailModel();
    }
    // Méthode pour afficher la page de abbonné
    public function affichePageAdminSubscribers() {
        include 'src/views/admin/abonnes.php';
    }

    // Récupère tous les abonnés depuis la base de données
    public function getAllSubscribers() {

        return $this->subscriberModel->getAllSubscribers();
    }

    // Ajoute un nouvel abonné et envoie un email de confirmation
    public function addSubscriber($email) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                try {
                    $this->subscriberModel->addSubscriber($email);
        
                    // Envoyer un email de confirmation
                    $subject = "Bienvenue dans notre Newsletter - Activation de votre inscription";
                    $content = "
                        <h1 style='color:#2c3e50;'>Bienvenue à la Newsletter de notre association</h1>
                        <p>Merci de vous être inscrit(e) à notre newsletter ! Nous sommes ravis de vous compter parmi nous.</p>
                        <p>Grâce à cette newsletter, vous recevrez :</p>
                        <ul>
                            <li>📅 Les dernières actualités et événements de l'association</li>
                            <li>🎭 Nos prochains ateliers et formations</li>
                            <li>📰 Le journal de l'association avec des témoignages et des mises à jour</li>
                        </ul>
                        <p>Si vous n'avez pas demandé cette inscription, désabonnez-vous ci-dessous.</p>
                        <p>À très bientôt,</p>
                        <p><strong>L'équipe de l'association J'SPR</strong></p>
                    ";
        
                    $token = $this->subscriberModel->generateUnsubscribeToken($email);
                    $unsubscribeLink = "http://localhost/projets/jspr/unsubscribe?email=" . urlencode($email) . "&token=" . $token;
        
                    $this->emailModel->sendEmail($email, $subject, $content, $unsubscribeLink, []);


                    // $_SESSION['status'] = "Abonné ajouté avec succès.";
                    // Retourner une réponse JSON pour AJAX
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Abonné ajouté avec succès.']);
                } catch (\Exception $e) {
                    // Gérer l'exception (email déjà existant)
                    // $_SESSION['error'] = $e->getMessage();
                    // Retourner une réponse JSON en cas d'erreur
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                }
            } else {
                // $_SESSION['error'] = "Veuillez entrer une adresse email valide.";
                // Retourner une réponse JSON si l'email est invalide
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Veuillez entrer une adresse email valide.']);
            }
        }


    }
    public function searchSubscriber($search_email){
        
            return $this->subscriberModel->searchSubscriber($search_email);
        
    }

    // Met à jour l'email d'un abonné existant
    public function updateSubscriber($id, $email) {

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->subscriberModel->updateSubscriber($id, $email);
            $_SESSION['status'] = "Abonné modifié avec succès.";
        } else {
            $_SESSION['error'] = "Veuillez entrer une adresse email valide.";
        }
    }

    // Supprime un abonné de la base de données
    public function deleteSubscriber($id) {

        $this->subscriberModel->deleteSubscriber($id);
        $_SESSION['status'] = "Abonné supprimé avec succès.";
    }

    // Gère le processus de désabonnement d'un utilisateur
    public function unsubscribe($email, $token) {

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if ($this->subscriberModel->validateUnsubscribeToken($email, $token)) {
                if ($this->subscriberModel->deleteSubscriberByEmail($email)) {
                    echo "<h2>Vous avez bien été supprimé de notre liste d'abonnement.</h2>";
                } else {
                    error_log("Erreur lors de la suppression de l'abonné : $email");
                    echo "<h2>Erreur : Impossible de vous désabonner.</h2>";
                }
            } else {
                error_log("Tentative de désabonnement avec un token invalide : $email");
                echo "<h2>Token invalide ou expiré.</h2>";
            }
        } else {
            echo "<h2>Email invalide.</h2>";
        }
    }
}
