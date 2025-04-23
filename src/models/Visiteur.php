<?php
namespace Models;

use PDO;

class Visiteur extends Bdd {
    /**
     * Ajouter un visiteur en évitant les doublons trop proches.
     */
    public function addVisiteur($ip, $user_agent) {
        try {
            // Vérifier si le même visiteur est déjà enregistré dans les 10 minutes
            $stmt = $this->pdo->prepare("SELECT id FROM visiteurs WHERE ip = ? AND date_visite >= NOW() - INTERVAL 10 MINUTE");
            $stmt->execute([$ip]);

            if ($stmt->fetch()) {
                error_log("⏳ Visite ignorée (déjà enregistré récemment) : IP = $ip");
                return false; 
            }

            // Ajouter le visiteur s'il est nouveau
            $stmt = $this->pdo->prepare("INSERT INTO visiteurs (ip, user_agent) VALUES (?, ?)");
            $result = $stmt->execute([$ip, $user_agent]);

            if ($result) {
                error_log("✅ Visiteur ajouté avec succès : IP = $ip");
            } else {
                error_log("❌ Échec de l'ajout du visiteur : IP = $ip");
            }

            return $result;
        } catch (\PDOException $e) {
            error_log("🔥 Erreur SQL lors de l'ajout du visiteur : " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Récupérer les statistiques des visiteurs par période (jour, semaine, mois, année).
     */
    public function getVisiteursParPeriode($periode) {
        $query = "";
    
        switch ($periode) {
            case 'jour':
                $query = "SELECT DATE(date_visite) AS date, COUNT(*) AS nombre FROM visiteurs GROUP BY DATE(date_visite)";
                break;
            case 'semaine':
                $query = "SELECT YEAR(date_visite) AS annee, WEEK(date_visite, 1) AS semaine, COUNT(*) AS nombre FROM visiteurs GROUP BY annee, semaine";
                break;
            case 'mois':
                $query = "SELECT DATE_FORMAT(date_visite, '%Y-%m') AS date, COUNT(*) AS nombre FROM visiteurs GROUP BY date";
                break;
            case 'annee':
                $query = "SELECT YEAR(date_visite) AS date, COUNT(*) AS nombre FROM visiteurs GROUP BY date";
                break;
            default:
                throw new \InvalidArgumentException("🚨 Période invalide : $periode");
        }
    
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
