<?php 
// Le reste de votre code...
use Controllers\PageController;
// creer le variable routeur
if (!isset($_GET['route']) || empty($_GET['route'])) {
    $maRoute = [];
} else {
    $maRoute = explode('/', $_GET['route']);
}
// Rediriger les itinéraires premier niveau
if (!isset($maRoute[0]) || $maRoute[0] == '') {
    $maRoute[0] = 'accueil'; // Par défaut, rediriger vers l'accueil
}

switch ($maRoute[0]) {
    case 'accueil':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {

            // Instancier le contrôleur
            $contactController = new Controllers\ContactController();
            // Appeler la méthode pour envoyer le message
            $contactController->envoyerMessage(); // Cette méthode renvoie déjà une réponse JSON

        }
        else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email_pour_ajouter_en_subscriber'])){
            $controller = new Controllers\SubscriberController();
            $controller->addSubscriber($_POST['email_pour_ajouter_en_subscriber']);
        } 
        else {
            $pageController = new PageController();
            $pageController->affichePageAccueil();
        }
        break;
        
    case 'shamm':
    	    if ( 1 == 2 ) {
                // !isset($_SESSION["user"]) || empty($_SESSION["user"])
                //  ) {

        		// On redirige vers la page de connexion admin si on n'est pas connecté
       			//  header("Location: /klaxon");

  		  } else {
        		
       		 // Sinon si on est connecté 
              if (!isset($maRoute[1]) || $maRoute[1] == '') {
                  // Par défaut, rediriger vers la page d'evenemment       
                  $eventsController = new Controllers\EventsController();
                  $eventsController->affichePageAdminEvenements();
          		}else {
              		// gerer routage URL Admin
                  
                      switch ($maRoute[1]) {


                          case 'evenements':  
                              $eventsController = new Controllers\EventsController();
                              $eventsController->affichePageAdminEvenements(); 
                              break;  

                          case 'statistiques':
                              $pageController = new PageController();  // Utilisation de PageController
                              $pageController->affichePageStatistiqueVisiteurs();
                              break;  

                          case 'journal':
                              $journalController = new Controllers\JournalController();
                              $journalController->affichePageAdminJournal();
                              break; 
                          case 'abonnes':
                              if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email_pour_ajouter_en_subscriber'])){
                                  $controller = new Controllers\SubscriberController();
                                  $controller->addSubscriber($_POST['email_pour_ajouter_en_subscriber']);
                              } else {
                                  $subscriberController = new Controllers\SubscriberController();
                                  $subscriberController->affichePageAdminSubscribers();
                              }

                              break; 
                          case 'equipe':
                              $equipeController = new Controllers\EquipeController();
                              $equipeController->affichePageAdminEquipe();
                              break; 
                          case 'envoy_newsletter':

                              // Initialisation du contrôleur de la newsletter
                              $newsletterController = new Controllers\NewsletterController();

                              // Vérification si le formulaire d'envoi de newsletter a été soumis
                              if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_newsletter'])) {
                                  $subject = trim($_POST['subject']);
                                  $content = trim($_POST['content']);

                                  // Envoi de la newsletter à tous les abonnés
                                  $newsletterController->sendNewsletter($subject, $content);

                                  // Recharge la page après l'envoi
                                  echo '<script>window.location.href = window.location.href;</script>';
                                  exit();
                              }
                              // Inclusion de la vue d'envoi de newsletter
                              $newsletterController->affichePageAdminSendNewsletter();
                              break;  
                              case 'manage-admins':
                                  // Gestion des administrateurs
                                  $adminController = new \Controllers\AdminController();
                                  $adminController->manageAdmins();
                                  break;
                              case 'create-admin':
                                  // Création d'un administrateur
                                  $adminController = new \Controllers\AdminController();
                                  $adminController->createAdmin();
                                  break;
                              case 'update-admin':
                                  // Mise à jour d'un administrateur
                                  $adminController = new \Controllers\AdminController();
                                  $adminController->updateAdmin($_POST['id']);
                                  break;
                              case 'delete-admin':
                                  // Suppression d'un administrateur
                                  $adminController = new \Controllers\AdminController();
                                  $adminController->deleteAdmin($maRoute[2]); 
                                  break;
                          default:
                              $pageController = new PageController();
                              $pageController->affichePage404();
                              break;  
                      }
                  
              
              }

  		  }
    
    
    
        
        break;
    case 'evenements':
         if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email_pour_ajouter_en_subscriber'])){
            $controller = new Controllers\SubscriberController();
            $controller->addSubscriber($_POST['email_pour_ajouter_en_subscriber']);
        } 
        else {
            $pageController = new PageController();
            $pageController->affichePageEenements();
        }
        break;
    case 'journal':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email_pour_ajouter_en_subscriber'])){
            $controller = new Controllers\SubscriberController();
            $controller->addSubscriber($_POST['email_pour_ajouter_en_subscriber']);
        } 
        else {
            $pageController = new PageController();
            $pageController->affichePageJournal();
        }
        break;
    case 'unsubscribe':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email_pour_ajouter_en_subscriber'])){
            $controller = new Controllers\SubscriberController();
            $controller->addSubscriber($_POST['email_pour_ajouter_en_subscriber']);
        } 
        else {
        $pageController = new PageController();
        $pageController->affichePageUnsubscribe();
        }
        break;

    case 'klaxon':

        $authController = new \Controllers\AuthController();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $authController->login();
        } else {
            $authController->afficheLoginPage();
        }
        break;


        case 'deconnexion':
            $authController = new \Controllers\AuthController();
            $authController->logout();
            break;
        
            
    default:
        $pageController = new PageController();
        $pageController->affichePage404();
        break;
}


