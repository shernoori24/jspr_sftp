<?php
namespace Controllers;

use Models\Visiteur;

class VisiteurController{
    public function ComptVisiteur(){
        
        $visiteur = new Visiteur(); // Create a new instance of the Visiteur class

        if (!isset($_SESSION['visited'])) { // Check if the user has already visited the site in the current session

            $_SESSION['visited'] = true;

            // 🔍 Detect the real IP address
            if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]; // Take the first IP from the forwarded list
            } elseif (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
                $ip = $_SERVER['HTTP_CF_CONNECTING_IP']; // For Cloudflare
            } else {
                $ip = $_SERVER['REMOTE_ADDR']; // Standard method to get the user's IP address
            }
            $ip = trim($ip); // Clean up the IP address by removing whitespace

            // 🔍 Detect the User Agent
            $user_agent = trim($_SERVER['HTTP_USER_AGENT'] ?? 'Inconnu');
            $user_agent = htmlspecialchars($user_agent, ENT_QUOTES, 'UTF-8'); // Sanitize user agent to prevent XSS attacks

            // 🔍 Validate the data
            if (filter_var($ip, FILTER_VALIDATE_IP) && !empty($user_agent)) {
                error_log("✅ Conditions met: IP = $ip, User Agent = $user_agent"); // Log successful validation

                try {
                    // 💾 Add the visitor to the database
                    $visiteur->addVisiteur($ip, $user_agent);
                } catch (\Exception $e) {
                    error_log("❌ SQL error when adding the visitor: " . $e->getMessage());
                }
            } else {
                error_log("⚠️ Invalid IP or User Agent: IP = $ip, User Agent = $user_agent");
            }
        }
    }
}

