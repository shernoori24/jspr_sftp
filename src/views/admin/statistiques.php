<?php
// Vérification de la session utilisateur
if (!isset($_SESSION['user'])) {
    echo "<script>window.location.href = '../klaxon'</script>";
    exit; 
}

// Récupération des données statistiques
$visiteur = new \Models\Visiteur();
$periode = $_GET['periode'] ?? 'jour';
$stats = $visiteur->getVisiteursParPeriode($periode);

// Préparation des données pour le graphique
$dates = [];
$counts = [];

foreach ($stats as $row) {
    $dates[] = ($periode === 'semaine') 
        ? "Année " . $row['annee'] . ", Semaine " . $row['semaine']
        : $row['date'];
    $counts[] = $row['nombre'];
}

include './src/views/includes/header_backoffice.php'; 
?>

<section>
    <div class="d-flex">
        <!-- Sidebar fixe -->
        <?php include_once 'src/views/includes/sidebar_backoffice.php'; ?>
        
        <!-- Contenu principal avec marge -->
        <div class="flex-fill p-4" style="margin-left: 250px; min-height: 100vh;">
            <div class="container my-5" data-aos="fade-down">
                <h2>Statistiques des Visiteurs</h2>
                
                <!-- Formulaire de sélection de période -->
                <form method="GET" class="mb-4">
                    <div class="row g-2 align-items-center">
                        <div class="col-auto">
                            <label for="periode" class="col-form-label">Période :</label>
                        </div>
                        <div class="col-auto">
                            <select name="periode" id="periode" class="form-select" onchange="this.form.submit()">
                                <option value="jour" <?= $periode === 'jour' ? 'selected' : '' ?>>Journalier</option>
                                <option value="semaine" <?= $periode === 'semaine' ? 'selected' : '' ?>>Hebdomadaire</option>
                                <option value="mois" <?= $periode === 'mois' ? 'selected' : '' ?>>Mensuel</option>
                                <option value="annee" <?= $periode === 'annee' ? 'selected' : '' ?>>Annuel</option>
                            </select>
                        </div>
                    </div>
                </form>
                
                <!-- Graphique -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div style="height: 450px;">
                            <canvas id="visiteursChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'src/views/includes/footer_links.php' ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('visiteursChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($dates) ?>,
            datasets: [{
                label: 'Nombre de visiteurs',
                data: <?= json_encode($counts) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' visiteur(s)';
                        }
                    }
                },
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    },
                    title: {
                        display: true,
                        text: 'Nombre de visiteurs'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Période'
                    }
                }
            }
        }
    });
});
</script>