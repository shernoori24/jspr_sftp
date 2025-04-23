<!DOCTYPE html>
<html lang="fr">

<?php include 'src/views/includes/head.php' ?>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top header-transparent ">
    <div class="container d-flex align-items-center justify-content-between">

      <div class="logo">
        <h1><a href="accueil"><img src="assets/logo/Screenshot_20240120_014747_Instagram.jpg" alt="Logo de J'SPR 08" class="img-fluid"></a></h1>
      </div>
      
      <!-- .navbar -->
      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="accueil#hero">Accueil</a></li>

          <!-- si admin est connecté on montre l'onglret acces au page backoffice -->
          <?php if (isset($_SESSION['user'])) : ?>
              <?php if (isset($_SESSION['user']['role']) && ($_SESSION['user']['role'] === 'master_admin' || $_SESSION['user']['role'] === 'admin')) : ?>
                  <li><a class="nav-link scrollto" href="shamm/">Backoffice </a></li>
              <?php endif; ?>
          <?php endif; ?>

          <li><a class="nav-link scrollto" href="evenements">Événements</a></li>
          <li><a class="nav-link scrollto" href="journal">Journal</a></li>
          <li><a class="nav-link scrollto" href="accueil#features">Qui Sommes Nous</a></li>
          <li><a class="nav-link scrollto" href="accueil#faq">F.A.Q</a></li>
          <li><a class="nav-link scrollto" href="accueil#contact">Contact</a></li>
          <li class="dropdown"><a href="#"><span>Autres</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="accueil#testimonials">Équipe</a></li>
              <li><a href="accueil#Horaires d’ouverture">Horaires</a></li>
              <li><a href="accueil#mediation_sociale">Médiation sociale</a></li>
              <li><a href="accueil#financeurs_section">Nos financeurs</a></li>
              <li><a href="accueil#prescripteurs_section">Les prescripteurs</a></li>
              <li><a href="accueil#nos_partenaires_section">Nos Partenaires</a></li>
              <li><a href="accueil#cours & methode">Cours & Méthode</a></li>
            </ul>
          </li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- End .navbar -->
    </div>
  </header><!-- End Header -->