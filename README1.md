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
👨‍💻 Auteur

Pierre-Jordan Tchokote
BTS SIO SLAM – 2026

🎓 Projet académique

Ce projet a été réalisé dans le cadre de l’épreuve E6 – Conception et développement d’applications.