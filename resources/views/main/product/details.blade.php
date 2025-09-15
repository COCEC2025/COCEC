@extends('layout.main')

@section('css')
<style>
    /* ------------------------------------------- */
    /*    STYLE PRO DE LA PAGE DÉTAILS PRODUIT     */
    /* ------------------------------------------- */

    .product-details-section {
        padding: 100px 0;
        background-color: #f7f8fc;
        font-family: 'Poppins', sans-serif;
    }

    /* Styles supprimés - utilisation des styles globaux page-header-pro */

    /* Styles supprimés - utilisation des styles globaux */

    .product-content {
        background: white;
        border-radius: 20px;
        padding: 50px;
        margin-top: -50px;
        position: relative;
        z-index: 3;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    }

    .product-description {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #555;
        margin-bottom: 40px;
    }

    .features-section, .requirements-section {
        margin-bottom: 40px;
    }

    .section-title {
        color: #EC281C;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }

    .section-title i {
        margin-right: 10px;
    }

    .features-list, .requirements-list {
        list-style: none;
        padding: 0;
    }

    .features-list li, .requirements-list li {
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
        position: relative;
        padding-left: 30px;
    }

    .features-list li:last-child, .requirements-list li:last-child {
        border-bottom: none;
    }

    .features-list li::before {
        content: '✓';
        position: absolute;
        left: 0;
        color: #28a745;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .requirements-list li::before {
        content: '•';
        position: absolute;
        left: 0;
        color: #EC281C;
        font-weight: bold;
        font-size: 1.5rem;
    }

    .cta-section {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        margin-top: 40px;
    }

    .cta-title {
        color: #EC281C;
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .cta-description {
        color: #666;
        margin-bottom: 25px;
    }

    .breadcrumb-custom {
        background: transparent;
        padding: 0;
        margin-bottom: 30px;
    }

    .breadcrumb-custom .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
    }

    .breadcrumb-custom .breadcrumb-item.active {
        color: white;
    }

    .breadcrumb-custom .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.6);
    }

    /* Loading state */
    .loading-state {
        text-align: center;
        padding: 100px 0;
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
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .product-title-large {
            font-size: 2rem;
        }
        
        .product-content {
            padding: 30px 20px;
            margin-top: -30px;
        }
        
        .product-icon-large {
            font-size: 3rem;
        }
    }
</style>
@endsection

@section('content')

<body>
    @include('includes.main.loading')
    @include('includes.main.header')

    <!-- Product Details Content -->
    <div id="productContent">
        <section class="page-header-pro">
            <div class="page-header-overlay"></div>
            <div class="container">
                <div class="page-header-content-pro" data-aos="fade-up">
                    <h1 class="title-pro">{{ $product['title'] ?? 'Titre du Produit' }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb-pro">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Accueil</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Produits</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $product['title'] ?? 'Produit' }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </section>

        <section class="product-details-section">
            <div class="container">
                <div class="product-content">
                    <div class="product-description">
                        {{ $product['description'] ?? 'Description détaillée du produit...' }}
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="features-section">
                                <h3 class="section-title">
                                    <i class="fas fa-star"></i>
                                    Caractéristiques
                                </h3>
                                <ul class="features-list">
                                    @if(isset($product['features']))
                                        @foreach($product['features'] as $feature)
                                            <li><i class="fas fa-check-circle"></i> {{ $feature }}</li>
                                        @endforeach
                                    @else
                                        <li><i class="fas fa-check-circle"></i> Caractéristique principale</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="requirements-section">
                                <h3 class="section-title">
                                    <i class="fas fa-clipboard-list"></i>
                                    Conditions requises
                                </h3>
                                <ul class="requirements-list">
                                    @if(isset($product['requirements']))
                                        @foreach($product['requirements'] as $requirement)
                                            <li><i class="fas fa-arrow-right"></i> {{ $requirement }}</li>
                                        @endforeach
                                    @else
                                        <li><i class="fas fa-arrow-right"></i> Condition requise</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="cta-section">
                        <h4 class="cta-title">Intéressé par ce produit ?</h4>
                        <p class="cta-description">Nos conseillers sont à votre disposition pour vous accompagner et répondre à toutes vos questions.</p>
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <a href="{{ route('contact') }}" class="bz-primary-btn red-btn">
                                <i class="fas fa-phone"></i> Nous contacter
                            </a>
                            <a href="{{ route('product.index') }}" class="bz-primary-btn hero-btn">
                                <i class="fas fa-arrow-left"></i> Retour aux produits
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('includes.main.footer')

</body>  
@endsection

@section('js')
<script>
    // Le contenu est maintenant chargé directement depuis le contrôleur
    // Plus besoin de JavaScript pour charger les données
</script>
@endsection
