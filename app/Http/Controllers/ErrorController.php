<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    /**
     * Afficher la page d'erreur 404
     */
    public function notFound()
    {
        return view('errors.404');
    }

    /**
     * Afficher la page d'erreur 500
     */
    public function serverError()
    {
        return view('errors.500');
    }

    /**
     * Afficher une page d'erreur générique
     */
    public function error($code = 500)
    {
        $titles = [
            400 => 'Requête invalide',
            401 => 'Non autorisé',
            403 => 'Accès interdit',
            404 => 'Page non trouvée',
            405 => 'Méthode non autorisée',
            408 => 'Délai d\'attente dépassé',
            429 => 'Trop de requêtes',
            500 => 'Erreur serveur',
            502 => 'Passerelle invalide',
            503 => 'Service indisponible',
            504 => 'Délai d\'attente de la passerelle',
        ];

        $messages = [
            400 => 'La requête que vous avez envoyée est invalide.',
            401 => 'Vous devez être connecté pour accéder à cette page.',
            403 => 'Vous n\'avez pas l\'autorisation d\'accéder à cette page.',
            404 => 'La page que vous recherchez n\'existe pas ou a été déplacée.',
            405 => 'La méthode utilisée pour accéder à cette page n\'est pas autorisée.',
            408 => 'Le délai d\'attente de la requête a été dépassé.',
            429 => 'Vous avez envoyé trop de requêtes. Veuillez patienter avant de réessayer.',
            500 => 'Une erreur interne s\'est produite sur notre serveur.',
            502 => 'Le serveur a reçu une réponse invalide d\'un autre serveur.',
            503 => 'Le service est temporairement indisponible.',
            504 => 'Le délai d\'attente de la passerelle a été dépassé.',
        ];

        $title = $titles[$code] ?? 'Erreur inconnue';
        $message = $messages[$code] ?? 'Une erreur inattendue s\'est produite.';

        return view('errors.generic', compact('code', 'title', 'message'));
    }
}
