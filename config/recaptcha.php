<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google reCAPTCHA Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration pour Google reCAPTCHA v2 (checkbox)
    | Obtenez vos clés sur : https://www.google.com/recaptcha/admin
    |
    */

    'site_key' => env('RECAPTCHA_SITE_KEY', ''),
    'secret_key' => env('RECAPTCHA_SECRET_KEY', ''),
    
    /*
    |--------------------------------------------------------------------------
    | Score Threshold (pour reCAPTCHA v3 uniquement)
    |--------------------------------------------------------------------------
    |
    | Score minimum requis pour considérer une soumission comme légitime
    | Valeur entre 0.0 (très probablement un bot) et 1.0 (très probablement un humain)
    | Recommandé : 0.5 pour un bon équilibre
    | NOTE: Non utilisé avec reCAPTCHA v2 (checkbox)
    |
    */
    'score_threshold' => env('RECAPTCHA_SCORE_THRESHOLD', 0.5),
    
    /*
    |--------------------------------------------------------------------------
    | Action Names
    |--------------------------------------------------------------------------
    |
    | Actions spécifiques pour chaque formulaire
    | Permet de différencier les types de soumissions
    |
    */
    'actions' => [
        'contact' => 'contact_form',
        'job_application' => 'job_application',
        'newsletter' => 'newsletter_subscription',
        'complaint' => 'complaint_form',
        'faq_comment' => 'faq_comment',
        'account_creation' => 'account_creation',
        'admin_login' => 'admin_login',
    ],
];
