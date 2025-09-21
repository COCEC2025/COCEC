<?php

namespace App\Services;

use App\Mail\BlogNotificationMail;
use App\Models\Blog;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;

class NewsletterService
{
    /**
     * Envoie une notification de nouveau blog à tous les abonnés
     */
    public function notifyNewBlog(Blog $blog)
    {
        try {
            // Récupérer tous les abonnés actifs
            $subscribers = NewsletterSubscriber::all();
            
            if ($subscribers->isEmpty()) {
                Log::info('Aucun abonné à la newsletter trouvé pour la notification du blog: ' . $blog->title);
                return false;
            }

            $successCount = 0;
            $errorCount = 0;

            foreach ($subscribers as $subscriber) {
                try {
                    // Générer un token de désabonnement simple
                    $unsubscribeToken = $this->generateUnsubscribeToken($subscriber->email);
                    
                    // Envoyer l'email en queue pour éviter les timeouts
                    Mail::to($subscriber->email)
                        ->queue(new BlogNotificationMail($blog, $unsubscribeToken));
                    
                    $successCount++;
                    
                } catch (\Exception $e) {
                    $errorCount++;
                    Log::error('Erreur lors de l\'envoi de la notification blog à ' . $subscriber->email . ': ' . $e->getMessage());
                }
            }

            Log::info("Notification blog '{$blog->title}' envoyée: {$successCount} succès, {$errorCount} erreurs");
            
            return [
                'success' => true,
                'total_subscribers' => $subscribers->count(),
                'success_count' => $successCount,
                'error_count' => $errorCount
            ];

        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi des notifications blog: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Génère un token simple pour le désabonnement
     */
    private function generateUnsubscribeToken($email)
    {
        return base64_encode($email . '|' . time());
    }

    /**
     * Vérifie si un token de désabonnement est valide
     */
    public function validateUnsubscribeToken($token)
    {
        try {
            $decoded = base64_decode($token);
            $parts = explode('|', $decoded);
            
            if (count($parts) !== 2) {
                return false;
            }

            $email = $parts[0];
            $timestamp = $parts[1];
            
            // Le token est valide pendant 30 jours
            if (time() - $timestamp > 30 * 24 * 60 * 60) {
                return false;
            }

            return $email;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Désabonne un utilisateur de la newsletter
     */
    public function unsubscribe($token)
    {
        $email = $this->validateUnsubscribeToken($token);
        
        if (!$email) {
            return false;
        }

        try {
            NewsletterSubscriber::where('email', $email)->delete();
            Log::info("Utilisateur désabonné de la newsletter: {$email}");
            return true;
        } catch (\Exception $e) {
            Log::error("Erreur lors du désabonnement: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtient les statistiques de la newsletter
     */
    public function getStats()
    {
        return [
            'total_subscribers' => NewsletterSubscriber::count(),
            'recent_subscribers' => NewsletterSubscriber::where('created_at', '>=', now()->subDays(7))->count(),
        ];
    }
}
