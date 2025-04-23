<!DOCTYPE html>
<html lang="fr">

<?php include 'src/views/includes/head.php' ?>

<body>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top header-transparent">
  <div class="container d-flex align-items-center justify-content-between">

    <div class="logo d-flex align-items-center">
      <h1 class="m-0">
        <a href="accueil">
          <img src="assets/logo/Screenshot_20240120_014747_Instagram.jpg" alt="Logo de J'SPR 08" class="img-fluid">
        </a>
      </h1>
      <span class="ms-3"><strong>Space Admin |  <?= $_SESSION['user']['nom_utilisateur'] ?></strong></span>
    </div>

    <!-- .navbar -->
    <nav id="navbar" class="navbar">
      <ul>
        <li><a href="accueil" class="nav-link scrollto">Voir Le Site</a></li>
        <!-- Lien pour la déconnexion -->
        <li><a href="deconnexion" class="px-3 py-2 d-block"><i class='bx bx-log-out'></i> Déconnexion</a></li>
      </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
    </nav>
    <!-- End .navbar -->
  </div>
</header><!-- End Header -->