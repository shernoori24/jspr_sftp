<?php
 // Include the header section of the website
 include './src/views/includes/header.php'; 
 $_SESSION['sher'] = 'alijan';
?>

<main id="main">
  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
    <div class="container">
      <div class="row">
        <div
          class="order-2 pt-5 col-lg-6 d-lg-flex flex-lg-column justify-content-center align-items-stretch pt-lg-0 order-lg-1"
          data-aos="fade-up">
          <div>
            <h1>Acteur de l'évolution</h1>
            <h2>Bienvenue sur le site de J'SPR 08, une association engagée dans l'évolution sociale et l'entraide
              communautaire. Notre mission est de créer un environnement inclusif où chacun peut s'épanouir.</h2>
            <a href="#contact" class="download-btn">Devenir bénévole</a>
          </div>
        </div>
        <div class="order-1 col-lg-6 d-lg-flex flex-lg-column align-items-stretch order-lg-2 hero-img"
          data-aos="fade-up">
          <img src="assets/img/IMG20240314135441.jpg" class="img-fluid" alt="">
        </div>
      </div>
    </div>
  </section><!-- End Hero -->

  <!-- ======= App Features Section ======= -->
  <section id="features" class="features">
    <div class="container py-5" data-aos="fade-left">
      <div class="row justify-content-center">
        <div class="text-center col-md-10">
          <div class="mb-4 section-title">
            <h2 class="fw-bold">Qui Sommes-Nous</h2>
            <div class="mx-auto mb-3 underline"></div>
          </div>
          <p class="lead text-muted">
            Notre mission est l'Action éducative et socio-culturelle pour une entrée ou un retour vers la scolarité ou
            l’emploi. Nous sommes une association dédiée à l'intégration et à l'émancipation des individus venus
            d'horizons divers.
          </p>
          <p>
            Fondée sur des valeurs de solidarité, d'égalité et de respect, notre association s'engage à soutenir toute
            personne en offrant un accompagnement personnalisé et des ressources adaptées à ses besoins.
          </p>
          <p>
            Que vous soyez nouvellement arrivé ou que vous cherchiez simplement à vous investir dans des actions
            sociales, notre association vous offre l'opportunité de faire partie d'une communauté engagée et solidaire.
          </p>
          <p class="fw-bold">
            Ensemble, œuvrons pour un monde où chacun a sa place et peut réaliser son potentiel.
          </p>
        </div>
      </div>
    </div>

    <section id="features" class="features">
      <div class="container" data-aos="fade-up">
        <div class="row no-gutters">
          <!-- Colonne de gauche : Contenu des icônes et descriptions -->
          <div class="order-2 col-xl-7 d-flex align-items-stretch order-lg-1">
            <div class="content d-flex flex-column align-items-center justify-content-center">
              <div class="row">
                <!-- Boîte d'icône 1 : Alphabétisation -->
                <div class="col-md-6 icon-box" data-aos="fade-up">
                  <i class="bx bx-receipt"></i>
                  <h4>Alphabétisation et Acquisition des Savoirs de Base.</h4>
                  <p>Nous offrons des programmes d'alphabétisation et d'acquisition des savoirs de base pour aider les
                    individus à renforcer leurs compétences fondamentales.</p>
                </div>

                <!-- Boîte d'icône 2 : Français Langue Étrangère (FLE) -->
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                  <i class="bx bx-receipt"></i>
                  <h4>Français Langue Étrangère. (FLE)</h4>
                  <p>Nous proposons des cours de français langue étrangère pour faciliter l'intégration linguistique des
                    nouveaux arrivants.</p>
                </div>

                <!-- Boîte d'icône 3 : Lutte contre l'Illettrisme -->
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="200">
                  <i class="bx bx-receipt"></i>
                  <h4>Lutte contre l'Illettrisme.</h4>
                  <p>Nous nous engageons activement dans la lutte contre l'illettrisme en fournissant des ressources et
                    un soutien personnalisé.</p>
                </div>

                <!-- Boîte d'icône 4 : Remise à Niveau -->
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="300">
                  <i class="bx bx-receipt"></i>
                  <h4>Remise à Niveau Avant Formation ou Examen.</h4>
                  <p>Nous aidons les personnes à se préparer et à se remettre à niveau avant de passer des examens ou de
                    suivre des formations.</p>
                </div>

                <!-- Boîte d'icône 5 : Intégration par la Culture et le Sport -->
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="400">
                  <i class="bx bx-receipt"></i>
                  <h4>Intégration par la Culture et le Sport.</h4>
                  <p>Nous organisons des activités culturelles et sportives pour favoriser l'intégration sociale et
                    renforcer les liens.</p>
                </div>

                <!-- Boîte d'icône 6 : Médiation de Champ Scolaire -->
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="500">
                  <i class="bx bx-receipt"></i>
                  <h4>Médiation de Champ Scolaire</h4>
                  <p>Nous intervenons dans les établissements scolaires pour accompagner les élèves et les familles dans
                    leurs démarches éducatives.</p>
                </div>

                <!-- Boîte d'icône 7 : Médiation d'Accès aux Droits -->
                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="600">
                  <i class="bx bx-receipt"></i>
                  <h4>Médiation d'Accès aux Droits.</h4>
                  <p>Nous offrons un service de médiation pour aider les individus à accéder à leurs droits et à
                    naviguer dans les démarches administratives.</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Colonne de droite : Image -->
          <div class="order-1 image col-xl-5 d-flex align-items-stretch justify-content-center order-lg-2"
            data-aos="fade-left" data-aos-delay="100">
            <img src="assets/img/IMG20240314135159.jpg" class="img-fluid" alt=""
              style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
          </div>
        </div>
      </div>
    </section>

    <!-- ======= Details Section ======= -->
    <section id="details" class="details">
      <div class="container">
        <div class="row content">
          <div class="col-md-4" data-aos="fade-right">
            <img src="assets/img/IMG20240314135049.jpg" class="img-fluid" alt="">
          </div>
          <div class="pt-4 col-md-8" data-aos="fade-up">
            <h3>Attention</h3>
            <p class="fst-italic">
              Attention il faut être présent 5 minutes avant le cours et se rendre directement dans la salle de cours.
              Un retard de plus de 15 minutes n'est pas accepté et vous ne serez plus autorisé à entrer dans les locaux.
              Ce retard devra rester exceptionnel.
            </p>
            <p>
              En salle de cours,
              - aucun couvre chef (bonnet, casquette, capuche, etc...)
              - pas de téléphone portable (mettre le téléphone sur silencieux et prévenir l'entourage d'appeler en
              dehors des heures de cours.)
              - les cours durent 2 heures, il faut arriver et partir à l'heure.
            </p>
          </div>
        </div>

        <div class="row content" id="mediation_sociale">
          <div class="order-1 col-md-4 order-md-2" data-aos="fade-left">
            <img src="assets/img/IMG_20210805_100349.jpg" class="img-fluid" alt="">
          </div>
          <div class="order-2 pt-5 col-md-8 order-md-1" data-aos="fade-up">
            <h3>Médiation sociale</h3>
            <h4>Champ scolaires</h4>
            <p class="fst-italic">
              Pour rappel le médiateur scolaire a pour tâche d’aider les jeunes élèves du collège Scamaroni de
              Manchester dans toutes les difficultés qu’ils pourraient rencontrer, que ce soit avec le collège, les
              autres élèves, leur scolarité, leur famille ou toute autre tracasserie qui pourrait concerner un(e)
              collégien(ne).
            </p>
            <h4>Accès aux droits</h4>
            <p>
              Médiation d’Accès aux Droits au sein de l’association. Ce service n’est pas destiné uniquement aux membres
              de la structure, bien qu’indispensable à notre public, mais il est, au besoin, ouvert aux habitants du
              quartier de Manchester.
              Ce service pour but d’accompagner une population de plus en plus en demande pour des démarches diverses et
              variées (inscriptions Pôle Emploi, établissement de CV et/ou lettres de motivations, recherches de stages,
              demande de RDV à la préfecture, montage de dossiers CMU, demande d’appartements, impôts …/…).
            </p>
            <p>
              La demande a concerné également des dossiers de demande de naturalisation, des demandes d’aide financière
              et médicale.
            </p>
            <p>
              <h5>Il est à noter que conseiller et aider ne signifie pas faire à la place de…</h5>
            </p>
          </div>
        </div>

        <div class="row content" id="cours & methode">
          <div class="col-md-4" data-aos="fade-right">
            <img src="assets/img/img all.jpg" class="img-fluid" alt="">
          </div>
          <div class="pt-5 col-md-8" data-aos="fade-up">
            <h3>Cours</h3>
            <ul>
              <li><i class="bi bi-check"></i> Cours en petits groupes : Principale activité dans nos locaux, ces séances
                de travail mobilisent la majeure partie de notre temps. Nous abordons le français (lu, écrit et parlé)
                et les mathématiques.</li>
              <li><i class="bi bi-check"></i> Ateliers éducatifs : Des ateliers sont régulièrement organisés autour de
                thèmes variés : code de la route, cuisine, civisme, gestion de budget, histoire, géographie et éducation
                civique, etc.</li>
              <li><i class="bi bi-check"></i> Accompagnement individuel : orthophonie par exemple</li>
              <li><i class="bi bi-check"></i> Intégration par la culture et le sport : Sorties culturelles et activités
                sportives afin d’offrir d’autres opportunités d’intégration.</li>
            </ul>
            <p>
              <h4>Méthode</h4>
            </p>
            <p>
              Lors de l’inscription à l’association, nous effectuons un test de positionnement afin d’évaluer le niveau
              de l’apprenant et ainsi établir un projet de suivi adapté. Les groupes de travail sont ensuite constitués
              par niveaux.
            </p>
          </div>
        </div>

        <section id="Horaires d’ouverture">
          <div class="table-container">
            <h3>Horaires d’ouverture</h3>
            <table>
              <tr>
                <td>Lundi</td>
                <td>8h00 - 12h</td>
                <td>13h00 - 17h</td>
              </tr>
              <tr>
                <td>Mardi</td>
                <td>8h00 - 12h</td>
                <td>13h00 - 17h</td>
              </tr>
              <tr>
                <td>Mercredi</td>
                <td>8h00 - 12h</td>
                <td>13h00 - 17h</td>
              </tr>
              <tr>
                <td>Jeudi</td>
                <td>8h00 - 12h</td>
                <td>13h00 - 17h</td>
              </tr>
              <tr>
                <td>Vendredi</td>
                <td>8h00 - 12h</td>
                <td>13h00 - 17h</td>
              </tr>
            </table>
          </div>
        </section>

        <section id="horaire-cours">
          <div class="table-container">
            <h3>Horaire des cours</h3>
            <table>
              <tr>
                <td>Lundi</td>
                <td></td>
                <td></td>
                <td>13h30 - 15h</td>
                <td></td>
              </tr>
              <tr>
                <td>Mardi</td>
                <td>8h30 - 10h</td>
                <td>10h - 11h30</td>
                <td>13h30 - 15h</td>
                <td>15h - 16h30</td>
              </tr>
              <tr>
                <td>Mercredi</td>
                <td>8h30 - 10h</td>
                <td>10h - 11h30</td>
                <td>13h30 - 15h</td>
                <td>15h - 16h30</td>
              </tr>
              <tr>
                <td>Jeudi</td>
                <td>8h30 - 10h</td>
                <td>10h - 11h30</td>
                <td>13h30 - 15h</td>
                <td>15h - 16h30</td>
              </tr>
            </table>
          </div>
        </section>

        <div class="row content" id="financeurs_section">
          <div class="order-1 col-md-4 order-md-2" data-aos="fade-left">
            <img src="assets/img/Nos financeurs grand format.png" class="img-fluid" alt="">
          </div>
          <div class="order-2 pt-5 col-md-8 order-md-1" data-aos="fade-up">
            <h3>Nos financeurs </h3>
            <ul>
              <li><i class="bi bi-check"></i> Ardennes Conseil Départemental.</li>
              <li><i class="bi bi-check"></i> Adenne Metropole.</li>
              <li><i class="bi bi-check"></i> Ville de Charleville-Mézières</li>
              <li><i class="bi bi-check"></i> Ardennes Conseil Départemental.</li>
              <li><i class="bi bi-check"></i> charlevil lecture.</li>
              <li><i class="bi bi-check"></i> BTP CFA Grand Est.</li>
              <li><i class="bi bi-check"></i> Ardennes Conseil DépartementalRépublique Française.</li>
              <li><i class="bi bi-check"></i> Agence nationale de la cohésion des territoires.</li>
              <li><i class="bi bi-check"></i> Ville de Charleville-MézièresMinistère du travail de l'emploi et de
                l'insertion</li>
              <li><i class="bi bi-check"></i> Quartiers Solidaires.</li>
              <li><i class="bi bi-check"></i> Allocation Familiales</li>
              <li><i class="bi bi-check"></i> Fondation de coopération de la jeunesse et de l'éducation populaire.</li>
            </ul>
          </div>
        </div>
      </div>
    </section><!-- End Details Section -->

    <!-- ======= Details détail ======= -->
    <section id="details" class="details">
      <div class="container">
        <div class="row content" id="prescripteurs_section">
          <div class="col-md-4" data-aos="fade-right">
            <img src="assets/img/pexels-ingo-joseph-609771.jpg" class="img-fluid" alt="">
          </div>
          <div class="pt-4 col-md-8" data-aos="fade-up">
            <h3>Les prescripteurs</h3>
            <p class="fst-italic">
              Le Foyer de l’Enfance (FDE) nous adresse les Mineurs Non Accompagnés (MNA).<br>
              • Partenaires réguliers de l’association, les Missions locales de Charleville et Sedan nous adressent des
              jeunes des jeunes qui ont besoin de se mettre à niveau avant une formation , un examen, etc. Des bilans
              sont faits ponctuellement entre nos services respectifs.<br>
              • Le public migrant que nous accueillons est composé de demandeurs d’asile en provenance des CADA AATM ou
              L’ANCRE sur Charleville, ADOMA à Revin et Fumay et de Bénéficiaires de la Protection Internationale (BPI)
              envoyés par le CPH ARDENNES et COALLIA.<br>
              • GLOBAL AXE, hébergement d’urgence par le 115.<br>
              • La Protection Judiciaire de la Jeunesse (PJJ) et le restaurant d’application Le Damier.<br>
              • Le CIO nous adresse à l’occasion quelques jeunes scolarisés en grande difficulté avec la langue
              française.<br>
              • L’IME de Boutancourt.<br>
              • RESIDEIS, centre d’hébergement.<br>
              • Armée du Salut.<br>
              • À noter enfin que le bouche-à-oreille nous apporte près de 3/4 de nos nouveaux « élèves », résidant
              majoritairement dans les différents foyers d’accueil.
            </p>
          </div>
        </div>

        <div class="row content" id="nos_partenaires_section">
          <div class="order-1 col-md-4 order-md-2" data-aos="fade-left">
          </div>
          <div class="order-2 pt-5 col-md-8 order-md-1" data-aos="fade-up">
            <h3>Nos Partenaires </h3>
            <ul>
              <li><i class="bi bi-check"></i> L'armée du salut Charleville et rethel.</li>
              <li><i class="bi bi-check"></i> Le CHRS L'espérance de Sedan. </li>
              <li><i class="bi bi-check"></i> Les Centre sociaux.</li>
              <li><i class="bi bi-check"></i> Les assistantes sociales.</li>
              <li><i class="bi bi-check"></i> Les foyers d'hébergement (L'Ancre et Voltaire par exemple).</li>
              <li><i class="bi bi-check"></i> Le CCAS de charleville.</li>
              <li><i class="bi bi-check"></i> France Travail et CAP Emploi 08.(reconnaissance MDPH) </li>
              <li><i class="bi bi-check"></i> La Cimade. </li>
              <li><i class="bi bi-check"></i> SAMSAH SAVS la Passerelle.</li>
              <li><i class="bi bi-check"></i> AAPH (Nos locaux étant dotés d'une rampe d'accès et d'un ascenseur).</li>
            </ul>
          </div>
        </div>
      </div>
    </section>

<!-- ======= Section Équipe ======= -->
<section id="testimonials" class="testimonials section-bg">
  <div class="container">
    <h1 class="mb-5 text-center" data-aos="fade-up">Équipe</h1>
    <div class="d-flex flex-lg-row flex-column justify-content-between">
      <!-- Bénévoles -->
      <div class="mb-4 col-lg-6 col-12 pe-lg-3" data-aos="fade-right">
        <h2 class="mb-4 text-center">Bénévoles</h2>
        <div class="swiper benevoles-slider">
          <div class="swiper-wrapper">
            <?php foreach ($benevoles as $membre) : ?>
            <div class="swiper-slide">
              <div class="border-0 shadow-lg card h-100 min-vh-50">
                <div class="text-center card-body">
                  <h3 class="card-title"><?= htmlspecialchars($membre['nom']) ?></h3>
                  <h4 class="mb-2 card-subtitle text-muted"><?= htmlspecialchars($membre['poste']) ?></h4>
                  <p class="card-text">
                    <i class="bx bxs-quote-alt-left quote-icon-left text-primary"></i>
                    <?= htmlspecialchars($membre['description']) ?>
                    <i class="bx bxs-quote-alt-right quote-icon-right text-primary"></i>
                  </p>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
          <div class="swiper-pagination"></div>
          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
        </div>
      </div>

      <!-- Salariés -->
      <div class="mb-4 col-lg-6 col-12 ps-lg-3" data-aos="fade-left">
        <h2 class="mb-4 text-center">Salariés</h2>
        <div class="swiper salaries-slider">
          <div class="swiper-wrapper">
            <?php foreach ($salaries as $membre) : ?>
            <div class="swiper-slide">
              <div class="border-0 shadow-lg card h-100 min-vh-50">
                <div class="text-center card-body">
                  <h3 class="card-title"><?= htmlspecialchars($membre['nom']) ?></h3>
                  <h4 class="mb-2 card-subtitle text-muted"><?= htmlspecialchars($membre['poste']) ?></h4>
                  <p class="card-text">
                    <i class="bx bxs-quote-alt-left quote-icon-left text-primary"></i>
                    <?= htmlspecialchars($membre['description']) ?>
                    <i class="bx bxs-quote-alt-right quote-icon-right text-primary"></i>
                  </p>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
          <div class="swiper-pagination"></div>
          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
        </div>
      </div>
    </div>
  </div>
</section>
  </section><!-- End Section qui somme nous -->

  <!-- ======= Frequently Asked Questions Section ======= -->
  <section id="faq" class="faq section-bg">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2> Point sur les apprenants</h2>
        <p>
          <h4>Nombre, âge et compétences.</h4>
        </p>
      </div>
      <div class="accordion-list">
        <ul>
          <li data-aos="fade-up">
            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse"
              data-bs-target="#accordion-list-1">Nombre d'inscrits ? <i class="bx bx-chevron-down icon-show"></i><i
                class="bx bx-chevron-up icon-close"></i></a>
            <div id="accordion-list-1" class="collapse show" data-bs-parent=".accordion-list">
              <p>
                Le nombre de nouveaux inscrits augmente de manière exponentielle depuis 2017.
              </p>
            </div>
          </li>
          <li data-aos="fade-up" data-aos-delay="100">
            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#accordion-list-2"
              class="collapsed">Répartition par âge? <i class="bx bx-chevron-down icon-show"></i><i
                class="bx bx-chevron-up icon-close"></i></a>
            <div id="accordion-list-2" class="collapse" data-bs-parent=".accordion-list">
              <p>
                Les inscrits vont de 4 à 79 ans, avec une majorité dans la tranche d'âge de 26 à 64 ans.
              </p>
            </div>
          </li>
          <li data-aos="fade-up" data-aos-delay="200">
            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#accordion-list-3"
              class="collapsed">Répartition par genre ? <i class="bx bx-chevron-down icon-show"></i><i
                class="bx bx-chevron-up icon-close"></i></a>
            <div id="accordion-list-3" class="collapse" data-bs-parent=".accordion-list">
              <p>
                La proportion d'hommes inscrits est en augmentation, passant de 34,25 % en 2021 à 56,73 % en 2022.
              </p>
            </div>
          </li>
          <li data-aos="fade-up" data-aos-delay="300">
            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#accordion-list-4"
              class="collapsed">Niveau de compétences ? <i class="bx bx-chevron-down icon-show"></i><i
                class="bx bx-chevron-up icon-close"></i></a>
            <div id="accordion-list-4" class="collapse" data-bs-parent=".accordion-list">
              <p>
                - Certains nouveaux inscrits ne savent ni lire ni écrire.
                - Le nombre de diplômés, y compris des juristes, des étudiants en médecine, en droit et en économie,
                est en augmentation.
              </p>
            </div>
          </li>
          <li data-aos="fade-up" data-aos-delay="400">
            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#accordion-list-5"
              class="collapsed">Origine géographique? <i class="bx bx-chevron-down icon-show"></i><i
                class="bx bx-chevron-up icon-close"></i></a>
            <div id="accordion-list-5" class="collapse" data-bs-parent=".accordion-list">
              <p>
                Les inscrits sont majoritairement originaires d'Afrique, suivis par l'Asie. Seuls 2,12 % des inscrits
                sont français.
              </p>
            </div>
          </li>
          <li data-aos="fade-up" data-aos-delay="300">
            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#accordion-list-6"
              class="collapsed">Hébergement? <i class="bx bx-chevron-down icon-show"></i><i
                class="bx bx-chevron-up icon-close"></i></a>
            <div id="accordion-list-6" class="collapse" data-bs-parent=".accordion-list">
              <p>
                La plupart des inscrits résident dans des foyers, et près de la moitié (48,65 %) proviennent de
                quartiers prioritaires.
              </p>
            </div>
          </li>
          <p>
            <h4>Les Mineurs Non Accompagnés</h4>
          </p>
          <li data-aos="fade-up" data-aos-delay="400">
            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#accordion-list-7"
              class="collapsed">Nombre de MNA hébergés? <i class="bx bx-chevron-down icon-show"></i><i
                class="bx bx-chevron-up icon-close"></i></a>
            <div id="accordion-list-7" class="collapse" data-bs-parent=".accordion-list">
              <p>
                Les MNA sont hébergés par le Foyer De L’Enfance (FDE), l’Armée du Salut et dans une moindre mesure par
                le CHRS l’Espérance.
              </p>
            </div>
          </li>
          <li data-aos="fade-up" data-aos-delay="400">
            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#accordion-list-8"
              class="collapsed">Tendance des inscriptions? <i class="bx bx-chevron-down icon-show"></i><i
                class="bx bx-chevron-up icon-close"></i></a>
            <div id="accordion-list-8" class="collapse" data-bs-parent=".accordion-list">
              <p>
                Après une diminution en 2020, le nombre d'inscriptions des MNA a augmenté de façon significative,
                passant de 22 en 2020 à 40 en 2021, puis à 52 en 2022. En début 2023, il y a eu 5 nouvelles
                inscriptions.
              </p>
            </div>
          </li>
          <li data-aos="fade-up" data-aos-delay="400">
            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#accordion-list-9"
              class="collapsed">Mode d'hébergement? <i class="bx bx-chevron-down icon-show"></i><i
                class="bx bx-chevron-up icon-close"></i></a>
            <div id="accordion-list-9" class="collapse" data-bs-parent=".accordion-list">
              <p>
                Les MNA sont encore principalement hébergés à l'hôtel.
              </p>
            </div>
          </li>
          <li data-aos="fade-up" data-aos-delay="400">
            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#accordion-list-10"
              class="collapsed">Préparation à l'éducation? <i class="bx bx-chevron-down icon-show"></i><i
                class="bx bx-chevron-up icon-close"></i></a>
            <div id="accordion-list-10" class="collapse" data-bs-parent=".accordion-list">
              <p>
                Il est mentionné que les MNA peuvent être préparés à entrer en scolarité, ce qui indique une volonté
                de soutenir leur éducation et leur intégration.
              </p>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </section><!-- End Frequently Asked Questions Section -->

  <!-- ======= Contact Section ======= -->
  <section id="contact" class="contact">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Contact</h2>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <div class="row">
            <div class="col-lg-6 info">
              <i class="bx bx-map"></i>
              <h4>Adresse</h4>
              <p>3 Rue Louis Hanot,<br>Charleville-Mézières, 08000</p>
            </div>
            <div class="col-lg-6 info">
              <i class="bx bx-phone"></i>
              <h4>Numéro</h4>
              <p>06 29 31 82 29<br></p>
            </div>
            <div class="col-lg-6 info">
              <i class="bx bx-envelope"></i>
              <h4>Email </h4>
              <p>jspr08phone@gmail.com<br></p>
            </div>
            <div class="col-lg-6 info">
              <i class="bx bx-time-five"></i>
              <h4>Horaire</h4>
              <p>Lundi - Jeudi: 8:30 à 12:00<br>13:30 à 17:30<br>Vendredi: 8:30 à 12:00</p>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <form id="contact-form" action="" method="post" role="form" class="php-email-form" data-aos="fade-up">
            <div class="form-group">
              <input placeholder="Nom" type="text" name="nom" class="form-control" id="name" required>
            </div>
            <div class="mt-3 form-group">
              <input placeholder="Email" type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="mt-3 form-group">
              <input placeholder="Sujet" type="text" class="form-control" name="sujet" id="subject" required>
            </div>
            <div class="mt-3 form-group">
              <textarea placeholder="Message" class="form-control" name="message" rows="5" required></textarea>
            </div>
            <div class="my-3">
              <div id="loading-animation-contact" class="loading-animation">Chargement</div>
              <div id="error-message-contact" class="error-message" style="display: none;"></div>
              <div id="sent-message-contact" class="sent-message" style="display: none;"></div>
            </div>
            <div class="text-center"><button type="submit">Envoyer le message</button></div>
          </form>
        </div>
      </div>
    </div>
  </section><!-- End Contact Section -->
</main><!-- End #main -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!--  envoy le message par ajax et recuperer le reponse de traitement  -->
<script src="assets/js/ajax/contact.js">
</script>

<!-- Include the footer section of the website -->
<?php include './src/views/includes/newsletter.php'; ?>
<?php include './src/views/includes/footer.php'; ?>
<?php include 'src/views/includes/footer_links.php' ?>