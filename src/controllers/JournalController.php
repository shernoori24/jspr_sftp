<?php
namespace Controllers;

use Models\JournalModel;
use Models\EmailModel;
use Models\SubscriberModel;
use Exception;

class JournalController {
    // Constantes pour les chemins d'upload
    private const UPLOAD_IMAGE_DIR = 'uploads/journal/images/';
    private const UPLOAD_PDF_DIR = 'uploads/journal/pdf/';
    
    protected $journalModel;
    protected $emailModel;
    protected $subscriberModel;

    public function __construct() {
        $this->journalModel = new JournalModel();
        $this->emailModel = new EmailModel();
        $this->subscriberModel = new SubscriberModel();
        
        // Créer les répertoires d'upload s'ils n'existent pas
        $this->createUploadDirectories();
    }
    
    /**
     * Crée les répertoires d'upload s'ils n'existent pas
     */
    private function createUploadDirectories() {
        if (!is_dir(self::UPLOAD_IMAGE_DIR)) {
            mkdir(self::UPLOAD_IMAGE_DIR, 0777, true);
        }
        if (!is_dir(self::UPLOAD_PDF_DIR)) {
            mkdir(self::UPLOAD_PDF_DIR, 0777, true);
        }
    }

    public function affichePageAdminJournal() {
        include_once 'src/views/admin/journal.php';
    }

    public function getAllArticles() {
        return $this->journalModel->getAllArticles();
    }

    /**
     * Ajoute un nouvel article avec gestion des fichiers et envoi de newsletter
     */
    public function addArticle($title, $content, $image, $pdf) {
        try {
            // Validation des entrées de base
            if (empty($title)) {
                throw new Exception('Le titre est obligatoire');
            }

            // Gestion des uploads
            $imagePath = $this->handleImageUpload($image);
            $pdfPath = $this->handlePdfUpload($pdf);

            // Ajout à la base de données
            $articleId = $this->journalModel->addArticle(
                htmlspecialchars($title),
                htmlspecialchars($content),
                $imagePath,
                $pdfPath
            );

            if (!$articleId) {
                throw new Exception('Erreur lors de l\'ajout en base de données');
            }

            $_SESSION['message'] = 'Article ajouté avec succès.';

            // Envoi de la newsletter si demandé
            if (isset($_POST['send_email']) && $_POST['send_email'] === 'on') {
                $this->sendNewsletter($title, $content, $imagePath, $pdfPath);
                $_SESSION['message'] .= ' Newsletter envoyée aux abonnés.';
            }

            return $articleId;
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            return false;
        }
    }

    /**
     * Envoie une newsletter à tous les abonnés
     */
    private function sendNewsletter($title, $content, $imagePath, $pdfPath) {
        $subscribers = $this->subscriberModel->getAllSubscribers();
        
        if (empty($subscribers)) {
            return;
        }

        $subject = "Nouvel Article: " . htmlspecialchars($title);
        $message = "<h1>" . htmlspecialchars($title) . "</h1>";
        $message .= "<p>" . nl2br(htmlspecialchars($content)) . "</p>";
        

        foreach ($subscribers as $subscriber) {
            $token = $this->subscriberModel->generateUnsubscribeToken($subscriber['email']);
            $unsubscribeLink = "http://localhost/projets/jspr/unsubscribe?email=" . 
                             urlencode($subscriber['email']) . "&token=" . $token;
            
            $this->emailModel->sendEmail(
                $subscriber['email'],
                $subject,
                $message,
                $unsubscribeLink,
                $pdfPath ? [$pdfPath] : [],
                $imagePath
            );
        }
    }

    /**
     * Met à jour un article existant
     */
    public function updateArticle($id, $title, $content, $image, $pdf) {
        try {
            // Validation de l'ID
            if (!is_numeric($id)) {
                throw new Exception('ID d\'article invalide');
            }

            // Récupération de l'article existant
            $existingArticle = $this->journalModel->getArticleById($id);
            if (!$existingArticle) {
                throw new Exception('Article non trouvé');
            }

            // Gestion des uploads (conserve l'ancien fichier si aucun nouveau n'est uploadé)
            $imagePath = $this->handleImageUpload($image) ?: $existingArticle['image'];
            $pdfPath = $this->handlePdfUpload($pdf) ?: $existingArticle['pdf_path'];

            // Mise à jour en base de données
            $result = $this->journalModel->updateArticle(
                $id,
                htmlspecialchars($title),
                htmlspecialchars($content),
                $imagePath,
                $pdfPath
            );

            if (!$result) {
                throw new Exception('Erreur lors de la mise à jour de l\'article');
            }

            $_SESSION['message'] = 'Article modifié avec succès.';
            return true;
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            return false;
        }
    }

    /**
     * Supprime un article et ses fichiers associés
     */
    public function deleteArticle($id) {
        try {
            if (!is_numeric($id)) {
                throw new Exception('ID d\'article invalide');
            }

            $result = $this->journalModel->deleteArticle($id);
            
            if (!$result) {
                throw new Exception('Erreur lors de la suppression de l\'article');
            }

            $_SESSION['message'] = 'Article supprimé avec succès.';
            return true;
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            return false;
        }
    }

    /**
     * Gère l'upload d'image (accepte tous les types d'images)
     */
    private function handleImageUpload($image) {
        // Si aucun fichier n'est uploadé ou s'il y a une erreur
        if ($image['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        // Vérification que c'est bien une image (accepte tous les types)
        if (!getimagesize($image['tmp_name'])) {
            throw new Exception('Le fichier n\'est pas une image valide');
        }

        // Génération d'un nom de fichier unique
        $filename = uniqid() . '-' . preg_replace('/[^a-zA-Z0-9\.\-_]/', '', $image['name']);
        $uploadPath = self::UPLOAD_IMAGE_DIR . $filename;

        // Déplacement du fichier uploadé
        if (!move_uploaded_file($image['tmp_name'], $uploadPath)) {
            throw new Exception('Erreur lors du téléchargement de l\'image');
        }

        return $uploadPath;
    }

    /**
     * Gère l'upload de PDF avec validation
     */
    private function handlePdfUpload($pdf) {
        if ($pdf['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        // Validation du type MIME pour les PDF
        $mime = mime_content_type($pdf['tmp_name']);
        if ($mime !== 'application/pdf') {
            throw new Exception('Seuls les fichiers PDF sont autorisés');
        }

        $filename = uniqid() . '-' . preg_replace('/[^a-zA-Z0-9\.\-_]/', '', $pdf['name']);
        $uploadPath = self::UPLOAD_PDF_DIR . $filename;

        if (!move_uploaded_file($pdf['tmp_name'], $uploadPath)) {
            throw new Exception('Erreur lors du téléchargement du PDF');
        }

        return $uploadPath;
    }
    
    /**
     * Génère un token CSRF pour la protection des formulaires
     */
    public function generateCsrfToken(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Valide un token CSRF
     */
    public function validateCsrfToken(string $token): bool {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}