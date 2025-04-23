<?php
// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    echo "<script>window.location.href = '../klaxon'</script>";
    exit; 
} 

// Initialisation du contrôleur
$equipeController = new \Controllers\EquipeController();

// Appel de la méthode pour afficher la page
$equipeController->affichePageAdminEquipe();
?>

<?php include './src/views/includes/header_backoffice.php'; ?>

<section>
    <div class="d-flex min-vh-100">
        <?php include_once 'src/views/includes/sidebar_backoffice.php'; ?>

        <div class="p-4 flex-fill" style="margin-left: 250px;">
            <div class="container mt-5" data-aos="fade-down">
                <h2>Gestion des Membres</h2>

                <?php if (!empty($_SESSION['message'])): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['message']) ?></div>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>
                <?php if (!empty($_SESSION['error'])): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMembreModal">
                    <i class='bx bx-plus'></i> Ajouter un Membre
                </button>

                <table class="table mt-3 table-hover">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Poste</th>
                            <th>Description</th>
                            <th>Catégorie</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($membres as $membre): ?>
                        <tr>
                            <td><?= htmlspecialchars($membre['nom']) ?></td>
                            <td><?= htmlspecialchars($membre['poste']) ?></td>
                            <td><?= htmlspecialchars($membre['description']) ?></td>
                            <td><?= htmlspecialchars($membre['categorie']) ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-btn" data-bs-toggle="modal"
                                    data-bs-target="#editMembreModal" 
                                    data-id="<?= $membre['id'] ?>"
                                    data-nom="<?= htmlspecialchars($membre['nom']) ?>"
                                    data-description="<?= htmlspecialchars($membre['description']) ?>"
                                    data-poste_id="<?= $membre['id_postes_membres'] ?>"
                                    data-categorie_id="<?= $membre['id_categories_membres'] ?>">
                                    <i class='bx bxs-message-square-edit'></i>
                                </button>
                                <hr>
                                <form method="post" action="" style="display: inline;">
                                    <input type="hidden" name="delete_membre" value="1">
                                    <input type="hidden" name="id" value="<?= $membre['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce membre?')">
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
</section>

<?php include 'src/views/includes/footer_links.php' ?>

<!-- Modal pour ajouter un membre -->
<div class="modal fade" id="addMembreModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un Membre</h5>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label>Nom</label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Poste</label>
                        <div class="input-group">
                            <select name="poste_select" class="form-control" id="poste-select" onchange="toggleNewPosteField(this)">
                                <?php foreach ($postes as $poste): ?>
                                    <option value="<?= $poste['id'] ?>"><?= htmlspecialchars($poste['poste']) ?></option>
                                <?php endforeach; ?>
                                <option value="new">++ Ajouter un nouveau poste ++</option>
                            </select>
                        </div>
                        <input type="text" name="new_poste" class="mt-2 form-control d-none" id="new-poste-input" placeholder="Entrez le nouveau poste">
                    </div>
                    <div class="mb-3">
                        <label>Catégorie</label>
                        <select name="categorie_id" class="form-control" required>
                            <?php foreach ($categories as $categorie): ?>
                                <option value="<?= $categorie['id'] ?>"><?= htmlspecialchars($categorie['categorie']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" name="add_membre" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour modifier un membre -->
<div class="modal fade" id="editMembreModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier le Membre</h5>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="mb-3">
                        <label>Nom</label>
                        <input type="text" name="nom" class="form-control" id="edit-nom" required>
                    </div>
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" id="edit-description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Poste</label>
                        <div class="input-group">
                            <select name="poste_select" class="form-control" id="edit-poste-select" onchange="toggleEditNewPosteField(this)">
                                <?php foreach ($postes as $poste): ?>
                                    <option value="<?= $poste['id'] ?>"><?= htmlspecialchars($poste['poste']) ?></option>
                                <?php endforeach; ?>
                                <option value="new">++ Ajouter un nouveau poste ++</option>
                            </select>
                        </div>
                        <input type="text" name="new_poste" class="mt-2 form-control d-none" id="edit-new-poste-input" placeholder="Entrez le nouveau poste">
                    </div>
                    <div class="mb-3">
                        <label>Catégorie</label>
                        <select name="categorie_id" class="form-control" id="edit-categorie_id" required>
                            <?php foreach ($categories as $categorie): ?>
                                <option value="<?= $categorie['id'] ?>"><?= htmlspecialchars($categorie['categorie']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" name="edit_membre" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Fonction pour afficher/masquer le champ de nouveau poste dans l'édition
    function toggleEditNewPosteField(select) {
        const newPosteInput = document.getElementById('edit-new-poste-input');
        if (select.value === 'new') {
            newPosteInput.classList.remove('d-none');
            newPosteInput.required = true;
        } else {
            newPosteInput.classList.add('d-none');
            newPosteInput.required = false;
        }
    }

    // Mise à jour de la gestion des boutons d'édition
    document.addEventListener('DOMContentLoaded', () => {
        const editButtons = document.querySelectorAll('.edit-btn');
        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                document.getElementById('edit-id').value = button.dataset.id;
                document.getElementById('edit-nom').value = button.dataset.nom;
                document.getElementById('edit-description').value = button.dataset.description;
                
                // Sélectionne le poste existant par défaut
                const posteSelect = document.getElementById('edit-poste-select');
                posteSelect.value = button.dataset.poste_id;
                
                // Masque le champ nouveau poste
                document.getElementById('edit-new-poste-input').classList.add('d-none');
                
                // Sélectionne la catégorie
                document.getElementById('edit-categorie_id').value = button.dataset.categorie_id;
            });
        });
    });
</script>