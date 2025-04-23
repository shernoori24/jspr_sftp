<?php
$eventsController = new Controllers\EventsController();
$events = $eventsController->getAllEvents();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_event'])) {
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $date = trim($_POST['date']);
        $adresse = trim($_POST['adresse']);
        $image = $_FILES['image'] ?? null;

        if ($eventsController->addEvent($title, $description, $date, $adresse, $image)) {
            echo '<script>window.location.href = window.location.href;</script>';
            exit();
        }
    } elseif (isset($_POST['edit_event'])) {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $title = trim($_POST['title']);
        $description = trim($_POST['description']);
        $date = trim($_POST['date']);
        $adresse = trim($_POST['adresse']);
        $image = $_FILES['image'] ?? null;

        if ($eventsController->updateEvent($id, $title, $description, $date, $adresse, $image)) {
            echo '<script>window.location.href = window.location.href;</script>';
            exit();
        }
    } elseif (isset($_POST['delete_event'])) {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        
        if ($eventsController->deleteEvent($id)) {
            echo '<script>window.location.href = window.location.href;</script>';
            exit();
        }
    }
}

if (!isset($_SESSION['user']) || empty($_SESSION["user"])) {  
    // echo "<script>window.location.href = '../klaxon'</script>";
    // header('Location: https://dev.jspr08.fr/klaxon');

    echo "<script>window.location.href = '../klaxon'</script>";
    exit(); 
}



?>

<?php include './src/views/includes/header_backoffice.php'; ?>

<section>
    <div class="d-flex min-vh-100">
        <?php include_once 'src/views/includes/sidebar_backoffice.php'; ?>
        
        <div class="p-4 flex-fill" style="margin-left: 250px;">
            <div class="container mt-5" data-aos="fade-down">
                <h2>Gestion des Événements</h2>

                <?php if (!empty($_SESSION['message'])): ?>
                <div class="alert alert-success"><?= htmlspecialchars($_SESSION['message']) ?></div>
                <?php unset($_SESSION['message']); ?>
                <?php endif; ?>
                
                <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
                <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEventModal">
                    <i class='bx bx-plus'></i> Ajouter un Événement
                </button>

                <table class="table mt-3 table-hover">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Adresse</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($events as $event): ?>
                        <tr>
                            <td><?= htmlspecialchars($event['title']) ?></td>
                            <td><?= nl2br(htmlspecialchars(mb_strimwidth($event['description'], 0, 100, ' ...'))) ?></td>
                            <td><?= htmlspecialchars($event['date']) ?></td>
                            <td><?= htmlspecialchars($event['adresse']) ?></td>
                            <td>
                                <?php if (!empty($event['image']) && file_exists($event['image'])): ?>
                                    <img src="<?= htmlspecialchars($event['image']) ?>" width="100">
                                <?php else: ?>
                                    <span class="text-muted">Aucune image</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-btn" data-bs-toggle="modal"
                                    data-bs-target="#editEventModal" data-id="<?= $event['id'] ?>"
                                    data-title="<?= htmlspecialchars($event['title']) ?>"
                                    data-description="<?= htmlspecialchars($event['description']) ?>"
                                    data-date="<?= htmlspecialchars($event['date']) ?>"
                                    data-adresse="<?= htmlspecialchars($event['adresse']) ?>"
                                    data-image="<?= htmlspecialchars($event['image'] ?? '') ?>">
                                    <i class='bx bxs-edit'></i>
                                </button>
                                <hr>
                                <form method="post" action="" style="display: inline;">
                                    <input type="hidden" name="delete_event" value="1">
                                    <input type="hidden" name="id" value="<?= $event['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet événement?')">
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

<!-- Modals -->
<div class="modal fade" id="addEventModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un Événement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Titre *</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description *</label>
                        <textarea name="description" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date *</label>
                        <input type="datetime-local" name="date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Adresse *</label>
                        <input type="text" name="adresse" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image (optionnel)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">Formats acceptés: JPG, PNG, GIF, etc.</small>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="send_email" class="form-check-input" id="sendEmailCheck" checked>
                        <label class="form-check-label" for="sendEmailCheck">Envoyer un email aux abonnés</label>
                    </div>
                    <button type="submit" name="add_event" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editEventModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier l'Événement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="mb-3">
                        <label class="form-label">Titre *</label>
                        <input type="text" name="title" class="form-control" id="edit-title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description *</label>
                        <textarea name="description" class="form-control" id="edit-description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date *</label>
                        <input type="datetime-local" name="date" class="form-control" id="edit-date" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Adresse *</label>
                        <input type="text" name="adresse" class="form-control" id="edit-adresse" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image (optionnel)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <div class="mt-2">
                            <img id="edit-image-preview" src="" style="max-width: 100px; display: none;">
                            <span id="no-image-text" class="text-muted">Aucune image</span>
                        </div>
                    </div>
                    <button type="submit" name="edit_event" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('edit-id').value = button.dataset.id;
            document.getElementById('edit-title').value = button.dataset.title;
            document.getElementById('edit-description').value = button.dataset.description;
            document.getElementById('edit-date').value = button.dataset.date;
            document.getElementById('edit-adresse').value = button.dataset.adresse;
            
            const imagePreview = document.getElementById('edit-image-preview');
            const noImageText = document.getElementById('no-image-text');
            
            if (button.dataset.image) {
                imagePreview.src = button.dataset.image;
                imagePreview.style.display = 'block';
                noImageText.style.display = 'none';
            } else {
                imagePreview.style.display = 'none';
                noImageText.style.display = 'inline';
            }
        });
    });
});
</script>

<?php include 'src/views/includes/footer_links.php' ?>