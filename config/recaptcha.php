<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google reCAPTCHA Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration pour Google reCAPTCHA v3
    | Obtenez vos clés sur : https://www.google.com/recaptcha/admin
    |
    */

    'site_key' => env('RECAPTCHA_SITE_KEY', ''),
    'secret_key' => env('RECAPTCHA_SECRET_KEY', ''),
    
    /*
    |--------------------------------------------------------------------------
    | Score Threshold
    |--------------------------------------------------------------------------
    |
    | Score minimum requis pour considérer une soumission comme légitime
    | Valeur entre 0.0 (très probablement un bot) et 1.0 (très probablement un humain)
    | Recommandé : 0.5 pour un bon équilibre
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
    ],
];
