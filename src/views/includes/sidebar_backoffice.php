<!-- Sidebar (Barre latérale) -->
<nav id="sidebar-admin" class="p-3 mt-4 text-white bg-dark min-vh-100 position-fixed"
        style="min-width: 250px; max-width: 270px;">
        <br>
        <!-- Titre du tableau de bord avec le nom de l'utilisateur connecté -->
        

        <!-- Liste des liens du menu de navigation -->
        <ul class="list-unstyled">
                <li><a href="shamm/statistiques" class="px-3 py-2 d-block text-white-50 hover:bg-dark"
                                data-section="stats"><i class='bx bxs-bar-chart-square'></i> Statistiques</a></li>
                <hr>
                <li><a href="shamm/evenements" class="px-3 py-2 d-block text-white-50 hover:bg-dark"
                                data-section="stats"><i class='bx bxs-calendar-event'></i> Événements</a></li>

                <li><a href="shamm/journal" class="px-3 py-2 d-block text-white-50 hover:bg-dark"
                                data-section="commandes"><i class='bx bxs-news'></i> Journal</a></li>
                <li><a href="shamm/envoy_newsletter" class="px-3 py-2 d-block text-white-50 hover:bg-dark"
                                data-section="commandes"><i class='bx bxs-envelope'></i> Envoyer une Newsletter</a></li>
                <hr>
                <li><a href="shamm/abonnes" class="px-3 py-2 d-block text-white-50 hover:bg-dark"
                                data-section="commandes"><i class='bx bxs-add-to-queue'></i> Abonnés</a></li>
                <li><a href="shamm/equipe" class="px-3 py-2 d-block text-white-50 hover:bg-dark"
                                data-section="articles"><i class='bx bxs-group'></i> Équipe</a></li>

                <!-- Vérification si l'utilisateur est un administrateur principal (master admin) -->
                <?php
                if (!isset($_SESSION['user']) || $_SESSION['user']['role'] === 'master_admin') {
                    ?> <li><a href="shamm/manage-admins" class="px-3 py-2 d-block text-white-50 hover:bg-dark"
                                data-section="commandes"><i class='bx bxs-user-detail'></i> Manager Admins</a></li>
                <?php }?>
               
        </ul>
</nav>