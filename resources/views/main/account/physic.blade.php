@extends('layout.main')

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .account-form-section {
        background-color: #f7f8fc;
        font-family: 'Poppins', sans-serif;
    }

    .form-container {
        max-width: 900px;
        margin: 0 auto;
        background: #FFFFFF;
        border-radius: 16px;
        padding: 40px 50px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        border-top: 5px solid #EC281C;
    }

    .section-heading h2 {
        font-weight: 700;
        color: #000000;
    }

    .section-heading p {
        color: #555;
        line-height: 1.7;
    }

    .form-section-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-top: 35px;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }

    .input-group-custom {
        position: relative;
    }

    .input-group-custom .form-label {
        font-weight: 500;
        color: #343a40;
        margin-bottom: 8px;
    }



    /* Style pour les inputs */
    .input-group-custom .form-control {
        border-radius: 8px;
        padding-top: 12px;
        padding-bottom: 12px;
    }



    .form-stepper {
        display: flex;
        justify-content: space-around;
        width: 100%;
        position: relative;
        margin: 30px 0;
    }

    .form-stepper .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 1;
        text-align: center;
    }

    .form-stepper .step-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e0e0e0;
        color: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        transition: all 0.3s ease;
        border: 3px solid #e0e0e0;
    }

    .form-stepper .step-label {
        margin-top: 10px;
        font-size: 0.8rem;
        color: #6c757d;
        font-weight: 500;
    }

    .form-stepper .step.active .step-icon,
    .form-stepper .step.completed .step-icon {
        background: #EC281C;
        border-color: #EC281C;
    }

    .form-stepper .step.active .step-label {
        color: #EC281C;
        font-weight: 600;
    }

    .form-stepper::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 0;
        right: 0;
        height: 2px;
        background-color: #e0e0e0;
        transform: translateY(-50%);
        z-index: 0;
    }

    .form-stepper .progress-line {
        position: absolute;
        top: 20px;
        left: 0;
        height: 2px;
        background-color: #EC281C;
        transform: translateY(-50%);
        z-index: 0;
        width: 0%;
        transition: width 0.4s ease;
    }

    .form-step-content {
        display: none;
    }

    .form-step-content.active {
        display: block;
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-navigation-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 40px;
        align-items: center;
    }

    .form-navigation-buttons .btn-next {
        margin-left: auto;
    }

    .form-navigation-buttons .btn-submit-form {
        margin-left: auto;
    }

    .btn-nav {
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 700;
        border: none;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .btn-nav::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s;
    }

    .btn-nav:hover::before {
        left: 100%;
    }

    .btn-prev {
        background: linear-gradient(135deg, #6c757d, #495057);
        color: white !important;
        border: 2px solid #6c757d;
    }

    .btn-prev:hover {
        background: linear-gradient(135deg, #495057, #343a40);
        border-color: #495057;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }

    .btn-next {
        background: linear-gradient(135deg, #EC281C, #d4241a);
        color: white !important;
        border: 2px solid #EC281C;
    }

    .btn-next:hover {
        background: linear-gradient(135deg, #d4241a, #b91c13);
        border-color: #d4241a;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }

    .btn-submit-form {
        font-size: 1rem;
        border-radius: 8px;
        padding: 14px 35px;
        width: auto;
        background: linear-gradient(135deg, #EC281C, #d4241a);
        color: white !important;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 2px solid #EC281C;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .btn-submit-form::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s;
    }

    .btn-submit-form:hover::before {
        left: 100%;
    }

    .btn-submit-form:hover {
        background: linear-gradient(135deg, #d4241a, #b91c13);
        border-color: #d4241a;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }

    .dynamic-adder-btn {
        background: linear-gradient(135deg, #EC281C, #d4241a);
        color: white !important;
        border: 2px solid #EC281C;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
        position: relative;
        overflow: hidden;
    }

    .dynamic-adder-btn:hover {
        background: linear-gradient(135deg, #d4241a, #b91c13);
        border-color: #d4241a;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
    }

    /* Responsive pour les boutons */
    @media (max-width: 768px) {

        .btn-nav,
        .btn-submit-form {
            padding: 10px 20px;
            font-size: 0.9rem;
        }

        .dynamic-adder-btn {
            padding: 8px 16px;
            font-size: 0.8rem;
        }
    }

    .file-upload-wrapper {
        position: relative;
        border: 2px dashed #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        transition: border-color 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .file-upload-wrapper:hover {
        border-color: #EC281C;
    }

    .file-upload-wrapper input[type="file"] {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .file-upload-icon {
        color: #EC281C;
        font-size: 2rem;
        margin-bottom: 10px;
    }

    .file-upload-text {
        font-weight: 500;
        color: #555;
    }

    .file-upload-preview img {
        max-width: 150px;
        max-height: 150px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .file-upload-preview span {
        font-style: italic;
        color: #000;
        font-weight: 500;
    }

    .choice-container .choice-label {
        display: block;
        padding: 15px 20px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
    }

    .choice-container input[type="radio"] {
        display: none;
    }

    .choice-container input[type="radio"]:checked+.choice-label {
        border-color: #EC281C;
        background-color: #ec281c1a;
        font-weight: 600;
        color: #EC281C;
    }

    .method-area {
        margin-top: 20px;
        padding: 20px;
        border: 1px solid #eee;
        border-radius: 8px;
        display: none;
    }

    #signature-pad {
        /* ID D'ORIGINE RESTAURÉ */
        border: 2px solid #f0f0f0;
        border-radius: 8px;
        width: 100%;
        height: 200px;
        cursor: crosshair;
        background-color: #fff;
    }

    .signature-controls {
        margin-top: 15px;
        text-align: right;
    }

    .map-container {
        height: 350px;
        border-radius: 8px;
        border: 1px solid #ddd;
        z-index: 1;
    }

    .btn-clear {
        background: #6c757d;
        color: white;
        border-radius: 6px;
        padding: 8px 16px;
        font-weight: 500;
        border: none;
    }

    .versemants-summary {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
    }

    .versemants-summary .row-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .versemants-summary .label {
        color: #6c757d;
    }

    .versemants-summary .value,
    .versemants-summary .total-value {
        font-weight: 600;
        color: #000;
    }

    .versemants-summary .total-row {
        border-top: 2px solid #343a40;
        margin-top: 10px;
        padding-top: 10px;
    }

    .versemants-summary .total-label,
    .versemants-summary .total-value {
        font-size: 1.2rem;
        font-weight: 700;
        color: #EC281C;
    }

    .form-control.is-invalid,
    .file-upload-wrapper.is-invalid,
    .choice-container.is-invalid .choice-label {
        border-color: #dc3545 !important;
    }

    .file-upload-wrapper.is-invalid {
        border-style: solid;
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
    }

    /* Masquer les éléments de sélection SweetAlert2 inutiles */
    .nice-select.swal2-select {
        display: none !important;
    }

    .invalid-feedback {
        display: none;
        width: 100%;
        margin-top: .25rem;
        font-size: .875em;
        color: #dc3545;
    }

    .form-control.is-invalid~.invalid-feedback,
    .choice-container.is-invalid+.invalid-feedback {
        display: block;
    }

    .dynamic-field {
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 20px;
        position: relative;
    }

    .dynamic-field .remove-field {
        top: 10px;
        right: 10px;
    }

    /* Messages d'erreur personnalisés */
    .custom-error-message {
        background: linear-gradient(135deg, #ff6b6b, #ee5a52);
        border: 2px solid #dc3545;
        border-radius: 12px;
        padding: 15px 20px;
        margin: 15px 0;
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        animation: errorShake 0.5s ease-in-out;
    }

    .custom-error-message .error-content {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .custom-error-message .error-icon {
        color: #fff;
        font-size: 1.5rem;
        animation: errorPulse 2s infinite;
    }

    .custom-error-message .error-text {
        color: #fff;
        font-weight: 600;
    }

    .custom-error-message .error-text strong {
        display: block;
        margin-bottom: 5px;
        font-size: 1.1rem;
    }

    @keyframes errorShake {

        0%,
        100% {
            transform: translateX(0);
        }

        25% {
            transform: translateX(-5px);
        }

        75% {
            transform: translateX(5px);
        }
    }

    @keyframes errorPulse {

        0%,
        100% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.1);
            opacity: 0.8;
        }
    }

    @keyframes errorGlow {

        0%,
        100% {
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }

        50% {
            box-shadow: 0 4px 25px rgba(220, 53, 69, 0.6);
        }
    }
</style>
@endsection

@section('content')
<section class="account-form-section">
    @include('includes.main.loading')
    @include('includes.main.header')

    <section class="page-header-pro">
        <div class="page-header-overlay"></div>
        <div class="container">
            <div class="page-header-content-pro" data-aos="fade-up">
                <br>
                <h1 class="title-pro">Compte en Ligne - Personne Physique</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb-pro">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Accueil</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Compte en Ligne</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <br><br>

    <div class="container">
        <div class="form-container">
            <div class="section-heading mb-4 text-center">
                <h4 class="sub-heading"><span class="left-shape"></span>Compte en Ligne</h4>
                <h2 class="section-title">Ouvrez Votre Compte Personnel COCEC</h2>
                <p>Rejoignez la COCEC en remplissant le formulaire ci-dessous. C'est simple, rapide et sécurisé.</p>
            </div>

            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger">
                <p class="mb-0"><strong>Oups !</strong> Veuillez corriger les erreurs indiquées en rouge ci-dessous avant de continuer.</p>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('account.store.physical') }}" method="POST" enctype="multipart/form-data" class="adhesion-form multi-step-form" id="physique" novalidate>
                @csrf

                {{-- Champs honeypot pour détecter les bots --}}
                @include('components.honeypot')

                <div class="form-stepper">
                    <div class="progress-line"></div>
                    <div class="step active" data-step="1">
                        <div class="step-icon">1</div>
                        <div class="step-label">Identité</div>
                    </div>
                    <div class="step" data-step="2">
                        <div class="step-icon">2</div>
                        <div class="step-label">Adresse</div>
                    </div>
                    <div class="step" data-step="3">
                        <div class="step-icon">3</div>
                        <div class="step-label">Profession</div>
                    </div>
                    <div class="step" data-step="4">
                        <div class="step-icon">4</div>
                        <div class="step-label">Documents</div>
                    </div>
                    <div class="step" data-step="5">
                        <div class="step-icon">5</div>
                        <div class="step-label">Versements & Consentement UMOA</div>
                    </div>
                </div>

                <!-- Étape 1: Identité -->
                <div class="form-step-content active" data-step="1">
                    <h4 class="form-section-title">Informations d'Identité</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Nom</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required>
                            <div class="invalid-feedback">@error('last_name') {{ $message }} @else Ce champ est requis. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Prénoms</label>
                            <input type="text" class="form-control @error('first_names') is-invalid @enderror" name="first_names" value="{{ old('first_names') }}" required>
                            <div class="invalid-feedback">@error('first_names') {{ $message }} @else Ce champ est requis. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Nom du père</label>
                            <input type="text" class="form-control @error('father_name') is-invalid @enderror" name="father_name" value="{{ old('father_name') }}" required>
                            <div class="invalid-feedback">@error('father_name') {{ $message }} @else Ce champ est requis. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Nom de la mère</label>
                            <input type="text" class="form-control @error('mother_name') is-invalid @enderror" name="mother_name" value="{{ old('mother_name') }}" required>
                            <div class="invalid-feedback">@error('mother_name') {{ $message }} @else Ce champ est requis. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Sexe</label>
                            <select class="form-control @error('gender') is-invalid @enderror" name="gender" required>
                                <option value="">Sélectionner...</option>
                                <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Masculin</option>
                                <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Féminin</option>
                            </select>
                            <div class="invalid-feedback">@error('gender') {{ $message }} @else Ce champ est requis. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Date de naissance</label>
                            <input type="date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date') }}" max="{{ \Carbon\Carbon::today()->subYears(18)->format('Y-m-d') }}" required>
                            <div class="invalid-feedback">@error('birth_date') {{ $message }} @else Ce champ est requis et doit être antérieur à aujourd'hui. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Lieu de naissance</label>
                            <input type="text" class="form-control @error('birth_place') is-invalid @enderror" name="birth_place" value="{{ old('birth_place') }}" required>
                            <div class="invalid-feedback">@error('birth_place') {{ $message }} @else Ce champ est requis. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Nationalité(TOGO)</label>
                            <input type="text" class="form-control @error('nationality') is-invalid @enderror" name="nationality" value="{{ old('nationality') }}" required>
                            <div class="invalid-feedback">@error('nationality') {{ $message }} @else Ce champ est requis. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Téléphone</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" pattern="\+?[0-9\s\-\(\)]{7,15}" required>
                            <div class="invalid-feedback">@error('phone') {{ $message }} @else Numéro de téléphone invalide. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">État Civil</label>
                            <select class="form-control @error('marital_status') is-invalid @enderror" name="marital_status" required>
                                <option value="">Sélectionner...</option>
                                <option value="Célibataire" {{ old('marital_status') == 'Célibataire' ? 'selected' : '' }}>Célibataire</option>
                                <option value="Marié(e)" {{ old('marital_status') == 'Marié(e)' ? 'selected' : '' }}>Marié(e)</option>
                                <option value="Divorcé(e)" {{ old('marital_status') == 'Divorcé(e)' ? 'selected' : '' }}>Divorcé(e)</option>
                                <option value="Veuf/Veuve" {{ old('marital_status') == 'Veuf/Veuve' ? 'selected' : '' }}>Veuf/Veuve</option>
                            </select>
                            <div class="invalid-feedback">@error('marital_status') {{ $message }} @else Ce champ est requis. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Nom du/de la Conjoint(e) (si applicable)</label>
                            <input type="text" class="form-control @error('spouse_name') is-invalid @enderror" name="spouse_name" value="{{ old('spouse_name') }}">
                            <div class="invalid-feedback">@error('spouse_name') {{ $message }} @else Ce champ est requis si marié(e). @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Personne politiquement exposée (national) ?</label>
                            <select class="form-control @error('is_ppe_national') is-invalid @enderror" name="is_ppe_national" id="is_ppe_national" required>
                                <option value="0" {{ old('is_ppe_national', '0') == '0' ? 'selected' : '' }}>Non</option>
                                <option value="1" {{ old('is_ppe_national') == '1' ? 'selected' : '' }}>Oui</option>
                            </select>
                            <div class="invalid-feedback">@error('is_ppe_national') {{ $message }} @else Ce champ est requis. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Personne politiquement exposée (étranger) ? <span id="ppe-foreign-required" style="color: #dc3545; display: none;">*</span></label>
                            <select class="form-control @error('ppe_foreign') is-invalid @enderror" name="ppe_foreign" id="ppe_foreign" required>
                                <option value="0" {{ old('ppe_foreign', '0') == '0' ? 'selected' : '' }}>Non</option>
                                <option value="1" {{ old('ppe_foreign') == '1' ? 'selected' : '' }}>Oui</option>
                            </select>
                            <div class="invalid-feedback">@error('ppe_foreign') {{ $message }} @else Ce champ est requis si vous n'êtes pas PPE national. @enderror</div>
                        </div>
                    </div>
                </div>

                <!-- Étape 2: Adresse -->
                <div class="form-step-content" data-step="2">
                    <h4 class="form-section-title">Adresse du Domicile</h4>
                    <div class="alert alert-info">
                        <h5 class="alert-heading">Attestation sur l'honneur</h5>
                        <p class="mb-0">Je certifie sur l'honneur l'exactitude des informations de domicile fournies ci-dessous.</p>
                    </div>
                    <div class="row mb-3 choice-container @error('loc_method_residence') is-invalid @enderror">
                        <div class="col-6">
                            <input type="radio" name="loc_method_residence" id="desc_physique" value="description" {{ old('loc_method_residence', 'description') == 'description' ? 'checked' : '' }} required>
                            <label for="desc_physique" class="choice-label"><i class="fas fa-keyboard"></i> Décrire l'adresse</label>
                        </div>
                        <div class="col-6">
                            <input type="radio" name="loc_method_residence" id="map_physique" value="map" {{ old('loc_method_residence') == 'map' ? 'checked' : '' }}>
                            <label for="map_physique" class="choice-label"><i class="fas fa-map-marked-alt"></i> Sélectionner sur une carte</label>
                        </div>
                        <div class="invalid-feedback">@error('loc_method_residence') {{ $message }} @else Veuillez choisir une méthode. @enderror</div>
                    </div>
                    <div class="method-area" id="description-area-physique">
                        <div class="input-group-custom">
                            <label class="form-label">Description détaillée du domicile</label>
                            <textarea class="form-control @error('residence_description') is-invalid @enderror" name="residence_description" rows="4" placeholder="Indiquer ville, quartier, rue, repères..." {{ old('loc_method_residence') == 'description' ? 'required' : '' }}>{{ old('residence_description') }}</textarea>
                            <div class="invalid-feedback">@error('residence_description') {{ $message }} @else Ce champ est requis si vous choisissez de décrire l'adresse. @enderror</div>
                        </div>
                    </div>
                    <div class="method-area" id="map-area-physique">
                        <label class="form-label">Cliquez sur la carte ou déplacez le marqueur pour indiquer votre domicile</label>
                        <div id="map-container-physique" class="map-container"></div>
                        <input type="hidden" name="residence_lat" id="latitude-physique" value="{{ old('residence_lat') }}" {{ old('loc_method_residence') == 'map' ? 'required' : '' }}>
                        <input type="hidden" name="residence_lng" id="longitude-physique" value="{{ old('residence_lng') }}" {{ old('loc_method_residence') == 'map' ? 'required' : '' }}>
                        <div class="invalid-feedback">@error('residence_lat') Une position sur la carte est requise. @else Veuillez sélectionner un point sur la carte. @enderror</div>
                    </div>
                    <div class="mt-3 col-12 mb-3">
                        <label class="form-label">Plan du domicile (optionnel)</label>
                        <div class="file-upload-wrapper @error('residence_plan_path') is-invalid @enderror">
                            <div class="file-upload-content">
                                <i class="fas fa-map-marked-alt file-upload-icon"></i>
                                <p class="file-upload-text">Importer un plan scanné (PDF ou image)</p>
                            </div>
                            <div class="file-upload-preview"></div>
                            <input type="file" name="residence_plan_path" accept="image/*,application/pdf">
                            <div class="invalid-feedback">@error('residence_plan_path') {{ $message }} @else Une erreur est survenue avec le fichier. @enderror</div>
                        </div>
                    </div>

                    <h4 class="form-section-title mt-4">Adresse du Lieu de Travail(SI APPLICABLE)</h4>
                    <div class="row mb-3 choice-container @error('loc_method_workplace') is-invalid @enderror">
                        <div class="col-6">
                            <input type="radio" name="loc_method_workplace" id="desc_workplace" value="description" {{ old('loc_method_workplace') == 'description' ? 'checked' : '' }}>
                            <label for="desc_workplace" class="choice-label"><i class="fas fa-keyboard"></i> Décrire l'adresse</label>
                        </div>
                        <div class="col-6">
                            <input type="radio" name="loc_method_workplace" id="map_workplace" value="map" {{ old('loc_method_workplace') == 'map' ? 'checked' : '' }}>
                            <label for="map_workplace" class="choice-label"><i class="fas fa-map-marked-alt"></i> Sélectionner sur une carte</label>
                        </div>
                        <div class="invalid-feedback">@error('loc_method_workplace') {{ $message }} @else Veuillez choisir une méthode. @enderror</div>
                    </div>
                    <div class="method-area" id="description-area-workplace">
                        <div class="input-group-custom">
                            <label class="form-label">Description détaillée du lieu de travail</label>
                            <textarea class="form-control @error('workplace_description') is-invalid @enderror" name="workplace_description" rows="4" placeholder="Indiquer ville, quartier, rue, repères... (facultatif)">{{ old('workplace_description') }}</textarea>
                            <div class="invalid-feedback">@error('workplace_description') {{ $message }} @enderror</div>
                        </div>
                    </div>
                    <div class="method-area" id="map-area-workplace">
                        <label class="form-label">Cliquez sur la carte ou déplacez le marqueur pour indiquer votre lieu de travail</label>
                        <div id="map-container-workplace" class="map-container"></div>
                        <input type="hidden" name="workplace_lat" id="latitude-workplace" value="{{ old('workplace_lat') }}">
                        <input type="hidden" name="workplace_lng" id="longitude-workplace" value="{{ old('workplace_lng') }}">
                        <small class="text-muted">(facultatif)</small>

                    </div>
                    <div class="mt-3 col-12 mb-3">
                        <label class="form-label">Plan du lieu de travail (optionnel)</label>
                        <div class="file-upload-wrapper @error('workplace_plan_path') is-invalid @enderror">
                            <div class="file-upload-content">
                                <i class="fas fa-map-marked-alt file-upload-icon"></i>
                                <p class="file-upload-text">Importer un plan scanné (PDF ou image)</p>
                            </div>
                            <div class="file-upload-preview"></div>
                            <input type="file" name="workplace_plan_path" accept="image/*,application/pdf">
                            <div class="invalid-feedback">@error('workplace_plan_path') {{ $message }} @else Une erreur est survenue avec le fichier. @enderror</div>
                        </div>
                    </div>
                </div>

                <!-- Étape 3: Profession -->
                <div class="form-step-content" data-step="3">
                    <h4 class="form-section-title">Informations Professionnelles</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Profession / Type d'activité</label>
                            <input type="text" class="form-control @error('occupation') is-invalid @enderror" name="occupation" value="{{ old('occupation') }}" required>
                            <div class="invalid-feedback">@error('occupation') {{ $message }} @else Ce champ est requis. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Nom de l'entreprise (si applicable)</label>
                            <input type="text" class="form-control @error('company_name_activity') is-invalid @enderror" name="company_name_activity" value="{{ old('company_name_activity') }}">
                            <div class="invalid-feedback">@error('company_name_activity') {{ $message }} @else Ce champ est optionnel. @enderror</div>
                        </div>
                        <div class="col-12 mb-3 input-group-custom">
                            <label class="form-label">Description de l'activité</label>
                            <textarea class="form-control @error('activity_description') is-invalid @enderror" name="activity_description" rows="3">{{ old('activity_description') }}</textarea>
                            <div class="invalid-feedback">@error('activity_description') {{ $message }} @else Ce champ est optionnel. @enderror</div>
                        </div>
                    </div>
                    <h4 class="form-section-title mt-4">Personnes de Référence</h4>
                    <div id="references-container-physique">
                        @if (old('references'))
                        @foreach (old('references') as $index => $reference)
                        <div class="dynamic-field p-3 mb-3 border rounded position-relative">
                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-field">X</button>
                            <h5>Référence {{ $index + 1 }}</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3 input-group-custom">
                                    <label class="form-label">Nom & Prénoms</label>
                                    <input type="text" class="form-control @error(" references.$index.name") is-invalid @enderror" name="references[{{ $index }}][name]" value="{{ $reference['name'] }}" required>
                                    <div class="invalid-feedback">@error("references.$index.name") {{ $message }} @else Ce champ est requis. @enderror</div>
                                </div>
                                <div class="col-md-6 mb-3 input-group-custom">
                                    <label class="form-label">Téléphone</label>
                                    <input type="tel" class="form-control @error(" references.$index.phone") is-invalid @enderror" name="references[{{ $index }}][phone]" value="{{ $reference['phone'] }}" pattern="\+?[0-9\s\-\(\)]{7,15}" required>
                                    <div class="invalid-feedback">@error("references.$index.phone") {{ $message }} @else Numéro de téléphone invalide. @enderror</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="dynamic-field p-3 mb-3 border rounded position-relative">
                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-field">X</button>
                            <h5>Référence 1</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3 input-group-custom">
                                    <label class="form-label">Nom & Prénoms</label>
                                    <input type="text" class="form-control @error('references.0.name') is-invalid @enderror" name="references[0][name]" value="{{ old('references.0.name') }}" required>
                                    <div class="invalid-feedback">@error('references.0.name') {{ $message }} @else Ce champ est requis. @enderror</div>
                                </div>
                                <div class="col-md-6 mb-3 input-group-custom">
                                    <label class="form-label">Téléphone</label>
                                    <input type="tel" class="form-control @error('references.0.phone') is-invalid @enderror" name="references[0][phone]" value="{{ old('references.0.phone') }}" pattern="\+?[0-9\s\-\(\)]{7,15}" required>
                                    <div class="invalid-feedback">@error('references.0.phone') {{ $message }} @else Numéro de téléphone invalide. @enderror</div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-outline-primary mt-2 dynamic-adder-btn" data-container="references-container-physique" data-type="reference"><i class="fas fa-plus"></i> Ajouter une référence</button>
                    <div id="references-error" class="custom-error-message" style="display: none;">
                        <div class="error-content">
                            <i class="fas fa-exclamation-triangle error-icon"></i>
                            <div class="error-text">
                                <strong>Attention !</strong>
                                <span>Veuillez ajouter au moins une référence.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Étape 4: Documents -->
                <div class="form-step-content" data-step="4">
                    <h4 class="form-section-title">Documents d'Identification</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Type de pièce d'identité</label>
                            <select class="form-control @error('id_type') is-invalid @enderror" name="id_type" required>
                                <option value="">Sélectionner...</option>
                                <option value="CNI" {{ old('id_type') == 'CNI' ? 'selected' : '' }}>Carte Nationale d'Identité</option>
                                <option value="Passeport" {{ old('id_type') == 'Passeport' ? 'selected' : '' }}>Passeport</option>
                                <option value="Carte de Résident" {{ old('id_type') == 'Carte de Résident' ? 'selected' : '' }}>Carte de Résident</option>
                            </select>
                            <div class="invalid-feedback">@error('id_type') {{ $message }} @else Ce champ est requis. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Numéro de la pièce</label>
                            <input type="text" class="form-control @error('id_number') is-invalid @enderror" name="id_number" value="{{ old('id_number') }}" required>
                            <div class="invalid-feedback">@error('id_number') {{ $message }} @else Ce champ est requis. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3 input-group-custom">
                            <label class="form-label">Date d'émission de la pièce (optionnel)</label>
                            <input type="date" class="form-control @error('id_issue_date') is-invalid @enderror" name="id_issue_date" value="{{ old('id_issue_date') }}">
                            <div class="invalid-feedback">@error('id_issue_date') {{ $message }} @else Ce champ est optionnel. @enderror</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Photo d'identité</label>
                            <div class="file-upload-wrapper @error('photo_path') is-invalid @enderror">
                                <div class="file-upload-content">
                                    <i class="fas fa-camera file-upload-icon"></i>
                                    <p class="file-upload-text">Choisir une photo (JPEG, PNG)</p>
                                </div>
                                <div class="file-upload-preview"></div>
                                <input type="file" name="photo_path" accept="image/jpeg,image/png" required>
                                <div class="invalid-feedback">@error('photo_path') {{ $message }} @else Une photo est requise. @enderror</div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Scan de la pièce d'identité</label>
                            <div class="file-upload-wrapper @error('id_scan_path') is-invalid @enderror">
                                <div class="file-upload-content">
                                    <i class="fas fa-file-pdf file-upload-icon"></i>
                                    <p class="file-upload-text">Choisir un fichier (PDF)</p>
                                </div>
                                <div class="file-upload-preview"></div>
                                <input type="file" name="id_scan_path" accept="application/pdf" required>
                                <div class="invalid-feedback">@error('id_scan_path') {{ $message }} @else Le scan (PDF) est requis. @enderror</div>
                            </div>
                        </div>
                    </div>
                    <h4 class="form-section-title mt-4">Bénéficiaires Désignés</h4>
                    <div id="beneficiaries-container-physique">
                        @if (old('beneficiaries'))
                        @foreach (old('beneficiaries') as $index => $beneficiary)
                        <div class="dynamic-field p-3 mb-3 border rounded position-relative">
                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-field">X</button>
                            <h5>Bénéficiaire {{ $index + 1 }}</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3 input-group-custom">
                                    <label class="form-label">Nom & Prénoms</label>
                                    <input type="text" class="form-control @error(" beneficiaries.$index.nom") is-invalid @enderror" name="beneficiaries[{{ $index }}][nom]" value="{{ $beneficiary['nom'] }}" required>
                                    <div class="invalid-feedback">@error("beneficiaries.$index.nom") {{ $message }} @else Ce champ est requis. @enderror</div>
                                </div>
                                <div class="col-md-6 mb-3 input-group-custom">
                                    <label class="form-label">Lien / Relation</label>
                                    <input type="text" class="form-control @error(" beneficiaries.$index.lien") is-invalid @enderror" name="beneficiaries[{{ $index }}][lien]" value="{{ $beneficiary['lien'] }}" required>
                                    <div class="invalid-feedback">@error("beneficiaries.$index.lien") {{ $message }} @else Ce champ est requis. @enderror</div>
                                </div>
                                <div class="col-md-6 mb-3 input-group-custom">
                                    <label class="form-label">Téléphone</label>
                                    <input type="tel" class="form-control @error(" beneficiaries.$index.contact") is-invalid @enderror" name="beneficiaries[{{ $index }}][contact]" value="{{ $beneficiary['contact'] }}" pattern="\+?[0-9\s\-\(\)]{7,15}" required>
                                    <div class="invalid-feedback">@error("beneficiaries.$index.contact") {{ $message }} @else Numéro de téléphone invalide. @enderror</div>
                                </div>
                                <div class="col-md-6 mb-3 input-group-custom">
                                    <label class="form-label">Date de naissance</label>
                                    <input type="date" class="form-control @error(" beneficiaries.$index.birth_date") is-invalid @enderror" name="beneficiaries[{{ $index }}][birth_date]" value="{{ $beneficiary['birth_date'] }}">
                                    <div class="invalid-feedback">@error("beneficiaries.$index.birth_date") {{ $message }} @else Ce champ est optionnel. @enderror</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="dynamic-field p-3 mb-3 border rounded position-relative">
                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-field">X</button>
                            <h5>Bénéficiaire 1</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3 input-group-custom">
                                    <label class="form-label">Nom & Prénoms</label>
                                    <input type="text" class="form-control @error('beneficiaries.0.nom') is-invalid @enderror" name="beneficiaries[0][nom]" value="{{ old('beneficiaries.0.nom') }}" required>
                                    <div class="invalid-feedback">@error('beneficiaries.0.nom') {{ $message }} @else Ce champ est requis. @enderror</div>
                                </div>
                                <div class="col-md-6 mb-3 input-group-custom">
                                    <label class="form-label">Lien / Relation</label>
                                    <input type="text" class="form-control @error('beneficiaries.0.lien') is-invalid @enderror" name="beneficiaries[0][lien]" value="{{ old('beneficiaries.0.lien') }}" required>
                                    <div class="invalid-feedback">@error('beneficiaries.0.lien') {{ $message }} @else Ce champ est requis. @enderror</div>
                                </div>
                                <div class="col-md-6 mb-3 input-group-custom">
                                    <label class="form-label">Téléphone</label>
                                    <input type="tel" class="form-control @error('beneficiaries.0.contact') is-invalid @enderror" name="beneficiaries[0][contact]" value="{{ old('beneficiaries.0.contact') }}" pattern="\+?[0-9\s\-\(\)]{7,15}" required>
                                    <div class="invalid-feedback">@error('beneficiaries.0.contact') {{ $message }} @else Numéro de téléphone invalide. @enderror</div>
                                </div>
                                <div class="col-md-6 mb-3 input-group-custom">
                                    <label class="form-label">Date de naissance</label>
                                    <input type="date" class="form-control @error('beneficiaries.0.birth_date') is-invalid @enderror" name="beneficiaries[0][birth_date]" value="{{ old('beneficiaries.0.birth_date') }}">
                                    <div class="invalid-feedback">@error('beneficiaries.0.birth_date') {{ $message }} @else Ce champ est optionnel. @enderror</div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-outline-primary mt-2 dynamic-adder-btn" data-container="beneficiaries-container-physique" data-type="beneficiaire"><i class="fas fa-plus"></i> Ajouter un bénéficiaire</button>
                    <div id="beneficiaries-error" class="custom-error-message" style="display: none;">
                        <div class="error-content">
                            <i class="fas fa-exclamation-triangle error-icon"></i>
                            <div class="error-text">
                                <strong>Attention !</strong>
                                <span>Veuillez ajouter au moins un bénéficiaire.</span>
                            </div>
                        </div>
                    </div>

                    <!-- ==== BLOC SIGNATURE CORRIGÉ ==== -->

                </div>

                <!-- Étape 5: Versements + Consentement UMOA + Signature -->
                <div class="form-step-content" data-step="5">
                    <!-- Section Versements -->
                    <h4 class="form-section-title">Versements Initiaux</h4>
                    <div class="row align-items-center mb-5">
                        <div class="col-md-6">
                            <div class="input-group-custom mb-3">
                                <label class="form-label">Dépôt Initial (FCFA)</label>
                                <input type="number" class="form-control @error('initial_deposit') is-invalid @enderror" id="depot-initial-physique" name="initial_deposit" value="{{ old('initial_deposit', 0) }}" min="0" step="1000" required>
                                <div class="invalid-feedback">@error('initial_deposit') {{ $message }} @else Ce champ est requis. @enderror</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="versemants-summary">
                                <div class="row-item"><span class="label">Droit d'adhésion</span> <span class="value">2,000 FCFA</span></div>
                                <div class="row-item"><span class="label">Part Sociale</span> <span class="value">5,000 FCFA</span></div>
                                <div class="row-item total-row"><span class="total-label">TOTAL À VERSER</span> <span class="total-value" id="total-versement-physique">7,000 FCFA</span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Section Consentement UMOA -->
                    <h4 class="form-section-title">Consentement UMOA - Personne Physique</h4>
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="consent-form-header text-center">
                                <h5 class="mb-3"><strong>FORMULAIRE TYPE D'OBTENTION DU CONSENTEMENT DANS LE CADRE DU SYSTEME DE PARTAGE D'INFORMATION SUR LE CREDIT DANS L'UMOA</strong></h5>
                                <h6 class="mb-4"><strong>[PERSONNE PHYSIQUE]</strong></h6>
                            </div>
                        </div>

                        <!-- Checkboxes de consentement -->
                        <div class="col-12 mb-4">
                            <div class="consent-checkboxes">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="consent1" required>
                                    <label class="form-check-label" for="consent1">
                                        <strong>Accepte que les informations de crédit, historiques et courantes, me concernant notamment, les soldes approuvés et en souffrance, les limites de crédit, les cessations de paiement, le solde des arriérés auprès de la COOPERATIVE CHRETIENNE D'EPARGNE ET DE CREDIT (COCEC) soient transmises à CREDIT INFO VOLO COTE D'IVOIRE, Rue Des Jardins, Cocody, 2 Plateaux 01 BP 11266 Abidjan 01 - Côte d'Ivoire.</strong> <em>[Art 41 points 2, 3 et 4, Art 44, points 1 et 2]</em>
                                    </label>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="consent2" required>
                                    <label class="form-check-label" for="consent2">
                                        <strong>Accepte que les informations précitées soient communiquées par CREDIT INFO VOLO COTE D'IVOIRE aux établissements ayant accès à sa base de données, y compris ceux situés sur le territoire d'un autre Etat membre de l'UMOA.</strong> <em>[Art 42 point 1, Art 44, point 4]</em>
                                    </label>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="consent3" required>
                                    <label class="form-check-label" for="consent3">
                                        <strong>Comprends que ces informations ne peuvent, en aucun cas, porter sur mes dépôts</strong> <em>[Art 53, alinéa 3]</em>
                                    </label>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="consent4" required>
                                    <label class="form-check-label" for="consent4">
                                        <strong>Comprends que CREDIT INFO VOLO COTE D'IVOIRE ne diffusera que les informations dont l'ancienneté n'excède pas cinq (5) ans.</strong> <em>[Art 41, point 3]</em>
                                    </label>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="consent5" required>
                                    <label class="form-check-label" for="consent5">
                                        <strong>Comprends que CREDIT INFO VOLO COTE D'IVOIRE conservera ces informations pendant une durée de cinq (5) ans supplémentaire après la cession de la relation d'affaires avec la COOPERATIVE CHRETIENNE D'EPARGNE ET DE CREDIT (COCEC).</strong> <em>[Art 41, point 4]</em>
                                    </label>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="consent6" required>
                                    <label class="form-check-label" for="consent6">
                                        <strong>Comprends que j'ai le droit d'accès aux données me concernant dans la base de données CREDIT INFO VOLO COTE D'IVOIRE afin de vérifier mes historiques de crédit, de contester et faire corriger ou radier des informations erronées dans ladite base ou dans un rapport de crédit.</strong> <em>[Art 44, point 7]</em>
                                    </label>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="consent7" required>
                                    <label class="form-check-label" for="consent7">
                                        <strong>Comprends que j'ai le droit de recevoir toutes les informations conservées par CREDIT INFO VOLO COTE D'IVOIRE sur mon historique de crédit, sous la forme d'un rapport de crédit gratuitement une (1) fois par an et en cas de litige lié à une erreur dans les données, imputable à la COOPERATIVE CHRETIENNE D'EPARGNE ET DE CREDIT (COCEC) ou à CREDIT INFO VOLO COTE D'IVOIRE.</strong> <em>[Art 44, point 8]</em>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="alert alert-info">
                                <strong>Références de la Loi uniforme portant réglementation des BIC</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Section Signature Unique -->
                    <h4 class="form-section-title mt-5">Signature de l'Adhésion</h4>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="alert alert-warning">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Information importante :</strong> Cette signature sera prise en compte pour l'ensemble de votre adhésion et les autres questionnaires de cette procédure.
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row choice-container @error('signature_method') is-invalid @enderror">
                                <div class="col-6">
                                    <input type="radio" name="signature_method" id="draw_physique" value="draw" {{ old('signature_method', 'draw') == 'draw' ? 'checked' : '' }} required>
                                    <label for="draw_physique" class="choice-label"><i class="fas fa-pencil-alt"></i> Dessiner</label>
                                </div>
                                <div class="col-6">
                                    <input type="radio" name="signature_method" id="upload_physique" value="upload" {{ old('signature_method') == 'upload' ? 'checked' : '' }}>
                                    <label for="upload_physique" class="choice-label"><i class="fas fa-upload"></i> Importer</label>
                                </div>
                                <div class="invalid-feedback" id="signature-method-error">@error('signature_method') {{ $message }} @else Une méthode de signature est requise. @enderror</div>
                            </div>

                            <div class="method-area" id="draw-area-physique">
                                <p class="text-muted small">Signez dans le cadre ci-dessous.</p>
                                <canvas id="signature-pad" width="600" height="200"></canvas>
                                <div class="signature-controls">
                                    <button type="button" class="btn btn-outline-danger btn-sm" id="clear-signature-btn">
                                        <i class="fas fa-eraser me-2"></i>Effacer
                                    </button>
                                </div>
                                <input type="hidden" name="signature_data" id="signature-data-physique" value="{{ old('signature_data') }}">
                                <div id="signature-draw-error-physique" class="custom-error-message" style="display:none;">
                                    <div class="error-content">
                                        <i class="fas fa-exclamation-triangle error-icon"></i>
                                        <div class="error-text">
                                            <strong>Attention !</strong>
                                            <span>Veuillez dessiner une signature.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="method-area" id="upload-area-physique">
                                <div class="@error('signature_upload') is-invalid @enderror file-upload-wrapper">
                                    <div class="file-upload-content">
                                        <i class="fas fa-file-image file-upload-icon"></i>
                                        <p class="file-upload-text">Importer (PNG)</p>
                                    </div>
                                    <div class="file-upload-preview"></div>
                                    <input type="file" name="signature_upload" accept="image/png" />
                                    <div class="invalid-feedback">@error('signature_upload') {{ $message }} @else L'import de la signature est requis. @enderror</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Widget reCAPTCHA --}}
                <div class="mt-4 text-center" style="display: none;" id="recaptcha-container">
                    @include('components.recaptcha', ['action' => 'account_creation'])
                </div>

                <div class="form-navigation-buttons">
                    <button type="button" class="btn btn-nav btn-prev" style="display: none;"><i class="fas fa-arrow-left"></i> Précédent</button>
                    <button type="button" class="btn btn-nav btn-next">Suivant <i class="fas fa-arrow-right"></i> </button>
                    <button type="submit" class="btn btn-submit-form" style="display: none;"><i class="fas fa-paper-plane"></i> Soumettre l'Adhésion</button>
                </div>
            </form>
        </div>
    </div>

    <br><br><br>
    @include('includes.main.scroll')
    @include('includes.main.footer')
</section>
@endsection

@section('js')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('.multi-step-form');
        forms.forEach(form => {
            const steps = form.querySelectorAll('.form-step-content');
            const stepperItems = form.querySelectorAll('.form-stepper .step');
            const progressLine = form.querySelector('.form-stepper .progress-line');
            const prevBtn = form.querySelector('.btn-prev');
            const nextBtn = form.querySelector('.btn-next');
            const submitBtn = form.querySelector('.btn-submit-form');
            let currentStep = 1;
            const maps = new Map();

            function updateProgress() {
                const progress = (currentStep / steps.length) * 100;
                progressLine.style.width = `${progress}%`;
                stepperItems.forEach((item, index) => {
                    item.classList.toggle('active', index + 1 <= currentStep);
                    if (index + 1 < currentStep) {
                        item.classList.add('completed');
                    } else {
                        item.classList.remove('completed');
                    }
                });
            }

            function showStep(step) {
                steps.forEach(s => s.classList.remove('active'));
                steps[step - 1].classList.add('active');
                prevBtn.style.display = step === 1 ? 'none' : 'inline-block';
                nextBtn.style.display = step === steps.length ? 'none' : 'inline-block';
                submitBtn.style.display = step === steps.length ? 'inline-block' : 'none';
                updateProgress();

                // Afficher/masquer reCAPTCHA selon l'étape
                const recaptchaContainer = document.getElementById('recaptcha-container');
                if (recaptchaContainer) {
                    if (step === steps.length) {
                        recaptchaContainer.style.display = 'block';
                    } else {
                        recaptchaContainer.style.display = 'none';
                    }
                }

                const mapContainers = steps[step - 1].querySelectorAll('.map-container');
                mapContainers.forEach(container => {
                    const mapId = container.id;
                    const mapObj = maps.get(mapId);
                    if (mapObj) {
                        setTimeout(() => mapObj.invalidate(), 100);
                    }
                });
            }

            function validateStep(step) {
                const currentStepContent = steps[step - 1];
                const requiredInputs = currentStepContent.querySelectorAll('input[required], select[required], textarea[required]');
                let isValid = true;

                // Réinitialiser tous les états d'erreur
                currentStepContent.querySelectorAll('.is-invalid').forEach(element => {
                    element.classList.remove('is-invalid');
                });

                requiredInputs.forEach(input => {
                    // Ne pas valider les champs de signature ici, ils ont leur propre logique
                    if (input.name.includes('signature')) return;

                    if (!input.value.trim()) {
                        input.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        input.classList.remove('is-invalid');
                    }

                    if (input.type === 'tel' && input.pattern) {
                        const regex = new RegExp(input.pattern);
                        if (!regex.test(input.value)) {
                            input.classList.add('is-invalid');
                            isValid = false;
                        }
                    }
                });

                // Validation pour loc_method_residence
                const locMethodResidence = currentStepContent.querySelector('input[name="loc_method_residence"]:checked');
                if (locMethodResidence) {
                    if (locMethodResidence.value === 'description') {
                        const descInput = currentStepContent.querySelector('textarea[name="residence_description"]');
                        if (descInput && !descInput.value.trim()) {
                            descInput.classList.add('is-invalid');
                            isValid = false;
                        }
                    } else if (locMethodResidence.value === 'map') {
                        const latInput = currentStepContent.querySelector('input[name="residence_lat"]');
                        const lngInput = currentStepContent.querySelector('input[name="residence_lng"]');
                        if (latInput && lngInput && (!latInput.value || !lngInput.value)) {
                            latInput.classList.add('is-invalid');
                            lngInput.classList.add('is-invalid');
                            isValid = false;
                        }
                    }
                } else if (step === 2 && currentStepContent.querySelector('input[name="loc_method_residence"]')) {
                    const choiceContainer = currentStepContent.querySelector('input[name="loc_method_residence"]').closest('.choice-container');
                    choiceContainer.classList.add('is-invalid');
                    isValid = false;
                }

                // Validation pour loc_method_workplace - TOUJOURS FACULTATIF
                const locMethodWorkplace = currentStepContent.querySelector('input[name="loc_method_workplace"]:checked');
                if (locMethodWorkplace) {
                    // Si l'utilisateur a choisi une méthode, on peut valider les champs correspondants
                    // MAIS on ne force jamais l'utilisateur à choisir une méthode
                    if (locMethodWorkplace.value === 'description') {
                        const descInput = currentStepContent.querySelector('textarea[name="workplace_description"]');
                        // Le champ reste facultatif même si la méthode est choisie
                        if (descInput && descInput.value.trim()) {
                            descInput.classList.remove('is-invalid');
                        }
                    } else if (locMethodWorkplace.value === 'map') {
                        const latInput = currentStepContent.querySelector('input[name="workplace_lat"]');
                        const lngInput = currentStepContent.querySelector('input[name="workplace_lng"]');
                        // Les coordonnées restent facultatives même si la méthode est choisie
                        if (latInput && lngInput && latInput.value && lngInput.value) {
                            latInput.classList.remove('is-invalid');
                            lngInput.classList.remove('is-invalid');
                        }
                    }
                }
                // SUPPRIMÉ : Plus de validation obligatoire pour loc_method_workplace

                // ==== BLOC VALIDATION SIGNATURE CORRIGÉ ====
                const signatureMethod = currentStepContent.querySelector('input[name="signature_method"]:checked');
                if (signatureMethod) {
                    if (signatureMethod.value === 'draw') {
                        const canvas = currentStepContent.querySelector('#signature-pad');
                        const signaturePad = canvas.signaturePadInstance;
                        if (signaturePad && signaturePad.isEmpty()) {
                            currentStepContent.querySelector('#signature-draw-error-physique').style.display = 'block';
                            isValid = false;
                        } else {
                            currentStepContent.querySelector('#signature-draw-error-physique').style.display = 'none';
                        }
                    } else if (signatureMethod.value === 'upload') {
                        const signatureUpload = currentStepContent.querySelector('input[name="signature_upload"]');
                        if (!signatureUpload.files.length) {
                            signatureUpload.closest('.file-upload-wrapper').classList.add('is-invalid');
                            isValid = false;
                        } else {
                            signatureUpload.closest('.file-upload-wrapper').classList.remove('is-invalid');
                        }
                    }
                } else if (step === 4 && currentStepContent.querySelector('input[name="signature_method"]')) {
                    const choiceContainer = currentStepContent.querySelector('input[name="signature_method"]').closest('.choice-container');
                    choiceContainer.classList.add('is-invalid');
                    isValid = false;
                }
                // ==== FIN BLOC VALIDATION SIGNATURE CORRIGÉ ====

                // Validation pour l'étape UMOA (étape 5)
                if (step === 5) {
                    // Vérifier que tous les checkboxes sont cochés
                    const checkboxes = currentStepContent.querySelectorAll('input[type="checkbox"]');
                    let uncheckedCount = 0;

                    checkboxes.forEach((checkbox, index) => {
                        if (!checkbox.checked) {
                            checkbox.classList.add('is-invalid');
                            // Ajouter un message d'erreur sous chaque checkbox non coché
                            let errorDiv = checkbox.parentNode.querySelector('.umoa-checkbox-error');
                            if (!errorDiv) {
                                errorDiv = document.createElement('div');
                                errorDiv.className = 'umoa-checkbox-error invalid-feedback';
                                errorDiv.style.display = 'block';
                                errorDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Ce consentement est obligatoire pour continuer.';
                                checkbox.parentNode.appendChild(errorDiv);
                            }
                            uncheckedCount++;
                            isValid = false;
                        } else {
                            checkbox.classList.remove('is-invalid');
                            // Supprimer le message d'erreur si le checkbox est coché
                            const errorDiv = checkbox.parentNode.querySelector('.umoa-checkbox-error');
                            if (errorDiv) {
                                errorDiv.remove();
                            }
                        }
                    });

                    // Afficher un message d'erreur général si des checkboxes ne sont pas cochés
                    let generalError = currentStepContent.querySelector('.umoa-general-error');
                    if (uncheckedCount > 0) {
                        if (!generalError) {
                            generalError = document.createElement('div');
                            generalError.className = 'umoa-general-error alert alert-danger mt-3';
                            generalError.innerHTML = `
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Attention :</strong> Vous devez accepter tous les consentements UMOA pour continuer. 
                                <span class="badge bg-danger ms-2">${uncheckedCount} consentement(s) manquant(s)</span>
                            `;
                            currentStepContent.querySelector('.consent-checkboxes').after(generalError);
                        }
                    } else {
                        if (generalError) {
                            generalError.remove();
                        }
                    }

                    // Vérifier la signature
                    const signatureMethod = currentStepContent.querySelector('input[name="signature_method"]:checked');
                    if (signatureMethod) {
                        if (signatureMethod.value === 'draw') {
                            const canvas = currentStepContent.querySelector('#signature-pad');
                            const signaturePad = canvas.signaturePadInstance;
                            if (signaturePad && signaturePad.isEmpty()) {
                                currentStepContent.querySelector('#signature-draw-error-physique').style.display = 'block';
                                isValid = false;
                            } else {
                                currentStepContent.querySelector('#signature-draw-error-physique').style.display = 'none';
                            }
                        } else if (signatureMethod.value === 'upload') {
                            const signatureUpload = currentStepContent.querySelector('input[name="signature_upload"]');
                            if (!signatureUpload.files.length) {
                                signatureUpload.closest('.file-upload-wrapper').classList.add('is-invalid');
                                isValid = false;
                            } else {
                                signatureUpload.closest('.file-upload-wrapper').classList.remove('is-invalid');
                            }
                        }
                    } else {
                        const choiceContainer = currentStepContent.querySelector('input[name="signature_method"]').closest('.choice-container');
                        choiceContainer.classList.add('is-invalid');
                        isValid = false;
                    }

                    // Vérifier reCAPTCHA à la dernière étape
                    if (!window.isRecaptchaResolved()) {
                        isValid = false;
                        // Afficher un message d'erreur pour reCAPTCHA
                        let recaptchaError = document.querySelector('.recaptcha-error');
                        if (!recaptchaError) {
                            recaptchaError = document.createElement('div');
                            recaptchaError.className = 'recaptcha-error alert alert-warning mt-3';
                            recaptchaError.innerHTML = '<i class="fas fa-shield-alt me-2"></i>Veuillez cocher la case "Je ne suis pas un robot" pour continuer.';
                            document.getElementById('recaptcha-container').after(recaptchaError);
                        }
                    } else {
                        // Supprimer l'erreur reCAPTCHA si résolu
                        const recaptchaError = document.querySelector('.recaptcha-error');
                        if (recaptchaError) {
                            recaptchaError.remove();
                        }
                    }
                }

                // Validation pour références et bénéficiaires
                if (step === 3 || step === 4) {
                    const containerId = step === 3 ? 'references-container-physique' : 'beneficiaries-container-physique';
                    const errorId = step === 3 ? 'references-error' : 'beneficiaries-error';
                    const container = currentStepContent.querySelector(`#${containerId}`);
                    const errorDiv = currentStepContent.querySelector(`#${errorId}`);

                    if (container) {
                        const fields = container.querySelectorAll('.dynamic-field');
                        if (fields.length === 0) {
                            if (errorDiv) {
                                errorDiv.style.display = 'block';
                            }
                            isValid = false;
                        } else {
                            if (errorDiv) {
                                errorDiv.style.display = 'none';
                            }
                        }
                    }
                }

                if (!isValid) {
                    const firstInvalid = currentStepContent.querySelector('.is-invalid, .is-invalid .form-control');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                }

                return isValid;
            }

            prevBtn.addEventListener('click', () => {
                if (currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            });

            nextBtn.addEventListener('click', () => {
                if (validateStep(currentStep) && currentStep < steps.length) {
                    currentStep++;
                    showStep(currentStep);
                }
            });

            const depotInput = form.querySelector('#depot-initial-physique');
            const totalSpan = form.querySelector('#total-versement-physique');
            if (depotInput && totalSpan) {
                const baseAmount = 7000;
                depotInput.addEventListener('input', () => {
                    const depot = parseFloat(depotInput.value) || 0;
                    totalSpan.textContent = `${(baseAmount + depot).toLocaleString('fr-FR')} FCFA`;
                });
            }

            form.querySelectorAll('.dynamic-adder-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const containerId = btn.dataset.container;
                    const type = btn.dataset.type;
                    const container = document.getElementById(containerId);
                    const index = container.querySelectorAll('.dynamic-field').length;
                    const template = type === 'beneficiaire' ? `
                    <div class="dynamic-field p-3 mb-3 border rounded position-relative">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-field">X</button>
                        <h5>Bénéficiaire ${index + 1}</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3 input-group-custom">
                                <label class="form-label">Nom & Prénoms</label>
                                <input type="text" class="form-control" name="beneficiaries[${index}][nom]" required>
                                <div class="invalid-feedback">Ce champ est requis.</div>
                            </div>
                            <div class="col-md-6 mb-3 input-group-custom">
                                <label class="form-label">Lien / Relation</label>
                                <input type="text" class="form-control" name="beneficiaries[${index}][lien]" required>
                                <div class="invalid-feedback">Ce champ est requis.</div>
                            </div>
                            <div class="col-md-6 mb-3 input-group-custom">
                                <label class="form-label">Téléphone</label>
                                <input type="tel" class="form-control" name="beneficiaries[${index}][contact]" pattern="\+?[0-9\s\-\(\)]{7,15}" required>
                                <div class="invalid-feedback">Numéro de téléphone invalide.</div>
                            </div>
                            <div class="col-md-6 mb-3 input-group-custom">
                                <label class="form-label">Date de naissance</label>
                                <input type="date" class="form-control" name="beneficiaries[${index}][birth_date]">
                                <div class="invalid-feedback">Ce champ est optionnel.</div>
                            </div>
                        </div>
                    </div>` : `
                    <div class="dynamic-field p-3 mb-3 border rounded position-relative">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-field">X</button>
                        <h5>Référence ${index + 1}</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3 input-group-custom">
                                <label class="form-label">Nom & Prénoms</label>
                                <input type="text" class="form-control" name="references[${index}][name]" required>
                                <div class="invalid-feedback">Ce champ est requis.</div>
                            </div>
                            <div class="col-md-6 mb-3 input-group-custom">
                                <label class="form-label">Téléphone</label>
                                <input type="tel" class="form-control" name="references[${index}][phone]" pattern="\+?[0-9\s\-\(\)]{7,15}" required>
                                <div class="invalid-feedback">Numéro de téléphone invalide.</div>
                            </div>
                        </div>
                    </div>`;
                    container.insertAdjacentHTML('beforeend', template);
                    const errorDiv = container.querySelector('.invalid-feedback');
                    if (errorDiv) errorDiv.remove();

                    // Masquer le message d'erreur personnalisé
                    const customErrorId = type === 'beneficiaire' ? 'beneficiaries-error' : 'references-error';
                    const customErrorDiv = document.getElementById(customErrorId);
                    if (customErrorDiv) {
                        customErrorDiv.style.display = 'none';
                    }

                    container.querySelectorAll('.remove-field').forEach(removeBtn => {
                        removeBtn.addEventListener('click', () => removeBtn.closest('.dynamic-field').remove());
                    });
                });
            });

            form.querySelectorAll('input[type="file"]').forEach(input => {
                input.addEventListener('change', () => {
                    const wrapper = input.closest('.file-upload-wrapper');
                    const preview = wrapper.querySelector('.file-upload-preview');
                    const file = input.files[0];
                    if (file) {
                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                preview.innerHTML = `<img src="${e.target.result}" alt="Aperçu">`;
                            };
                            reader.readAsDataURL(file);
                        } else {
                            preview.innerHTML = `<span>${file.name}</span>`;
                        }
                        wrapper.classList.remove('is-invalid');
                    } else {
                        preview.innerHTML = '';
                        wrapper.classList.toggle('is-invalid', input.hasAttribute('required'));
                    }
                });
            });

            const locRadiosResidence = form.querySelectorAll('input[name="loc_method_residence"]');
            locRadiosResidence.forEach(radio => {
                radio.addEventListener('change', () => {
                    const descArea = form.querySelector('#description-area-physique');
                    const mapArea = form.querySelector('#map-area-physique');
                    const descInput = descArea.querySelector('textarea[name="residence_description"]');
                    const latInput = mapArea.querySelector('input[name="residence_lat"]');
                    const lngInput = mapArea.querySelector('input[name="residence_lng"]');

                    descArea.style.display = radio.value === 'description' ? 'block' : 'none';
                    mapArea.style.display = radio.value === 'map' ? 'block' : 'none';
                    descInput.toggleAttribute('required', radio.value === 'description');
                    latInput.toggleAttribute('required', radio.value === 'map');
                    lngInput.toggleAttribute('required', radio.value === 'map');

                    if (radio.value === 'map') {
                        const mapObj = maps.get('map-container-physique');
                        if (mapObj) {
                            setTimeout(() => mapObj.invalidate(), 100);
                        }
                    }
                });
                if (radio.checked) radio.dispatchEvent(new Event('change'));
            });

            const locRadiosWorkplace = form.querySelectorAll('input[name="loc_method_workplace"]');
            locRadiosWorkplace.forEach(radio => {
                radio.addEventListener('change', () => {
                    const descArea = form.querySelector('#description-area-workplace');
                    const mapArea = form.querySelector('#map-area-workplace');
                    const descInput = descArea.querySelector('textarea[name="workplace_description"]');
                    const latInput = mapArea.querySelector('input[name="workplace_lat"]');
                    const lngInput = mapArea.querySelector('input[name="workplace_lng"]');

                    // Afficher la zone correspondante au choix
                    if (radio.value === 'description') {
                        descArea.style.display = 'block';
                        mapArea.style.display = 'none';
                    } else if (radio.value === 'map') {
                        descArea.style.display = 'none';
                        mapArea.style.display = 'block';

                        const mapObj = maps.get('map-container-workplace');
                        if (mapObj) {
                            setTimeout(() => mapObj.invalidate(), 100);
                        }
                    }

                    // JAMAIS d'attribut required - TOUJOURS facultatif
                    descInput.removeAttribute('required');
                    latInput.removeAttribute('required');
                    lngInput.removeAttribute('required');
                });

                // Afficher la zone par défaut selon le choix initial
                if (radio.checked) {
                    radio.dispatchEvent(new Event('change'));
                }
            });

            // Afficher la zone de description par défaut si aucune méthode n'est sélectionnée
            const defaultWorkplaceMethod = form.querySelector('input[name="loc_method_workplace"]:checked');
            if (!defaultWorkplaceMethod) {
                const descArea = form.querySelector('#description-area-workplace');
                descArea.style.display = 'block';
            }

            function initializeLeafletMap(mapId, latInputId, lonInputId) {
                const mapContainer = document.getElementById(mapId);
                if (!mapContainer) return null;

                const latInput = document.getElementById(latInputId);
                const lonInput = document.getElementById(lonInputId);
                const fallbackCoords = [6.1375, 1.2226];
                let map;
                let marker;

                const setupMap = (coords) => {
                    if (map) {
                        map.setView(coords, 14);
                        marker.setLatLng(coords);
                        updateInputs(coords);
                        return;
                    }

                    map = L.map(mapId).setView(coords, 14);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                    }).addTo(map);

                    marker = L.marker(coords, {
                        draggable: true
                    }).addTo(map);
                    updateInputs(marker.getLatLng());

                    marker.on('dragend', (event) => updateInputs(event.target.getLatLng()));
                    map.on('click', (e) => {
                        marker.setLatLng(e.latlng);
                        updateInputs(e.latlng);
                    });
                };

                const updateInputs = (latlng) => {
                    latInput.value = latlng.lat.toFixed(6);
                    lonInput.value = latlng.lng.toFixed(6);
                };

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => setupMap([position.coords.latitude, position.coords.longitude]),
                        () => setupMap(fallbackCoords)
                    );
                } else {
                    setupMap(fallbackCoords);
                }

                return {
                    invalidate: () => {
                        if (map) map.invalidateSize();
                    }
                };
            }

            maps.set('map-container-physique', initializeLeafletMap('map-container-physique', 'latitude-physique', 'longitude-physique'));
            maps.set('map-container-workplace', initializeLeafletMap('map-container-workplace', 'latitude-workplace', 'longitude-workplace'));

            // ==== FONCTIONS SIGNATURE CORRIGÉES (SANS formType) ====
            function setupSignatureChoice() {
                const radioButtons = form.querySelectorAll('input[name="signature_method"]');
                if (!radioButtons.length) return;

                const drawArea = form.querySelector('#draw-area-physique');
                const uploadArea = form.querySelector('#upload-area-physique');
                const canvas = form.querySelector('#signature-pad');
                const uploadInput = form.querySelector('input[name="signature_upload"]');
                let signaturePadInstance = null;

                function updateSignatureArea() {
                    const selectedValue = form.querySelector('input[name="signature_method"]:checked')?.value;
                    if (!selectedValue) return;

                    drawArea.style.display = selectedValue === 'draw' ? 'block' : 'none';
                    uploadArea.style.display = selectedValue === 'upload' ? 'block' : 'none';
                    uploadInput.toggleAttribute('required', selectedValue === 'upload');

                    if (selectedValue === 'draw' && !signaturePadInstance) {
                        signaturePadInstance = initializeSignaturePad(canvas);
                    }
                }

                radioButtons.forEach(radio => radio.addEventListener('change', updateSignatureArea));
                updateSignatureArea(); // Lancer au chargement
            }

            function initializeSignaturePad(canvas) {
                if (!canvas) return null;

                const hiddenInput = form.querySelector('#signature-data-physique');
                const clearBtn = form.querySelector('#clear-signature-btn');
                let signaturePad = null;
                let isInitialized = false;

                const resizeCanvas = () => {
                    const ratio = Math.max(window.devicePixelRatio || 1, 1);
                    const parentWidth = canvas.parentElement.offsetWidth;

                    if (parentWidth > 0) {
                        canvas.width = parentWidth * ratio;
                        canvas.height = (canvas.offsetHeight || 200) * ratio;
                        canvas.getContext('2d').scale(ratio, ratio);

                        const data = signaturePad ? signaturePad.toData() : [];

                        signaturePad = new SignaturePad(canvas, {
                            backgroundColor: 'rgb(255, 255, 255)',
                            penColor: 'rgb(0, 0, 0)'
                        });
                        canvas.signaturePadInstance = signaturePad;

                        // Restaurer les données si elles existent
                        if (data.length > 0) {
                            signaturePad.fromData(data);
                        }

                        // Ajouter l'événement endStroke seulement une fois
                        if (!isInitialized) {
                            signaturePad.addEventListener('endStroke', () => {
                                console.log('Signature stroke ended');
                                if (!signaturePad.isEmpty()) {
                                    const signatureData = signaturePad.toDataURL('image/png');
                                    console.log('Signature data length:', signatureData.length);
                                    hiddenInput.value = signatureData;
                                    form.querySelector('#signature-draw-error-physique').style.display = 'none';
                                } else {
                                    hiddenInput.value = '';
                                }
                            });
                            isInitialized = true;
                        }
                    }
                };

                const resizeObserver = new ResizeObserver(resizeCanvas);
                resizeObserver.observe(canvas.parentElement);

                // Exécute une fois pour l'initialisation
                resizeCanvas();

                clearBtn.addEventListener('click', () => {
                    if (signaturePad) {
                        signaturePad.clear();
                    }
                    hiddenInput.value = '';
                    form.querySelector('#signature-draw-error-physique').style.display = 'none';
                    console.log('Signature cleared');
                });

                return signaturePad;
            }

            setupSignatureChoice();
            // ==== FIN FONCTIONS SIGNATURE CORRIGÉES ====

            // Fonction pour sauvegarder la signature avant soumission
            form.addEventListener('submit', function(e) {
                // ==== VALIDATION OBLIGATOIRE DES CHECKBOXES UMOA ====
                const umoaCheckboxes = form.querySelectorAll('.consent-checkboxes input[type="checkbox"]');
                let uncheckedCount = 0;

                umoaCheckboxes.forEach(checkbox => {
                    if (!checkbox.checked) {
                        uncheckedCount++;
                    }
                });

                if (uncheckedCount > 0) {
                    e.preventDefault();
                    // Afficher un message d'erreur
                    Swal.fire({
                        icon: 'warning',
                        title: 'Consentements UMOA requis',
                        html: `
                            <div class="text-center">
                                <i class="fas fa-exclamation-triangle text-warning mb-3" style="font-size: 3rem;"></i>
                                <p><strong>Vous devez accepter tous les consentements UMOA pour continuer.</strong></p>
                                <p class="text-muted">${uncheckedCount} consentement(s) manquant(s)</p>
                            </div>
                        `,
                        confirmButtonText: 'Comprendre',
                        confirmButtonColor: '#EC281C',
                        background: '#fff'
                    });

                    // Aller à l'étape 5 (UMOA)
                    currentStep = 5;
                    showStep(currentStep);

                    // Mettre en évidence les checkboxes non cochés
                    umoaCheckboxes.forEach(checkbox => {
                        if (!checkbox.checked) {
                            checkbox.classList.add('is-invalid');
                        }
                    });

                    // Afficher le message d'erreur général
                    let generalError = document.querySelector('.umoa-general-error');
                    if (!generalError) {
                        generalError = document.createElement('div');
                        generalError.className = 'umoa-general-error alert alert-danger mt-3';
                        generalError.innerHTML = `
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Attention :</strong> Vous devez accepter tous les consentements UMOA pour continuer. 
                            <span class="badge bg-danger ms-2">${uncheckedCount} consentement(s) manquant(s)</span>
                        `;
                        const consentContainer = document.querySelector('.consent-checkboxes');
                        if (consentContainer) {
                            consentContainer.after(generalError);
                        }
                    }

                    return false;
                }

                // ==== VALIDATION DE LA SIGNATURE ====
                const signatureMethod = form.querySelector('input[name="signature_method"]:checked');
                if (signatureMethod && signatureMethod.value === 'draw') {
                    const canvas = form.querySelector('#signature-pad');
                    const signaturePad = canvas.signaturePadInstance;
                    const hiddenInput = form.querySelector('#signature-data-physique');

                    if (signaturePad && !signaturePad.isEmpty()) {
                        const signatureData = signaturePad.toDataURL('image/png');
                        console.log('Saving signature before submit, length:', signatureData.length);
                        hiddenInput.value = signatureData;
                    } else {
                        console.log('Signature pad is empty or not available');
                        e.preventDefault();

                        Swal.fire({
                            icon: 'warning',
                            title: 'Signature requise',
                            text: 'Veuillez dessiner votre signature avant de continuer.',
                            confirmButtonText: 'Comprendre',
                            confirmButtonColor: '#EC281C',
                            background: '#fff'
                        });

                        // Aller à l'étape 5
                        currentStep = 5;
                        showStep(currentStep);
                        return false;
                    }
                } else if (signatureMethod && signatureMethod.value === 'upload') {
                    const signatureUpload = form.querySelector('input[name="signature_upload"]');
                    if (!signatureUpload.files.length) {
                        e.preventDefault();

                        Swal.fire({
                            icon: 'warning',
                            title: 'Signature requise',
                            text: 'Veuillez importer votre signature avant de continuer.',
                            confirmButtonText: 'Comprendre',
                            confirmButtonColor: '#EC281C',
                            background: '#fff'
                        });

                        signatureUpload.closest('.file-upload-wrapper').classList.add('is-invalid');
                        // Aller à l'étape 5
                        currentStep = 5;
                        showStep(currentStep);
                        return false;
                    }
                } else {
                    e.preventDefault();

                    Swal.fire({
                        icon: 'warning',
                        title: 'Méthode de signature requise',
                        text: 'Veuillez choisir une méthode de signature (dessiner ou importer).',
                        confirmButtonText: 'Comprendre',
                        confirmButtonColor: '#EC281C',
                        background: '#fff'
                    });

                    // Aller à l'étape 5
                    currentStep = 5;
                    showStep(currentStep);
                    return false;
                }

                // ==== TOUTES LES VALIDATIONS SONT PASSÉES - SOUMISSION ====
                // Afficher le loader SweetAlert avant soumission
                Swal.fire({
                    title: 'Envoi en cours...',
                    text: 'Votre adhésion est en cours de transmission',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            });
        });
    });



    // Intercepter les messages de validation après soumission
    document.addEventListener('DOMContentLoaded', function() {
        // Intercepter les messages de succès
        const successAlert = document.querySelector('.alert-success');
        if (successAlert) {
            const message = successAlert.textContent.trim();
            Swal.fire({
                icon: 'success',
                title: 'Succès !',
                text: message,
                confirmButtonColor: '#EC281C',
                background: '#fff',

            });
            successAlert.remove();
        }

        // Intercepter les messages d'erreur
        const errorAlert = document.querySelector('.alert-danger');
        if (errorAlert) {
            let message = '';
            let title = 'Erreur !';

            // Vérifier s'il y a une liste d'erreurs de validation
            const errorList = errorAlert.querySelector('ul');
            if (errorList) {
                title = 'Erreurs de validation';
                message = errorList.outerHTML;
            } else {
                message = errorAlert.textContent.trim();
            }

            Swal.fire({
                icon: 'warning',
                title: title,
                html: message,
                confirmButtonColor: '#EC281C',
                background: '#fff',

            });
            errorAlert.remove();
        }
    });
</script>
@endsection