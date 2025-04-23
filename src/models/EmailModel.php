<?php
namespace Models;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailModel {
    private $mailer;

    public function __construct() {
        $this->mailer = new PHPMailer(true);
        $this->configureMailer();
    }

    private function configureMailer() {
        $this->mailer->isSMTP();
        $this->mailer->Host = 'smtp.gmail.com';
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $_ENV['MAIL_EXPEDITATEUR'];
        $this->mailer->Password = $_ENV['MDP_APP'];
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mailer->Port = 465;
        $this->mailer->CharSet = 'UTF-8';
        $this->mailer->Encoding = 'base64';
        $this->mailer->setFrom($_ENV['MAIL_EXPEDITATEUR'], "J'SPR 08");
    }

    /**
     * Envoie un email.
     *
     * @param string $to Email du destinataire
     * @param string $subject Sujet de l'email
     * @param string $content Contenu de l'email (HTML)
     * @param string $unsubscribeLink Lien de désabonnement
     * @param array $attachments Chemins des fichiers joints
     * @param string|null $imagePath Chemin de l'image intégrée
     * @return bool True si l'email est envoyé avec succès, sinon false
     */
    public function sendEmail($to, $subject, $content, $unsubscribeLink, $attachments = [], $imagePath = null) {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($to);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = mb_convert_encoding(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'), 'UTF-8', 'auto');

            // Charger et personnaliser le template
            $body = $this->prepareEmailBody($content, $unsubscribeLink, $attachments, $imagePath);
            
            $this->mailer->Body = $body;
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Erreur lors de l'envoi de l'email : " . $this->mailer->ErrorInfo);
            return false;
        }
    }

    private function prepareEmailBody($content, $unsubscribeLink, $attachments, $imagePath) {
        $templatePath = __DIR__ . '/../../assets/templates/email_template.html';
        if (!file_exists($templatePath)) {
            throw new \Exception("Le fichier template n'existe pas : " . $templatePath);
        }
        $template = file_get_contents($templatePath);
    
        // Intégration d'une image responsive
        $imageSection = '';
        if ($imagePath && file_exists($imagePath)) {
            $cid = md5(uniqid());
            $this->mailer->addEmbeddedImage($imagePath, $cid, basename($imagePath));
            $imageSection = "<img src='cid:$cid' alt='Image' class='responsive-image'>";
        }
    
        // Gestion des pièces jointes
        $attachmentsSection = '';
        if (!empty($attachments)) {
            $attachmentsSection = "<div class='attachments'><h3>Pièces jointes en bas de l'email</h3><ul>";
            foreach ($attachments as $filePath) {
                if (file_exists($filePath)) {
                    $fileName = basename($filePath);
                    $this->mailer->addAttachment($filePath, $fileName);
                    $attachmentsSection .= "<li>$fileName</li>";
                }
            }
            $attachmentsSection .= "</ul></div>";
        }
    
        // Remplacement des placeholders dans le template
        return str_replace(
            ['{{ image_section }}', '{{ content }}', '{{ attachments_section }}', '{{ unsubscribe_link }}'],
            [$imageSection, $content, $attachmentsSection, $unsubscribeLink],
            $template
        );
    }
}
