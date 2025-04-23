<?php
// Vérification de l'authentification
if (!isset($_SESSION['user'])) {
    echo "<script>window.location.href = '../klaxon'</script>";
    exit; 
} 

use Controllers\JournalController;
$journalController = new JournalController();
$articles = $journalController->getAllArticles();

// Gestion des requêtes POST avec vérification CSRF
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $journalController->validateCsrfToken($_POST['csrf_token'] ?? '')) {
    // Ajout d'un nouvel article
    if (isset($_POST['add_article'])) {
        $title = trim($_POST['title']);
        $content = trim($_POST['content']);
        $image = $_FILES['image'] ?? [];
        $pdf = $_FILES['pdf'] ?? [];
        
        $journalController->addArticle($title, $content, $image, $pdf);
        echo '<script>window.location.href = window.location.href;</script>';
        exit();
    }
    // Modification d'un article
    elseif (isset($_POST['edit_article'])) {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $title = trim($_POST['title']);
        $content = trim($_POST['content']);
        $image = $_FILES['image'] ?? [];
        $pdf = $_FILES['pdf'] ?? [];
        
        $journalController->updateArticle($id, $title, $content, $image, $pdf);
        echo '<script>window.location.href = window.location.href;</script>';
        exit();
    }
    // Suppression d'un article
    elseif (isset($_POST['delete_article'])) {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $journalController->deleteArticle($id);
        echo '<script>window.location.href = window.location.href;</script>';
        exit();
    }
}

// Include the header
include './src/views/includes/header_backoffice.php'; 
?>

<section>
    <div class="d-flex min-vh-100">
        <?php include_once 'src/views/includes/sidebar_backoffice.php'; ?>

        <div class="p-4 flex-fill" style="margin-left: 250px;">
            <div class="container mt-5" data-aos="fade-down">
                <h2>Gestion des Articles</h2>

                <!-- Affichage des messages -->
                <?php if (!empty($_SESSION['message'])): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['message']) ?></div>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>
                <?php if (!empty($_SESSION['error'])): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <!-- Bouton d'ajout -->
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addArticleModal">
                    <i class='bx bx-plus'></i> Ajouter un Article
                </button>

                <!-- Tableau des articles -->
                <div data-aos="fade-left">
                    <table class="table mt-3 table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Titre</th>
                                <th>Contenu</th>
                                <th>Image</th>
                                <th>PDF</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($articles as $article): ?>
                            <tr>
                                <td><?= htmlspecialchars($article['created_at']) ?></td>
                                <td><?= htmlspecialchars($article['title']) ?></td>
                                <td><?= nl2br(htmlspecialchars(mb_strimwidth($article['content'], 0, 100, ' ...'))) ?></td>
                                <td>
                                    <?php if (!empty($article['image'])): ?>
                                        <img src="<?= htmlspecialchars($article['image']) ?>" 
                                             alt="Image de l'article" 
                                             style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                    <?php else: ?>
                                        <span class="text-muted">Aucune image</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($article['pdf_path'])): ?>
                                        <a href="<?= htmlspecialchars($article['pdf_path']) ?>" 
                                           class="btn btn-sm btn-outline-primary" 
                                           target="_blank">
                                            <i class='bx bx-file'></i> PDF
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">Aucun PDF</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <!-- Bouton d'édition -->
                                    <button class="btn btn-sm btn-warning edit-btn" 
                                            data-bs-toggle="modal"
                                            data-bs-target="#editArticleModal" 
                                            data-id="<?= $article['id'] ?>"
                                            data-title="<?= htmlspecialchars($article['title']) ?>"
                                            data-content="<?= htmlspecialchars($article['content']) ?>">
                                        <i class='bx bxs-edit'></i>
                                    </button>
                                    
<!-- Formulaire de suppression -->
<form method="post" action="" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article?');">
    <input type="hidden" name="csrf_token" value="<?= $journalController->generateCsrfToken() ?>">
    <input type="hidden" name="delete_article" value="1">
    <input type="hidden" name="id" value="<?= $article['id'] ?>">
    <button type="submit" class="btn btn-sm btn-danger">
        <i class='bx bxs-trash'></i>
    </button>
</form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal d'ajout -->
<div class="modal fade" id="addArticleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un Nouvel Article</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= $journalController->generateCsrfToken() ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">Titre *</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Contenu *</label>
                        <textarea name="content" class="form-control" rows="8" required></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <div class="form-text">Tous les formats d'image sont acceptés</div>
                        </div>
                        
                        <div class="mb-3 col-md-6">
                            <label class="form-label">PDF</label>
                            <input type="file" name="pdf" class="form-control" accept=".pdf">
                            <div class="form-text">Format PDF uniquement</div>
                        </div>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="send_email" class="form-check-input" id="sendEmailCheck" checked>
                        <label class="form-check-label" for="sendEmailCheck">Envoyer une notification aux abonnés</label>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" name="add_article" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'édition -->
<div class="modal fade" id="editArticleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier l'Article</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= $journalController->generateCsrfToken() ?>">
                    <input type="hidden" name="id" id="edit-id">
                    
                    <div class="mb-3">
                        <label class="form-label">Titre *</label>
                        <input type="text" name="title" id="edit-title" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Contenu *</label>
                        <textarea name="content" id="edit-content" class="form-control" rows="8" required></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Nouvelle Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <div class="form-text">Laisser vide pour conserver l'image actuelle</div>
                        </div>
                        
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Nouveau PDF</label>
                            <input type="file" name="pdf" class="form-control" accept=".pdf">
                            <div class="form-text">Laisser vide pour conserver le PDF actuel</div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" name="edit_article" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script pour gérer les modals -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Gestion des boutons d'édition
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('edit-id').value = btn.dataset.id;
            document.getElementById('edit-title').value = btn.dataset.title;
            document.getElementById('edit-content').value = btn.dataset.content;
        });
    });
});
</script>

<?php include 'src/views/includes/footer_links.php' ?>