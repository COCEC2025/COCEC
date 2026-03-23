@extends('layout.main')

@section('css')
<style>
    /* Styles généraux du simulateur */
    .loan-simulator-section .form-control.is-invalid,
    .loan-simulator-section .form-select.is-invalid {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }

    .loan-simulator-section .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
    }

    .loan-simulator-section .form-control,
    .loan-simulator-section .form-select {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
        height: 50px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
    }

    /* Largeur fixe pour le sélecteur */
    .loan-simulator-section .form-select {
        width: 100%;
        max-width: 100%;
        min-width: 0;
    }

    /* Options du sélecteur visibles */
    .loan-simulator-section .form-select option {
        white-space: normal;
        word-wrap: break-word;
    }

    .loan-simulator-section .form-control:focus,
    .loan-simulator-section .form-select:focus {
        border-color: #EC281C;
        box-shadow: 0 0 0 0.2rem rgba(236, 40, 28, 0.25);
    }

    /* Harmonisation du bouton avec les champs */
    .loan-simulator-section .bz-primary-btn {
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        font-weight: 600;
        text-transform: none;
        letter-spacing: 0.5px;
        padding: 12px 24px;
    }

    /* Centrage du bouton Actualiser */
    .simulation-actions {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
    }

    .simulation-actions .bz-primary-btn {
        margin: 0 auto;
    }

    /* Correction du bug d'affichage du sélecteur */
    .simulation-form,
    .loan-simulator-card {
        overflow: visible !important;
    }

    /* Espace supplémentaire pour le simulateur de prêt */
    .loan-simulator-section {
        padding: 60px 0 300px 0; /* Beaucoup plus d'espace en bas pour la liste déroulante */
    }

    /* Optimisation des performances - Réduction des animations au chargement */
    .fade-wrapper,
    .fade-top,
    .fade-bottom,
    .img-reveal {
        opacity: 1;
        transform: none;
        transition: none;
    }

    /* Animation différée pour améliorer les performances - EXCEPTION pour les cartes de la bannière */
    @media (prefers-reduced-motion: no-preference) {
        .fade-wrapper:not(.promo-section .fade-wrapper),
        .fade-top:not(.promo-section .fade-top),
        .fade-bottom:not(.promo-section .fade-bottom),
        .img-reveal:not(.promo-section .img-reveal) {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        
        .fade-wrapper.animate:not(.promo-section .fade-wrapper),
        .fade-top.animate:not(.promo-section .fade-top),
        .fade-bottom.animate:not(.promo-section .fade-bottom),
        .img-reveal.animate:not(.promo-section .img-reveal) {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Style de la carte verte */
    .promo-section .promo-item.credit-card-middle .overlay {
        background: linear-gradient(180deg, rgba(22, 101, 52, 0) 0%, var(--bz-color-theme-green) 58.48%);
    }

    .promo-section .promo-item.credit-card-middle .overlay-2 {
        background: rgba(22, 101, 52, 0.45);
        mix-blend-mode: normal;
    }

    .promo-section .promo-item.credit-card-middle .bz-primary-btn.red-btn {
        background-color: #EC281C;
        color: white;
    }

    .promo-section .promo-item.credit-card-middle {
        transform: translateY(-20px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    /* NOUVEAUX STYLES POUR LA CARTE "RÉSUMÉ DU PRÊT" */
    .result-card {
        background: linear-gradient(145deg, var(--bz-color-heading-secondary), #2c3e50);
        color: #ffffff;
        padding: 30px;
        border-radius: 15px;
        height: 100%;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        border-top: 4px solid var(--bz-color-theme-primary);
        display: flex;
        flex-direction: column;
    }

    .result-card h4 {
        color: #ffffff;
        margin-bottom: 25px;
        font-size: 22px;
        font-weight: 700;
        text-align: center;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
    }

    .result-card h4::before {
        content: '\f543';
        /* Icône calculatrice FontAwesome */
        font-family: "Font Awesome 6 Pro";
        font-weight: 900;
        margin-right: 10px;
        color: var(--bz-color-theme-secondary);
    }

    .result-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        padding: 12px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        font-size: 15px;
    }

    .result-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .result-item span {
        color: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
    }

    .result-item span::before {
        font-family: "Font Awesome 6 Pro";
        font-weight: 900;
        margin-right: 10px;
        width: 20px;
        text-align: center;
        color: var(--bz-color-theme-secondary);
        font-size: 14px;
    }

    .result-item:nth-child(2) span::before {
        content: '\f0d6';
    }

    /* Montant */
    .result-item:nth-child(3) span::before {
        content: '\f2f2';
    }

    /* Durée */
    .result-item:nth-child(4) span::before {
        content: '\f52c';
    }

    /* Taux */
    .result-item:nth-child(5) span::before {
        content: '\f783';
    }

    /* Première Échéance */
    .result-item:nth-child(6) span::before {
        content: '\f782';
    }

    /* Dernière Échéance */
    .result-item:nth-child(7) span::before {
        content: '\f651';
    }

    /* Total Intérêts */
    .result-item:nth-child(8) span::before {
        content: '\f09d';
    }

    /* Total à Rembourser */
    .result-item strong {
        font-size: 16px;
        font-weight: 700;
        color: var(--bz-color-theme-secondary);
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    }

    /* Styles pour le tableau d'amortissement */
    .amortization-table-wrapper {
        background: #ffffff;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .amortization-table-wrapper h4 {
        color: var(--bz-color-heading-secondary);
        font-weight: 700;
        margin-bottom: 25px;
        font-size: 22px;
        text-align: center;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 15px;
    }

    .amortization-table-wrapper .table-responsive {
        /* Hauteur libre - pas de restriction */
    }

    .amortization-table-wrapper .table {
        border-collapse: separate;
        border-spacing: 0 5px;
    }

    .amortization-table-wrapper .table thead th {
        background: var(--bz-color-theme-red);
        color: white;
        border: none;
        padding: 16px;
        font-size: 14px;
        font-weight: 600;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .amortization-table-wrapper .table thead th:first-child {
        border-radius: 8px 0 0 8px;
    }

    .amortization-table-wrapper .table thead th:last-child {
        border-radius: 0 8px 8px 0;
    }

    .amortization-table-wrapper .table tbody tr {
        background-color: #f8f9fa;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .amortization-table-wrapper .table tbody tr:hover {
        background-color: #ffffff;
        transform: scale(1.02);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        z-index: 2;
        position: relative;
    }

    .amortization-table-wrapper .table tbody td {
        padding: 15px;
        text-align: center;
        vertical-align: middle;
        font-size: 14px;
        color: #495057;
        border: none;
        border-bottom: 1px solid #e9ecef;
    }

    .amortization-table-wrapper .table tbody tr td:first-child {
        border-left: 1px solid #e9ecef;
        border-radius: 8px 0 0 8px;
        font-weight: 600;
        color: var(--bz-color-theme-red);
    }

    .amortization-table-wrapper .table tbody tr td:last-child {
        border-right: 1px solid #e9ecef;
        border-radius: 0 8px 8px 0;
        font-weight: 500;
    }

    .amortization-table-wrapper .table tbody tr:last-child td {
        border-bottom: 1px solid #e9ecef;
    }

    /* ===========================================
       SECTION GESTION DES PLAINTES
       =========================================== */
    .complaints-section {
        background: #f8f9fa;
        position: relative;
        overflow: hidden;
    }

    .complaints-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(236, 40, 28, 0.05) 0%, rgba(255, 255, 255, 0.1) 100%);
        z-index: 1;
    }

    .complaints-section .container-2 {
        position: relative;
        z-index: 2;
    }

    .complaints-features {
        list-style: none;
        padding: 0;
        margin: 0 0 40px 0;
    }

    .complaints-features li {
        display: flex;
        align-items: flex-start;
        margin-bottom: 25px;
        padding: 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .complaints-features li:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .feature-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #EC281C 0%, #d4241a 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
        flex-shrink: 0;
    }

    .feature-icon i {
        color: white;
        font-size: 20px;
    }

    .feature-text {
        text-align: left;
    }

    .feature-text h5 {
        color: #1a1a1a;
        font-size: 18px;
        font-weight: 600;
        margin: 0 0 8px 0;
    }

    .feature-text span {
        color: #6c757d;
        font-size: 14px;
        line-height: 1.6;
    }

    .complaints-cta {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .complaints-cta .bz-primary-btn {
        padding: 15px 30px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .complaints-cta .bz-primary-btn i {
        font-size: 18px;
    }

    .complaints-image {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    .complaints-image img {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }
    

    .complaints-stats {
        position: absolute;
        bottom: 20px;
        left: 20px;
        right: 20px;
        display: flex;
        gap: 20px;
        justify-content: space-between;
    }

    .stat-item {
        background: rgba(255, 255, 255, 0.95);
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        backdrop-filter: blur(10px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .stat-item h3 {
        color: #EC281C;
        font-size: 28px;
        font-weight: 700;
        margin: 0 0 5px 0;
    }

    .stat-item p {
        color: #6c757d;
        font-size: 14px;
        font-weight: 500;
        margin: 0;
    }

    /* Styles pour les textes spécifiques avec couleur verte */
    .green-text {
        color: var(--bz-color-theme-green) !important;
    }
        /* .complaints-cta {
            flex-direction: column;
        }

        .complaints-cta .bz-primary-btn {
            width: 100%;
            justify-content: center;
        } */

        .complaints-cta {
            margin-bottom: 30px;
        }

        .complaints-features li {
            display: flex;
            /* flex-direction: column; */
            align-items: center;
        }

        .feature-icon {
            margin-right: 0;
            margin-bottom: 15px;
        }

        .feature-text {
            margin-left: 15px;
        }
    
</style>
@endsection

@section('content')

<body>
    @include('includes.main.loading')
    @include('includes.main.popup')
    <!-- ./ preloader -->

    @include('includes.main.header')

    <!-- hero-section-3 -->
    <section class="hero-section-3">
        <!-- <div class="shapes">
            <div class="shape shape-1"><img src="{{ asset('assets/main/img/shapes/hero-bg-shape-2.png') }}" alt="forme"></div>
            <div class="shape shape-2"><img src="{{ asset('assets/main/img/shapes/hero-bg-shape-3.png') }}" alt="forme"></div>
        </div> -->
        <div class="swiper-container-wrapper swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide hero-slide-1" data-background="{{ asset('assets/images/cocec-accueil-banniere-principale.jpg') }}">
                    <div class="container-2">
                        <div class="hero-content hero-content-3">
                            <div class="section-heading mb-40 red-content">
                                <h4 class="sub-heading"><span class="left-shape"></span>Votre Partenaire Financier</h4>
                                <h2 class="section-title">Des solutions financières pour <br>votre avenir</h2>
                                <p class="text-justify">La COCEC vous accompagne avec des services d’épargne, de crédit et d’accompagnement personnalisé pour réaliser vos projets et assurer votre sécurité financière.</p>
                            </div>
                            <div class="hero-btn-wrap" style="--bz-color-theme-primary: #EC281C">
                                <a href="{{ route('contact') }}" class="bz-primary-btn primary">Nous contacter <i class="fa-regular fa-arrow-right"></i></a>
                                <a href="{{ route('product.index') }}" class="bz-primary-btn hero-btn">Nos produits</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide hero-slide-2" data-background="{{ asset('assets/images/cocec-accueil-banniere-credit-investissement.jpg') }}?v={{ time() }}">
                    <div class="container-2">
                        <div class="hero-content hero-content-3">
                            <div class="section-heading mb-40 red-content">
                                <h4 class="sub-heading"><span class="left-shape"></span>Crédit & Investissement</h4>
                                <h2 class="section-title">Financez vos projets les plus <br>ambitieux</h2>
                                <p class="text-justify">Que ce soit pour un projet immobilier, agricole ou entrepreneurial, nos solutions de crédit sont conçues pour vous donner les moyens de réussir.</p>
                            </div>
                            <div class="hero-btn-wrap" style="--bz-color-theme-primary: #EC281C">
                                <a href="{{ route('contact') }}" class="bz-primary-btn primary">Demander un crédit <i class="fa-regular fa-arrow-right"></i></a>
                                <a href="{{ route('product.index') }}" class="bz-primary-btn hero-btn">Explorer les options</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide hero-slide-3" data-background="{{ asset('assets/images/cocec-accueil-banniere-epargne-securisee.jpg') }}">
                    <div class="container-2">
                        <div class="hero-content hero-content-3">
                            <div class="section-heading mb-40 red-content">
                                <h4 class="sub-heading"><span class="left-shape"></span>Épargne Sécurisée</h4>
                                <h2 class="section-title">Construisez votre patrimoine <br>en toute confiance</h2>
                                <p class="text-justify">Découvrez nos comptes d'épargne flexibles et rentables pour préparer l'avenir, financer les études de vos enfants ou simplement vous constituer une réserve.</p>
                            </div>
                            <div class="hero-btn-wrap" style="--bz-color-theme-primary: #EC281C">
                                <a href="{{ route('contact') }}" class="bz-primary-btn primary">Ouvrir un compte <i class="fa-regular fa-arrow-right"></i></a>
                                <a href="{{ route('product.index') }}" class="bz-primary-btn hero-btn">Types de comptes</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </section>
    <!-- ./ hero-section -->

    <!-- promo-section -->
    <section class="promo-section pb-120">
        <div class="container-2">
            <div class="row gy-lg-0 gy-4 justify-content-center fade-wrapper">
                <div class="col-lg-4 col-md-6">
                    <div class="promo-item white-content">
                        <div class="bg-items">
                            <div class="bg-img"><img src="{{ asset('assets/images/cocec-service-epargne-securisee.jpg') }}" alt="Épargne" loading="lazy" decoding="async"></div>
                            <div class="overlay"></div>
                            <div class="overlay-2"></div>
                        </div>
                        <h3 class="title">Épargne sécurisée</h3>
                        <p class="text-justify">Épargnez en toute tranquillité avec nos comptes d’épargne flexibles, conçus pour répondre à vos besoins à court et long terme, avec des options comme l’épargne à vue ou à terme.</p>
                        <a href="{{route('product.index') }}" class="bz-primary-btn red-btn">En savoir plus <i class="fa-regular fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="promo-item white-content credit-card-middle">
                        <div class="bg-items">
                            <div class="bg-img"><img src="{{ asset('assets/images/cocec-service-credits-adaptes.jpg') }}" alt="Crédit" loading="lazy" decoding="async"></div>
                            <div class="overlay"></div>
                            <div class="overlay-2"></div>
                        </div>
                        <h3 class="title">Crédits adaptés</h3>
                        <p class="text-justify">Financez vos projets avec nos solutions de crédit sur mesure : prêts scolaires, commerciaux, ou agricoles pour soutenir vos ambitions personnelles et professionnelles.</p>
                        <a href="{{route('product.index') }}" class="bz-primary-btn red-btn">En savoir plus <i class="fa-regular fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="promo-item white-content">
                        <div class="bg-items">
                            <div class="bg-img"><img src="{{ asset('assets/images/cocec-service-accompagnement-financier.jpg') }}" alt="Services Financiers" loading="lazy" decoding="async"></div>
                            <div class="overlay"></div>
                            <div class="overlay-2"></div>
                        </div>
                        <h3 class="title">Accompagnement financier</h3>
                        <p class="text-justify">Bénéficiez de conseils personnalisés et de services comme le transfert d’argent pour gérer efficacement vos finances avec le soutien de la COCEC.</p>
                        <a href="{{route('product.index') }}" class="bz-primary-btn red-btn">En savoir plus <i class="fa-regular fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ./ promo-section -->

    <section class="about-section-3 pb-120">
        <div class="container-2">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-img-3 img-reveal">
                        <div class="img-overlay overlay-2"></div>
                        <img src="{{ asset('assets/images/cocec-directeur-general-kokou-gabiam.jpg') }}" alt="Directeur Général COCEC Kokou Gabiam" loading="lazy">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-content-3 fade-wrapper">
                        <div class="section-heading red-content mb-20">
                            <h4 class="sub-heading" data-text-animation="fade-in" data-duration="1.5"><span class="left-shape"></span>Mot du directeur général</h4>
                            <h2 class="section-title green-text" data-text-animation data-split="word" data-duration="1">Bâtir un avenir financier inclusif et moderne</h2>
                        </div>
                        <p class="fade-top text-justify">
                            Depuis 2001, la COCEC a placé l’amélioration de vos conditions de vie au centre de ses stratégies. Notre plus grande fierté réside dans les témoignages de ceux qui, partis de rien, subviennent aujourd’hui aux besoins de leur famille grâce à notre accompagnement.
                        </p>
                        <ul class="about-list-revisited fade-top">
                            <li>
                                <div class="list-icon-revisited"><i class="fas fa-rocket"></i></div>
                                <div class="list-text">
                                    <h5>Innovation & modernité</h5>
                                    <span>Nous intégrons les nouvelles technologies (Mobile Money, Web Banking) pour vous offrir des produits innovants à moindre coût.</span>
                                </div>
                            </li>
                            <li>
                                <div class="list-icon-revisited"><i class="fas fa-hands-helping"></i></div>
                                <div class="list-text">
                                    <h5>Confiance & partenariat</h5>
                                    <span>Avec la confiance renouvelée de nos clients et partenaires, et avec Dieu à nos côtés, nous accomplirons des exploits.</span>
                                </div>
                            </li>
                        </ul>
                        <hr class="section-divider fade-top">
                        <div class="director-cta-block fade-top">
                            <div class="director-signature-block">
                                <strong class="green-text">M. Kokou GABIAM</strong>
                                <span>Directeur général</span>
                            </div>
                            <div class="about-btn">
                                <a href="{{ route('about') }}" class="bz-primary-btn red-btn">En savoir plus <i class="fa-regular fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ./ about-section -->

    <section class="service-section-3 pt-120 pb-120" data-background="{{ asset('assets/images/shapes/service-bg-shape.png') }}">
        <div class="container-2">
            <div class="section-heading text-center red-content">
                <h4 class="sub-heading"><span class="left-shape"></span>Nos produits phares</h4>
                <h2 class="section-title mb-0">Des solutions financières conçues pour vous</h2>
            </div>
            <div class="row gy-lg-0 gy-4 justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="service-item-3">
                        <div class="service-thumb">
                            <img class="img-item" src="{{ asset('assets/images/cocec-produit-epargne-compte.jpg') }}" alt="Compte d'épargne COCEC" loading="lazy">
                        </div>
                        <div class="service-content">
                            <h3 class="title"><a href="#">Épargne</a></h3>
                            <p class="text-justify">Faites fructifier votre argent en toute sécurité et préparez sereinement votre avenir grâce à nos solutions d'épargne flexibles.</p>
                            <a href="{{ route('product.index') }}" class="bz-primary-btn red-btn">Découvrir <i class="fa-regular fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item-3">
                        <div class="service-thumb">
                            <img class="img-item" src="{{ asset('assets/images/cocec-produit-credits-financements.jpg') }}" alt="Crédits et financements COCEC" loading="lazy">
                        </div>
                        <div class="service-content">
                            <h3 class="title"><a href="#">Crédits & financements</a></h3>
                            <p class="text-justify">Donnez vie à vos projets personnels ou professionnels avec nos solutions de crédit sur-mesure et à des conditions avantageuses.</p>
                            <a href="{{ route('product.index') }}" class="bz-primary-btn red-btn">Découvrir <i class="fa-regular fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item-3">
                        <div class="service-thumb">
                            <img class="img-item" src="{{ asset('assets/images/cocec-produit-tontine-traditionnelle.jpg') }}" alt="Tontine traditionnelle COCEC" loading="lazy">
                        </div>
                        <div class="service-content">
                            <h3 class="title"><a href="#">Tontine</a></h3>
                            <p class="text-justify">Un système d'épargne rotatif et solidaire pour atteindre vos objectifs financiers en groupe. Découvrez nos solutions de tontine traditionnelle et moderne.</p>
                            <a href="{{ route('product.index') }}" class="bz-primary-btn red-btn">Découvrir <i class="fa-regular fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ./ service-section -->

    <section class="cta-section cta-2 pt-120 pb-120">
        <div class="bg-img"><img src="{{ asset('assets/images/cocec-gamme-complete-produits-financiers.jpg') }}" alt="Gamme complète de produits financiers COCEC"></div>
        <div class="overlay"></div>
        <div class="overlay-2"></div>
        <div class="container-2">
            <div class="cta-wrap">
                <div class="cta-content">
                    <div class="section-heading mb-0 white-content">
                        <h4 class="sub-heading">
                            <span class="left-shape"></span>Une gamme complète de produits
                        </h4>
                        <h2 class="section-title mb-0">
                            De l'épargne à la concrétisation de vos projets, nous avons la solution financière qu'il vous faut.</h2>
                    </div>
                </div>
                <div class="cta-btn-wrap">
                    <a href="{{-- route('produits.index') --}}" class="bz-primary-btn red-btn">Voir tous les produits</a>
                </div>
            </div>
        </div>
    </section>
    <!-- ./ cta-section -->

    <!-- Simulateur de Prêt Section -->
    <section class="loan-simulator-section pt-120">
        <div class="container-2">
            <div class="section-heading text-center red-content mb-60">
                <h4 class="sub-heading" data-text-animation="fade-in" data-duration="1.5">
                    <span class="left-shape"></span>Simulateur de prêt
                </h4>
                <h2 class="section-title green-text mb-0" data-text-animation data-split="word" data-duration="1">
                    Calculez votre échéance de prêt
                </h2>
                <p class="mt-20">Simulez votre prêt en quelques clics et obtenez un tableau d'amortissement détaillé</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="loan-simulator-card">
                        <div class="simulator-header">
                            <h3><i class="fas fa-calculator"></i> Simulateur de prêt COCEC</h3>
                            <p>Entrez vos informations pour calculer votre échéance et voir le tableau d'amortissement</p>
                        </div>

                        <!-- Formulaire de simulation -->
                        <div class="simulation-form mb-4">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="loan-type" class="form-label">Type de prêt</label>
                                    <select class="form-select" id="loan-type">
                                        <option value="" selected disabled>Sélectionner le type</option>
                                        <option value="ORDINAIRE">CREDIT ORDINAIRE</option>
                                        <option value="MARCHE">FINANCEMENT DE MARCHE</option>
                                        <option value="SCOLAIRE">CRÉDIT SPECIAL R (PRÊT SCOLAIRE)</option>
                                        <option value="COMMERCE">CREDIT COMMERCE & AUTRES AGR</option>
                                        <option value="IMMOBILIER">CREDIT IMMOBILIER</option>
                                        <option value="ENERGIE">CRÉDIT ENERGIE RENOUVELABLE</option>
                                        <option value="FONCIER">CREDIT OBTENTION DE TITRE FONCIER</option>
                                        <option value="TONTINE">CREDIT TONTINE</option>
                                        <option value="SALAIRE">CREDIT SUR VIREMENT SALAIRE</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="loan-amount" class="form-label">Montant (FCFA)</label>
                                    <input type="number" class="form-control" id="loan-amount" placeholder="Ex: 1000000" min="0" step="10000">
                                </div>
                                <div class="col-md-3">
                                    <label for="loan-duration" class="form-label">Durée (mois)</label>
                                    <input type="number" class="form-control" id="loan-duration" placeholder="Ex: 12" min="1" step="1">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="button" class="bz-primary-btn red-btn w-100" id="calculate-loan">
                                        <span class="btn-text">Calculer</span>
                                        <span class="btn-loading" style="display: none;">
                                            <i class="fa-solid fa-spinner fa-spin"></i> Calcul...
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Loading -->
                        <div id="loan-loading" class="text-center py-5" style="display: none;">
                            <div class="loading-spinner">
                                <div class="spinner"></div>
                            </div>
                            <p class="mt-3">Calcul en cours...</p>
                        </div>

                        <!-- Résultats -->
                        <div id="loan-results" class="loan-results" style="display: none;">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="result-card">
                                        <h4>Résumé du Prêt</h4>
                                        <div class="result-item">
                                            <span>Montant emprunté</span>
                                            <strong id="borrowed-amount">0 FCFA</strong>
                                        </div>
                                        <div class="result-item">
                                            <span>Durée</span>
                                            <strong id="loan-period">0 mois</strong>
                                        </div>
                                        <div class="result-item">
                                            <span>Taux Annuel</span>
                                            <strong id="interest-rate">0%</strong>
                                        </div>
                                        <div class="result-item">
                                            <span>Première Échéance</span>
                                            <strong id="first-payment">0 FCFA</strong>
                                        </div>
                                        <div class="result-item">
                                            <span>Dernière Échéance</span>
                                            <strong id="last-payment">0 FCFA</strong>
                                        </div>
                                        <div class="result-item">
                                            <span>Total des Intérêts</span>
                                            <strong id="total-interest">0 FCFA</strong>
                                        </div>
                                        <div class="result-item">
                                            <span>Total à Rembourser</span>
                                            <strong id="total-amount">0 FCFA</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="amortization-table-wrapper">
                                        <h4>Tableau d'Amortissement</h4>
                                        <div class="table-responsive">
                                            <table class="table" id="amortization-table">
                                                <thead>
                                                    <tr>
                                                        <th>N°</th>
                                                        <th>Capital</th>
                                                        <th>Intérêts</th>
                                                        <th>Mensualité</th>
                                                        <th>Capital Restant</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="amortization-body">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="simulation-actions text-center mt-4">
                            <button type="button" class="bz-primary-btn hero-btn" id="refresh-loan">
                                <i class="fas fa-redo"></i> Actualiser
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- SECTION STATISTIQUES - VERSION OPTIMISÉE -->
    <section class="strength-section pt-120 pb-120">
        <div class="bg-item">
            <div class="bg-img" data-background="{{ asset('assets/images/cocec-statistiques-force-chiffres.jpg') }}"></div>
            <div class="overlay"></div>
            <div class="shapes">
                <div class="shape">
                    <img src="{{ asset('assets/images/shapes/strength-shape-1.png') }}" alt="img">
                </div>
                <div class="shape-2"></div>
            </div>
        </div>
        <div class="container-2">
            <div class="row strength-wrap fade-wrapper">
                <div class="col-lg-6 col-md-12">
                    <div class="strength-content">
                        <div class="section-heading mb-20 white-content red-content">
                            <h4 class="sub-heading" data-text-animation="fade-in" data-duration="1.5">
                                <span class="left-shape"></span>Notre force en chiffres
                            </h4>
                            <h2 class="section-title mb-0" data-text-animation data-split="word" data-duration="1">
                                Plus qu'une institution, <br>une communauté qui prospère
                            </h2>
                        </div>
                        <p class="fade-top text-justify mb-40">
                            Depuis plus de 20 ans, notre force réside dans la confiance de nos membres et notre engagement indéfectible pour leur réussite financière.
                        </p>
                        <div class="strength-items-grid">
                            <div class="strength-item fade-top">
                                <div class="strength-icon"><i class="fas fa-heart"></i></div>
                                <div class="strength-content">
                                    <h3 class="title"><span class="odometer" data-count="95">0</span>%</h3>
                                    <p>Taux de satisfaction</p>
                                </div>
                            </div>
                            <div class="strength-item fade-top">
                                <div class="strength-icon"><i class="fas fa-users"></i></div>
                                <div class="strength-content">
                                    <h3 class="title">+<span class="odometer" data-count="50000">0</span></h3>
                                    <p>Membres accompagnés</p>
                                </div>
                            </div>
                            <div class="strength-item fade-top">
                                <div class="strength-icon"><i class="fas fa-chart-line"></i></div>
                                <div class="strength-content">
                                    <h3 class="title"><span class="odometer" data-count="20">0</span>+</h3>
                                    <p>Années d'expérience</p>
                                </div>
                            </div>
                            <div class="strength-item fade-top">
                                <div class="strength-icon"><i class="fas fa-handshake"></i></div>
                                <div class="strength-content">
                                    <h3 class="title"><span class="odometer" data-count="1000">0</span>+</h3>
                                    <p>Projets financés</p>
                                </div>
                            </div>
                            <div class="strength-item fade-top">
                                <div class="strength-icon"><i class="fas fa-eye"></i></div>
                                <div class="strength-content">
                                    <h3 class="title">+<span class="odometer" data-count="{{ $total }}">0</span></h3>
                                    <p>Visiteurs totaux</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="strength-man">
                        <img class="men" src="{{ asset('assets/images/cocec-equipe-professionnelle.jpg') }}" alt="Équipe professionnelle COCEC">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ./ process-section -->

    <section class="home-agencies-section">
        <div class="container">
            <div class="section-heading text-center">
                <h4 class="sub-heading"><span class="left-shape"></span>Notre réseau</h4>
                <h2 class="green-text">Trouvez un point de service proche de vous</h2>
                <p>Avec un réseau en pleine expansion, la COCEC est toujours à vos côtés. Découvrez nos agences principales.</p>
            </div>
            <div class="agency-grid">
                @foreach ($agencies as $agency)
                <a href="{{ route('agencies') }}" class="mini-agency-card">
                    <div class="card-icon-wrapper">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="card-status">
                        <?php
                        $currentHour = now()->hour;
                        $isOpen = ($currentHour >= 9 && $currentHour < 17);
                        $status = $isOpen ? 'Ouvert' : 'Fermé';
                        ?>
                        <span class="status-dot {{ $isOpen ? 'open' : 'closed' }}"></span> {{ $status }}
                    </div>
                    <h3 class="card-title">{{ $agency->name }}</h3>
                    <p class="card-address">{{ $agency->address }}</p>
                    <span class="card-arrow"><i class="fas fa-arrow-right"></i></span>
                </a>
                @endforeach
            </div>
            <div class="text-center" style="margin-top: 50px;">
                <a href="{{ route('agencies') }}" class="btn-see-all">
                    Voir toutes nos agences <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
                </a>
            </div>
        </div>
    </section>

    <section class="cta-section-3">
        <div class="container-2">
            <div class="cta-wrap-3">
                <div class="shapes">
                    <div class="shape-1"><img src="{{ asset('assets/images/shapes/cta-shape-1.png') }}" alt="cta"></div>
                    <div class="shape-2"><img src="{{ asset('assets/images/shapes/cta-shape-2.png') }}" alt="cta"></div>
                </div>
                <div class="cta-mask-img">
                    <div class="overlay"></div>
                    <img src="{{ asset('assets/images/cocec-rejoindre-equipe-offres-emploi.jpg') }}" alt="Rejoindre l'équipe COCEC - Offres d'emploi">
                </div>
                <h3 class="title">Rejoignez notre équipe</h3>
                <p>Nous sommes toujours à la recherche de professionnels talentueux et passionnés, <br> désireux de contribuer à notre mission d'inclusion financière.</p>
                <div style="margin-top: 30px;">
                    <a href="{{ route('career') }}" class="bz-primary-btn red-btn">Voir les offres d'emploi <i class="fa-regular fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>
    <!-- ./ agencies-section -->

    <section class="testimonial-section-3 overflow-hidden pb-120" data-background="{{ URL::asset('assets/images/shapes/testi-bg-2.png') }}">
        <div class="container-2">
            <div class="section-heading text-center red-content">
                <h4 class="sub-heading" data-text-animation="fade-in" data-duration="1.5"><span class="left-shape"></span>Témoignages de nos membres</h4>
                <h2 class="section-title mb-0" data-text-animation data-split="word" data-duration="1">Leurs mots, notre plus grande fierté</h2>
            </div>
            <div class="testi-carousel-2 swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="testi-item-2">
                            <div class="testi-top no-image">
                                <div class="testi-author">
                                    <h3 class="name">Mme Akouvi MENSAH <span>Enseignante & mère de famille</span></h3>
                                </div>
                                <ul class="review">
                                    <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                    <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                    <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                    <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                    <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                </ul>
                            </div>
                            <p>Grâce au compte épargne projet de la COCEC, j'ai pu financer les études supérieures de mon fils sans stress. Leur accompagnement a été précieux à chaque étape.</p>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="testi-item-2">
                            <div class="testi-top no-image">
                                <div class="testi-author">
                                    <h3 class="name">M. Koffi SOSSOU <span>Commerçant au grand marché</span></h3>
                                </div>
                                <ul class="review">
                                    <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                    <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                    <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                    <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                    <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                </ul>
                            </div>
                            <p>Obtenir un crédit pour développer mon commerce a été simple et rapide. L'équipe de la COCEC a vraiment compris mes besoins et m'a fait confiance.</p>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="testi-item-2">
                            <div class="testi-top no-image">
                                <div class="testi-author">
                                    <h3 class="name">Mlle Fati ALI <span>Jeune entrepreneure</span></h3>
                                </div>
                                <ul class="review">
                                    <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                    <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                    <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                    <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                    <li><i class="fa-sharp fa-solid fa-star"></i></li>
                                </ul>
                            </div>
                            <p>Avec finance digitale, je gère mes finances directement depuis ma boutique. C'est un gain de temps incroyable qui me permet de me concentrer sur mon business.</p>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination" style="--bz-color-theme-primary: #EC281C"></div>
            </div>
        </div>
    </section>
    <!-- ./ testimonial-section -->

    <section class="blog-section-3 pt-120 pb-120">
        <div class="container-2">
            <div class="blog-top heading-space">
                <div class="section-heading red-content mb-0">
                    <h4 class="sub-heading" data-text-animation="fade-in" data-duration="1.5"><span class="left-shape"></span>Nos actualités</h4>
                    <h2 class="section-title green-text mb-0" data-text-animation data-split="word" data-duration="1">L'actualité financière décryptée <br>par nos experts</h2>
                </div>
                <a href="{{ route('blogs') }}" class="bz-primary-btn red-btn">Voir tous les posts <i class="fa-regular fa-arrow-right"></i></a>
            </div>
            <div class="row gy-lg-0 gy-4 fade-wrapper">
                @if($blogs->count() > 0)
                @foreach ($blogs as $blog)
                <div class="col-md-6">
                    <div class="post-card-3 fade-top" style="--bz-color-theme-primary: #EC281C">
                        <div class="post-thumb img-reveal">
                            <div class="img-overlay"></div>
                            <img src="@image($blog->image, 'assets/images/blog.jpg')" alt="{{ $blog->title }}">
                        </div>
                        <div class="post-content">
                            <ul class="post-meta">
                                <li><i class="fa-regular fa-calendar"></i>{{ $blog->created_at->translatedFormat('d F Y') }}</li>
                                <li><i class="fa-regular fa-user"></i>{{ $blog->author ?? 'Admin' }}</li>
                            </ul>
                            <h3 class="title"><a href="{{ route('blogs.show', $blog->id) }}">{{ $blog->title }}</a></h3>
                            <a href="{{ route('blogs.show', $blog->id) }}" class="blog-btn"><i class="fa-regular fa-arrow-right"></i>Lire la suite</a>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="col-12">
                    <div class="text-center py-5">
                        <div class="empty-blog-message">
                            <i class="fa-regular fa-newspaper" style="font-size: 4rem; color: #EC281C; margin-bottom: 1rem;"></i>
                            <h3 class="mb-3">Aucun article disponible</h3>
                            <p class="text-muted mb-4">Nous travaillons actuellement sur de nouveaux contenus. Revenez bientôt pour découvrir nos derniers articles !</p>
                            <a href="{{ route('blogs') }}" class="bz-primary-btn red-btn">Voir tous les posts <i class="fa-regular fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
    <!-- ./ blog-section -->

    <div class="sponsor-section pb-120">
        <div class="container">
            <h3 class="sponsor-text-wrap">
                <span></span>
                <span class="sponsor-text">Nos partenaires institutionnels & techniques nous font confiance</span>
                <span></span>
            </h3>
            <div class="sponsor-carousel swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="sponsor-item text-center"><a href="#"><img src="{{ asset('assets/images/fnfi.png') }}" alt="sponsor"></a></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="sponsor-item text-center"><a href="#"><img src="{{ asset('assets/images/ada.jpg') }}" alt="sponsor"></a></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="sponsor-item text-center"><a href="#"><img src="{{ asset('assets/images/apsfd.png') }}" alt="sponsor"></a></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="sponsor-item text-center"><a href="#"><img src="{{ asset('assets/images/btci.png') }}" alt="sponsor"></a></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="sponsor-item text-center"><a href="#"><img src="{{ asset('assets/images/ecobank.jpg') }}" alt="sponsor"></a></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="sponsor-item text-center"><a href="#"><img src="{{ asset('assets/images/mainnetwork.jpg') }}" alt="sponsor"></a></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="sponsor-item text-center"><a href="#"><img src="{{ asset('assets/images/nsia.png') }}" alt="sponsor"></a></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="sponsor-item text-center"><a href="#"><img src="{{ asset('assets/images/orabank.jpg') }}" alt="sponsor"></a></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="sponsor-item text-center"><a href="#"><img src="{{ asset('assets/images/poste.jpg') }}" alt="sponsor"></a></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="sponsor-item text-center"><a href="#"><img src="{{ asset('assets/images/sunu.jpg') }}" alt="sponsor"></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Gestion des Plaintes -->
    <section class="complaints-section pt-120 pb-120" data-background="{{ asset('assets/images/shapes/complaints-bg-shape.png') }}">
        <div class="container-2">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="complaints-content fade-wrapper">
                        <div class="section-heading red-content mb-20">
                            <h4 class="sub-heading" data-text-animation="fade-in" data-duration="1.5">
                                <span class="left-shape"></span>Votre voix compte
                            </h4>
                            <h2 class="section-title" data-text-animation data-split="word" data-duration="1">
                                Gestion des plaintes & réclamations
                            </h2>
                        </div>
                        <p class="fade-top text-justify mb-30">
                            Votre satisfaction est notre priorité. Si vous rencontrez un problème ou souhaitez faire une réclamation, 
                            notre équipe dédiée est là pour vous écouter et vous accompagner dans la résolution de votre dossier.
                        </p>
                        <ul class="complaints-features fade-top">
                            <li>
                                <div class="feature-icon"><i class="fas fa-headset"></i></div>
                                <div class="feature-text">
                                    <h5>Écoute active</h5>
                                    <span>Notre équipe vous écoute attentivement et traite chaque plainte avec sérieux.</span>
                                </div>
                            </li>
                            <li>
                                <div class="feature-icon"><i class="fas fa-clock"></i></div>
                                <div class="feature-text">
                                    <h5>Réponse rapide</h5>
                                    <span>Nous nous engageons à vous répondre dans les plus brefs délais.</span>
                                </div>
                            </li>
                            <li>
                                <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                                <div class="feature-text">
                                    <h5>Confidentialité</h5>
                                    <span>Vos informations sont protégées et traitées en toute confidentialité.</span>
                                </div>
                            </li>
                        </ul>
                        <div class="complaints-cta fade-top">
                            <a href="{{ route('complaint') }}" class="bz-primary-btn red-btn">
                                <i class="fas fa-file-alt"></i> Déposer une plainte
                            </a>
                            <a href="tel:8989" class="bz-primary-btn hero-btn">
                                <i class="fas fa-phone"></i> Appeler le 8989
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="complaints-image img-reveal">
                        <div class="img-overlay overlay-2"></div>
                        <img src="{{ asset('assets/images/cocec-produit-tontine-traditionnelle.jpg') }}" alt="Gestion des Plaintes COCEC" loading="lazy">
                        <div class="complaints-stats">
                            <div class="stat-item">
                                <h3><span class="odometer" data-count="95">0</span>%</h3>
                                <p>Taux de résolution</p>
                            </div>
                            <div class="stat-item">
                                <h3><span class="odometer" data-count="24">0</span>h</h3>
                                <p>Délai de réponse</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ./ complaints-section -->

    @include('includes.main.scroll')
    @include('includes.main.footer')
</body>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Initialisation de tous les sliders Swiper de la page ---

    // 1. Slider du HÉROS (bannière principale)
    new Swiper('.hero-section-3 .swiper-container-wrapper', {
        loop: true,
        effect: 'fade',
        fadeEffect: { crossFade: true },
        autoplay: { delay: 7000, disableOnInteraction: false },
        navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
        pagination: { el: '.swiper-pagination', clickable: true },
    });

    // 2. Slider des TÉMOIGNAGES
    new Swiper('.testi-carousel-2', {
        loop: true,
        spaceBetween: 30,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            // Pour mobile
            320: { slidesPerView: 1 },
            // Pour tablettes
            768: { slidesPerView: 2 },
            // Pour ordinateurs
            992: { slidesPerView: 2 }
        }
    });

    // 3. Slider des PARTENAIRES (Sponsors)
    new Swiper('.sponsor-carousel', {
        loop: true,
        speed: 1000,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        slidesPerView: 2,
        spaceBetween: 30,
        breakpoints: {
            768: { slidesPerView: 4, spaceBetween: 40 },
            992: { slidesPerView: 5, spaceBetween: 50 }
        }
    });

    // --- Animation des compteurs (Odometer) ---
    const counters = document.querySelectorAll('.odometer');
    if ('IntersectionObserver' in window) {
        const counterObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const odometer = entry.target;
                    const target = parseInt(odometer.getAttribute('data-count'), 10);
                    odometer.innerHTML = target; // Remplacé par une animation simple pour éviter les dépendances lourdes
                    observer.unobserve(odometer);
                }
            });
        }, { threshold: 0.1 });
        counters.forEach(counter => counterObserver.observe(counter));
    }
    
    // --- LOGIQUE DU SIMULATEUR DE PRÊT ---
    const loanSimulatorSection = document.querySelector('.loan-simulator-section');
    if (loanSimulatorSection) {
    
        const loanRates = {
            'ORDINAIRE': 14.0, 'MARCHE': 14.0, 'SCOLAIRE': 0.0, 'COMMERCE': 14.0,
            'IMMOBILIER': 14.0, 'ENERGIE': 0.0, 'FONCIER': 14.0, 'TONTINE': 14.0, 'SALAIRE': 13.0
        };

        const loanTypeEl = document.getElementById('loan-type');
        const loanAmountEl = document.getElementById('loan-amount');
        const loanDurationEl = document.getElementById('loan-duration');
        const calculateBtn = document.getElementById('calculate-loan');
        const refreshBtn = document.getElementById('refresh-loan');
        const loadingEl = document.getElementById('loan-loading');
        const resultsEl = document.getElementById('loan-results');
        
        const formatCurrency = (amount) => {
            // Formatage exact comme dans les spécimens COCEC
            return Math.round(amount).toLocaleString('fr-FR') + ' FCFA';
        };

        const calculateLoan = () => {
            let hasError = false;
            [loanTypeEl, loanAmountEl, loanDurationEl].forEach(el => {
                el.classList.remove('is-invalid');
                if (!el.value) {
                    el.classList.add('is-invalid');
                    hasError = true;
                }
            });

            if (hasError) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'warning', title: 'Champs manquants', text: 'Veuillez remplir tous les champs correctement.', confirmButtonColor: '#EC281C' });
                }
                return;
            }

            const type = loanTypeEl.value;
            const principal = parseFloat(loanAmountEl.value);
            const duration = parseInt(loanDurationEl.value);
            const annualRate = loanRates[type];

            loadingEl.style.display = 'block';
            resultsEl.style.display = 'none';
            calculateBtn.disabled = true;
            calculateBtn.querySelector('.btn-text').style.display = 'none';
            calculateBtn.querySelector('.btn-loading').style.display = 'inline-block';

            setTimeout(() => {
                // Calcul semi-dégressif : Capital fixe + Intérêts dégressifs
                const capitalPerMonth = Math.floor(principal / duration); // Capital fixe par mois
                const lastMonthCapital = principal - (capitalPerMonth * (duration - 1)); // Dernière échéance
                let remainingCapital = principal;
                let totalInterestPaid = 0;
                
                const amortizationTable = [];
                for (let i = 1; i <= duration; i++) {
                    // Intérêts calculés sur le capital restant dû
                    const interestRaw = remainingCapital * (annualRate / 100 / 12);
                    // Arrondi standard (0.5 vers le haut)
                    const interestForMonth = Math.round(interestRaw);
                    totalInterestPaid += interestForMonth;
                    
                    // Capital fixe sauf pour la dernière échéance
                    let capitalToPay = (i === duration) ? lastMonthCapital : capitalPerMonth;
                    const monthlyPayment = capitalToPay + interestForMonth;
                    remainingCapital -= capitalToPay;

                    amortizationTable.push({
                        month: i,
                        capital: capitalToPay,
                        interest: interestForMonth,
                        payment: monthlyPayment,
                        remaining: Math.max(0, remainingCapital)
                    });
                }
                
                const firstPayment = amortizationTable.length > 0 ? amortizationTable[0].payment : 0;
                const lastPayment = amortizationTable.length > 0 ? amortizationTable[amortizationTable.length - 1].payment : 0;

                document.getElementById('borrowed-amount').textContent = formatCurrency(principal);
                document.getElementById('loan-period').textContent = `${duration} mois`;
                document.getElementById('interest-rate').textContent = `${annualRate}%`;
                document.getElementById('first-payment').textContent = formatCurrency(firstPayment);
                document.getElementById('last-payment').textContent = formatCurrency(lastPayment);
                document.getElementById('total-interest').textContent = formatCurrency(totalInterestPaid);
                document.getElementById('total-amount').textContent = formatCurrency(principal + totalInterestPaid);
                
                const tbody = document.getElementById('amortization-body');
                tbody.innerHTML = '';
                amortizationTable.forEach(row => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${row.month}</td>
                        <td>${formatCurrency(row.capital)}</td>
                        <td>${formatCurrency(row.interest)}</td>
                        <td>${formatCurrency(row.payment)}</td>
                        <td>${formatCurrency(row.remaining)}</td>
                    `;
                    tbody.appendChild(tr);
                });

                loadingEl.style.display = 'none';
                resultsEl.style.display = 'block';
                calculateBtn.disabled = false;
                calculateBtn.querySelector('.btn-text').style.display = 'inline-block';
                calculateBtn.querySelector('.btn-loading').style.display = 'none';
                resultsEl.scrollIntoView({ behavior: 'smooth' });
            }, 1000);
        };
        
        const refreshLoanSimulator = () => {
            loanTypeEl.selectedIndex = 0;
            loanAmountEl.value = '';
            loanDurationEl.value = '';
            [loanTypeEl, loanAmountEl, loanDurationEl].forEach(el => el.classList.remove('is-invalid'));
            resultsEl.style.display = 'none';
            document.querySelector('.loan-simulator-section').scrollIntoView({ behavior: 'smooth' });
        };

        calculateBtn.addEventListener('click', calculateLoan);
        refreshBtn.addEventListener('click', refreshLoanSimulator);
    }

    // Optimisation des performances - Chargement différé des animations
    function initAnimations() {
        // Attendre que le DOM soit prêt
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initAnimations);
            return;
        }

        // Délai pour laisser le contenu se charger
        setTimeout(() => {
            // Animation des éléments avec Intersection Observer - EXCEPTION pour les cartes de la bannière
            const animatedElements = document.querySelectorAll('.fade-wrapper:not(.promo-section .fade-wrapper), .fade-top:not(.promo-section .fade-top), .fade-bottom:not(.promo-section .fade-bottom), .img-reveal:not(.promo-section .img-reveal)');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            animatedElements.forEach(el => {
                observer.observe(el);
            });
        }, 500);
    }

    // Initialiser les animations
    initAnimations();
});
</script>
@endsection