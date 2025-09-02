<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        // Informations sur la chorale MRDA
        $choirInfo = [
            'name' => 'Chorale MRDA',
            'founded' => '2015',
            'director' => 'Maître Jean-Baptiste Martin',
            'members_count' => 45,
            'description' => 'La Chorale MRDA est un ensemble vocal passionné dédié à la musique sacrée et classique. Fondée en 2015, elle rassemble des chanteurs de tous horizons unis par l\'amour de la musique religieuse.',
            'mission' => 'Notre mission est de partager la beauté de la musique sacrée et d\'enrichir la vie spirituelle de notre communauté à travers des concerts et des célébrations liturgiques.'
        ];

        // Membres actuels de la chorale (vous pouvez les modifier selon vos besoins)
        $members = [
            [
                'name' => 'Jean-Baptiste Martin',
                'role' => 'Chef de Chœur',
                'voice' => 'Direction',
                'years' => 10,
                'bio' => 'Diplômé du Conservatoire, Jean-Baptiste dirige la chorale avec passion depuis sa création.'
            ],
            [
                'name' => 'Marie Dubois',
                'role' => 'Soprano Solo',
                'voice' => 'Soprano',
                'years' => 8,
                'bio' => 'Soliste reconnue, Marie apporte sa voix cristalline aux œuvres les plus exigeantes.'
            ],
            [
                'name' => 'Pierre Lefebvre',
                'role' => 'Ténor Principal',
                'voice' => 'Ténor',
                'years' => 6,
                'bio' => 'Professeur de musique, Pierre enrichit le chœur de son expérience pédagogique.'
            ],
            [
                'name' => 'Sophie Moreau',
                'role' => 'Alto',
                'voice' => 'Alto',
                'years' => 5,
                'bio' => 'Musicienne polyvalente, Sophie contribue également aux arrangements musicaux.'
            ],
            [
                'name' => 'Thomas Bernard',
                'role' => 'Basse',
                'voice' => 'Basse',
                'years' => 7,
                'bio' => 'Voix profonde et chaleureuse, Thomas ancre solidement les harmonies du chœur.'
            ]
        ];

        // Réalisations et concerts marquants
        $achievements = [
            [
                'year' => '2024',
                'title' => 'Concert de Noël Exceptionnel',
                'description' => 'Performance du Messie de Haendel devant 500 spectateurs'
            ],
            [
                'year' => '2023',
                'title' => 'Festival International de Musique Sacrée',
                'description' => 'Participation remarquée au festival avec les plus grands chœurs européens'
            ],
            [
                'year' => '2022',
                'title' => 'Enregistrement Studio',
                'description' => 'Premier album studio "Lumière Divine" avec 12 œuvres sacrées'
            ]
        ];

        return view('about.index', compact('choirInfo', 'members', 'achievements'));
    }
}
