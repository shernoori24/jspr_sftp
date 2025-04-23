<?php
namespace Models;

use PDO;
use Exception;

class JournalModel extends Bdd {
    /**
     * Récupère tous les articles triés par date de création (du plus récent au plus ancien)
     */
    public function getAllArticles() {
        try {
            $query = "SELECT * FROM journal ORDER BY created_at DESC";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Erreur lors de la récupération des articles: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Récupère un article spécifique par son ID
     */
    public function getArticleById($id) {
        try {
            $query = "SELECT * FROM journal WHERE id = :id LIMIT 1";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (Exception $e) {
            error_log("Erreur lors de la récupération de l'article ID $id: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Vérifie si un article existe
     */
    public function articleExists($id): bool {
        try {
            $query = "SELECT COUNT(*) FROM journal WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':id' => $id]);
            return $stmt->fetchColumn() > 0;
        } catch (Exception $e) {
            error_log("Erreur lors de la vérification de l'article ID $id: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Ajoute un nouvel article dans la base de données
     */
    public function addArticle($title, $content, $imagePath = null, $pdfPath = null) {
        try {
            $query = "INSERT INTO journal 
                     (title, content, image, pdf_path, created_at) 
                     VALUES (:title, :content, :image, :pdf_path, NOW())";
            
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                ':title' => $title,
                ':content' => $content,
                ':image' => $imagePath,
                ':pdf_path' => $pdfPath
            ]);
            
            return $this->pdo->lastInsertId();
        } catch (Exception $e) {
            error_log("Erreur lors de l'ajout de l'article: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Met à jour un article existant
     */
    public function updateArticle($id, $title, $content, $imagePath = null, $pdfPath = null) {
        try {
            $query = "UPDATE journal SET 
                     title = :title, 
                     content = :content, 
                     image = COALESCE(:image, image), 
                     pdf_path = COALESCE(:pdf_path, pdf_path) 
                     WHERE id = :id";
            
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                ':id' => $id,
                ':title' => $title,
                ':content' => $content,
                ':image' => $imagePath,
                ':pdf_path' => $pdfPath
            ]);
            
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Erreur lors de la mise à jour de l'article ID $id: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Supprime un article et ses fichiers associés
     */
    public function deleteArticle($id) {
        try {
            // Récupère l'article pour supprimer ses fichiers
            $article = $this->getArticleById($id);
            if (!$article) {
                throw new Exception("Article introuvable");
            }

            // Suppression des fichiers associés
            $this->deleteArticleFiles($article);

            // Suppression de la base de données
            $query = "DELETE FROM journal WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':id' => $id]);
            
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Erreur lors de la suppression de l'article ID $id: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Supprime les fichiers associés à un article
     */
    private function deleteArticleFiles($article) {
        try {
            if (!empty($article['image']) && file_exists($article['image'])) {
                unlink($article['image']);
            }
            if (!empty($article['pdf_path']) && file_exists($article['pdf_path'])) {
                unlink($article['pdf_path']);
            }
        } catch (Exception $e) {
            error_log("Erreur lors de la suppression des fichiers de l'article ID {$article['id']}: " . $e->getMessage());
        }
    }
}