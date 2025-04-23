
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
            <div class="container mt-5">
                <!-- Titre de la section -->
                <h2 data-aos="fade-down">Envoyer une Newsletter</h2>

                <!-- Affichage des messages de statut (succès ou erreur) -->
                <?php if (!empty($_SESSION['status'])): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['status']) ?></div>
                    <?php unset($_SESSION['status']); ?>
                <?php endif; ?>
                <?php if (!empty($_SESSION['error'])): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <!-- Formulaire pour envoyer une newsletter -->
                <form action="shamm/envoy_newsletter" method="POST" enctype="multipart/form-data" data-aos="fade-up">
                    <!-- Champ pour le sujet de la newsletter -->
                    <div class="mb-3">
                        <label>Sujet</label>
                        <input type="text" name="subject" class="form-control" required>
                    </div>

                    <!-- Éditeur de texte riche (Quill) pour le contenu de la newsletter -->
                    <div class="mb-3">
                        <label>Contenu</label>
                        <div id="editor" style="height: 300px;"></div>
                        <!-- Champ caché pour stocker le contenu HTML généré par Quill -->
                        <textarea id="quill-content" name="content" style="display: none;"></textarea>
                    </div>

                    <!-- Champ pour les pièces jointes -->
                    <div class="mb-3">
                        <label>Pièces jointes (PDF, images, etc.)</label>
                        <input type="file" name="attachments[]" class="form-control" multiple>
                    </div>

                    <!-- Bouton pour soumettre le formulaire -->
                    <button type="submit" name="send_newsletter" class="btn btn-primary">Envoyer</button>
                </form>
            </div>
            </div>
    </div>
</section>
<!-- Include the footer section of the website -->
<?php include 'src/views/includes/footer_links.php' ?>
<!-- Script JavaScript pour initialiser l'éditeur Quill et gérer la soumission du formulaire -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialisation de l'éditeur Quill
        const quill = new Quill('#editor', {
            placeholder: 'Ecrivez votre Text ...', // Texte d'espace réservé
            theme: 'snow', // Thème de l'éditeur
            modules: {
                toolbar: [
                    // Options de la barre d'outils
                    [{ 'header': [1, 2, 3, false] }], // En-têtes
                    ['bold', 'italic', 'underline', 'strike'], // Styles de texte
                    [{ 'color': [] }, { 'background': [] }], // Couleur du texte et du fond
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }], // Listes
                    ['link'], // Liens
                ]
            }
        });

        // Gestion de la soumission du formulaire
        const form = document.querySelector('form');
        form.addEventListener('submit', function () {
            // Récupération du contenu HTML généré par Quill
            const htmlContent = quill.root.innerHTML;
            // Injection du contenu dans le champ caché pour l'envoi via le formulaire
            document.getElementById('quill-content').value = htmlContent;
        });
    });
</script>