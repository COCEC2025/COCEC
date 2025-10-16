@extends('layout.main')

@section('css')
<style>
    /* ------------------------------------------- */
    /*    STYLE PRO DE LA PAGE PRODUITS - V4.0     */
    /* ------------------------------------------- */

    /* ----- Section Générale ----- */
    .title-pro{
        margin-top: 30px;
    }

    .products-page-section {
        padding: 80px 0;
        background-color: #f7f8fc;
        font-family: 'Poppins', sans-serif;
    }

    .hero-section {
        background: #FFFFFF;
        padding: 60px 0;
    }

    .section-heading h2 {
        font-weight: 700;
        color: #000000;
        font-size: 2.5rem;
        margin-bottom: 20px;
    }

    .section-heading p.lead {
        color: #555;
        line-height: 1.7;
        max-width: 800px;
        margin: 15px auto 0;
        font-size: 1.1rem;
    }

    /* ----- Onglets Responsifs ----- */
    .product-tabs-nav {
        display: flex;
        background-color: #e9ecef;
        border-radius: 50px;
        padding: 6px;
        margin-bottom: 50px;
        border-bottom: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        flex-wrap: wrap;
        justify-content: center;
    }

    .product-tabs-nav .nav-item .nav-link {
        color: #343a40;
        font-weight: 600;
        font-size: 0.95rem;
        border: none;
        border-radius: 50px;
        padding: 12px 20px;
        background-color: transparent;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        white-space: nowrap;
        margin: 2px;
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

    /* ----- Animation de fondu ----- */
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

    /* ----- DESIGN DES CARTES PRODUITS ----- */
    .product-card {
        background: #FFFFFF;
        border: 1px solid #e9ecef;
        border-radius: 16px;
        text-align: left;
        transition: all 0.4s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(40, 40, 90, 0.12);
        border-color: #EC281C;
    }

    .product-card-header {
        padding: 30px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid #e9ecef;
        text-align: center;
    }

    .product-card-icon {
        font-size: 3.5rem;
        color: #adb5bd;
        transition: all 0.4s ease;
    }

    .product-card:hover .product-card-icon {
        color: #EC281C;
        transform: scale(1.1);
    }

    .product-card-body {
        padding: 30px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .product-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 15px;
        line-height: 1.3;
    }

    .product-description {
        color: #555;
        line-height: 1.6;
        flex-grow: 1;
        font-size: 0.95rem;
        margin-bottom: 20px;
    }

    .details-link {
        margin-top: auto;
        font-weight: 600;
        color: #EC281C;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        position: relative;
        font-size: 0.95rem;
    }

    .details-link::after {
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
    }

    .details-link i {
        margin-left: 8px;
        transition: transform 0.3s ease;
    }

    .details-link:hover i {
        transform: translateX(5px);
    }

    /* ----- Responsive Design ----- */
    @media (max-width: 768px) {
        .products-page-section {
            padding: 60px 0;
        }

        .hero-section {
            padding: 40px 0;
        }

        .section-heading h2 {
            font-size: 2rem;
        }

        .section-heading p.lead {
            font-size: 1rem;
        }

        .product-tabs-nav {
            flex-direction: column;
            border-radius: 25px;
            padding: 8px;
        }

        .product-tabs-nav .nav-item .nav-link {
            font-size: 0.9rem;
            padding: 10px 15px;
            margin: 1px;
        }

        .product-card-header {
            padding: 25px 20px;
        }

        .product-card-icon {
            font-size: 3rem;
        }

        .product-card-body {
            padding: 25px 20px;
        }

        .product-title {
            font-size: 1.3rem;
        }

        .product-description {
            font-size: 0.9rem;
        }

        /* Amélioration pour les cartes sur mobile */
        .col-md-6 {
            margin-bottom: 20px;
        }
    }

    @media (max-width: 576px) {
        .section-heading h2 {
            font-size: 1.8rem;
        }

        .section-heading p.lead {
            font-size: 0.95rem;
        }

        .product-tabs-nav .nav-item .nav-link {
            font-size: 0.85rem;
            padding: 8px 12px;
        }

        .product-card-header {
            padding: 20px 15px;
        }

        .product-card-body {
            padding: 20px 15px;
        }

        .product-title {
            font-size: 1.2rem;
        }

        .product-description {
            font-size: 0.85rem;
        }

        .details-link {
            font-size: 0.9rem;
        }

        /* Amélioration pour les très petits écrans */
        .container {
            padding-left: 15px;
            padding-right: 15px;
        }
    }

    /* ----- Loading State ----- */
    .loading-container {
        text-align: center;
        padding: 60px 20px;
    }

    .loading-spinner {
        width: 50px;
        height: 50px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #EC281C;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 20px;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .error-message {
        text-align: center;
        padding: 40px 20px;
        color: #dc3545;
        background: #f8d7da;
        border-radius: 8px;
        margin: 20px 0;
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
                <br><br><br>

                <h1 class="title-pro">Nos produits & services</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb-pro">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Accueil</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Produits</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <section class="hero-section text-center">
        <div class="container">
            <div class="section-heading">
                <h4 class="sub-heading"><span class="left-shape"></span>Solutions financières COCEC</h4>
                <h2 class="section-title">Votre partenaire financier de confiance</h2>
                <p class="lead">Découvrez notre gamme complète de produits d'épargne, de crédit et de services financiers. Depuis 2001, COCEC accompagne les Togolais dans la réalisation de leurs projets avec des solutions adaptées et des conditions transparentes.</p>
            </div>
        </div>
    </section>

    <section class="products-page-section">
        <div class="container">
            <div class="d-flex justify-content-center">
                <ul class="nav nav-pills product-tabs-nav" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="epargne-tab" data-bs-toggle="tab" data-bs-target="#epargne" type="button" role="tab">
                            <i class="fas fa-piggy-bank me-2"></i>Épargne
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="credit-tab" data-bs-toggle="tab" data-bs-target="#credit" type="button" role="tab">
                            <i class="fas fa-hand-holding-usd me-2"></i>Crédit
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="services-tab" data-bs-toggle="tab" data-bs-target="#services" type="button" role="tab">
                            <i class="fas fa-cogs me-2"></i>Services
                        </button>
                    </li>
                </ul>
            </div>

            <div class="tab-content pt-4" id="productTabsContent">
                <!-- Le contenu sera généré dynamiquement par JavaScript -->
                <div class="loading-container" id="loadingState">
                    <div class="loading-spinner"></div>
                    <p>Chargement des produits...</p>
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
        // Charger les produits depuis le JSON
        loadProducts();

        // Initialisation des onglets Bootstrap
        var triggerTabList = [].slice.call(document.querySelectorAll('#productTabs button'))
        triggerTabList.forEach(function(triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl)

            triggerEl.addEventListener('click', function(event) {
                event.preventDefault()
                tabTrigger.show()
            })
        })
    });

    async function loadProducts() {
        try {
            console.log('Début du chargement des produits...');

            // Charger le fichier JSON
            const response = await fetch('{{ asset("assets/data/products.json") }}');
            console.log('Réponse du fetch:', response.status, response.statusText);

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log('Données JSON chargées:', data);
            console.log('Nombre de produits:', data.products ? data.products.length : 'undefined');

            // Organiser les produits par catégorie
            const productsByCategory = {};
            data.products.forEach(product => {
                if (!productsByCategory[product.category]) {
                    productsByCategory[product.category] = [];
                }
                productsByCategory[product.category].push(product);
            });

            console.log('Produits organisés par catégorie:', productsByCategory);

            // Générer le contenu des onglets
            generateTabContent(productsByCategory);

            // Masquer le loading
            const loadingState = document.getElementById('loadingState');
            if (loadingState) {
                loadingState.style.display = 'none';
            }

        } catch (error) {
            console.error('Erreur lors du chargement des produits:', error);
            // Afficher un message d'erreur
            const productTabsContent = document.getElementById('productTabsContent');
            if (productTabsContent) {
                productTabsContent.innerHTML = `
                <div class="error-message">
                    <h4><i class="fas fa-exclamation-triangle me-2"></i>Erreur de chargement</h4>
                    <p>Impossible de charger les produits pour le moment. Veuillez réessayer plus tard.</p>
                    <p style="font-size: 12px; margin-top: 10px;">Erreur: ${error.message}</p>
                    <button onclick="location.reload()" class="btn btn-primary mt-3">
                        <i class="fas fa-redo me-2"></i>Réessayer
                    </button>
                </div>
            `;
            }
        }
    }

    function generateTabContent(productsByCategory) {
        const tabContent = document.getElementById('productTabsContent');
        if (!tabContent) {
            console.error('Élément productTabsContent non trouvé');
            return;
        }
        tabContent.innerHTML = '';

        // Mapping des catégories vers les onglets
        const categoryMapping = {
            'credit': 'credit',
            'epargne': 'epargne',
            'tontine': 'epargne', // Tontine va dans l'onglet épargne
            'transfert': 'services', // Transfert va dans l'onglet services
            'conseils': 'services', // Conseils va dans l'onglet services
            'domiciliation': 'services' // Domiciliation va dans l'onglet services
        };

        // Organiser les produits par onglet
        const productsByTab = {
            'epargne': [],
            'credit': [],
            'services': []
        };

        // Répartir les produits selon le mapping
        Object.keys(productsByCategory).forEach(category => {
            const targetTab = categoryMapping[category] || 'services';
            productsByTab[targetTab] = productsByTab[targetTab].concat(productsByCategory[category]);
        });

        // Générer le contenu pour chaque onglet
        Object.keys(productsByTab).forEach((tabName, index) => {
            const products = productsByTab[tabName];
            const isActive = index === 0 ? 'show active' : '';

            const tabPane = document.createElement('div');
            tabPane.className = `tab-pane fade ${isActive}`;
            tabPane.id = tabName;
            tabPane.setAttribute('role', 'tabpanel');

            const row = document.createElement('div');
            row.className = 'row g-4';

            // Ajouter les produits de cet onglet
            products.forEach(product => {
                const productCard = createProductCard(product);
                row.appendChild(productCard);
            });

            tabPane.appendChild(row);
            tabContent.appendChild(tabPane);
        });
    }

    function createProductCard(product) {
        const col = document.createElement('div');
        col.className = 'col-lg-4 col-md-6 d-flex';

        col.innerHTML = `
        <div class="product-card">
            <div class="product-card-header">
                <i class="${product.icon} product-card-icon"></i>
            </div>
            <div class="product-card-body">
                <h3 class="product-title">${product.title}</h3>
                <p class="product-description">${product.short_description}</p>
                <a href="{{ route('product.details') }}?slug=${product.slug}" class="details-link" title="Découvrir ${product.title}">
                    En savoir plus <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    `;

        return col;
    }
</script>
@endsection