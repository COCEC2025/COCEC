@extends('layout.main')

@section('css')
<style>
    /* 1. VOS VARIABLES DE COULEURS */
    :root {
        --primary-color: #EC281C;
        --secondary-color: #FFCC00;
        --dark-charcoal: #1A202C;
        --text-color: #4A5568;
        --light-gray-bg: #F7FAFC;
        --white: #FFFFFF;
        --border-color: #E2E8F0;
        --font-family: 'Poppins', sans-serif;
    }

    body {
        font-family: var(--font-family);
    }

    .page-header-pro,
    .faq-pro-section,
    .community-section,
    .faq-contact-wrapper {
        box-sizing: border-box;
    }

    /* === STYLES DE LA PAGE FAQ AVEC COULEURS APPLIQUÉES === */
    .faq-pro-section {
        padding: 100px 0;
        background-color: #FFFFFF;
    }

    /* Padding bas ajouté */

    /* === AJOUT DE JAUNE : Sous-titre === */
    .faq-pro-section .section-heading .sub-heading {
        color: var(--secondary-color);
        /* JAUNE pour le sous-titre */
        font-weight: 600;
    }

    .faq-pro-section .section-heading .section-title {
        color: var(--dark-charcoal);
        font-weight: 700;
        font-size: 2.8rem;
    }

    .faq-pro-section .section-heading .lead {
        color: var(--text-color);
        max-width: 700px;
        margin: 15px auto 0;
    }

    .faq-layout {
        display: grid;
        grid-template-columns: 0.8fr 2fr;
        gap: 50px;
        margin-top: 60px;
        align-items: flex-start;
    }

    .faq-categories-list {
        position: sticky;
        top: 120px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .faq-category-item {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        border: 1px solid transparent;
        border-radius: 10px;
        font-weight: 600;
        color: var(--text-color);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .faq-category-item i {
        font-size: 1.2rem;
        width: 30px;
        margin-right: 15px;
        color: var(--text-color);
        transition: all 0.3s ease;
    }

    .faq-category-item:hover {
        background-color: var(--light-gray-bg);
        color: var(--dark-charcoal);
    }

    .faq-category-item.active {
        background-color: rgba(236, 40, 28, 0.1);
        color: var(--primary-color);
        font-weight: 700;
    }

    .faq-category-item.active i {
        color: var(--primary-color);
    }

    .faq-accordion-container {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .faq-item-pro {
        background: #FFFFFF;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .faq-question-pro {
        padding: 20px 25px;
        font-weight: 600;
        font-size: 1.1rem;
        color: var(--dark-charcoal);
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .faq-question-pro:hover {
        color: var(--primary-color);
    }

    .faq-toggle-icon {
        font-size: 1rem;
        color: var(--text-color);
        transition: transform 0.3s ease;
        width: 30px;
        height: 30px;
        display: grid;
        place-items: center;
        border-radius: 50%;
        background-color: var(--light-gray-bg);
    }

    .faq-answer-pro {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease-out, padding-bottom 0.4s ease-out;
    }

    .faq-answer-content {
        padding: 0 25px 0 25px;
        color: var(--text-color);
        line-height: 1.8;
    }

    .faq-answer-content ul {
        padding-left: 20px;
        margin-top: 15px;
    }

    .faq-answer-content li {
        margin-bottom: 10px;
    }

    .faq-item-pro.active .faq-toggle-icon {
        transform: rotate(135deg);
        background-color: var(--primary-color);
        color: #FFFFFF;
    }

    /* === STYLE DE LA SECTION AVIS & QUESTIONS === */
    .community-section {
        padding: 80px 0;
        background-color: var(--light-gray-bg);
        border-top: 1px solid var(--border-color);
    }

    .community-wrapper {
        max-width: 800px;
        margin: 0 auto;
    }

    .community-wrapper .section-heading {
        margin-bottom: 40px;
    }

    .comment-form-wrapper {
        padding: 40px;
        background-color: #FFFFFF;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        margin-bottom: 60px;
    }

    .comment-form-wrapper .form-title {
        font-size: 1.8rem;
        font-weight: 600;
        color: var(--dark-charcoal);
        margin-bottom: 30px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-label {
        display: block;
        font-weight: 500;
        color: var(--dark-charcoal);
        margin-bottom: 8px;
    }

    .form-control-pro {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: #FFFFFF;
        font-size: 1rem;
        color: var(--text-color);
        transition: all 0.3s ease;
    }

    .form-control-pro:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(236, 40, 28, 0.1);
    }

    textarea.form-control-pro {
        min-height: 120px;
        resize: vertical;
    }

    .btn-submit-comment {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background-color: var(--primary-color);
        color: #FFFFFF;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-submit-comment:hover {
        background-color: #c01e13;
        transform: translateY(-2px);
    }

    .btn-submit-comment:disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }

    .comments-list-wrapper .list-title {
        font-size: 1.8rem;
        font-weight: 600;
        color: var(--dark-charcoal);
        margin-bottom: 30px;
    }

    .comments-list {
        list-style: none;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    .comment-item {
        display: flex;
        gap: 0;
    }

    .comment-content {
        flex-grow: 1;
    }

    .comment-header {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
        gap: 10px;
    }

    .comment-author {
        font-weight: 600;
        color: var(--dark-charcoal);
    }

    /* === AJOUT DE JAUNE : Tag "Officiel" === */
    .comment-author .support-tag {
        background-color: var(--secondary-color);
        color: var(--dark-charcoal);
        font-size: 0.7rem;
        padding: 3px 8px;
        border-radius: 5px;
        margin-left: 8px;
        font-weight: 600;
    }

    .comment-date {
        font-size: 0.85rem;
        color: var(--text-color);
    }

    .comment-body p {
        color: var(--text-color);
        line-height: 1.7;
        margin: 0;
    }

    .comment-actions {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-top: 10px;
    }

    .comment-reply-btn {
        background: none;
        border: none;
        color: var(--primary-color);
        font-weight: 600;
        cursor: pointer;
        padding: 5px 0;
        font-size: 0.9rem;
    }

    .comment-reply-btn i {
        margin-right: 5px;
    }

    .comment-delete-btn {
        background: none;
        border: none;
        color: var(--primary-color);
        font-weight: 600;
        cursor: pointer;
        padding: 5px 0;
        font-size: 0.9rem;
        opacity: 0.7;
        transition: opacity 0.3s ease;
    }

    .comment-delete-btn:hover {
        opacity: 1;
    }

    .comment-delete-btn i {
        margin-right: 5px;
    }

    .comment-replies {
        margin-left: 30px;
        margin-top: 15px;
        padding-left: 20px;
        border-left: 2px solid #eee;
    }

    .reply-form-wrapper {
        display: none;
        margin-top: 20px;
        width: 100%;
    }

    .form-control-pro.is-invalid {
        border-color: var(--primary-color);
    }

    .invalid-feedback {
        display: none;
        color: var(--primary-color);
        font-size: 0.875em;
        margin-top: 5px;
    }

    .is-invalid~.invalid-feedback {
        display: block;
    }

    /* === CORRECTION LAYOUT & COULEURS : Section Contact === */
    .faq-contact-section-wrapper {
        padding: 80px 0;
        /* Padding cohérent */
        background: #FFFFFF;
    }

    .faq-contact-section {
        padding: 50px;
        background: var(--secondary-color);
        /* JAUNE pour un fond vibrant */
        border-radius: 16px;
        text-align: center;
    }

    .faq-contact-section h3 {
        color: #FFFFFF;
        /* Texte sombre pour la lisibilité sur fond jaune */
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .faq-contact-section p {
        color: #FFFFFF;
        opacity: 0.8;
        margin-bottom: 25px;
        font-size: 1.1rem;
    }

    .btn-contact-faq {
        display: inline-block;
        background: var(--primary-color);
        /* Bouton ROUGE pour un appel à l'action fort */
        color: #FFFFFF;
        padding: 14px 35px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-contact-faq:hover {
        background-color: var(--dark-charcoal);
        color: #FFFFFF;
        transform: translateY(-3px);
    }

    @media (max-width: 991px) {
        .faq-layout {
            grid-template-columns: 1fr;
        }

        .faq-categories-list {
            position: relative;
            top: 0;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: center;
        }
    }

    @media (max-width: 767px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Avatar avec initiale */
    .comment-thumb {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #EC281C;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.1rem;
        text-transform: uppercase;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .comment-item {
        display: flex;
        align-items: flex-start;
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
                <h1 class="title-pro">FAQ</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb-pro">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Accueil</a></li>
                        <li class="breadcrumb-item active" aria-current="page">FAQ</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <section class="faq-pro-section">
        <div class="container">
            <div class="section-heading text-center" data-aos="fade-up">
                <h4 class="sub-heading">Aide & support</h4>
                <h2 class="section-title">Réponses à vos questions</h2>
                <p class="lead">Parcourez nos catégories pour trouver rapidement les informations dont vous avez besoin.</p>
            </div>
            <div class="faq-layout">
                <aside class="faq-categories-list" data-aos="fade-right">
                    <div class="faq-category-item active" data-category="tous"><i class="fas fa-globe-americas"></i><span>Toutes les questions</span></div>
                    <div class="faq-category-item" data-category="general"><i class="fas fa-info-circle"></i><span>Généralités</span></div>
                    <div class="faq-category-item" data-category="produits"><i class="fas fa-briefcase"></i><span>Produits et services</span></div>
                    <div class="faq-category-item" data-category="eligibilite"><i class="fas fa-check-circle"></i><span>Conditions d'éligibilité</span></div>
                    <div class="faq-category-item" data-category="demande"><i class="fas fa-file-alt"></i><span>Procédure de demande</span></div>
                    <div class="faq-category-item" data-category="remboursement"><i class="fas fa-money-check"></i><span>Remboursement</span></div>
                    <div class="faq-category-item" data-category="digital"><i class="fas fa-mobile-alt"></i><span>Services digitaux</span></div>
                    <div class="faq-category-item" data-category="securite"><i class="fas fa-shield-alt"></i><span>Sécurité</span></div>
                    <div class="faq-category-item" data-category="assistance"><i class="fas fa-headset"></i><span>Assistance</span></div>
                </aside>
                <main class="faq-accordion-container" data-aos="fade-left" data-aos-delay="200">
                    <!-- Généralités sur l’institution -->
                    <div class="faq-item-pro" data-category="general">
                        <div class="faq-question-pro"><span>Qu’est-ce que la COCEC ?</span>
                            <div class="faq-toggle-icon"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-answer-pro">
                            <div class="faq-answer-content">
                                <p>La Coopérative Chrétienne d’Epargne et de Crédit (COCEC) est une institution spécialisée dans l’octroi de prêts, l’épargne et d’autres services financiers adaptés aux populations exclues du système bancaire traditionnel.</p>
                            </div>
                        </div>
                    </div>
                    <div class="faq-item-pro" data-category="general">
                        <div class="faq-question-pro"><span>À qui s’adressent vos services ?</span>
                            <div class="faq-toggle-icon"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-answer-pro">
                            <div class="faq-answer-content">
                                <p>Nos services sont destinés à toute personne partageant son lien commun et adhérant à ses objectifs principaux ci-après sans distinction de sexes, de races, de région, d’ethnie ou de religion :</p>
                                <ul>
                                    <li>Collecter l’épargne de ses membres et de leur consentir du crédit</li>
                                    <li>Favoriser la solidarité et la coopération entre les membres</li>
                                    <li>Promouvoir l’éducation économique, sociale et coopérative de ses membres</li>
                                    <li>Accompagner ses clients dans la réalisation de leurs projets et la gestion de leurs propres affaires à travers des conseils et des assistances</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="faq-item-pro" data-category="general">
                        <div class="faq-question-pro"><span>Où êtes-vous localisés ?</span>
                            <div class="faq-toggle-icon"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-answer-pro">
                            <div class="faq-answer-content">
                                <p>Siège (Kanyikopé), Adamavo, Anfamé, Attiégou, Kpogan, Bé-Kpota, Agoè, Amadahomé, Djagblé, Adétikopé</p>
                            </div>
                        </div>
                    </div>
                    <div class="faq-item-pro" data-category="general">
                        <div class="faq-question-pro"><span>Quel jour puis-je ouvrir un compte ?</span>
                            <div class="faq-toggle-icon"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-answer-pro">
                            <div class="faq-answer-content">
                                <p>Les ouvertures de compte se font du lundi au vendredi.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Produits et services -->
                    <div class="faq-item-pro" data-category="produits">
                        <div class="faq-question-pro"><span>Quels types de crédit proposez-vous ?</span>
                            <div class="faq-toggle-icon"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-answer-pro">
                            <div class="faq-answer-content">
                                <p>Nous proposons des crédits commerce et autres activités génératrices de revenus, crédit artisanat, crédit agriculture élevage et pêche, crédit immobilier, crédit tontine, crédit sur virement de salaire, crédit de financement de marché, crédit aux groupements, crédit aux associations, crédit acquisition de matériel de transport, etc.</p>
                                <p><a href="{{ route('product.index') }}">Consultez la liste complète des crédits</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="faq-item-pro" data-category="produits">
                        <div class="faq-question-pro"><span>Proposez-vous des services d’épargne ?</span>
                            <div class="faq-toggle-icon"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-answer-pro">
                            <div class="faq-answer-content">
                                <p>Oui, nous proposons différents types de comptes d’épargne adaptés à vos besoins : épargne simple, épargne projet, épargne groupe, etc.</p>
                            </div>
                        </div>
                    </div>
                    <div class="faq-item-pro" data-category="produits">
                        <div class="faq-question-pro"><span>Offrez-vous des services non financiers ?</span>
                            <div class="faq-toggle-icon"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-answer-pro">
                            <div class="faq-answer-content">
                                <p>Oui, nous proposons également des formations en éducation financière, accompagnement personnalisé, etc.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Conditions d’éligibilité -->
                    <div class="faq-item-pro" data-category="eligibilite">
                        <div class="faq-question-pro"><span>Comment puis-je bénéficier d’un prêt ?</span>
                            <div class="faq-toggle-icon"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-answer-pro">
                            <div class="faq-answer-content">
                                <p>Vous devez :</p>
                                <ul>
                                    <li>Être âgé de 18 ans minimum</li>
                                    <li>Être membre et avoir mouvementé régulièrement son compte</li>
                                    <li>Avoir une activité génératrice de revenus</li>
                                    <li>Présenter certaines pièces justificatives (CNI, justificatif de résidence, etc.)</li>
                                    <li>Avoir une capacité de remboursement</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="faq-item-pro" data-category="eligibilite">
                        <div class="faq-question-pro"><span>Faut-il une garantie pour obtenir un prêt ?</span>
                            <div class="faq-toggle-icon"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-answer-pro">
                            <div class="faq-answer-content">
                                <p>Cela dépend du type de prêt. Certains nécessitent une garantie matérielle et/ou morale (caution solidaire).</p>
                            </div>
                        </div>
                    </div>
                    <div class="faq-item-pro" data-category="eligibilite">
                        <div class="faq-question-pro"><span>Puis-je emprunter si je suis salarié ?</span>
                            <div class="faq-toggle-icon"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-answer-pro">
                            <div class="faq-answer-content">
                                <p>Oui, un salarié peut solliciter un crédit sur virement salaire.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Procédure de demande -->
                    <div class="faq-item-pro" data-category="demande">
                        <div class="faq-question-pro"><span>Comment faire une demande de prêt ?</span>
                            <div class="faq-toggle-icon"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-answer-pro">
                            <div class="faq-answer-content">
                                <p>Vous pouvez faire une demande en vous rendant dans votre agence.</p>
                            </div>
                        </div>
                    </div>
                    <div class="faq-item-pro" data-category="demande">
                        <div class="faq-question-pro"><span>Combien de temps faut-il pour obtenir un prêt ?</span>
                            <div class="faq-toggle-icon"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-answer-pro">
                            <div class="faq-answer-content">
                                <p>Le traitement prend généralement entre 5 et 15 jours ouvrables, selon le type de prêt.</p>
                            </div>
                        </div>
                    </div>
                    <div class="faq-item-pro" data-category="demande">
                        <div class="faq-question-pro"><span>Quels documents dois-je fournir ?</span>
                            <div class="faq-toggle-icon"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-answer-pro">
                            <div class="faq-answer-content">
                                <p>Une pièce d’identité, un justificatif de résidence, un plan d’affaires simplifié ou les preuves d’activité, etc.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Remboursement et gestion du crédit -->
                    <div class="faq-item-pro" data-category="remboursement">
                        <div class="faq-question-pro"><span>Quels sont les taux d’intérêt ?</span>
                            <div class="faq-toggle-icon"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-answer-pro">
                            <div class="faq-answer-content">
                                <p>Nos taux varient en fonction du type de prêt. Ils sont transparents et communiqués dès le début du processus.</p>
                            </div>
                        </div>
                    </div>
                    <div class="faq-item-pro" data-category="remboursement">
                        <div class="faq-question-pro"><span>Comment effectuer un remboursement ?</span>
                            <div class="faq-toggle-icon"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-answer-pro">
                            <div class="faq-answer-content">
                                <p>Vous pouvez rembourser :</p>
                                <ul>
                                    <li>En espèces à l’agence</li>
                                    <li>À travers l’application Bindoo</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="faq-item-pro" data-category="remboursement">
                        <div class="faq-question-pro"><span>Que se passe-t-il si je ne peux pas rembourser à temps ?</span>
                            <div class="faq-toggle-icon"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-answer-pro">
                            <div class="faq-answer-content">
                                <p>Nous vous invitons à contacter notre service client rapidement. Des solutions d’aménagement peuvent être envisagées selon la situation.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Finance digitale et services en ligne -->
                    <div class="faq-item-pro" data-category="digital">
                        <div class="faq-question-pro"><span>Proposez-vous des services financiers digitaux ?</span>
                            <div class="faq-toggle-icon"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-answer-pro">
                            <div class="faq-answer-content">
                                <p>Oui. Nous offrons plusieurs services numériques pour faciliter l’accès à nos produits, comme :</p>
                                <ul>
                                    <li><strong>Mobile Banking :</strong> Utilisation de l’application Bindoo mobile pour consulter le solde de son compte, effectuer des virements entre comptes, faire des remboursements de crédit, voir les 40 dernières opérations de compte, mini relevé de compte...</li>
                                    <li><strong>Mobile Money :</strong> Utilisation de code USSD pour accéder à votre compte COCEC et faire les dépôts, retraits et consultation de solde. Fonctionne sur tout type de téléphone et sans connexion Internet.</li>
                                    <li><strong>SMS Banking :</strong> Vous recevez des SMS à chaque mouvement sur votre compte.</li>
                                    <li><strong>Web Banking :</strong> Permet aux membres d’accéder à leur compte bancaire via un navigateur internet sur un ordinateur, une tablette ou un smartphone.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="faq-item-pro" data-category="digital">
                        <div class="faq-question-pro"><span>Quelle code USSD me permettra de faire des opérations sur mon compte COCEC ?</span>
                            <div class="faq-toggle-icon"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-answer-pro">
                            <div class="faq-answer-content">
                                <p>FLOOZ : *155*7*1*2# puis choisissez le compte sur lequel vous voulez faire l’opération, puis consultez le solde du compte COCEC. Si le solde s’affiche (le serveur est disponible), on peut donc faire l’opération qu’on veut.</p>
                                <p>Mixx by Yas : *145*6*3*2#</p>
                            </div>
                        </div>
                    </div>
                    <div class="faq-item-pro" data-category="digital">
                        <div class="faq-question-pro"><span>Comment accéder à mon compte à distance ?</span>
                            <div class="faq-toggle-icon"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-answer-pro">
                            <div class="faq-answer-content">
                                <p>Vous pouvez consulter votre solde, vos échéances et votre historique via l’application Bindoo Mobile ou un code USSD.</p>
                            </div>
                        </div>
                    </div>
                    <div class="faq-item-pro" data-category="digital">
                        <div class="faq-question-pro"><span>Est-ce que l’application mobile est sécurisée ?</span>
                            <div class="faq-toggle-icon"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-answer-pro">
                            <div class="faq-answer-content">
                                <p>Oui. Notre application utilise un cryptage de données avancé et nécessite une authentification à chaque connexion. Nous recommandons de ne jamais partager votre mot de passe ou votre code PIN.</p>
                            </div>
                        </div>
                    </div>
                    <div class="faq-item-pro" data-category="digital">
                        <div class="faq-question-pro"><span>Que se passe-t-il quand je perds mon téléphone ?</span>
                            <div class="faq-toggle-icon"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-answer-pro">
                            <div class="faq-answer-content">
                                <p>Alertez sans délai la COCEC pour que le service soit désactivé temporairement.</p>
                            </div>
                        </div>
                    </div>
                    <div class="faq-item-pro" data-category="digital">
                        <div class="faq-question-pro"><span>Et si je rencontre un problème technique ?</span>
                            <div class="faq-toggle-icon"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-answer-pro">
                            <div class="faq-answer-content">
                                <p>Vous pouvez contacter notre assistance digitale via WhatsApp, téléphone ou email. Nous avons une équipe dédiée pour vous aider.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Sécurité et protection -->
                    <div class="faq-item-pro" data-category="securite">
                        <div class="faq-question-pro"><span>Mes données personnelles sont-elles protégées ?</span>
                            <div class="faq-toggle-icon"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-answer-pro">
                            <div class="faq-answer-content">
                                <p>Oui. Nous respectons la réglementation en vigueur sur la protection des données personnelles et assurons la confidentialité de vos informations.</p>
                            </div>
                        </div>
                    </div>
                    <div class="faq-item-pro" data-category="securite">
                        <div class="faq-question-pro"><span>Comment éviter les arnaques ou fausses promesses de prêt ?</span>
                            <div class="faq-toggle-icon"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-answer-pro">
                            <div class="faq-answer-content">
                                <p>Méfiez-vous des personnes non autorisées. Ne versez jamais d’argent avant une approbation formelle. Appelez-nous pour vérifier toute information douteuse.</p>
                            </div>
                        </div>
                    </div>
                    <div class="faq-item-pro" data-category="securite">
                        <div class="faq-question-pro"><span>Comment éviter les arnaques concernant la finance digitale ?</span>
                            <div class="faq-toggle-icon"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-answer-pro">
                            <div class="faq-answer-content">
                                <p>La COCEC ne demandera jamais vos informations de connexion ni aucun code (code PIN Bindoo, identifiants de connexion Bindoo, code secret Flooz, code secret Tmoney). Ne communiquez aucune information liée à Bindoo, Flooz ou Tmoney à qui que ce soit.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Assistance et contact -->
                    <div class="faq-item-pro" data-category="assistance">
                        <div class="faq-question-pro"><span>Comment puis-je vous contacter ?</span>
                            <div class="faq-toggle-icon"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-answer-pro">
                            <div class="faq-answer-content">
                                <p>Par téléphone ou WhatsApp : +228 91 12 64 71</p>
                                <p>Par email : cocec@cocectogo.org</p>
                                <p>En agence</p>
                            </div>
                        </div>
                    </div>
                    <div class="faq-item-pro" data-category="assistance">
                        <div class="faq-question-pro"><span>Quels sont vos horaires d’ouverture ?</span>
                            <div class="faq-toggle-icon"><i class="fas fa-plus"></i></div>
                        </div>
                        <div class="faq-answer-pro">
                            <div class="faq-answer-content">
                                <p>Du lundi au vendredi, de 7h30-15h00 ; le samedi de 8h00-12h00.</p>
                                <p>Seules nos agences du Siège, Adamavo, Anfamé, Attiégou, Kpogan, Agoè, Djagblé ouvrent les samedis pour un service minimum.</p>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>
    <br><br>
    <section class="community-section">
        <div class="container">
            <div class="community-wrapper">
                <div class="section-heading text-center" data-aos="fade-up">
                    <h2 class="section-title">Avis & questions des membres</h2>
                    <p class="lead">Posez une question ou partagez votre expérience.</p>
                </div>
                <div class="comment-form-wrapper" data-aos="fade-up">
                    <h3 class="form-title">Exprimez-vous</h3>
                    <form id="main-comment-form" action="{{ route('faq.comments.store') }}" method="POST" novalidate>@csrf<div class="form-grid">
                            <div class="form-group"><label for="comment-name" class="form-label">Votre nom</label><input type="text" id="comment-name" name="name" class="form-control-pro" required value="{{ auth()->user()->name ?? '' }}">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group"><label for="comment-email" class="form-label">Votre email</label><input type="email" id="comment-email" name="email" class="form-control-pro" required value="{{ auth()->user()->email ?? '' }}">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group full-width"><label for="comment-message" class="form-label">Votre question ou avis</label><textarea id="comment-message" name="body" class="form-control-pro" placeholder="Posez votre question ou laissez un avis..." required></textarea>
                            <div class="invalid-feedback"></div>
                        </div><button type="submit" class="btn-submit-comment"><i class="fas fa-paper-plane"></i><span>Soumettre</span></button>
                    </form>
                </div>
                <div class="comments-list-wrapper" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="list-title">Discussions récentes</h3>
                    <ol class="comments-list">
                        @forelse ($comments as $comment)
                        <li class="comment-item" id="comment-{{ $comment->id }}">
                            <div class="comment-thumb">
                                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                            </div>
                            <div class="comment-content">
                                <div class="comment-header">
                                    <span class="comment-author">
                                        {{ $comment->user->name }}
                                        @if ($comment->user && $comment->user->is_admin)
                                        <span class="support-tag">Officiel</span>
                                        @endif
                                    </span>
                                    <span class="comment-date">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="comment-body">
                                    <p>{{ $comment->body }}</p>
                                </div>
                                <div class="comment-actions">
                                    @auth
                                    <button class="comment-reply-btn" data-comment-id="{{ $comment->id }}">
                                        <i class="fas fa-reply"></i> Répondre
                                    </button>
                                    @if (Auth::user()->is_admin || Auth::id() == $comment->user_id)
                                    <button class="comment-delete-btn" data-comment-id="{{ $comment->id }}"
                                        data-delete-url="{{ route('faq.comments.destroy', $comment) }}"
                                        data-csrf="{{ csrf_token() }}">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                    @endif
                                    @endauth
                                </div>
                                <div class="reply-form-wrapper" id="reply-form-{{ $comment->id }}">
                                    <form class="reply-form" action="{{ route('faq.comments.store') }}" method="POST" novalidate>
                                        @csrf
                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                        <div class="form-group">
                                            <textarea name="body" class="form-control-pro" rows="3" style="width:100%; min-width:300px;" placeholder="Écrivez votre réponse à {{ $comment->name }}..." required></textarea>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <button type="submit" class="btn-submit-comment">
                                            <span>Répondre</span>
                                        </button>
                                    </form>
                                </div>
                                @if ($comment->replies->isNotEmpty())
                                <ol class="comment-replies">
                                    @foreach ($comment->replies as $reply)
                                    <li class="comment-item" id="comment-{{ $reply->id }}">
                                        <div class="comment-thumb">
                                            {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                                        </div>
                                        <div class="comment-content">
                                            <div class="comment-header">
                                                <span class="comment-author">
                                                    {{ $reply->user->name }}
                                                    @if ($reply->user && $reply->user->is_admin)
                                                    <span class="support-tag">Officiel</span>
                                                    @endif
                                                </span>
                                                <span class="comment-date">{{ $reply->created_at->diffForHumans() }}</span>
                                            </div>
                                            <div class="comment-body">
                                                <p>{{ $reply->body }}</p>
                                            </div>
                                            <div class="comment-actions">
                                                @auth
                                                @if (Auth::user()->is_admin || Auth::id() == $reply->user_id)
                                                <button class="comment-delete-btn" data-comment-id="{{ $reply->id }}"
                                                    data-delete-url="{{ route('faq.comments.destroy', $reply) }}"
                                                    data-csrf="{{ csrf_token() }}">
                                                    <i class="fas fa-trash"></i> Supprimer
                                                </button>
                                                @endif
                                                @endauth
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ol>
                                @endif
                            </div>
                        </li>
                        @empty
                        <p class="text-center text-muted">Soyez la première personne à poser une question ou à laisser un avis !</p>
                        @endforelse
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="faq-contact-section-wrapper">
        <div class="container" data-aos="fade-up">
            <div class="faq-contact-section">
                <h3>Vous ne trouvez pas votre réponse ?</h3>
                <p>Notre équipe est là pour vous aider. N'hésitez pas à nous contacter directement.</p>
                <a href="{{ route('contact') }}" class="btn-contact-faq">Nous contacter</a>
            </div>
        </div>
    </section>
    <br>
    @include('includes.main.scroll')
    @include('includes.main.footer')
</body>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const faqSection = document.querySelector('.faq-pro-section');
        if (faqSection) {
            const categoryItems = faqSection.querySelectorAll('.faq-category-item');
            const faqItems = faqSection.querySelectorAll('.faq-item-pro');
            categoryItems.forEach(categoryTab => {
                categoryTab.addEventListener('click', () => {
                    const category = categoryTab.dataset.category;
                    categoryItems.forEach(t => t.classList.remove('active'));
                    categoryTab.classList.add('active');
                    faqItems.forEach(item => {
                        item.style.display = (category === 'tous' || item.dataset.category === category) ? 'block' : 'none';
                    });
                });
            });
            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question-pro');
                const answer = item.querySelector('.faq-answer-pro');
                const answerContent = item.querySelector('.faq-answer-content');
                question.addEventListener('click', () => {
                    const isOpen = item.classList.contains('active');
                    if (isOpen) {
                        item.classList.remove('active');
                        answer.style.maxHeight = '0px';
                        answer.style.paddingBottom = '0px';
                    } else {
                        item.classList.add('active');
                        answer.style.maxHeight = answerContent.scrollHeight + 45 + 'px';
                        answer.style.paddingBottom = '25px';
                    }
                });
            });
        }
        if (window.jQuery) {
            $(document).ready(function() {
                function handleFormSubmit(form) {
                    const $form = $(form);
                    const $button = $form.find('.btn-submit-comment');
                    const originalButtonHtml = $button.html();
                    const csrfToken = $form.find('input[name="_token"]').val();
                    $.ajax({
                        url: $form.attr('action'),
                        method: 'POST',
                        data: new FormData(form),
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        beforeSend: function() {
                            $button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Envoi...');
                            $form.find('.is-invalid').removeClass('is-invalid');
                            $form.find('.invalid-feedback').text('');
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Succès!',
                                text: response.message,
                                timer: 2500,
                                showConfirmButton: false
                            });
                            setTimeout(() => location.reload(), 1500);
                        },
                        error: function(jqXHR) {
                            if (jqXHR.status === 422) {
                                const errors = jqXHR.responseJSON.errors;
                                $.each(errors, function(key, value) {
                                    const field = $form.find('[name="' + key + '"]');
                                    field.addClass('is-invalid');
                                    field.closest('.form-group').find('.invalid-feedback').text(value[0]).show();
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erreur de validation',
                                    text: 'Veuillez vérifier les champs du formulaire.'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oups...',
                                    text: 'Une erreur inattendue est survenue.'
                                });
                            }
                        },
                        complete: function() {
                            $button.prop('disabled', false).html(originalButtonHtml);
                        }
                    });
                }
                $('#main-comment-form').on('submit', function(e) {
                    e.preventDefault();
                    handleFormSubmit(this);
                });
                $('.comment-reply-btn').on('click', function() {
                    const commentId = $(this).data('comment-id');
                    $('#reply-form-' + commentId).slideToggle();
                });
                $('.comments-list').on('submit', '.reply-form', function(e) {
                    e.preventDefault();
                    handleFormSubmit(this);
                });
                $('.comments-list').on('click', '.comment-delete-btn', function() {
                    const $button = $(this);
                    const commentId = $button.data('comment-id');
                    const deleteUrl = $button.data('delete-url');
                    const csrfToken = $button.data('csrf');
                    Swal.fire({
                        title: 'Êtes-vous sûr ?',
                        text: "Cette action est irréversible !",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#EC281C',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Oui, supprimer !',
                        cancelButtonText: 'Annuler'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: deleteUrl,
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Supprimé!',
                                        text: response.message,
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                    $('#comment-' + commentId).fadeOut(500, function() {
                                        $(this).remove();
                                    });
                                },
                                error: function(jqXHR) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Erreur',
                                        text: jqXHR.responseJSON?.message || 'Une erreur est survenue.'
                                    });
                                }
                            });
                        }
                    });
                });
            });
        }
    });
</script>
@endsection