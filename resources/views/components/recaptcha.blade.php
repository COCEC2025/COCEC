@php
    $siteKey = app(\App\Services\RecaptchaService::class)->getSiteKey();
    $isConfigured = app(\App\Services\RecaptchaService::class)->isConfigured();
@endphp

@if($isConfigured)
    <!-- Google reCAPTCHA v3 -->
    <script src="https://www.google.com/recaptcha/api.js?render={{ $siteKey }}"></script>
    
    <script>
        // Variable globale pour suivre l'état de reCAPTCHA
        window.recaptchaReady = false;
        window.recaptchaToken = null;
        
        // Initialiser reCAPTCHA v3
        grecaptcha.ready(function() {
            grecaptcha.execute('{{ $siteKey }}', {
                action: '{{ isset($action) ? $action : 'submit' }}'
            }).then(function(token) {
                window.recaptchaReady = true;
                window.recaptchaToken = token;
                
                // Ajouter le token au formulaire
                const form = document.querySelector('form');
                if (form) {
                    // Supprimer l'ancien token s'il existe
                    const existingToken = form.querySelector('input[name="recaptcha_token"]');
                    if (existingToken) {
                        existingToken.remove();
                    }
                    
                    // Ajouter le nouveau token
                    const tokenInput = document.createElement('input');
                    tokenInput.type = 'hidden';
                    tokenInput.name = 'recaptcha_token';
                    tokenInput.value = token;
                    form.appendChild(tokenInput);
                }
            }).catch(function(error) {
                console.error('reCAPTCHA error:', error);
                window.recaptchaReady = false;
                window.recaptchaToken = null;
            });
        });
        
        // Fonction pour vérifier si reCAPTCHA est résolu
        window.isRecaptchaResolved = function() {
            // Si reCAPTCHA n'est pas encore prêt, attendre un peu
            if (!window.recaptchaReady) {
                return false;
            }
            return window.recaptchaToken && window.recaptchaToken.length > 0;
        };
        
        // Fonction pour réinitialiser reCAPTCHA
        window.resetRecaptcha = function() {
            window.recaptchaReady = false;
            window.recaptchaToken = null;
            
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ $siteKey }}', {
                    action: '{{ isset($action) ? $action : 'submit' }}'
                }).then(function(token) {
                    window.recaptchaReady = true;
                    window.recaptchaToken = token;
                    
                    const form = document.querySelector('form');
                    if (form) {
                        const tokenInput = form.querySelector('input[name="recaptcha_token"]');
                        if (tokenInput) {
                            tokenInput.value = token;
                        }
                    }
                });
            });
        };
        
        // Fonction pour attendre que reCAPTCHA soit prêt
        window.waitForRecaptcha = function(callback, maxWait = 3000) {
            const startTime = Date.now();
            
            function check() {
                if (window.isRecaptchaResolved()) {
                    callback(true);
                } else if (Date.now() - startTime > maxWait) {
                    // Si reCAPTCHA n'est pas prêt après 3 secondes, continuer quand même
                    // pour éviter de bloquer l'utilisateur
                    console.warn('reCAPTCHA timeout, continuing without verification');
                    callback(true);
                } else {
                    setTimeout(check, 100);
                }
            }
            
            check();
        };
        
        // Fonction de fallback pour les formulaires qui n'utilisent pas waitForRecaptcha
        window.forceRecaptchaReady = function() {
            window.recaptchaReady = true;
            window.recaptchaToken = 'fallback-token-' + Date.now();
        };
    </script>
@else
    <!-- reCAPTCHA non configuré - mode développement -->
    
    <script>
        window.isRecaptchaResolved = function() {
            return true; // En mode dev, toujours considérer comme résolu
        };
        
        window.resetRecaptcha = function() {
            // En mode dev, rien à faire
        };
    </script>
@endif
