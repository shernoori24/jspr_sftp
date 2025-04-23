<?php
namespace Controllers;

use Models\SubscriberModel;
use Models\EmailModel;

class NewsletterController {
    // Ce contrôleur gère l'envoi de newsletters aux abonnés

    protected $subscriberModel; // Modèle pour gérer les abonnés
    protected $emailModel; // Modèle pour gérer l'envoi d'emails


    public function __construct() {
        // Initialisation des modèles nécessaires
        $this->subscriberModel = new SubscriberModel();
        $this->emailModel = new EmailModel();
    }

    // afficher la page send newsletter
    public function affichePageAdminSendNewsletter() {
        include 'src/views/admin/envoy_newsletter.php';

    }

    /**
     * Envoie une newsletter à tous les abonnés.
     *
     * @param string $subject Sujet de l'email
     * @param string $content Contenu de l'email (HTML)
     */
    // Envoie une newsletter à tous les abonnés
    public function sendNewsletter($subject, $content) {

        // Formate le contenu pour l'affichage HTML

        $content = "<h1>" . htmlspecialchars($subject) . "</h1>" . nl2br($content);

        // Récupère tous les abonnés depuis la base de données

        $subscribers = $this->subscriberModel->getAllSubscribers();

        $errors = [];
        $attachments = [];

        // Gère le téléchargement des pièces jointes

        if (!empty($_FILES['attachments']['name'][0])) {
            foreach ($_FILES['attachments']['tmp_name'] as $key => $tmpName) {
                $fileName = $_FILES['attachments']['name'][$key];
                $filePath = 'uploads/newsletter/' . basename($fileName);

                // Crée le dossier uploads s'il n'existe pas

                if (!is_dir( 'uploads/newsletter')) {
                    mkdir( 'uploads/newsletter', 0777, true);
                }

                // Déplace le fichier téléchargé vers le dossier uploads

                if (move_uploaded_file($tmpName, $filePath)) {
                    $attachments[] = $filePath;
                } else {
                    $errors[] = "Erreur lors de l'upload du fichier : $fileName";
                }
            }
        }

        // Envoie la newsletter à chaque abonné

        foreach ($subscribers as $subscriber) {
            $token = $this->subscriberModel->generateUnsubscribeToken($subscriber['email']);
            $unsubscribeLink = "http://localhost/projets/jspr/unsubscribe?email=" . urlencode($subscriber['email']) . "&token=" . $token;

            if (!$this->emailModel->sendEmail($subscriber['email'], $subject, $content, $unsubscribeLink, $attachments)) {
                $errors[] = $subscriber['email'];
            }
        }

        // Gère les erreurs et affiche les messages appropriés

        if (empty($errors)) {
            $_SESSION['status'] = "Newsletter envoyée avec succès à tous les abonnés.";
        } else {
            $_SESSION['error'] = "La newsletter n'a pas pu être envoyée aux adresses suivantes : " . implode(", ", $errors);
        }

        // Nettoie les fichiers temporaires après l'envoi

        foreach ($attachments as $filePath) {
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }
}
