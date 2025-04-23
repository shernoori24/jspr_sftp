<?php
namespace Models;

use PDO; // Add this line to import the PDO class

class Event extends Bdd {
    /**
     * Ajoute un nouvel événement et récupère tous les abonnés.
     */
    public function addEvent($title, $description, $date, $adresse, $image) {

        try {
            $stmt = $this->pdo->prepare("INSERT INTO events (title, description, date, adresse, image) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $date, $adresse, $image]);
            return true;
        } catch (\PDOException $e) {
            error_log("Erreur lors de l'ajout de l'événement: " . $e->getMessage());
            return false;
        }
    }
    /**
     * Met à jour un événement existant.
     */
    public function updateEvent($id, $title, $description, $date, $adresse, $image) {
        try {
            $stmt = $this->pdo->prepare("UPDATE events SET title = ?, description = ?, date = ?, adresse = ?, image = ? WHERE id = ?");
            $stmt->execute([$title, $description, $date, $adresse, $image, $id]);
            return true;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la mise à jour de l'événement: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Supprime un événement.
     */
    public function deleteEvent($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM events WHERE id = ?");
            $stmt->execute([$id]);
            return true;
        } catch (\PDOException $e) {
            error_log("Erreur lors de la suppression de l'événement: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Récupère un événement par son ID.
     */
    public function getEventById($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM events WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération de l'événement: " . $e->getMessage());
            return null;
        }
    }

    // recupère tous les events
    public function getAllEvents() {
        try {
            return $this->pdo->query("SELECT * FROM events ORDER BY date DESC")->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération des événements: " . $e->getMessage());
            return [];
        }
    }
}
