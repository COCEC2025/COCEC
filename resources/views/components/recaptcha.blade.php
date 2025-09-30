@php
    $siteKey = app(\App\Services\RecaptchaService::class)->getSiteKey();
    $isConfigured = app(\App\Services\RecaptchaService::class)->isConfigured();
@endphp

@if($isConfigured)
    <!-- Google reCAPTCHA v3 -->
    <script src="https://www.google.com/recaptcha/api.js?render={{ $siteKey }}"></script>
    
    <script>
        // Initialiser reCAPTCHA v3
        grecaptcha.ready(function() {
            grecaptcha.execute('{{ $siteKey }}', {
                action: '{{ isset($action) ? $action : 'submit' }}'
            }).then(function(token) {
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
            });
        });
        
        // Fonction pour vérifier si reCAPTCHA est résolu
        window.isRecaptchaResolved = function() {
            const form = document.querySelector('form');
            const tokenInput = form ? form.querySelector('input[name="recaptcha_token"]') : null;
            return tokenInput && tokenInput.value.length > 0;
        };
        
        // Fonction pour réinitialiser reCAPTCHA
        window.resetRecaptcha = function() {
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ $siteKey }}', {
                    action: '{{ isset($action) ? $action : 'submit' }}'
                }).then(function(token) {
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
