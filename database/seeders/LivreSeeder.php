<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Livre;

class LivreSeeder extends Seeder
{
    public function run(): void
    {

        $livres = [

            [
                'titre' => 'Clean Code',
                'auteur' => 'Robert C. Martin',
                'categorie' => 'Informatique',
                'description' => 'Guide de référence pour écrire du code propre et maintenable.',
                'couverture' => null
            ],

            [
                'titre' => 'Design Patterns',
                'auteur' => 'Erich Gamma',
                'categorie' => 'Informatique',
                'description' => 'Les modèles de conception essentiels pour le développement logiciel.',
                'couverture' => null
            ],

            [
                'titre' => 'The Pragmatic Programmer',
                'auteur' => 'Andrew Hunt',
                'categorie' => 'Informatique',
                'description' => 'Les bonnes pratiques pour devenir un développeur professionnel.',
                'couverture' => null
            ],

            [
                'titre' => 'Le Petit Prince',
                'auteur' => 'Antoine de Saint-Exupéry',
                'categorie' => 'Roman',
                'description' => 'Un classique de la littérature française.',
                'couverture' => null
            ],

            [
                'titre' => '1984',
                'auteur' => 'George Orwell',
                'categorie' => 'Roman',
                'description' => 'Un roman dystopique sur une société sous surveillance.',
                'couverture' => null
            ],

            [
                'titre' => 'Sapiens',
                'auteur' => 'Yuval Noah Harari',
                'categorie' => 'Histoire',
                'description' => 'Une brève histoire de l’humanité.',
                'couverture' => null
            ],

            [
                'titre' => 'L\'Art de la guerre',
                'auteur' => 'Sun Tzu',
                'categorie' => 'Histoire',
                'description' => 'Traité stratégique militaire antique.',
                'couverture' => null
            ],

            [
                'titre' => 'Harry Potter à l\'école des sorciers',
                'auteur' => 'J.K. Rowling',
                'categorie' => 'Fantastique',
                'description' => 'Premier tome de la saga Harry Potter.',
                'couverture' => null
            ],

            [
                'titre' => 'Les Misérables',
                'auteur' => 'Victor Hugo',
                'categorie' => 'Roman',
                'description' => 'Chef-d\'œuvre de la littérature française.',
                'couverture' => null
            ],

            [
                'titre' => 'Introduction à Laravel',
                'auteur' => 'Taylor Otwell',
                'categorie' => 'Informatique',
                'description' => 'Découverte du framework Laravel.',
                'couverture' => null
            ],

            [
                'titre' => 'Tu nous appartiens',
                'auteur' => 'J.P. Delaney',
                'categorie' => 'Thriller',
                'description' => 'Un thriller psychologique sur un échange d’enfants à la naissance.',
                'couverture' => null
            ],

            [
                'titre' => 'Les sciences informatiques',
                'auteur' => 'Collectif',
                'categorie' => 'Informatique',
                'description' => 'Introduction aux bases de l’informatique moderne.',
                'couverture' => null
            ],

            [
                'titre' => 'Devenir un expert en informatique',
                'auteur' => 'Collectif',
                'categorie' => 'Informatique',
                'description' => 'Guide pour approfondir les compétences informatiques.',
                'couverture' => null
            ],

            [
                'titre' => 'Débuter en informatique pour les nuls',
                'auteur' => 'Dan Gookin',
                'categorie' => 'Informatique',
                'description' => 'Livre pédagogique pour apprendre l’informatique.',
                'couverture' => null
            ],

            [
                'titre' => 'Tout sur les réseaux et Internet',
                'auteur' => 'Dunod',
                'categorie' => 'Réseaux',
                'description' => 'Comprendre le fonctionnement des réseaux informatiques.',
                'couverture' => null
            ],

            [
                'titre' => 'L\'ordinateur pas à pas pour les nuls',
                'auteur' => 'Dan Gookin',
                'categorie' => 'Informatique',
                'description' => 'Apprendre à utiliser un ordinateur simplement.',
                'couverture' => null
            ],

            [
                'titre' => 'Machine Learning et IA avec Python',
                'auteur' => 'ENI',
                'categorie' => 'Intelligence Artificielle',
                'description' => 'Découverte du machine learning avec Python.',
                'couverture' => null
            ],

            [
                'titre' => 'L\'intelligence artificielle expliquée',
                'auteur' => 'ENI',
                'categorie' => 'Intelligence Artificielle',
                'description' => 'Introduction aux concepts fondamentaux de l’IA.',
                'couverture' => null
            ],

            [
                'titre' => 'Réseaux informatiques',
                'auteur' => 'ENI',
                'categorie' => 'Réseaux',
                'description' => 'Guide complet sur les réseaux informatiques.',
                'couverture' => null
            ],

        ];

        foreach ($livres as $livre) {
            Livre::create($livre);
        }
    }
}