<?php
var_dump($_SESSION['sher']);
echo '<br>';
var_dump($_SESSION);
 // Include the header section of the website
 include './src/views/includes/header.php'; 
// Inclusion du contrôleur du journal

// Création d'une instance du contrôleur du journal
$journalController = new Controllers\JournalController();
// Récupération de tous les articles du journal
$articles = $journalController->getAllArticles();
?>

<section>
    <div class="container mt-5" data-aos="fade-down">
        <h1 class="text-center mb-4">Journal</h1>
        <div class="row">
            <?php foreach ($articles as $article): ?>
                <div class="col-12">
                    <!-- Carte contenant l'article -->
                    <div class="card mb-4 shadow-lg rounded overflow-hidden" id="card-<?= $article['id'] ?>">
                        <div class="row g-0 align-items-stretch">
                            <!-- Texte à gauche -->
                            <div class="col-md-8 d-flex flex-column p-4">
                                <h5 class="card-title"> <?= htmlspecialchars($article['title']) ?> </h5>
                                <!-- Conteneur du texte avec effet de limitation -->
                                <div class="text-container position-relative" id="text-container-<?= $article['id'] ?>" style="max-height: 120px; overflow: hidden; transition: max-height 0.5s ease;">
                                    <p class="card-text"> <?= nl2br(htmlspecialchars($article['content'])) ?> </p>
                                    <!-- Overlay pour indiquer plus de contenu -->
                                    <div class="fade-overlay position-absolute bottom-0 w-100"></div>
                                </div>
                                <!-- Bouton pour afficher plus de texte -->
                                <button class="btn btn-link toggle-text p-0 mt-2" data-id="<?= $article['id'] ?>" style="font-size: 0.9rem; display: none;">
                                    Continue lire 
                                </button>
                                <p class="text-muted mt-auto">Publié le <?= date('d/m/Y', strtotime($article['created_at'])) ?></p>
                            </div>
                            <!-- Image associée à l'article -->
                            <?php if (!empty($article['image'])): ?>
                                <div class="col-md-4 d-flex flex-column align-items-center p-3">
                                    <img src="<?= htmlspecialchars($article['image']) ?>" class="img-fluid rounded w-100 object-fit-cover article-image" alt="Image de l'article">
                                </div>
                            <?php endif; ?>
                            <!-- Bouton pour afficher le PDF associé à l'article -->
                            <?php if (!empty($article['pdf_path'])): ?>
                                <div class="col-12 text-center mb-3">
                                    <a href="<?= htmlspecialchars($article['pdf_path']) ?>" class="btn btn-primary btn-lg" target="_blank">Voir en détail</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


  <!-- Include the footer section of the website -->
  <?php include './src/views/includes/newsletter.php'; ?>
  <?php   include './src/views/includes/footer.php'; ?>
  <?php include 'src/views/includes/footer_links.php' ?>

<style>
    /* Appliquer un style uniforme aux cartes */
    .card {
        border-radius: 12px;
        transition: transform 0.3s ease-in-out;
    }
    .card:hover {
        transform: scale(1.02);
    }
    /* Effet de fondu en bas du texte */
    .fade-overlay {
        height: 30px;
        background: linear-gradient(to top, white, transparent);
        transition: opacity 0.3s ease;
    }
    /* Ajustement des images pour qu'elles conservent une apparence uniforme */
    .article-image {
        max-height: 250px;
        object-fit: cover;
        border-radius: 8px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.text-container').forEach(container => {
            let id = container.getAttribute('id').split('-')[2];
            let button = document.querySelector(`.toggle-text[data-id="${id}"]`);
            let overlay = container.querySelector('.fade-overlay');
            let card = document.getElementById('card-' + id);

            // Vérifier si le texte dépasse la hauteur maximale et afficher le bouton si nécessaire
            if (container.scrollHeight > 120) {
                button.style.display = 'inline-block';
            }

            // Gérer l'affichage du texte complet ou tronqué au clic du bouton
            button.addEventListener('click', function() {
                if (card.classList.contains('expanded')) {
                    card.classList.remove('expanded');
                    container.style.maxHeight = "120px";
                    overlay.classList.remove('hidden-overlay');
                    this.textContent = "Voir plus";
                } else {
                    card.classList.add('expanded');
                    container.style.maxHeight = container.scrollHeight + "px";
                    overlay.classList.add('hidden-overlay');
                    this.textContent = "Voir moins";
                }
            });
        });
    });
</script>
