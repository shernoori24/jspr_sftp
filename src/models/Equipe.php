<?php 
namespace Models;

use PDO;

class Equipe extends Bdd {


    /**
     * Récupère les membres par catégorie
     */
    public function getMembresByCategorie($categorie_id) {
        $query = "SELECT m.*, p.poste 
                  FROM membres m
                  JOIN postes_membres p ON m.id_postes_membres = p.id
                  WHERE m.id_categories_membres = :categorie_id
                  ORDER BY m.nom";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':categorie_id' => $categorie_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère tous les membres avec leurs postes et catégories
     */
    public function getAllMembre() {
        $query = "SELECT m.*, p.poste, c.categorie 
                  FROM membres m
                  JOIN postes_membres p ON m.id_postes_membres = p.id
                  JOIN categories_membres c ON m.id_categories_membres = c.id
                  ORDER BY m.nom";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère tous les postes disponibles
     */
    public function getAllPostes() {
        $query = "SELECT * FROM postes_membres ORDER BY poste";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère toutes les catégories disponibles
     */
    public function getAllCategories() {
        $query = "SELECT * FROM categories_membres ORDER BY categorie";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Vérifie si un poste existe déjà
     */
    public function posteExists($poste) {
        $query = "SELECT id FROM postes_membres WHERE poste = :poste";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':poste' => $poste]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Ajoute un nouveau poste
     */
    public function addPoste($poste) {
        $query = "INSERT INTO postes_membres (poste) VALUES (:poste)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':poste' => $poste]);
        return $this->pdo->lastInsertId();
    }

    /**
     * Ajoute un nouveau membre
     */
    public function addMembre($nom, $description, $poste_id, $categorie_id) {
        $query = "INSERT INTO membres (nom, description, id_postes_membres, id_categories_membres) 
                  VALUES (:nom, :description, :poste_id, :categorie_id)";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            ':nom' => $nom,
            ':description' => $description,
            ':poste_id' => $poste_id,
            ':categorie_id' => $categorie_id
        ]);
    }

    /**
     * Met à jour un membre existant
     */
    public function updateMembre($id, $nom, $description, $poste_id, $categorie_id) {
        $query = "UPDATE membres 
                  SET nom = :nom, 
                      description = :description, 
                      id_postes_membres = :poste_id, 
                      id_categories_membres = :categorie_id 
                  WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            ':id' => $id,
            ':nom' => $nom,
            ':description' => $description,
            ':poste_id' => $poste_id,
            ':categorie_id' => $categorie_id
        ]);
    }

    /**
     * Supprime un membre
     */
    public function deleteMembre($id) {
        $query = "DELETE FROM membres WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([':id' => $id]);
    }
}
