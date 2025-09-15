<!-- Bannière de Cookies - Composant Réutilisable -->
<div id="cookie-banner" class="cookie-banner" style="display: none;">
    <div class="cookie-content">
        <div class="cookie-text">
            <h4>🍪 Politique de Cookies</h4>
            <p>Nous utilisons des cookies et du stockage local pour améliorer votre expérience sur notre site.</p>
        </div>
        <div class="cookie-actions">
            <button id="accept-cookies" class="btn btn-primary">Accepter</button>
            <button id="reject-cookies" class="btn btn-outline-secondary">Refuser</button>
        </div>
    </div>
</div>

<!-- Styles CSS pour la bannière de cookies -->
<link rel="stylesheet" href="{{ asset('assets/css/cookie-banner.css') }}">

<!-- Script pour la bannière de cookies -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cookieBanner = document.getElementById('cookie-banner');
    const acceptBtn = document.getElementById('accept-cookies');
    const rejectBtn = document.getElementById('reject-cookies');

    const cookieChoice = localStorage.getItem('cookieChoice');

    if (!cookieChoice) {
        setTimeout(() => {
            cookieBanner.style.display = 'block';
        }, 2000);
    }

    acceptBtn.addEventListener('click', function() {
        localStorage.setItem('cookieChoice', 'accepted');
        localStorage.setItem('cookieConsentDate', new Date().toISOString());
        hideCookieBanner();
        
        // Message de confirmation
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'Cookies acceptés',
                text: 'Vos préférences ont été sauvegardées.',
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        }
    });

    rejectBtn.addEventListener('click', function() {
        localStorage.setItem('cookieChoice', 'rejected');
        localStorage.setItem('cookieConsentDate', new Date().toISOString());
        hideCookieBanner();
        
        // Désactiver certaines fonctionnalités non essentielles
        disableNonEssentialFeatures();
        
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'info',
                title: 'Cookies refusés',
                text: 'Certaines fonctionnalités peuvent être limitées.',
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        }
    });

    function hideCookieBanner() {
        cookieBanner.style.animation = 'slideDown 0.5s ease-out';
        setTimeout(() => {
            cookieBanner.style.display = 'none';
        }, 500);
    }

    function disableNonEssentialFeatures() {
        // Désactiver le thème sombre/clair si refusé
        localStorage.removeItem('theme');
        
        // Forcer le thème clair par défaut
        document.documentElement.setAttribute('data-theme', 'light');
        
        // Désactiver les analytics si refusé
        if (typeof gtag !== 'undefined') {
            gtag('consent', 'update', {
                'analytics_storage': 'denied'
            });
        }
    }
});

// Animation de fermeture
const style = document.createElement('style');
style.textContent = `
    @keyframes slideDown {
        from { transform: translateY(0); }
        to { transform: translateY(100%); }
    }
`;
document.head.appendChild(style);
</script>
