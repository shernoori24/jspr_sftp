<?php
namespace Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactController
{
    public function envoyerMessage()
    {
        // Vérifie si la requête est de type POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Nettoyage des données
            $nom = strip_tags(trim($_POST['nom']));
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            $sujet = strip_tags(trim($_POST['sujet']));
            $message = htmlspecialchars(trim($_POST['message']));

            // Vérification des champs obligatoires
            if (empty($nom) || empty($email) || empty($sujet) || empty($message)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => "Merci de remplir tous les champs."]);
                return;
            }

            // Vérification de l'email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => "Merci d'écrire un email valide."]);
                return;
            }

            // Configuration et envoi de l'email avec PHPMailer
            $mail = new PHPMailer(true);
            $mail->CharSet = 'UTF-8'; // ✅ Correction de l'encodage pour les accents

            try {
                // Configuration SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = $_ENV['MAIL_EXPEDITATEUR'];
                $mail->Password = $_ENV['MDP_APP'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                // Expéditeur et destinataire
                $mail->setFrom($_ENV['MAIL_EXPEDITATEUR'], 'Contact Depuis le Site : ' . $nom . ', ' . $sujet);
                $mail->addAddress('shernoori24@gmail.com', 'Sheraqa JSPR');

                // Contenu de l'email
                $mail->isHTML(true);
                $mail->Subject = $sujet;
                $mail->Body = '
                <div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
                    <h2 style="color: #007BFF; text-align: center;">📩 Nouveau message reçu</h2>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 10px; border-bottom: 1px solid #ddd;"><strong>Nom Complet :</strong></td>
                            <td style="padding: 10px; border-bottom: 1px solid #ddd;">' . htmlspecialchars($nom) . '</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px; border-bottom: 1px solid #ddd;"><strong>Email :</strong></td>
                            <td style="padding: 10px; border-bottom: 1px solid #ddd;">' . htmlspecialchars($email) . '</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px; border-bottom: 1px solid #ddd;"><strong>Sujet :</strong></td>
                            <td style="padding: 10px; border-bottom: 1px solid #ddd;">' . htmlspecialchars($sujet) . '</td>
                        </tr>
                    </table>
                    <div style="margin-top: 20px; padding: 15px; background: #f9f9f9; border-left: 4px solid #007BFF;">
                        <h4 style="margin: 0;">📜 Message :</h4>
                        <p style="margin: 10px 0;">' . nl2br(htmlspecialchars($message)) . '</p>
                    </div>
                    <p style="text-align: center; font-size: 12px; color: #888; margin-top: 20px;">
                        Ce message a été envoyé via le formulaire de contact du site.
                    </p>
                </div>
            ';
            

                // Envoi de l'email
                if ($mail->send()) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => "Merci de nous avoir contactés - JSPR 08"]);
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => "Le message n'a pas pu être envoyé. Erreur: " . $mail->ErrorInfo]);
                }
            } catch (Exception $e) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => "Erreur lors de l'envoi : " . $e->getMessage()]);
            }
        } else {
            // Si la requête n'est pas de type POST
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => "Méthode de requête non autorisée."]);
        }
    }
}