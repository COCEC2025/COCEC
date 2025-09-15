<?php

namespace App\Helpers;

class PerformanceHelper
{
    /**
     * Génère une URL d'asset avec version pour le cache busting
     */
    public static function assetWithVersion($path, $version = null)
    {
        $version = $version ?: config('performance.assets.version', '1.0.0');
        $url = asset($path);
        
        // Ajouter le paramètre de version
        $separator = strpos($url, '?') !== false ? '&' : '?';
        return $url . $separator . 'v=' . $version;
    }

    /**
     * Génère les balises de preload pour les ressources critiques
     */
    public static function getCriticalPreloads()
    {
        if (!config('performance.preloading.enabled', true)) {
            return '';
        }

        $criticalResources = config('performance.preloading.critical_resources', []);
        $preloads = [];

        // Preload CSS
        foreach ($criticalResources['css'] ?? [] as $css) {
            $preloads[] = sprintf(
                '<link rel="preload" href="%s" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">',
                asset("assets/main/css/{$css}")
            );
        }

        // Preload JS
        foreach ($criticalResources['js'] ?? [] as $js) {
            $preloads[] = sprintf(
                '<link rel="preload" href="%s" as="script">',
                asset("assets/main/js/vendor/{$js}")
            );
        }

        // Preload Images
        foreach ($criticalResources['images'] ?? [] as $image) {
            $preloads[] = sprintf(
                '<link rel="preload" href="%s" as="image">',
                asset("assets/images/{$image}")
            );
        }

        return implode("\n    ", $preloads);
    }

    /**
     * Génère les balises noscript pour les ressources critiques
     */
    public static function getCriticalNoscript()
    {
        $criticalResources = config('performance.preloading.critical_resources', []);
        $noscripts = [];

        // Noscript pour CSS
        foreach ($criticalResources['css'] ?? [] as $css) {
            $noscripts[] = sprintf(
                '<link rel="stylesheet" href="%s">',
                asset("assets/main/css/{$css}")
            );
        }

        return '<noscript>' . implode("\n        ", $noscripts) . '</noscript>';
    }

    /**
     * Optimise une URL d'image avec lazy loading
     */
    public static function getOptimizedImage($path, $alt = '', $class = '', $lazy = true)
    {
        $attributes = [
            'src' => asset($path),
            'alt' => $alt,
        ];

        if ($class) {
            $attributes['class'] = $class;
        }

        if ($lazy && config('performance.lazy_loading.enabled', true)) {
            $attributes['loading'] = 'lazy';
            $attributes['decoding'] = 'async';
        }

        $attrString = '';
        foreach ($attributes as $key => $value) {
            $attrString .= sprintf(' %s="%s"', $key, htmlspecialchars($value));
        }

        return sprintf('<img%s>', $attrString);
    }

    /**
     * Génère le script d'optimisation des performances
     */
    public static function getPerformanceScript()
    {
        if (!config('performance.animations.enabled', true)) {
            return '';
        }

        $delay = config('performance.animations.init_delay', 500);
        $threshold = config('performance.lazy_loading.threshold', 50);

        return "
<script>
// Optimisation des performances - Chargement différé des animations
(function() {
    'use strict';
    
    function initAnimations() {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initAnimations);
            return;
        }

        setTimeout(() => {
            const animatedElements = document.querySelectorAll('.fade-wrapper, .fade-top, .fade-bottom, .img-reveal');
            
            if (animatedElements.length === 0) return;
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -{$threshold}px 0px'
            });

            animatedElements.forEach(el => {
                observer.observe(el);
            });
        }, {$delay});
    }

    // Initialiser les animations
    initAnimations();
})();
</script>";
    }
}
