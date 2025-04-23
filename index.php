 <?php
require 'vendor/autoload.php';
require 'init.php';
 
 // Votre routing...
// require __DIR__.'/init.php';
//  ini_set('display_errors', 1);
//  ini_set('display_startup_errors', 1);
//  error_reporting(E_ALL);

 // Include the Composer autoloader to use installed libraries
   //  require_once "./vendor/autoload.php";

 // Initialize the Dotenv library to load environment variables
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

 // Include the visitor counter logic to track unique visitors
 use Controllers\VisiteurController;
 $visiteurController = new VisiteurController();
 $visiteurController->ComptVisiteur(); // Appelez la méthode pour compter les visiteurs



// $_SESSION['user'] = 'sehr';

  // Include the routing logic to handle requests
    include "./routeur.php" ;