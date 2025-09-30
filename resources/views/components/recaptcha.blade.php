@php
    $siteKey = app(\App\Services\RecaptchaService::class)->getSiteKey();
    $isConfigured = app(\App\Services\RecaptchaService::class)->isConfigured();
@endphp

@if($isConfigured)
    <!-- Google reCAPTCHA v2 -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
    <!-- Widget reCAPTCHA v2 -->
    <div class="g-recaptcha" data-sitekey="{{ $siteKey }}" data-callback="onRecaptchaSuccess" data-expired-callback="onRecaptchaExpired"></div>
    
    <script>
        // Callback quand reCAPTCHA est résolu
        window.onRecaptchaSuccess = function(token) {
            console.log('reCAPTCHA résolu avec succès');
            // Le token est automatiquement ajouté au formulaire
        };
        
        // Callback quand reCAPTCHA expire
        window.onRecaptchaExpired = function() {
            console.log('reCAPTCHA expiré');
        };
        
        // Fonction pour vérifier si reCAPTCHA est résolu
        window.isRecaptchaResolved = function() {
            return grecaptcha.getResponse().length > 0;
        };
        
        // Fonction pour réinitialiser reCAPTCHA
        window.resetRecaptcha = function() {
            grecaptcha.reset();
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
