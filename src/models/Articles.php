<?php

namespace Models;

class Articles extends Bdd { // This class manages article-related database operations

    // Create a new order
    public function createCommande($email, $total, $adresse) { // This method inserts a new order into the database

        try {
            $stmt = $this->pdo->prepare("INSERT INTO commandes (email, totale, adresse) VALUES (?, ?, ?) RETURNING id"); // Prepare SQL statement to insert order

            $stmt->execute([$email, $total, $adresse]);
            return $stmt->fetchColumn(); // Return the ID of the newly created order

        } catch (\PDOException $e) {
            error_log("Erreur lors de la création de la commande : " . $e->getMessage());
            return false;
        }
    }

    // Add a product to the order
    public function ajouterProduitCommande($commande_id, $produit_id, $quantite, $prix) { // This method adds a product to an existing order

        try {
            $stmt = $this->pdo->prepare("INSERT INTO produits_commandes (commande_id, produit_id, quantite, prix) VALUES (?, ?, ?, ?)"); // Prepare SQL statement to insert product into order

            $stmt->execute([$commande_id, $produit_id, $quantite, $prix]);
            return true; // Return true if the product was successfully added

        } catch (\PDOException $e) {
            error_log("Erreur lors de l'ajout du produit à la commande : " . $e->getMessage());
            return false;
        }
    }

    // Retrieve products from an order
    public function getProduitsCommande($commande_id) { // This method retrieves all products associated with a specific order

        try {
            $stmt = $this->pdo->prepare(" // Prepare SQL statement to fetch products from the order

                SELECT p.nom, pc.quantite, pc.prix
                FROM produits_commandes pc
                JOIN produits p ON pc.produit_id = p.id
                WHERE pc.commande_id = ?
            ");
            $stmt->execute([$commande_id]);
            return $stmt->fetchAll(); // Return all products associated with the order

        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération des produits de la commande : " . $e->getMessage());
            return [];
        }
    }
}
