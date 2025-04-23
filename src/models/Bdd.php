<?php

    // Ce modèle parent sert à faire en sorte que tous les modèles qui en découlent héritent
    // de la connexion à la BDD, déjà effectuée dans le constructeur du modèle parent.

    namespace Models;

    class Bdd {

        protected $pdo;

        public function __construct() {
            
            $dbhost = $_ENV["DB_HOST"];
            $dbport = $_ENV["DB_PORT"];
            $dbname = $_ENV["DB_NAME"];
            $dbuser = $_ENV["DB_USER"];
            $dbpassword = $_ENV["DB_PASSWD"];
        
            try {
        
                // Connexion à la base de données avec PDO
                $dsn = "mysql:host=$dbhost;port=$dbport;dbname=$dbname";
                $this->pdo = new \PDO($dsn, $dbuser, $dbpassword);
        
                // Configuration des attributs PDO
                $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        
            } catch (\PDOException $e) {
                die("Erreur de connexion ou de requête : " . $e->getMessage());
            }

        }

    }
