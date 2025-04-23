<?php
namespace Models;

use PDO;

class SubscriberModel extends Bdd {
    /**
     * Récupère tous les abonnés.
     */
    public function getAllSubscribers() {
        $query = "SELECT * FROM subscribers";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // chercher un avonné par mail
    public function searchSubscriber($search_email){
        $query = "SELECT * FROM subscribers WHERE email LIKE :email";
        $stmt = $this->pdo->prepare($query);
        
        // Concaténer les % avec l'email
        $search_term = '%' . $search_email . '%';
        
        // Lier le paramètre
        $stmt->bindParam(':email', $search_term);
        
        // Exécuter la requête
        $stmt->execute();
        
        // Retourner les résultats (par exemple, sous forme de tableau associatif)
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Ajoute un nouvel abonné.
     */
    public function addSubscriber($email) {
        // Vérifier si l'email existe déjà
        if ($this->isEmailExists($email)) {
            throw new \Exception("Cet email est déjà enregistré.");
            // Ou retourner false si vous préférez gérer l'erreur différemment
            // return false;
        }
    
        // Ajouter l'abonné si l'email n'existe pas
        $query = "INSERT INTO subscribers (email) VALUES (:email)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':email' => $email]);
        return $this->pdo->lastInsertId();
    }

    /**
     * Supprime un abonné.
     */
    public function deleteSubscriber($id) {
        $query = "DELETE FROM subscribers WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount();
    }

    /**
     * Met à jour un abonné.
     */
    public function updateSubscriber($id, $email) {
        $query = "UPDATE subscribers SET email = :email WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':id' => $id,
            ':email' => $email,
        ]);
        return $stmt->rowCount();
    }

    public function deleteSubscriberByEmail($email) {
        $sql = "DELETE FROM subscribers WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function generateUnsubscribeToken($email) {
        $token = bin2hex(random_bytes(32));
        $sql = "UPDATE subscribers SET unsubscribe_token = :token WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':token' => $token, ':email' => $email]);
        return $token;
    }

    public function validateUnsubscribeToken($email, $token) {
        $sql = "SELECT id FROM subscribers WHERE email = :email AND unsubscribe_token = :token";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email, ':token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function isEmailExists($email) {
        $query = "SELECT COUNT(*) FROM subscribers WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':email' => $email]);
        return $stmt->fetchColumn() > 0;
    }
}