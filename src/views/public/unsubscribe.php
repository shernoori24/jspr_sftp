<?php  
// Include the header section of the website
 include './src/views/includes/header.php';  ?>
<section class="d-flex align-items-center justify-content-center vh-100">
    <?php
    // Inclusion des fichiers nécessaires pour la gestion des abonnés
    require_once 'src/Models/SubscriberModel.php';
    require_once 'src/Controllers/SubscriberController.php';

    // Création des instances des classes nécessaires
    $subscriberModel = new Models\SubscriberModel();
    $subscriberController = new Controllers\SubscriberController();

    // Vérification si les paramètres email et token sont présents dans l'URL
    if (isset($_GET['email']) && isset($_GET['token'])) {
        $email = urldecode($_GET['email']); // Décodage de l'email pour éviter les erreurs d'encodage
        $token = $_GET['token']; // Récupération du token

        // Appel de la méthode pour se désabonner
        $subscriberController->unsubscribe($email, $token);
    } else {
        // Affichage d'une alerte si les paramètres sont manquants
        echo "<h2>Paramètres manquants</h2>";
    }
    ?>
</section>

  <!-- Include the footer section of the website -->
  <?php include './src/views/includes/newsletter.php'; ?>
  <?php   include './src/views/includes/footer.php'; ?>
  <?php include 'src/views/includes/footer_links.php' ?>