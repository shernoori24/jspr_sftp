<?php

// Vérification si l'utilisateur est connecté, sinon redirection vers la page "klaxon"
if (!isset($_SESSION['user'])) {
    echo "<script>window.location.href = '../klaxon'</script>";
    exit; 
} 
// Utilisation du contrôleur pour gérer les abonnés
use Controllers\SubscriberController;

// Instanciation du contrôleur
$subscriberController = new SubscriberController();

// Récupération dees abonnés depuis la base de données
$cherche = $_GET['cherche'] ?? '';
$subscribers = $subscriberController->searchSubscriber($cherche);

// Gestion des requêtes POST (ajout, modification, suppression d'abonnés)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ajout d'un nouvel abonné
    if (isset($_POST['add_subscriber'])) {
        $email = ($_POST['email']);
        $subscriberController->addSubscriber($email);
        // Redirection pour éviter la soumission multiple du formulaire
        echo '<script>window.location.href = window.location.href;</script>';
        exit();
    }
    // Modification d'un abonné existant
    elseif (isset($_POST['edit_subscriber'])) {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT); // Sécurisation de l'ID
        $email = ($_POST['email']);
        $subscriberController->updateSubscriber($id, $email);
        // Redirection pour éviter la soumission multiple du formulaire
        echo '<script>window.location.href = window.location.href;</script>';
        exit();
    }
    // Suppression d'un abonné
    elseif (isset($_POST['delete_subscriber'])) {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT); // Sécurisation de l'ID
        $subscriberController->deleteSubscriber($id);
        // Redirection pour éviter la soumission multiple du formulaire
        echo '<script>window.location.href = window.location.href;</script>';
        exit();
    }
}

 // Include the header section of the website
 include './src/views/includes/header_backoffice.php'; 
?>

<section>
    <div class="d-flex min-vh-100">
        <!-- side bar navigation -->
        <?php include_once 'src/views/includes/sidebar_backoffice.php'; ?>

        <!-- Section principale de la page -->
        <div class="p-4 flex-fill" style="margin-left: 250px;">
        <div class="container mt-5"  data-aos="fade-down">
            <!-- Titre de la page -->
            <h2 class="mb-4">Gestion des Abonnés</h2>

            <!-- Affichage des messages de statut (succès ou erreur) -->
            <?php if (!empty($_SESSION['status'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['status']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['status']); ?>
            <?php endif; ?>
            <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- affiche le message par ajax quand on ajoute une abonnée -->
            <div class="my-3">
                <div id="loading-animation-subscriber" class="loading-animation">Chargement</div>
                <div id="error-message-subscriber" class="error-message" style="display: none;"></div>
                <div id="sent-message-subscriber" class="sent-message" style="display: none;"></div>
            </div>
            <!-- Bouton pour ouvrir le modal d'ajout d'un abonné -->
            <div class="mb-4 d-flex justify-content-between align-items-center">

                <!-- Formulaire d'ajout d'un abonné -->
                <form class="d-flex" id="abonner_form" action="" method="POST">
                    <input type="email" placeholder="Ajouter un Email" name="email_pour_ajouter_en_subscriber"
                        class="form-control me-2" required>

                    <button type="submit" name="add_subscriber" class="btn btn-primary">Ajouter</button>
                </form>
                <p class="p-1 text-center fs-6 fw-lighter"><?=  count($subscribers) ?> Résultat</p>
                <!-- Formulaire de recherche -->
                <form action="" method="get" class="d-flex">
                    <input type="text" name="cherche" class="form-control me-2" placeholder="Rechercher un email"
                        value="<?= $cherche ?>">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class='bx bx-search-alt-2'></i>
                    </button>
                </form>
            </div>

            <!-- Tableau pour afficher la liste des abonnés -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Boucle pour afficher chaque abonné -->
                        <?php foreach ($subscribers as $subscriber): ?>
                        <tr>
                            <td><?= htmlspecialchars($subscriber['email']) ?></td>
                            <td>
                                <!-- Bouton pour ouvrir le modal de modification -->
                                <button class="btn btn-warning btn-sm edit-btn" data-bs-toggle="modal"
                                    data-bs-target="#editSubscriberModal" data-id="<?= $subscriber['id'] ?>"
                                    data-email="<?= htmlspecialchars($subscriber['email']) ?>">
                                    <i class="fas fa-edit"></i> <i class='bx bxs-message-square-edit'></i>
                                </button> |
                                <!-- Formulaire pour supprimer un abonné -->
                                <form method="post" action="" style="display: inline;">
                                    <input type="hidden" name="delete_subscriber" value="1">
                                    <input type="hidden" name="id" value="<?= $subscriber['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet abonné?')">
                                        <i class="fas fa-trash"></i> <i class='bx bxs-trash'></i>
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

<!-- Include the footer section of the website -->
<?php include 'src/views/includes/footer_links.php' ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- js pour envoyer le formulaie par ajax -->
<script src="assets/js/ajax/abonnes.js"></script>

<!-- Modal pour modifier un abonné -->
<div class="modal fade" id="editSubscriberModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier l'Abonné</h5>
            </div>
            <div class="modal-body">
                <!-- Formulaire de modification d'un abonné -->
                <form action="" method="POST">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" id="edit-email" required>
                    </div>
                    <button type="submit" name="edit_subscriber" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script JavaScript pour gérer les modals -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Gestion des boutons de modification
        const editButtons = document.querySelectorAll('.edit-btn');
        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                const editId = document.getElementById('edit-id');
                const editEmail = document.getElementById('edit-email');
                // Remplissage des champs du modal de modification avec les données de l'abonné
                if (editId && editEmail) {
                    editId.value = button.dataset.id;
                    editEmail.value = button.dataset.email;
                }
            });
        });
    });
</script>