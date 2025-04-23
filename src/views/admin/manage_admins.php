<?php
// Vérification si l'utilisateur est connecté, sinon redirection vers la page "klaxon"
if (!isset($_SESSION['user'])) {
    echo "<script>window.location.href = '../klaxon'</script>";
    exit; 
} 
 // Include the header section of the website
 include './src/views/includes/header_backoffice.php'; 
?>

<section>
    <div class="d-flex min-vh-100">
        <!-- side bar navigation -->
        <?php include_once 'src/views/includes/sidebar_backoffice.php'; ?>

        <!-- main content -->

        <div class="p-4 flex-fill" style="margin-left: 250px;">
            <div class="container mt-5" data-aos="fade-down">
                <h2>Gestion des Administrateurs</h2>

                <!-- Affichage des messages d'erreur -->
                <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') ?></div>
                <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <!-- Affichage des messages de succès -->
                <?php if (!empty($_SESSION['success'])): ?>
                <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8') ?>
                </div>
                <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <!-- Bouton pour ouvrir le modal d'ajout d'un administrateur -->
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAdminModal"><i class='bx bx-plus'></i> Ajouter un
                    Administrateur</button>

                <!-- Tableau pour afficher la liste des administrateurs -->
                    <table class="table mt-3 table-hover">
                        <thead>
                            <tr>
                                <th>Nom d'utilisateur</th>
                                <th>Rôle</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Boucle pour afficher chaque administrateur -->
                            <?php foreach ($admins as $admin): ?>
                            <tr>
                                <td><?= htmlspecialchars($admin['nom_utilisateur'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($admin['role'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td>
                                    <!-- Bouton pour ouvrir le modal de modification -->
                                    <button class="btn btn-warning btn-sm edit-btn" data-bs-toggle="modal"
                                        data-bs-target="#editAdminModal" data-id="<?= $admin['id'] ?>"
                                        data-nom_utilisateur="<?= htmlspecialchars($admin['nom_utilisateur'], ENT_QUOTES, 'UTF-8') ?>">
                                        <i class='bx bxs-message-square-edit'></i>
                                    </button>      

                                    <!-- Suppression d'un administrateur (sauf le master admin) -->
                                    <?php if ($admin['role'] !== 'master_admin') : ?>
                                    <form method="post" action="shamm/delete-admin/<?= $admin['id'] ?>"
                                        style="display: inline;">
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet admin ?')"><i class='bx bxs-trash'></i></button>
                                    </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
            </div>
            </div>
        

    </div>
</section>


<!-- Include the footer section of the website -->
<?php include 'src/views/includes/footer_links.php' ?>


<!-- Modal pour ajouter un administrateur -->
<div class="modal fade" id="addAdminModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un Administrateur</h5>
            </div>
            <div class="modal-body">
                <!-- Formulaire d'ajout d'un administrateur -->
                <form action="shamm/create-admin" method="POST">
                    <div class="mb-3">
                        <label>Nom d'utilisateur</label>
                        <input type="text" name="nom_utilisateur" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Mot de passe</label>
                        <input type="password" name="mot_de_passe" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour modifier un administrateur -->
<div class="modal fade" id="editAdminModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier l'Administrateur</h5>
            </div>
            <div class="modal-body">
                <!-- Formulaire de modification d'un administrateur -->
                <form action="shamm/update-admin" method="POST">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="mb-3">
                        <label>Nom d'utilisateur</label>
                        <input type="text" name="nom_utilisateur" class="form-control" id="edit-nom_utilisateur"
                            required>
                    </div>
                    <div class="mb-3">
                        <label>Mot de passe (laisser vide pour ne pas changer)</label>
                        <input type="password" name="mot_de_passe" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
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
                // Récupération des éléments du modal de modification
                const editId = document.getElementById('edit-id');
                const editNomUtilisateur = document.getElementById('edit-nom_utilisateur');

                // Remplissage des champs du modal avec les données de l'administrateur sélectionné
                if (editId && editNomUtilisateur) {
                    editId.value = button.dataset.id;
                    editNomUtilisateur.value = button.dataset.nom_utilisateur;
                }
            });
        });
    });
</script>