📌 1. Structure de la documentation
Voici la structure idéale pour documenter ton projet :
📁 Documentation
   ├── 📝 1. Introduction.md
   ├── 🛠 2. Installation.md
   ├── 🏗 3. Architecture.md
   ├── 📄 4. Fonctionnalités.md
   ├── 🔍 5. Améliorations.md
   ├── 📊 6. Statistiques.md
   ├── 🛠 7. Déploiement.md
   ├── 🏗 8. API.md (si tu as une API)
   ├── 👤 9. Gestion des utilisateurs.md
   ├── 💡 10. Notes techniques.md

📝 1. Introduction
📌 Objectif : Présenter ton projet et son but.
# 📌 Introduction

## 🏗️ Nom du projet : jspr
## 🎯 Objectif :
Ce projet est un site web dynamique pour [Association J'SPR 08], permettant de gérer :
- 📩 Un système d'abonnement à la newsletter
- 📅 Un agenda des événements
- 📰 Un journal des activités
- 📊 Un système de statistiques des visiteurs pour l'admin
- ✉️ Un système d'envoi d'e-mails avec PHPMailer

## 🛠 Technologies utilisées :
- **Backend :** PHP (PDO, PHPMailer)
- **Frontend :** HTML, CSS, Bootstrap, JavaScript
- **Base de données :** MySQL (phpMyAdmin)


🛠 2. Installation
📌 Comment installer et configurer ton projet
# 🛠 Installation du projet

## 1️⃣ Prérequis
- PHP 8+
- MySQL et phpMyAdmin
- Composer installé

## 2️⃣ Cloner le projet
```bash
git clone https://github.com/ton-repo/nom-du-projet.git
cd nom-du-projet

3️⃣ Installer les dépendances
composer install
vlucas/phpdotenv
phpmailer/phpmailer

4️⃣ Configurer la base de données
Créer une base de données dans phpMyAdmin.
Importer le fichier bdd/jspr bdd.sql dans phpMyAdmin.
Créer une fichier .env à la base projet
# Variables de bases de données
DB_HOST=
DB_PORT=
DB_NAME=
DB_USER=
DB_PASSWD=


# Variables de mail
MAIL_DESTINATEUR = 
MAIL_EXPEDITATEUR  = 
NOM_EXPEDITATEUR = 
MDP_APP = 
Modifier le src/views/includes/header.php le ligne dessous dans jusqu’a la racine de votre projet
<base href="http://localhost/projets/jspr/">


5️⃣ Lancer le serveur local
php -S localhost:8000


---

🏗 3. Architecture du Projet
📌 **Comment le projet est organisé**  

```md
# 🏗 Architecture du projet

📁 `assets/` → Contient les fichiers CSS, JS et images.  
📁 `Bdd/` → (Dossier potentiellement pour la base de données ?)  
📁 `forms/` → (Dossier pour les formulaires ?)  
📁 `src/` → Contient le code source principal  
   📂 `controllers/` → Gère la logique des fonctionnalités  
   📂 `models/` → Contient les modèles pour interagir avec la base de données  
   📂 `templates/` → (Utilisé pour stocker les templates)  
   📂 `views/` → Contient les fichiers affichés  
      📂 `admin/` → Vue d'administration  
      📂 `includes/` → Contient des fichiers réutilisables comme `header.php` et `footer.html`  
📁 `uploads/` → Stocke les fichiers téléchargés  
📁 `vendor/` → Dépendances gérées par Composer  

📄 `.gitignore` → Fichiers à ignorer dans Git  
📄 `.htaccess` → Configuration des URLs  
📄 `composer.json` → Gestion des dépendances PHP  
📄 `index.php` → Point d’entrée du site  
📄 `routeur.php` → Gère le routage des pages  

## 🏗 Explication du routage  
- **URL:** `mon-site.com/accueil` → Charge `views/accueil.php`  
- **URL:** `mon-site.com/evenements` → Charge `views/evenements.php`  
- **URL:** `mon-site.com/journal` → Charge `views/journal.php`  
- **URL:** `mon-site.com/shamm` → Affiche le back-office  



📄 4. Fonctionnalités
📌 Détails sur ce que ton site peut faire
✅ Gestion de la Newsletter
📩 Inscription à la newsletter
🔗 Envoi d'un email de confirmation avec PHPMailer
❌ Désinscription possible via un lien unique
📢 Envoi de newsletters aux abonnés
📊 Statistiques des visiteurs
🔹 Comptage des visiteurs uniques
📆 Affichage des statistiques par jour, semaine, mois et année
📈 Visualisation des données avec un graphique interactif (Chart.js)
📅 Agenda des événements
📝 Ajout, modification et suppression d'événements
📩 Notification aux abonnés lorsqu'un nouvel événement est créé
📅 Intégration d'un calendrier dynamique avec FullCalendar.js
⚽ Gestion des équipes
👥 Création, modification et suppression des équipes
📜 Affichage des membres des équipes
🔐 Gestion des administrateurs
🏅 Rôle Master Admin pour gérer les autres administrateurs
👤 Ajout, modification et suppression d'administrateurs
🔐 Sécurisation de l’accès au back-office
📬 Gestion des abonnés
👥 Ajout et suppression d’abonnés
📩 Envoi de newsletters aux abonnés

🔍 5. Améliorations réalisées
📌 Les évolutions et optimisations du projet
# 🔍 Améliorations du projet

### 🏆 Sécurité et robustesse :
✅ **Validation et protection des entrées utilisateur**
✅ **Vérification des IPs pour éviter les spams**
✅ **Protection contre les injections SQL et XSS**

### 📊 Performance :
✅ **Optimisation des requêtes SQL avec des index**
✅ **Ajout d’un cache pour éviter les rechargements inutiles**
✅ **Amélioration du système de pagination des articles du journal**

### 🎨 Design :
✅ **Utilisation de Bootstrap pour une meilleure UI**
✅ **Amélioration de l’affichage mobile**
✅ **Ajout d’un bouton "Voir plus" pour les articles longs**

📊 6. Statistiques et Graphiques
📌 Comment fonctionne le système de suivi des visiteurs
# 📊 Statistiques des visiteurs

### 🏗 Comment ça marche ?
1️⃣ Lorsqu'un visiteur arrive, son **IP et user agent** sont enregistrés.  
2️⃣ Une protection empêche d’enregistrer la même IP plusieurs fois en **10 minutes**.  
3️⃣ Un système d'affichage dynamique permet de voir **les visiteurs par jour, semaine, mois, année**.

### 📈 Affichage des statistiques :
- Utilisation de **Chart.js** pour un graphique dynamique.
- Sélecteur pour changer la période d’affichage (jour, semaine, mois, année).

---

## **🛠 7. Déploiement sur IONOS**
📌 **Comment mettre ton site en ligne sur IONOS**  

```md
# 🛠 Déploiement sur IONOS

### 1️⃣ Transfert des fichiers via FTP
- Se connecter à **IONOS FTP** avec FileZilla
- Envoyer les fichiers dans `/htdocs`

### 2️⃣ Configuration de la base de données
- Aller dans **phpMyAdmin IONOS**
- Importer le fichier `database.sql`
- Modifier `config.php` avec les nouveaux identifiants

### 3️⃣ Vérification et test
- Accéder à `mon-site.com`
- Vérifier que tout fonctionne (BDD, emails, stats)
