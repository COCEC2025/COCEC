<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configuration des performances
    |--------------------------------------------------------------------------
    |
    | Ce fichier contient les paramètres d'optimisation des performances
    | pour l'application COCEC.
    |
    */

    'optimization' => [
        // Activation de la compression GZIP
        'gzip_enabled' => env('GZIP_ENABLED', true),
        
        // Cache des vues
        'view_cache' => env('VIEW_CACHE', true),
        
        // Cache des routes
        'route_cache' => env('ROUTE_CACHE', true),
        
        // Cache de la configuration
        'config_cache' => env('CONFIG_CACHE', true),
    ],

    'assets' => [
        // Version des assets pour le cache busting
        'version' => env('ASSETS_VERSION', '1.0.0'),
        
        // Minification des CSS/JS
        'minify' => env('ASSETS_MINIFY', true),
        
        // Compression des images
        'image_compression' => env('IMAGE_COMPRESSION', true),
        
        // Qualité des images (1-100)
        'image_quality' => env('IMAGE_QUALITY', 85),
    ],

    'lazy_loading' => [
        // Activation du lazy loading
        'enabled' => env('LAZY_LOADING', true),
        
        // Délai avant le chargement des images
        'delay' => env('LAZY_LOADING_DELAY', 100),
        
        // Distance de déclenchement (en pixels)
        'threshold' => env('LAZY_LOADING_THRESHOLD', 50),
    ],

    'animations' => [
        // Activation des animations
        'enabled' => env('ANIMATIONS_ENABLED', true),
        
        // Délai avant l'initialisation des animations
        'init_delay' => env('ANIMATIONS_DELAY', 500),
        
        // Réduction des animations pour les utilisateurs qui le préfèrent
        'respect_prefers_reduced_motion' => env('RESPECT_REDUCED_MOTION', true),
    ],

    'preloading' => [
        // Activation du preloading des ressources critiques
        'enabled' => env('PRELOADING_ENABLED', true),
        
        // Ressources critiques à précharger
        'critical_resources' => [
            'css' => [
                'bootstrap.min.css',
                'fontawesome.min.css',
                'main.css',
            ],
            'js' => [
                'jquary-3.6.0.min.js',
                'bootstrap-bundle.js',
            ],
            'images' => [
                'banner.jpg',
                'Logo.png',
            ],
        ],
    ],
];
