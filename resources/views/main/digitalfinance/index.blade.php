@extends('layout.main')

@section('css')
<style>
    /* === STYLE "PRESTIGE" FINANCE DIGITALE (THÈME CLAIR) === */

    :root {
        --primary-color: #EC281C;
        --secondary-color: #ffcc00;
        --dark-charcoal: #1A202C;
        --text-color: #4A5568;
        --light-gray-bg: #F7FAFC;
        --border-color: #E2E8F0;
        --font-family: 'Poppins', sans-serif;
    }

    .df-light-section {
        padding: 100px 0;
        background-color: var(--light-gray-bg);
        font-family: var(--font-family);
        position: relative;
        overflow: hidden;
    }

    .df-light-section .section-heading .sub-heading { color: var(--primary-color); }
    .df-light-section .section-heading .section-title { color: var(--dark-charcoal); }
    .df-light-section .section-heading .lead {
        color: var(--text-color);
        max-width: 800px;
        margin: 15px auto 0;
    }

    .df-light-layout {
        margin-top: 60px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: start;
    }

    /* --- Colonne des Services (Gauche) --- */
    .df-services-list { display: flex; flex-direction: column; gap: 25px; }
    .df-service-item {
        display: flex;
        align-items: flex-start;
        padding: 30px;
        background-color: #FFFFFF;
        border: 1px solid var(--border-color);
        border-radius: 15px;
        transition: all 0.3s ease-in-out;
        border-left: 4px solid transparent;
    }
    .df-service-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(45, 55, 72, 0.1);
        border-left-color: var(--primary-color);
    }
    .df-service-icon {
        font-size: 2.2rem;
        color: var(--primary-color);
        margin-right: 25px;
        width: 60px;
        flex-shrink: 0;
        text-align: center;
    }
    .df-service-text h5 {
        font-weight: 700;
        color: var(--dark-charcoal);
        margin-bottom: 12px;
        font-size: 1.3rem;
    }
    .df-service-text p {
        margin: 0 0 15px 0;
        color: var(--text-color);
        font-size: 1rem;
        line-height: 1.7;
    }
    .df-service-features { list-style: none; padding: 0; margin: 0; }
    .df-service-features li {
        color: var(--text-color);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 8px;
        padding-left: 20px;
        position: relative;
    }
    .df-service-features li:before {
        content: "✓";
        color: var(--primary-color);
        font-weight: bold;
        position: absolute;
        left: 0;
    }

    /* --- Colonne des Codes USSD (Droite) --- */
    .df-ussd-section {
        background-color: #FFFFFF;
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(45, 55, 72, 0.08);
        border: 1px solid var(--border-color);
    }
    .df-ussd-section h3 {
        color: var(--dark-charcoal);
        font-weight: 700;
        margin-bottom: 25px;
        font-size: 1.5rem;
        text-align: center;
    }
    .df-ussd-codes { display: flex; flex-direction: column; gap: 20px; }
    .df-ussd-item {
        background: var(--light-gray-bg);
        border-radius: 12px;
        padding: 20px;
        border-left: 4px solid var(--primary-color);
    }
    .df-ussd-provider {
        font-weight: 600;
        color: var(--dark-charcoal);
        margin-bottom: 8px;
        font-size: 1.1rem;
    }
    .df-ussd-code {
        font-family: 'Courier New', monospace;
        background: #FFFFFF;
        padding: 12px 15px;
        border-radius: 8px;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--primary-color);
        border: 2px solid var(--border-color);
        display: inline-block;
        margin: 5px 0;
    }
    .df-ussd-description {
        color: var(--text-color);
        font-size: 0.9rem;
        margin-top: 8px;
        line-height: 1.5;
    }

    /* === DÉBUT REFONTE SECTION MISE À JOUR (THÈME CLAIR) === */
    .df-update-section-clean {
        margin-top: 40px;
        padding: 80px 0;
        background-color: #FFFFFF;
    }
    .df-update-container-clean {
        max-width: 900px;
        margin: 0 auto;
        text-align: center;
    }
    .df-update-container-clean .section-heading {
        margin-bottom: 50px;
    }
    .df-update-container-clean .section-heading h3 {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--dark-charcoal);
        margin-bottom: 15px;
    }
    .df-update-container-clean .section-heading p {
        font-size: 1.1rem;
        color: var(--text-color);
        max-width: 650px;
        margin-left: auto;
        margin-right: auto;
    }
    .df-actions-grid-clean {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
    }
    .df-action-card-clean {
        background: var(--light-gray-bg);
        padding: 40px;
        border-radius: 15px;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        position: relative;
    }
    .df-action-card-clean:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(45, 55, 72, 0.1);
        border-color: var(--primary-color);
    }
    .df-action-card-clean .icon-wrapper {
        width: 80px;
        height: 80px;
        background: var(--primary-color);
        border-radius: 50%;
        display: grid;
        place-items: center;
        margin-bottom: 25px;
        box-shadow: 0 10px 25px rgba(236, 40, 28, 0.3);
        transition: all 0.3s ease;
    }
    .df-action-card-clean:hover .icon-wrapper {
        background: var(--secondary-color);
        transform: scale(1.1) rotate(-10deg);
    }
    .df-action-card-clean .icon-wrapper i {
        font-size: 2.5rem;
        color: white;
    }
    .df-action-card-clean strong {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--dark-charcoal);
        margin-bottom: 10px;
    }
    .df-action-card-clean span {
        font-size: 1rem;
        color: var(--text-color);
        line-height: 1.6;
        flex-grow: 1; /* Pour aligner les boutons en bas */
        margin-bottom: 25px;
    }
    .df-action-card-clean .btn-indicator {
        margin-top: auto; /* Pousse le bouton en bas */
        font-weight: 600;
        color: var(--primary-color);
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
    }
    .df-action-card-clean .btn-indicator i {
        margin-left: 8px;
        transition: transform 0.3s ease;
    }
    .df-action-card-clean:hover .btn-indicator i {
        transform: translateX(5px);
    }
    /* === FIN REFONTE === */

    /* --- Section Sécurité --- */
    .df-security-section {
        margin-top: 80px;
        background-color: #FFFFFF;
        border-radius: 15px;
        padding: 50px;
        box-shadow: 0 10px 30px rgba(45, 55, 72, 0.08);
        border: 1px solid var(--border-color);
    }
    .df-security-section h3 {
        color: var(--dark-charcoal);
        font-weight: 700;
        margin-bottom: 30px;
        font-size: 1.8rem;
        text-align: center;
    }
    .df-security-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 30px;
    }
    .df-security-item {
        padding: 25px;
        background: var(--light-gray-bg);
        border-radius: 12px;
        border-left: 4px solid var(--primary-color);
    }
    .df-security-item h5 {
        color: var(--dark-charcoal);
        font-weight: 600;
        margin-bottom: 15px;
        font-size: 1.2rem;
    }
    .df-security-item p { color: var(--text-color); line-height: 1.6; margin: 0; }

    /* --- Responsive --- */
    @media (max-width: 991px) {
        .df-light-layout { grid-template-columns: 1fr; gap: 40px; }
        .df-security-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
        .df-light-section, .df-update-section-clean { padding: 60px 0; }
        .df-actions-grid-clean { grid-template-columns: 1fr; }
        .df-update-container-clean .section-heading h3 { font-size: 2rem; }
    }
</style>
@endsection

@section('content')

<body>
    @include('includes.main.loading')
    @include('includes.main.header')

    <section class="page-header-pro">
        <div class="page-header-overlay"></div>
        <div class="container">
            <div class="page-header-content-pro" data-aos="fade-up">
                <h1 class="title-pro">Finance Digitale</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb-pro">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Accueil</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Finance Digitale</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <section class="df-light-section">
        <div class="container">
            <div class="section-heading text-center" data-aos="fade-up">
                <h4 class="sub-heading">Services Financiers Digitaux</h4>
                <h2 class="section-title">Finance Digitale et Services en Ligne</h2>
                <p class="lead">La COCEC met à votre disposition plusieurs services numériques pour faciliter l'accès à nos produits et gérer vos finances en toute simplicité.</p>
            </div>

            <div class="df-light-layout">
                <!-- Colonne des Services -->
                <div class="df-services-list" data-aos="fade-right" data-aos-delay="200">
                    <div class="df-service-item">
                        <div class="df-service-icon"><i class="fas fa-mobile-alt"></i></div>
                        <div class="df-service-text">
                            <h5>Mobile Banking</h5>
                            <p>Utilisation de l'Application Bindoo mobile pour gérer votre compte en toute simplicité :</p>
                            <ul class="df-service-features">
                                <li>Consulter le solde de votre compte</li>
                                <li>Effectuer des virements entre comptes</li>
                                <li>Faire des remboursements de crédit</li>
                                <li>Voir les 40 dernières opérations de compte</li>
                                <li>Mini relevé de compte</li>
                            </ul>
                        </div>
                    </div>
                    <div class="df-service-item">
                        <div class="df-service-icon"><i class="fas fa-keyboard"></i></div>
                        <div class="df-service-text">
                            <h5>Mobile Money</h5>
                            <p>Utilisation de code USSD pour accéder à votre compte COCEC et effectuer diverses opérations :</p>
                            <ul class="df-service-features">
                                <li>Faire des dépôts et retraits</li>
                                <li>Consulter votre solde</li>
                                <li>Fonctionne sur tout type de téléphone</li>
                                <li>Sans connexion Internet requise</li>
                            </ul>
                        </div>
                    </div>
                    <div class="df-service-item">
                        <div class="df-service-icon"><i class="fas fa-sms"></i></div>
                        <div class="df-service-text">
                            <h5>SMS Banking</h5>
                            <p>Restez informé de tous les mouvements sur votre compte :</p>
                            <ul class="df-service-features">
                                <li>Recevez des SMS à chaque mouvement</li>
                                <li>Notifications en temps réel</li>
                                <li>Suivi de vos transactions</li>
                            </ul>
                        </div>
                    </div>
                    <div class="df-service-item">
                        <div class="df-service-icon"><i class="fas fa-globe"></i></div>
                        <div class="df-service-text">
                            <h5>Web Banking</h5>
                            <p>Accédez à votre compte bancaire via un navigateur internet :</p>
                            <ul class="df-service-features">
                                <li>Compatible ordinateur, tablette et smartphone</li>
                                <li>Interface web sécurisée</li>
                                <li>Gestion complète de vos comptes</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Colonne des Codes USSD -->
                <div class="df-ussd-section" data-aos="fade-left" data-aos-delay="400">
                    <h3>Codes USSD pour Accéder à Votre Compte</h3>
                    <div class="df-ussd-codes">
                        <div class="df-ussd-item">
                            <div class="df-ussd-provider">FLOOZ</div>
                            <div class="df-ussd-code">*155*7*1*2#</div>
                            <div class="df-ussd-description">
                                Choisissez le compte sur lequel vous voulez faire l'opération, puis consultez le solde du compte COCEC. Si le solde s'affiche (le serveur est disponible), vous pouvez faire l'opération souhaitée.
                            </div>
                        </div>
                        <div class="df-ussd-item">
                            <div class="df-ussd-provider">Mixx by Yas</div>
                            <div class="df-ussd-code">*145*6*3*2#</div>
                            <div class="df-ussd-description">
                                Accédez à votre compte COCEC via le service Mixx by Yas pour effectuer vos opérations bancaires.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- NOUVELLE SECTION MISE À JOUR (REFONTE) -->
            <section class="df-update-section-clean" data-aos="fade-up">
                <div class="df-update-container-clean">
                    <div class="section-heading">
                        <h3>Prêt à passer au digital ?</h3>
                        <p>Souscrivez à nos services en ligne ou mettez à jour vos informations personnelles en quelques minutes via nos formulaires sécurisés.</p>
                    </div>
                    <div class="df-actions-grid-clean">
                        <a href="{{ route('digitalfinance.updates.create') }}" class="df-action-card-clean">
                            <div class="icon-wrapper"><i class="fas fa-user-edit"></i></div>
                            <strong>Mettre à Jour mes Informations</strong>
                            <span>Un changement de numéro ou d'adresse ? Mettez à jour votre profil pour garantir la sécurité de votre compte.</span>
                            <div class="btn-indicator">Remplir le formulaire <i class="fas fa-arrow-right"></i></div>
                        </a>
                        <a href="{{ route('digitalfinance.contracts.create') }}" class="df-action-card-clean">
                            <div class="icon-wrapper"><i class="fas fa-file-signature"></i></div>
                            <strong>Adhérer à la Finance Digitale</strong>
                            <span>Accédez à votre compte 24/7 depuis votre téléphone ou ordinateur en signant notre contrat d'adhésion en ligne.</span>
                            <div class="btn-indicator">Signer le contrat <i class="fas fa-arrow-right"></i></div>
                        </a>
                    </div>
                </div>
            </section>
            
            <!-- Section Sécurité -->
            <div class="df-security-section" data-aos="fade-up">
                <h3>Sécurité et Assistance</h3>
                <div class="df-security-grid">
                    <div class="df-security-item text-justify">
                        <h5>Application Mobile Sécurisée</h5>
                        <p>Notre application utilise un cryptage de données avancé et nécessite une authentification à chaque connexion. Nous recommandons de ne jamais partager votre mot de passe ou votre code PIN.</p>
                    </div>
                    <div class="df-security-item text-justify">
                        <h5>Perte de Téléphone</h5>
                        <p>Alertez sans délai la COCEC pour que le service soit désactivé temporairement et sécurisez votre compte.</p>
                    </div>
                    <div class="df-security-item text-justify">
                        <h5>Assistance Technique</h5>
                        <p>Vous pouvez contacter notre assistance digitale via WhatsApp, téléphone ou email. Nous avons une équipe dédiée pour vous aider en cas de problème technique.</p>
                    </div>
                    <div class="df-security-item text-justify">
                        <h5>Accès à Distance</h5>
                        <p>Vous pouvez consulter votre solde, vos échéances et votre historique via l'application Bindoo Mobile ou un code USSD, où que vous soyez.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('includes.main.scroll')
    @include('includes.main.footer')
</body>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialisation de AOS (Animate On Scroll) si la librairie est chargée
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 800,
                once: true,
                offset: 120,
            });
        }
    });
</script>
@endsection