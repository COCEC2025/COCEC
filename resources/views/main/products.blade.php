@extends('layout.main')

@section('css')
<style>
    /* ------------------------------------------- */
    /*    STYLE PRO DE LA PAGE PRODUITS - V3.0     */
    /* ------------------------------------------- */

    /* ----- Section Générale (inchangé) ----- */
    .products-page-section {
        padding: 100px 0;
        background-color: #f7f8fc;
        font-family: 'Poppins', sans-serif;
    }

    .hero-section {
        background: #FFFFFF;
        padding-bottom: 80px;
    }

    .section-heading h2 {
        font-weight: 700;
        color: #000000;
    }

    .section-heading p.lead {
        color: #555;
        line-height: 1.7;
        max-width: 800px;
        margin: 15px auto 0;
    }

    /* ----- Onglets "Pill" (inchangé) ----- */
    .product-tabs-nav {
        display: inline-flex;
        background-color: #e9ecef;
        border-radius: 50px;
        padding: 6px;
        margin-bottom: 50px;
        border-bottom: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .product-tabs-nav .nav-item .nav-link {
        color: #343a40;
        font-weight: 600;
        font-size: 1rem;
        border: none;
        border-radius: 50px;
        padding: 10px 25px;
        background-color: transparent;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    .product-tabs-nav .nav-item .nav-link:hover {
        background-color: rgba(0, 0, 0, 0.05);
        color: #000000;
    }

    .product-tabs-nav .nav-item .nav-link.active {
        color: #FFFFFF;
        background-color: #EC281C;
        box-shadow: 0 4px 12px rgba(236, 40, 28, 0.3);
    }

    /* ----- Animation de fondu (inchangé) ----- */
    .tab-content .tab-pane {
        animation: fadeIn 0.6s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(15px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ----- NOUVEAU DESIGN "PRO" DES CARTES PRODUITS ----- */
    .product-card {
        background: #FFFFFF;
        border: 1px solid #e9ecef;
        /* Bordure subtile par défaut */
        border-radius: 12px;
        text-align: left;
        /* Texte aligné à gauche pour un look plus pro */
        transition: all 0.4s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        /* Important pour les bordures */
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(40, 40, 90, 0.12);
        border-color: #EC281C;
        /* La bordure devient rouge au survol */
    }

    .product-card-header {
        padding: 30px;
        background-color: #f8f9fa;
        /* Léger contraste pour l'en-tête */
        border-bottom: 1px solid #e9ecef;
    }

    .product-card-icon {
        font-size: 3rem;
        /* Icône plus grande */
        color: #adb5bd;
        /* Couleur grise et neutre par défaut */
        transition: all 0.4s ease;
    }

    .product-card:hover .product-card-icon {
        color: #EC281C;
        /* L'icône devient rouge au survol */
        transform: scale(1.1);
    }

    .product-card-body {
        padding: 30px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        /* Permet au corps de prendre tout l'espace restant */
    }

    .product-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 15px;
    }

    .product-description {
        color: #555;
        line-height: 1.7;
        flex-grow: 1;
        /* Pousse le lien vers le bas */
    }

    .details-link {
        margin-top: 25px;
        font-weight: 600;
        color: #EC281C;
        text-decoration: none;
        display: inline-block;
        /* Nécessaire pour le pseudo-élément */
        position: relative;
    }

    .details-link::after {
        /* Soulignement animé */
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: -4px;
        left: 0;
        background-color: #FFCC00;
        transition: width 0.3s ease-out;
    }

    .product-card:hover .details-link::after {
        width: 100%;
        /* L'animation se déclenche au survol de la CARTE */
    }

    .details-link i {
        margin-left: 5px;
        transition: transform 0.3s ease;
    }

    .details-link:hover i {
        /* Animation de la flèche au survol du LIEN */
        transform: translateX(5px);
    }

    /* ----- Fenêtre Modale (inchangé) ----- */
    .modal-header {
        border-bottom: 1px solid #f0f0f0;
    }

    .modal-title {
        font-weight: 600;
    }

    .modal-body .modal-icon {
        font-size: 2rem;
        color: #EC281C;
        margin-right: 15px;
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
                <h1 class="title-pro">Nos Produits & Services</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb-pro">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Accueil</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Produits</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <!-- ./ page-header -->

    <br><br>

    <section class="hero-section text-center">
        <br><br>
        <div class="container">
            <div class="section-heading">
                <h4 class="sub-heading"><span class="left-shape"></span>Nos Produits & Services</h4>
                <h2 class="section-title">Des solutions financières conçues pour vous.</h2>
                <p class="lead">Découvrez notre gamme complète de produits d'épargne, de crédit et de services diversifiés, tous créés pour répondre à vos besoins spécifiques, soutenir vos projets et assurer votre avenir financier.</p>
            </div>
        </div>
    </section>

    {{-- Section principale des produits avec onglets --}}
    <section class="products-page-section">
        <div class="container">
            <div class="d-flex justify-content-center">
                <!-- Navigation par onglets -->
                <ul class="nav nav-pills product-tabs-nav" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation"><button class="nav-link active" id="epargne-tab" data-bs-toggle="tab" data-bs-target="#epargne" type="button" role="tab">Produits d'Épargne</button></li>
                    <li class="nav-item" role="presentation"><button class="nav-link" id="credit-tab" data-bs-toggle="tab" data-bs-target="#credit" type="button" role="tab">Produits de Crédit</button></li>
                    <li class="nav-item" role="presentation"><button class="nav-link" id="services-tab" data-bs-toggle="tab" data-bs-target="#services" type="button" role="tab">Services Divers</button></li>
                </ul>
            </div>

            <!-- Contenu des onglets -->
            <div class="tab-content pt-4" id="productTabsContent">

                <!-- ======================= Onglet Épargne ======================= -->
                <div class="tab-pane fade show active" id="epargne" role="tabpanel">
                    <div class="row g-4">
                        <!-- Produit: Dépôt à vue (DAV) -->
                        <div class="col-md-6 col-lg-4 d-flex">
                            <div class="product-card">
                                <div class="product-card-header">
                                    <i class="fas fa-piggy-bank product-card-icon"></i>
                                </div>
                                <div class="product-card-body">
                                    <h3 class="product-title">Dépôt à vue (DAV)</h3>
                                    <p class="product-description">Un compte courant flexible pour vos transactions quotidiennes, accessible à tout moment.</p>
                                    <a href="#" class="details-link" data-bs-toggle="modal" data-bs-target="#productDetailModal" data-title="Dépôt à vue (DAV)" data-description="Le Dépôt à Vue (DAV) est le compte de base pour gérer votre argent au quotidien. Il vous permet de recevoir des virements, d'effectuer des retraits et de domicilier vos revenus en toute simplicité. C'est l'outil indispensable pour une gestion fluide de vos finances." data-icon="fa-piggy-bank">
                                        En savoir plus <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- ... Les autres cartes sont structurées de la même manière ... -->

                        <div class="col-md-6 col-lg-4 d-flex">
                            <div class="product-card">
                                <div class="product-card-header"><i class="fas fa-lock product-card-icon"></i></div>
                                <div class="product-card-body">
                                    <h3 class="product-title">Dépôt à terme (DAT)</h3>
                                    <p class="product-description">Fructifiez votre capital en toute sécurité avec un taux d’intérêt attractif sur une période déterminée.</p>
                                    <a href="#" class="details-link" data-bs-toggle="modal" data-bs-target="#productDetailModal" data-title="Dépôt à terme (DAT)" data-description="Le Dépôt à Terme est une solution d'épargne bloquée qui vous garantit un rendement fixe et connu à l'avance. Idéal pour faire travailler un capital dont vous n'avez pas besoin à court terme, il offre une meilleure rémunération que les comptes d'épargne classiques." data-icon="fa-lock">En savoir plus <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 d-flex">
                            <div class="product-card">
                                <div class="product-card-header"><i class="fas fa-seedling product-card-icon"></i></div>
                                <div class="product-card-body">
                                    <h3 class="product-title">Épargne Projet</h3>
                                    <p class="product-description">Constituez une épargne progressive pour financer vos projets futurs : achat, études, voyages...</p>
                                    <a href="#" class="details-link" data-bs-toggle="modal" data-bs-target="#productDetailModal" data-title="Épargne Projet" data-description="Réalisez vos rêves grâce à l'Épargne Projet. Définissez un objectif et un plan de versements réguliers pour constituer le capital nécessaire. Que ce soit pour acheter une voiture, un terrain ou lancer une activité, nous vous accompagnons pour concrétiser vos ambitions." data-icon="fa-seedling">En savoir plus <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 d-flex">
                            <div class="product-card">
                                <div class="product-card-header"><i class="fas fa-graduation-cap product-card-icon"></i></div>
                                <div class="product-card-body">
                                    <h3 class="product-title">Épargne Étude</h3>
                                    <p class="product-description">Préparez sereinement l’avenir scolaire et universitaire de vos enfants grâce à une épargne dédiée.</p>
                                    <a href="#" class="details-link" data-bs-toggle="modal" data-bs-target="#productDetailModal" data-title="Épargne Étude" data-description="L'Épargne Étude est la solution idéale pour anticiper les coûts liés à l'éducation de vos enfants. En épargnant régulièrement, vous vous assurez de pouvoir couvrir les frais de scolarité, les fournitures et les frais de vie étudiante sans stress financier." data-icon="fa-graduation-cap">En savoir plus <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 d-flex">
                            <div class="product-card">
                                <div class="product-card-header"><i class="fas fa-baby product-card-icon"></i></div>
                                <div class="product-card-body">
                                    <h3 class="product-title">Épargne Tontine</h3>
                                    <p class="product-description">Un système d’épargne rotatif et solidaire pour atteindre vos objectifs financiers en groupe.</p>
                                    <a href="#" class="details-link" data-bs-toggle="modal" data-bs-target="#productDetailModal" data-title="Épargne Tontine" data-description="Inspirée des traditions de solidarité, notre Épargne Tontine vous permet de cotiser en groupe et de recevoir à tour de rôle une somme importante pour financer un projet majeur. C'est la force du collectif au service de vos ambitions individuelles." data-icon="fa-baby">En savoir plus <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ======================= Onglet Crédit ======================= -->
                <div class="tab-pane fade" id="credit" role="tabpanel">
                    <div class="row g-4">
                        <div class="col-md-6 col-lg-4 d-flex">
                            <div class="product-card">
                                <div class="product-card-header"><i class="fas fa-store product-card-icon"></i></div>
                                <div class="product-card-body">
                                    <h3 class="product-title">Crédit Ordinaire</h3>
                                    <p class="product-description">Un financement polyvalent pour répondre à tous vos besoins personnels ou professionnels imprévus.</p> <a href="#" class="details-link" data-bs-toggle="modal" data-bs-target="#productDetailModal" data-title="Crédit Ordinaire" data-description="Le Crédit Ordinaire est notre solution de prêt la plus flexible. Que ce soit pour faire face à une dépense imprévue, financer un petit projet ou consolider des dettes, il s'adapte à votre situation avec des conditions de remboursement claires." data-icon="fa-store">En savoir plus <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 d-flex">
                            <div class="product-card">
                                <div class="product-card-header"><i class="fas fa-fast-forward product-card-icon"></i></div>
                                <div class="product-card-body">
                                    <h3 class="product-title">Crédit Express</h3>
                                    <p class="product-description">Obtenez un financement rapide en 24h pour vos urgences financières, avec une procédure simplifiée.</p> <a href="#" class="details-link" data-bs-toggle="modal" data-bs-target="#productDetailModal" data-title="Crédit Express" data-description="Besoin d'argent en urgence ? Le Crédit Express est la réponse. Avec un dossier allégé et une décision rapide, vous pouvez obtenir les fonds nécessaires en moins de 24 heures pour gérer les situations critiques sans délai." data-icon="fa-fast-forward">En savoir plus <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 d-flex">
                            <div class="product-card">
                                <div class="product-card-header"><i class="fas fa-users product-card-icon"></i></div>
                                <div class="product-card-body">
                                    <h3 class="product-title">Crédit de Groupe</h3>
                                    <p class="product-description">Un crédit solidaire destiné aux groupes pour financer des activités génératrices de revenus communes.</p> <a href="#" class="details-link" data-bs-toggle="modal" data-bs-target="#productDetailModal" data-title="Crédit de Groupe" data-description="Le Crédit de Groupe s'appuie sur la caution solidaire des membres pour financer des projets collectifs. C'est un excellent moyen de développer une activité économique à plusieurs, en partageant les risques et les succès." data-icon="fa-users">En savoir plus <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 d-flex">
                            <div class="product-card">
                                <div class="product-card-header"><i class="fas fa-tractor product-card-icon"></i></div>
                                <div class="product-card-body">
                                    <h3 class="product-title">Crédit Agricole</h3>
                                    <p class="product-description">Soutenez vos activités agricoles, de l’achat d’intrants à la commercialisation de vos récoltes.</p> <a href="#" class="details-link" data-bs-toggle="modal" data-bs-target="#productDetailModal" data-title="Crédit Agricole" data-description="Parce que nous connaissons les cycles du monde agricole, notre Crédit Agricole est spécifiquement conçu pour vous accompagner à chaque étape : financement de campagne, achat de semences, d'engrais ou de matériel, et soutien pour la vente de votre production." data-icon="fa-tractor">En savoir plus <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 d-flex">
                            <div class="product-card">
                                <div class="product-card-header"><i class="fas fa-school product-card-icon"></i></div>
                                <div class="product-card-body">
                                    <h3 class="product-title">Crédit Scolaire</h3>
                                    <p class="product-description">Financez en toute tranquillité les frais de scolarité et les fournitures pour une rentrée sans stress.</p> <a href="#" class="details-link" data-bs-toggle="modal" data-bs-target="#productDetailModal" data-title="Crédit Scolaire" data-description="Ne laissez pas les dépenses de la rentrée scolaire peser sur votre budget. Le Crédit Scolaire vous permet d'étaler les coûts sur plusieurs mois et d'offrir à vos enfants tout ce dont ils ont besoin pour réussir." data-icon="fa-school">En savoir plus <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 d-flex">
                            <div class="product-card">
                                <div class="product-card-header"><i class="fas fa-couch product-card-icon"></i></div>
                                <div class="product-card-body">
                                    <h3 class="product-title">Crédit Équipement</h3>
                                    <p class="product-description">Équipez votre foyer ou votre entreprise avec le matériel dont vous avez besoin, du neuf ou d’occasion.</p> <a href="#" class="details-link" data-bs-toggle="modal" data-bs-target="#productDetailModal" data-title="Crédit Équipement" data-description="Modernisez votre maison ou votre outil de travail avec notre Crédit Équipement. Financez l'achat d'électroménager, de mobilier, d'outils professionnels ou de matériel informatique pour améliorer votre quotidien et votre productivité." data-icon="fa-couch">En savoir plus <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ======================= Onglet Services ======================= -->
                <div class="tab-pane fade" id="services" role="tabpanel">
                    <div class="row g-4 justify-content-center">
                        <div class="col-md-6 col-lg-4 d-flex">
                            <div class="product-card">
                                <div class="product-card-header"><i class="fas fa-exchange-alt product-card-icon"></i></div>
                                <div class="product-card-body">
                                    <h3 class="product-title">Opérations de Change</h3>
                                    <p class="product-description">Effectuez vos transactions de change de devises en toute sécurité et à des taux compétitifs.</p> <a href="#" class="details-link" data-bs-toggle="modal" data-bs-target="#productDetailModal" data-title="Opérations de Change" data-description="Nous offrons un service de change de devises fiable et rapide pour vos besoins personnels ou professionnels. Bénéficiez de taux de change avantageux pour vos opérations en toute confiance." data-icon="fa-exchange-alt">En savoir plus <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 d-flex">
                            <div class="product-card">
                                <div class="product-card-header"><i class="fas fa-mobile-alt product-card-icon"></i></div>
                                <div class="product-card-body">
                                    <h3 class="product-title">Finance Digitale</h3>
                                    <p class="product-description">Gérez votre argent, effectuez des transferts et payez vos factures facilement depuis votre mobile (T-Money, Flooz).</p> <a href="#" class="details-link" data-bs-toggle="modal" data-bs-target="#productDetailModal" data-title="Finance Digitale" data-description="Connectez votre compte COCEC aux services de Mobile Money (T-Money, Flooz) pour une gestion simplifiée. Déposez, retirez, transférez de l'argent et payez vos factures directement depuis votre téléphone, 24h/24 et 7j/7." data-icon="fa-mobile-alt">En savoir plus <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 d-flex">
                            <div class="product-card">
                                <div class="product-card-header"><i class="fas fa-comments-dollar product-card-icon"></i></div>
                                <div class="product-card-body">
                                    <h3 class="product-title">Conseils en Investissement</h3>
                                    <p class="product-description">Bénéficiez de l’expertise de nos conseillers pour faire les meilleurs choix d’investissement.</p> <a href="#" class="details-link" data-bs-toggle="modal" data-bs-target="#productDetailModal" data-title="Conseils en Investissement" data-description="Vous avez un capital à investir ? Nos conseillers sont à votre écoute pour analyser vos objectifs et votre profil de risque afin de vous proposer les meilleures opportunités de placement et de vous aider à construire un patrimoine solide." data-icon="fa-comments-dollar">En savoir plus <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fenêtre Modale -->
    <div class="modal fade" id="productDetailModal" tabindex="-1" aria-labelledby="productDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productDetailModalLabel"> <span id="modalProductTitle">Titre du produit</span> </h5> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="modalProductDescription"> Description détaillée du produit apparaîtra ici. </p>
                </div>
                <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button> <a href="{{ url('/contact') }}" class="btn btn-primary bz-primary-btn red-btn">Contacter un conseiller</a> </div>
            </div>
        </div>
    </div>

    @include('includes.main.scroll')
    @include('includes.main.footer')
</body>

@endsection

@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const productModal = document.getElementById('productDetailModal');
        if (productModal) {
            productModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const title = button.getAttribute('data-title');
                const description = button.getAttribute('data-description');
                const icon = button.getAttribute('data-icon');
                const modalTitle = productModal.querySelector('#modalProductTitle');
                const modalDescription = productModal.querySelector('#modalProductDescription');
                modalTitle.innerHTML = `<i class="fas ${icon} modal-icon"></i> ${title}`;
                modalDescription.textContent = description;
            });
        }
    });
</script>
@endsection