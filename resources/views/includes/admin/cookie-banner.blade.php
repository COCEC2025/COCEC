<!-- Bannière de Cookies pour l'Administration - Composant Réutilisable -->
<div id="cookie-banner-admin" class="cookie-banner admin-theme" style="display: none;">
    <div class="cookie-content">
        <div class="cookie-text">
            <h4>🍪 Politique de Cookies - Administration</h4>
            <p>Cette interface d'administration utilise des cookies et du stockage local pour :</p>
            <ul style="margin: 10px 0; padding-left: 20px; font-size: 14px;">
                <li>Gérer votre session d'administration</li>
                <li>Sauvegarder vos préférences (thème, paramètres d'interface)</li>
                <li>Améliorer les performances et la sécurité</li>
            </ul>
            <p style="margin: 10px 0 0 0; font-size: 13px; font-style: italic;">Ces cookies sont essentiels au bon fonctionnement de l'administration.</p>
        </div>
        <div class="cookie-actions">
            <button id="accept-cookies-admin" class="btn btn-primary">Accepter</button>
            <button id="reject-cookies-admin" class="btn btn-outline-secondary">Refuser</button>
        </div>
    </div>
</div>

<!-- Styles CSS pour la bannière de cookies admin -->
<link rel="stylesheet" href="{{ asset('assets/css/cookie-banner.css') }}">

<!-- Script pour la bannière de cookies admin -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cookieBanner = document.getElementById('cookie-banner-admin');
    const acceptBtn = document.getElementById('accept-cookies-admin');
    const rejectBtn = document.getElementById('reject-cookies-admin');
    
    // Vérifier si l'utilisateur a déjà fait un choix
    const cookieChoice = localStorage.getItem('cookieChoice');
    
    if (!cookieChoice) {
        // Afficher la bannière après 1 seconde (plus rapide pour l'admin)
        setTimeout(() => {
            cookieBanner.style.display = 'block';
        }, 1000);
    }
    
    // Gérer l'acceptation des cookies
    acceptBtn.addEventListener('click', function() {
        localStorage.setItem('cookieChoice', 'accepted');
        localStorage.setItem('cookieConsentDate', new Date().toISOString());
        hideCookieBanner();
        
        // Message de confirmation
        console.log('Cookies acceptés pour l\'administration');
        
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'Cookies acceptés',
                text: 'Vos préférences d\'administration ont été sauvegardées.',
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        }
    });
    
    // Gérer le refus des cookies
    rejectBtn.addEventListener('click', function() {
        localStorage.setItem('cookieChoice', 'rejected');
        localStorage.setItem('cookieConsentDate', new Date().toISOString());
        hideCookieBanner();
        
        // Désactiver certaines fonctionnalités non essentielles
        disableNonEssentialFeatures();
        
        console.log('Cookies refusés pour l\'administration');
        
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'info',
                title: 'Cookies refusés',
                text: 'Certaines fonctionnalités d\'administration peuvent être limitées.',
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
