<?php
namespace Controllers;
class PageController {
    // methode pour afficher page login 
    public function affichePage404() {
        include_once 'src/views/error.php';
        }
    
    public function affichePageAccueil() {

        // Récupérer les bénévoles et les salariés depuis le contrôleur
        $controller = new EquipeController();
        $benevoles = $controller->getBenevoles();
        $salaries = $controller->getSalaries();

        // Inclure la vue d'accueil et passer les membres
        include_once 'src/views/public/accueil.php';
        
        }
    
    public function affichePageEenements() {
        include_once 'src/views/public/evenements.php';
        }
    public function affichePageJournal() {
        include_once 'src/views/public/journal.php';
        }
    public function affichePageUnsubscribe() {
        include_once 'src/views/public/unsubscribe.php';
        }

    public function affichePageStatistiqueVisiteurs() {
        include_once 'src/views/admin/statistiques.php';
        }
}