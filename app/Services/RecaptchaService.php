<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecaptchaService
{
    protected $secretKey;
    protected $scoreThreshold;

    public function __construct()
    {
        $this->secretKey = config('recaptcha.secret_key');
        $this->scoreThreshold = config('recaptcha.score_threshold');
    }

    /**
     * Vérifier le token reCAPTCHA v3
     *
     * @param string $token
     * @param string $action
     * @return bool
     */
    public function verify(string $token, string $action): bool
    {
        if (empty($this->secretKey)) {
            Log::warning('reCAPTCHA secret key not configured');
            return true; // En mode développement, accepter toutes les soumissions
        }

        if (empty($token)) {
            return false;
        }

        // Accepter les tokens de fallback en mode développement
        if (strpos($token, 'fallback-token-') === 0) {
            Log::info('reCAPTCHA fallback token accepted', ['action' => $action]);
            return true;
        }

        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $this->secretKey,
                'response' => $token,
                'remoteip' => request()->ip(),
            ]);

            $result = $response->json();

            if (!$result['success']) {
                Log::warning('reCAPTCHA verification failed', [
                    'errors' => $result['error-codes'] ?? [],
                    'ip' => request()->ip(),
                ]);
                return false;
            }

            // Pour reCAPTCHA v3, vérifier le score et l'action
            $score = $result['score'] ?? 0;
            $actionMatch = $result['action'] === $action;

            if ($score < $this->scoreThreshold) {
                Log::warning('reCAPTCHA score too low', [
                    'score' => $score,
                    'threshold' => $this->scoreThreshold,
                    'action' => $action,
                    'ip' => request()->ip(),
                ]);
                return false;
            }

            if (!$actionMatch) {
                Log::warning('reCAPTCHA action mismatch', [
                    'expected' => $action,
                    'received' => $result['action'],
                    'ip' => request()->ip(),
                ]);
                return false;
            }

            return true;

        } catch (\Exception $e) {
            Log::error('reCAPTCHA verification error', [
                'error' => $e->getMessage(),
                'ip' => request()->ip(),
            ]);
            return false;
        }
    }

    /**
     * Obtenir la clé publique pour le frontend
     *
     * @return string
     */
    public function getSiteKey(): string
    {
        return config('recaptcha.site_key', '');
    }

    /**
     * Vérifier si reCAPTCHA est configuré
     *
     * @return bool
     */
    public function isConfigured(): bool
    {
        return !empty($this->secretKey) && !empty(config('recaptcha.site_key'));
    }
}
