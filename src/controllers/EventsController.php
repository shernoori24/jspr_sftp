<?php
namespace Controllers;

use Models\SubscriberModel;
use Models\Event;
use Models\EmailModel;
use InvalidArgumentException;
use Exception;

class EventsController {
    protected $subscriberModel;
    protected $eventModel;
    protected $emailModel;

    public function __construct() {
        $this->eventModel = new Event();
        $this->emailModel = new EmailModel(); 
        $this->subscriberModel = new SubscriberModel();
    }

    public function getAllEvents() {
        return $this->eventModel->getAllEvents();
    }

    public function affichePageAdminEvenements() {
        include_once "src/views/admin/evenements.php";
    }

    public function addEvent($title, $description, $date, $adresse, $image) {
        try {
            $this->validateEventData($title, $description, $date, $adresse);
            
            $imagePath = null;
            
            // Gestion de l'image seulement si elle est fournie
            if (isset($image['error']) && $image['error'] !== UPLOAD_ERR_NO_FILE) {
                $imagePath = $this->handleImageUpload($image);
                if (!$imagePath) {
                    throw new Exception('Erreur lors du téléchargement de l\'image.');
                }
            }

            // Ajout de l'événement avec ou sans image
            if ($this->eventModel->addEvent($title, $description, $date, $adresse, $imagePath)) {
                $_SESSION['message'] = 'Événement ajouté avec succès.';

                $sendEmail = isset($_POST['send_email']) && $_POST['send_email'] === 'on';
                if ($sendEmail) {
                    $this->sendNewsletter($title, $description, $date, $adresse, $imagePath);
                    $_SESSION['message'] .= ' Un email a été envoyé aux abonnés.';
                }
                return true;
            } else {
                throw new Exception('Erreur lors de l\'ajout de l\'événement.');
            }
        } catch (InvalidArgumentException $e) {
            $_SESSION['error'] = $e->getMessage();
            return false;
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            error_log($e->getMessage());
            return false;
        }
    }

    private function sendNewsletter($title, $description, $date, $adresse, $imagePath) {
        $subscribers = $this->subscriberModel->getAllSubscribers();
    
        $subject = "Nouvel Événement: " . htmlspecialchars($title);
        $content = "<h1>" . htmlspecialchars($title) . "</h1>";
        $content .= "<p>" . nl2br(htmlspecialchars($description)) . "</p>";
        $content .= "<p><strong>Date :</strong> " . htmlspecialchars($date) . "</p>";
        $content .= "<p><strong>Adresse :</strong> " . htmlspecialchars($adresse) . "</p>";
    
        foreach ($subscribers as $subscriber) {
            $token = $this->subscriberModel->generateUnsubscribeToken($subscriber['email']);
            $unsubscribeLink = "http://localhost/projets/jspr/unsubscribe?email=" . urlencode($subscriber['email']) . "&token=" . $token;
    
            $this->emailModel->sendEmail($subscriber['email'], $subject, $content, $unsubscribeLink, [], $imagePath);
        }
    }

    public function updateEvent($id, $title, $description, $date, $adresse, $image) {
        try {
            $this->validateEventData($title, $description, $date, $adresse);
            
            $event = $this->eventModel->getEventById($id);
            if (!$event) {
                throw new Exception('Événement non trouvé.');
            }

            $imagePath = $event['image'];

            // Si une nouvelle image est téléchargée
            if (isset($image['error']) && $image['error'] === UPLOAD_ERR_OK) {
                $newImagePath = $this->handleImageUpload($image);
                if ($newImagePath) {
                    // Supprimer l'ancienne image si elle existe
                    if ($imagePath && file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                    $imagePath = $newImagePath;
                }
            }

            if ($this->eventModel->updateEvent($id, $title, $description, $date, $adresse, $imagePath)) {
                $_SESSION['message'] = 'Événement modifié avec succès.';
                return true;
            } else {
                throw new Exception('Erreur lors de la modification de l\'événement.');
            }
        } catch (InvalidArgumentException $e) {
            $_SESSION['error'] = $e->getMessage();
            return false;
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            error_log($e->getMessage());
            return false;
        }
    }

    public function deleteEvent($id) {
        try {
            $event = $this->eventModel->getEventById($id);
            if (!$event) {
                throw new Exception('Événement non trouvé.');
            }

            if (!empty($event['image']) && file_exists($event['image'])) {
                unlink($event['image']);
            }

            if ($this->eventModel->deleteEvent($id)) {
                $_SESSION['message'] = 'Événement supprimé avec succès.';
                return true;
            } else {
                throw new Exception('Erreur lors de la suppression de l\'événement.');
            }
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            error_log($e->getMessage());
            return false;
        }
    }

    private function handleImageUpload($image) {
        if ($image['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Erreur lors du téléchargement de l'image.");
        }

        // Vérification que le fichier est bien une image
        $imageInfo = getimagesize($image['tmp_name']);
        if ($imageInfo === false) {
            throw new Exception("Le fichier téléchargé n'est pas une image valide.");
        }

        // Chemin de stockage
        $uploadDir = 'uploads/event/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Génération du nom de fichier
        $imageName = uniqid() . '-' . preg_replace('/[^a-zA-Z0-9\.\-_]/', '', basename($image['name']));
        $uploadFile = $uploadDir . $imageName;

        if (move_uploaded_file($image['tmp_name'], $uploadFile)) {
            return $uploadFile;
        }

        throw new Exception("Erreur lors du déplacement du fichier téléchargé.");
    }

    private function validateEventData($title, $description, $date, $adresse) {
        if (empty($title) || strlen($title) > 255) {
            throw new InvalidArgumentException("Le titre est requis et doit faire moins de 255 caractères.");
        }
        
        if (empty($description)) {
            throw new InvalidArgumentException("La description est requise.");
        }
        
        if (!strtotime($date)) {
            throw new InvalidArgumentException("La date est invalide.");
        }
        
        if (empty($adresse)) {
            throw new InvalidArgumentException("L'adresse est requise.");
        }
        
        return true;
    }
}