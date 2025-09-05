<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        // Informations sur la chorale MRDA
        $choirInfo = [
            'name' => 'Chorale Marie Reine Des Apôtres (MRDA)',
            'founded' => '2017',
            'director' => 'Gillis',
            'members_count' => 45,
            'description' => 'La Chorale MRDA est un ensemble vocal passionné dédié à la musique, la louage et l\'adoration sacrée. Fondée en 2017, elle rassemble des chanteurs de tous horizons unis par l\'amour de la musique religieuse et de Christ',
            'mission' => 'Notre mission est de partager la beauté de la musique sacrée et d\'enrichir la vie spirituelle de notre communauté à travers des concerts et des célébrations liturgiques.'
        ];

        $members = [
            [
                'name' => 'Gillis',
                'role' => 'Chef de Chœur',
                'voice' => 'Direction',
                'years' => 8,
                'bio' => 'Pianiste et maitre de choeur, Gillis dirige la chorale avec passion depuis sa création.'
            ],
            [
                'name' => 'Harrold',
                'role' => 'Assistant chef de choeur',
                'voice' => 'Baryton Tenor',
                'years' => 8,
                'bio' => 'Assistant chef de choeur, soliste, apporte sa voix et technique aux œuvres les plus exigeantes.'
            ],
            [
                'name' => 'Pamella',
                'role' => 'Soprano',
                'voice' => 'Soprano',
                'years' => 4,
                'bio' => 'Soprano, Pamella contribue également à la communication digitale de la chorale.'
            ],
            [
                'name' => 'Willy',
                'role' => 'Conseiller administratif',
                'voice' => 'Ténor',
                'years' => 7,
                'bio' => 'Maitre de choeur, Willy est aussi conseiller administratif de la chorale.'
            ],
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
