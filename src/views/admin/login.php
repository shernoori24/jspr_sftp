<?php 
 // Include the header section of the website
 include './src/views/includes/header.php'; 
?>
<!-- Section principale avec mise en page flex pour centrer le contenu verticalement et horizontalement -->
<section class="d-flex align-items-center justify-content-center vh-100">
    <div class="container" data-aos="fade-up">
        <!-- Conteneur principal avec animation AOS -->
        <div class="row justify-content-center">
            <!-- Centrage du contenu -->
            <div class="col-12 col-md-8 col-lg-6">
                <!-- Définition de la largeur en fonction de la taille de l'écran -->

                <!-- Titre de la section -->
                <div class="section-title text-center">
                    <h2>Admin connection</h2>
                </div>

                <!-- Affichage des messages d'erreur s'ils existent -->
                <div id="error-message" class="alert alert-danger" style="display: none;"></div>

                <!-- Formulaire de connexion -->
                <form id="login-form" method="POST" action="klaxon">
                    <!-- Champ pour le nom d'utilisateur -->
                    <div class="form-group">
                        <label for="username">Nom d'utilisateur :</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>

                    <!-- Champ pour le mot de passe -->
                    <div class="form-group">
                        <label for="password">Mot de passe :</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>

                    <!-- Bouton de soumission du formulaire -->
                    <div class="text-center my-4">
                        <!-- my-4 ajoute une marge en haut et en bas -->
                        <button type="submit" class="btn btn-primary btn-lg px-5">Se connecter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Intégration de jQuery pour faciliter l'utilisation d'AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/js/ajax/login.js"></script>

<!-- Include the footer section of the website -->
<?php include 'src/views/includes/footer_links.php' ?>