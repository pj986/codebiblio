# 📚 BiblioTEK

Application web de gestion de bibliothèque développée avec **Laravel** dans le cadre du BTS SIO SLAM.

---

## 🚀 Présentation

BiblioTEK est une application client léger permettant :

- 📖 d’emprunter des livres
- 🔁 de retourner des livres
- ❤️ de gérer ses favoris
- 📊 d’administrer une bibliothèque via un back-office

---

## 🎯 Objectifs du projet

- Développer une application full-stack avec Laravel
- Mettre en place un système métier réel (emprunt / retour)
- Concevoir un back-office administrateur
- Assurer la cohérence des données
- Implémenter des tests unitaires

---

## 🛠️ Stack technique

| Technologie | Usage |
|------------|------|
| PHP 8 | Backend |
| Laravel | Framework MVC |
| MySQL | Base de données |
| Blade | Frontend |
| JavaScript / Fetch | Interactions AJAX |
| Chart.js | Statistiques |
| PHPUnit | Tests |
| GitHub | Versionning |

---

## ⚙️ Installation

```bash
git clone https://github.com/ton-repo/bibliotek.git
cd bibliotek
composer install
cp .env.example .env
php artisan key:generate

Configurer la base de données dans .env :

DB_DATABASE=bibliotek
DB_USERNAME=root
DB_PASSWORD=

Puis :

php artisan migrate
php artisan serve

👉 Accès : http://127.0.0.1:8000

👤 Fonctionnalités utilisateur
Consultation du catalogue 📚
Recherche dynamique 🔎
Emprunt de livres 📖
Retour de livres 🔁
Gestion des favoris ❤️
Notifications (toast UI)
🛠️ Fonctionnalités administrateur
Dashboard avec statistiques 📊
Gestion des livres (CRUD)
Upload d’images
Gestion des utilisateurs
Suivi des emprunts
Détection des retards ⚠️
QR Code emprunt
🧱 Modélisation
📚 Livre
id
titre
auteur
categorie
couverture
📦 Exemplaire
id
livre_id
disponible
📖 Emprunt
id
user_id
exemplaire_id
date_emprunt
date_retour_prevue
date_retour
❤️ Favori
user_id
livre_id
🔐 Sécurité
Authentification Laravel
Middleware admin
Protection CSRF
Validation des données
🧪 Tests

Tests réalisés avec PHPUnit :

php artisan test

Tests couverts :

📚 Catalogue
🔎 Recherche
📖 Emprunt
🔁 Retour
❤️ Favoris
📊 Dashboard

Statistiques disponibles :

Nombre d’utilisateurs
Nombre de livres
Nombre d’emprunts
Livres en retard
Répartition par catégorie
Top livres
⚠️ Contraintes rencontrées
Gestion des relations (livre → exemplaire → emprunt)
Synchronisation des états (disponible / emprunté)
Gestion des images
Mise en place des tests unitaires
Gestion des routes Laravel
📈 Améliorations possibles
Notifications email 📧
Upload drag & drop
API REST
Application mobile
Optimisation performances

🚀 Mise en production de l'application
🎯 Objectif

L'objectif était de déployer l'application Laravel BiblioTEK dans un environnement de production réaliste, en utilisant une infrastructure moderne basée sur Docker et AWS.

☁️ 1. Mise en place du serveur AWS
Création d'une instance EC2 (Ubuntu)
Connexion au serveur via SSH
Mise à jour du système :
sudo apt update && sudo apt upgrade -y
📁 2. Déploiement du projet
Transfert du projet depuis l’environnement local (WAMP) vers le serveur AWS :
scp -i key.pem -r bibliotek ubuntu@IP:/var/www/
Positionnement du projet :
cd /var/www/bibliotek
🐳 3. Containerisation avec Docker
Installation de Docker :
sudo apt install docker.io docker-compose -y
Architecture mise en place :
Nginx → serveur web
PHP-FPM → exécution Laravel
MySQL → base de données
phpMyAdmin → administration BDD
⚙️ 4. Configuration Docker

Création des fichiers suivants :

📄 Dockerfile

Permet de configurer l’environnement PHP avec les extensions nécessaires.

📄 docker-compose.yml

Définition des services :

app (Laravel)
nginx
mysql
phpmyadmin
🌐 Configuration Nginx

Création du fichier :

docker/nginx/default.conf

Configuration :

root : /var/www/public
gestion des routes Laravel
liaison avec PHP-FPM
🛠️ 5. Configuration de Laravel

Modification du fichier .env :

DB_CONNECTION=mysql
DB_HOST=mysql-laravel
DB_PORT=3306
DB_DATABASE=bibliotek
DB_USERNAME=bibliotek
DB_PASSWORD=******
🚀 6. Lancement de l’application
sudo docker-compose up -d --build
⚠️ 7. Résolution de problèmes
🔥 Conflit de port 80

Erreur rencontrée :

bind: address already in use

Solution :

sudo systemctl stop nginx
sudo systemctl disable nginx
🔌 Déconnexion SSH fréquente

Erreur :

client_loop: send disconnect

Solution :

ssh -i key.pem ubuntu@IP -o ServerAliveInterval=60
🧪 8. Vérifications
Vérification des containers :
sudo docker ps
Accès à l'application :
http://IP-AWS
Accès à phpMyAdmin :
http://IP-AWS:8080

💎 🔐 Accès à l’application en ligne
🌐 Accès public

L’application est accessible à l’adresse suivante :

http://35.180.134.223

👤 Comptes de test

Afin de faciliter l’évaluation par le jury, plusieurs comptes de test ont été créés :

🔹 Compte utilisateur
Email : user@test.com
Mot de passe : Test123!

👉 Accès :

Consultation du catalogue
Emprunt de livres
Gestion des emprunts
🔹 Compte administrateur
Email : admin@test.com
Mot de passe : Admin123!

👉 Accès :

Back-office admin
Gestion des livres (CRUD)
Visualisation des statistiques
Dashboard administrateur


👨‍💻 Auteur

Pierre-Jordan Tchokote
BTS SIO SLAM – 2026

🎓 Projet académique

Ce projet a été réalisé dans le cadre de l’épreuve E6 – Conception et développement d’applications.