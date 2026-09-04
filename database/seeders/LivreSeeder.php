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
                'couverture' => 'clean-code.png',
            ],

            [
                'titre' => 'Design Patterns',
                'auteur' => 'Erich Gamma',
                'categorie' => 'Informatique',
                'description' => 'Les modèles de conception essentiels pour le développement logiciel.',
                'couverture' => 'design-pattern.png',
            ],

            [
                'titre' => 'The Pragmatic Programmer',
                'auteur' => 'Andrew Hunt',
                'categorie' => 'Informatique',
                'description' => 'Les bonnes pratiques pour devenir un développeur professionnel.',
                'couverture' => 'thepragmaticprogrammer.png',
            ],

            [
                'titre' => 'Le Petit Prince',
                'auteur' => 'Antoine de Saint-Exupéry',
                'categorie' => 'Roman',
                'description' => 'Un classique de la littérature française.',
                'couverture' => 'petit-prince-livre.png',
            ],

            [
                'titre' => '1984',
                'auteur' => 'George Orwell',
                'categorie' => 'Roman',
                'description' => 'Un roman dystopique sur une société sous surveillance.',
                'couverture' => '1984.png'
            ],

            [
                'titre' => 'Sapiens',
                'auteur' => 'Yuval Noah Harari',
                'categorie' => 'Histoire',
                'description' => 'Une brève histoire de l’humanité.',
                'couverture' => 'sapienslivre.png',
            ],

            [
                'titre' => 'L\'Art de la guerre',
                'auteur' => 'Sun Tzu',
                'categorie' => 'Histoire',
                'description' => 'Traité stratégique militaire antique.',
                'couverture' => 'lartdeguerre.png',
            ],

            [
                'titre' => 'Harry Potter à l\'école des sorciers',
                'auteur' => 'J.K. Rowling',
                'categorie' => 'Fantastique',
                'description' => 'Premier tome de la saga Harry Potter.',
                'couverture' => 'harrypotterlivre.png',
            ],

            [
                'titre' => 'Les Misérables',
                'auteur' => 'Victor Hugo',
                'categorie' => 'Roman',
                'description' => 'Chef-d\'œuvre de la littérature française.',
                'couverture' => 'lesmisérablesvictorhugolivre.png',
            ],

            [
                'titre' => 'Introduction à Laravel',
                'auteur' => 'Taylor Otwell',
                'categorie' => 'Informatique',
                'description' => 'Découverte du framework Laravel.',
                'couverture' => 'laravel-book.jpg',
            ],

            [
                'titre' => 'Tu nous appartiens',
                'auteur' => 'J.P. Delaney',
                'categorie' => 'Thriller',
                'description' => 'Un thriller psychologique sur un échange d’enfants à la naissance.',
                'couverture' => 'tunous.jpg',
            ],

            [
                'titre' => 'Les sciences informatiques',
                'auteur' => 'Calen Kelmore',
                'categorie' => 'Informatique',
                'description' => 'Introduction aux bases de l’informatique moderne.',
                'couverture' => 'science-info.jpg',
            ],

            [
                'titre' => 'Devenir un expert en informatique',
                'auteur' => 'Collectif',
                'categorie' => 'Informatique',
                'description' => 'Guide pour approfondir les compétences informatiques.',
                'couverture' => 'experteninfo.jpg',
            ],

            [
                'titre' => 'Débuter en informatique pour les nuls',
                'auteur' => 'Dan Gookin',
                'categorie' => 'Informatique',
                'description' => 'Livre pédagogique pour apprendre l’informatique.',
                'couverture' => 'débutereninformatiquepourlesnuls.jpg',
            ],
            [
                'titre' => 'Tout sur les réseaux et Internet',
                'auteur' => 'Fabrice Lemainique',
                'categorie' => 'Réseaux',
                'description' => 'Introduction aux réseaux informatiques et à Internet.',
                'couverture' => 'toutsurlesréseauxetinternet.jpg',
            ],

            

            [
                'titre' => 'L\'ordinateur pas à pas pour les nuls',
                'auteur' => 'Philip Escartin',
                'categorie' => 'Informatique',
                'description' => 'Apprendre à utiliser un ordinateur simplement.',
                'couverture' => 'ordinateur.jpg',
            ],

            [
                'titre' => 'Machine Learning et IA avec Python',
                'auteur' => 'Madjid Khichane',
                'categorie' => 'Intelligence Artificielle',
                'description' => 'Découverte du machine learning avec Python.',
                'couverture' => 'machinelearningetiaavecpython.jpg'
            ],

            [
                'titre' => 'L\'intelligence artificielle expliquée',
                'auteur' => 'David Bernet',
                'categorie' => 'Intelligence Artificielle',
                'description' => 'Introduction aux concepts fondamentaux de l’IA.',
                'couverture' => 'intelligenceartificielleexpliquée.jpg'
            ],

            [
                'titre' => 'Réseaux informatiques',
                'auteur' => 'José Dordoigne',
                'categorie' => 'Réseaux',
                'description' => 'Guide complet sur les réseaux informatiques.',
                'couverture' => 'réseauxinformatiques.jpg'
            ],

        ];

        foreach ($livres as $livre) {
            Livre::create($livre);
        }
    }
}