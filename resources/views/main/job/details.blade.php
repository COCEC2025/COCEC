@extends('layout.main')

{{-- ============================================= --}}
{{-- SECTION CSS DÉDIÉE À LA PAGE         --}}
{{-- ============================================= --}}
@section('css')
<style>
    /* 1. VARIABLES DE COULEURS ET STYLES DE BASE (INCHANGÉ) */
    :root {
        --primary-color: #EC281C;
        --secondary-color: #FFCC00;
        --text-dark: #212529;
        --text-light: #6c757d;
        --bg-light: #f8f9fa;
        --white: #ffffff;
        --border-color: #e9eaec;
        --error-color: #dc3545;
    }

    body {
        font-family: 'Poppins', sans-serif;
    }

    .page-section {
        padding: 80px 0;
    }

    .page-section-light {
        background-color: var(--bg-light);
        padding: 80px 0;
    }

    .section-header {
        margin-bottom: 50px;
    }

    .section-title {
        font-weight: 700;
        color: var(--text-dark);
    }

    .section-intro {
        color: var(--text-light);
        max-width: 650px;
        margin: 15px auto 0 auto;
    }

    /* 2. CONTENU PRINCIPAL DE L'OFFRE (INCHANGÉ) */
    .offer-main-content .content-title-wrapper {
        border-left: 4px solid var(--primary-color);
        padding-left: 20px;
        margin-bottom: 30px;
    }

    .offer-main-content h2 {
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
        font-size: 2rem;
    }

    .offer-main-content .description-section {
        color: #555;
        line-height: 1.8;
        font-size: 1.1rem;
    }

    .description-section ul {
        padding-left: 20px;
    }

    .description-section li {
        margin-bottom: 10px;
    }

    /* 3. CARTE RÉSUMÉ (STICKY) (INCHANGÉ) */
    .summary-card-revisited {
        background: var(--white);
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--border-color);
        position: sticky;
        top: 120px;
        border-top: 5px solid var(--secondary-color);
    }

    .summary-card-revisited .card-content {
        padding: 30px;
    }

    .summary-card-revisited .card-badge-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .summary-card-revisited h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text-dark);
        line-height: 1.4;
    }

    .summary-card-revisited .company {
        font-size: 1rem;
        color: var(--text-light);
    }

    .job-type-badge {
        display: inline-block;
        padding: 6px 15px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
    }

    .job-type-badge.emploi {
        background-color: rgba(236, 40, 28, 0.1);
        color: var(--primary-color);
    }

    .job-type-badge.stage {
        background-color: rgba(255, 204, 0, 0.2);
        color: #c39a00;
    }

    .summary-card-revisited .btn-apply {
        width: 100%;
        padding: 15px;
        font-weight: 600;
        font-size: 1.1rem;
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .summary-card-revisited .btn-apply:hover {
        background-color: #c41e12;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(236, 40, 28, 0.3);
    }

    .summary-list {
        list-style: none;
        padding: 0;
        margin: 25px 0;
        border-top: 1px solid var(--border-color);
    }

    .summary-list li {
        display: flex;
        align-items: center;
        padding: 15px 0;
        font-size: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .summary-list li i {
        font-size: 1.2rem;
        margin-right: 15px;
        width: 25px;
        text-align: center;
        color: var(--primary-color);
    }

    .summary-list li strong {
        color: var(--text-dark);
        margin-right: 8px;
    }

    .summary-list li span {
        color: var(--text-light);
    }

    .share-section {
        text-align: center;
    }

    .share-section p {
        font-weight: 500;
        color: #555;
        margin-bottom: 10px;
    }

    .share-links a {
        color: #aaa;
        font-size: 1.5rem;
        margin: 0 10px;
        transition: color 0.3s ease;
    }

    .share-links a:hover {
        color: var(--primary-color);
    }

    /* ==================================================== */
    /*   4. NOUVEAU DESIGN PREMIUM POUR LE FORMULAIRE       */
    /* ==================================================== */
    .premium-form-container {
        max-width: 800px;
        margin: 0 auto;
        background: var(--white);
        padding: 50px;
        border-radius: 16px;
        box-shadow: 0 15px 60px rgba(0, 0, 0, 0.1);
    }

    /* Style pour les labels flottants */
    .form-floating-group {
        position: relative;
    }

    .form-floating-group .form-control {
        height: 55px;
        /* Hauteur de champ plus généreuse */
        padding: 15px;
    }

    .form-floating-group .form-label {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        padding: 1rem 0.75rem;
        pointer-events: none;
        border: 1px solid transparent;
        transform-origin: 0 0;
        transition: opacity .1s ease-in-out, transform .1s ease-in-out;
        color: var(--text-light);
    }

    /* Animation du label flottant */
    .form-floating-group .form-control:focus~.form-label,
    .form-floating-group .form-control:not(:placeholder-shown)~.form-label {
        opacity: .65;
        transform: scale(.85) translateY(-.8rem) translateX(.15rem);
        color: var(--primary-color);
        font-weight: 600;
        background-color: var(--white);
        padding: 0 5px;
    }

    /* Style des champs de fichier */
    .file-upload-wrapper {
        border: 2px dashed var(--border-color);
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.3s ease, background-color 0.3s ease;
    }

    .file-upload-wrapper:hover {
        border-color: var(--primary-color);
    }

    .file-upload-wrapper .upload-icon {
        font-size: 1.8rem;
        color: var(--primary-color);
        margin-bottom: 8px;
    }

    .file-upload-wrapper .upload-text {
        font-weight: 500;
        color: var(--text-dark);
    }

    .file-upload-wrapper .upload-hint {
        font-size: 0.8rem;
        color: var(--text-light);
    }

    .file-upload-wrapper input[type="file"] {
        display: none;
    }

    /* Bouton d'envoi pleine largeur */
    .btn-submit-premium {
        width: 100%;
        background-color: var(--primary-color);
        color: var(--white);
        padding: 16px;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 8px;
        border: none;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-submit-premium:hover {
        background-color: #c41e12;
        transform: scale(1.02);
    }

    .btn-submit-premium:disabled {
        background-color: #ccc;
    }

    /* Styles de validation pour le nouveau design */
    .form-control.is-invalid {
        border-color: var(--error-color);
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }

    .file-upload-wrapper.is-invalid {
        border-color: var(--error-color);
    }

    .invalid-feedback {
        display: none;
        width: 100%;
        margin-top: 0.25rem;
        font-size: .875em;
        color: var(--error-color);
    }

    .is-invalid~.invalid-feedback {
        display: block;
    }
</style>
@endsection


@section('content')

<body>
    @include('includes.main.loading')
    @include('includes.main.header')

    {{-- HERO DE PAGE (INCHANGÉ) --}}
    <section class="page-header-pro">
        <div class="page-header-overlay"></div>
        <div class="container">
            <div class="page-header-content-pro" data-aos="fade-up">
                <h1 class="title-pro">{{ $offer->title }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb-pro">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Accueil</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('career') }}">Carrières</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ \Illuminate\Support\Str::limit($offer->title, 30) }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    {{-- DÉTAILS DE L'OFFRE (INCHANGÉ) --}}
    <section class="page-section-light">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-7 col-md-12 offer-main-content">
                    <div class="content-title-wrapper">
                        <h2>Description du poste</h2>
                    </div>
                    <p>{{ $offer->bref_description }}</p>
                    <div class="description-section">{!! $offer->description !!}</div>
                </div>
                <div class="col-lg-5 col-md-12">
                    <aside class="summary-card-revisited">
                        <div class="card-content">
                            <div class="card-badge-header">
                                <div>
                                    <h3>{{ $offer->title }}</h3>
                                    <p class="company">COCEC SA</p>
                                </div>
                                <span class="job-type-badge {{ $offer->type }}">{{ $offer->type }}</span>
                            </div>
                            <a href="#formulaire-candidature" class="btn btn-primary btn-apply"><i class="fas fa-paper-plane me-2"></i>Postuler à cette offre</a>
                            <ul class="summary-list">
                                <li><i class="fas fa-map-marker-alt"></i><strong>Lieu :</strong><span>Lomé, Togo</span></li>
                                <li><i class="fas fa-calendar-alt"></i><strong>Publié :</strong><span>{{ $offer->created_at->diffForHumans() }}</span></li>
                            </ul>
                            <div class="share-section">
                                <p>Partager cette opportunité</p>
                                <div class="share-links">
                                    <a href="#" title="Partager sur LinkedIn"><i class="fab fa-linkedin"></i></a>
                                    <a href="#" title="Partager sur Facebook"><i class="fab fa-facebook-square"></i></a>
                                    <a href="#" title="Partager par e-mail"><i class="fas fa-envelope"></i></a>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>

    {{-- ==================================================== --}}
    {{-- NOUVELLE SECTION FORMULAIRE DE CANDIDATURE         --}}
    {{-- ==================================================== --}}
    <section id="formulaire-candidature" class="page-section">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="section-title">Postulez pour : {{ $offer->title }}</h2>
                <p class="section-intro">Remplissez le formulaire ci-dessous. Notre équipe l'examinera avec la plus grande attention.</p>
            </div>

            <div class="premium-form-container" data-aos="fade-up">
                <form id="job-application-form" action="{{ route('career.apply.offer', $offer->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    
                    {{-- Champs honeypot pour détecter les bots --}}
                    @include('components.honeypot')
                    
                    <input type="hidden" name="intitule" value="{{ $offer->title }}">
                    <input type="hidden" name="application_type" value="{{ $offer->type }}">

                    <div class="row g-4">
                        {{-- Champs de texte avec labels flottants --}}
                        <div class="col-md-6 form-floating-group">
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder=" " required>
                            <label for="last_name" class="form-label">Nom</label>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 form-floating-group">
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder=" " required>
                            <label for="first_name" class="form-label">Prénom</label>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 form-floating-group">
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder=" " required>
                            <label for="phone" class="form-label">Téléphone</label>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6 form-floating-group">
                            <input type="email" class="form-control" id="email" name="email" placeholder=" " required>
                            <label for="email" class="form-label">Email</label>
                            <div class="invalid-feedback"></div>
                        </div>

                        {{-- Champs de fichiers avec le nouveau design --}}
                        <div class="col-md-6">
                            <label class="file-upload-wrapper">
                                <input type="file" name="cv" accept=".pdf" required>
                                <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                <div class="upload-text">Déposez votre CV ici ou cliquez</div>
                                <div class="upload-hint">Format PDF uniquement</div>
                            </label>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="file-upload-wrapper">
                                <input type="file" name="motivation_letter" accept=".pdf" required>
                                <div class="upload-icon"><i class="fas fa-file-alt"></i></div>
                                <div class="upload-text">Déposez votre lettre ou cliquez</div>
                                <div class="upload-hint">Format PDF uniquement</div>
                            </label>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="file-upload-wrapper">
                                <input type="file" name="identity_document" accept=".pdf,.jpg,.jpeg,.png" required>
                                <div class="upload-icon"><i class="fas fa-id-card"></i></div>
                                <div class="upload-text">Déposez votre document d'identité</div>
                                <div class="upload-hint">PDF, JPG ou PNG</div>
                            </label>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="file-upload-wrapper">
                                <input type="file" name="passport_photo" accept=".jpg,.jpeg,.png" required>
                                <div class="upload-icon"><i class="fas fa-camera"></i></div>
                                <div class="upload-text">Déposez votre photo passeport</div>
                                <div class="upload-hint">JPG ou PNG uniquement</div>
                            </label>
                            <div class="invalid-feedback"></div>
                        </div>

                    </div>

                    {{-- Widget reCAPTCHA --}}
                    <div class="mt-4 text-center">
                        @include('components.recaptcha', ['action' => 'job_application'])
                    </div>

                    <div class="mt-4">
                        <button type="submit" id="submit-button" class="btn-submit-premium">
                            <span class="btn-text">Envoyer ma candidature</span>
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @include('includes.main.scroll')
    @include('includes.main.footer')
</body>

@endsection


{{-- ============================================= --}}
{{-- JAVASCRIPT (LÉGÈREMENT ADAPTÉ)        --}}
{{-- ============================================= --}}
@section('js')
<script>
    $(document).ready(function() {
        // GESTION DU FEEDBACK VISUEL POUR LES CHAMPS D'UPLOAD
        $('.file-upload-wrapper input[type="file"]').on('change', function(e) {
            const wrapper = $(this).closest('.file-upload-wrapper');
            const textElement = wrapper.find('.upload-text');
            wrapper.removeClass('is-invalid');
            if (this.files && this.files.length > 0) {
                textElement.text(this.files[0].name);
                wrapper.css('border-color', '#28a745');
            } else {
                textElement.text(wrapper.find('input[name="cv"]').length ? 'Déposez votre CV ici ou cliquez' : 'Déposez votre lettre ou cliquez');
                wrapper.css('border-color', 'var(--border-color)');
            }
        });

        // SOUMISSION DU FORMULAIRE VIA AJAX
        $("#job-application-form").on("submit", function(e) {
            e.preventDefault();
            const $form = $(this);
            const $submitButton = $("#submit-button");
            const $btnText = $submitButton.find('.btn-text');
            const $spinner = $submitButton.find('.spinner-border');

            // Vérifier les champs honeypot
            if ($form.find('input[name="website_url"]').val() !== '' || $form.find('input[name="phone_number"]').val() !== '') {
                Swal.fire({ 
                    icon: 'error', 
                    title: 'Erreur', 
                    text: 'Soumission détectée comme spam.', 
                    confirmButtonColor: "var(--primary-color)" 
                });
                return;
            }

            // Vérifier si reCAPTCHA est résolu
            if (!window.isRecaptchaResolved()) {
                Swal.fire({ 
                    icon: 'warning', 
                    title: 'Vérification requise', 
                    text: 'Veuillez cocher la case "Je ne suis pas un robot".', 
                    confirmButtonColor: "var(--primary-color)" 
                });
                return;
            }

            $form.find(".form-control, .file-upload-wrapper").removeClass("is-invalid");
            $form.find(".invalid-feedback").text("");

            $submitButton.prop("disabled", true);
            $btnText.addClass('d-none');
            $spinner.removeClass('d-none');

            $.ajax({
                url: $form.attr("action"),
                method: "POST",
                data: new FormData(this),
                processData: false,
                contentType: false,
                headers: {
                    "X-CSRF-TOKEN": $form.find('input[name="_token"]').val()
                },
                success: function(data) {
                    Swal.fire({
                        icon: "success",
                        title: "Candidature envoyée ! 🎉",
                        text: data.message || "Merci, nous avons bien reçu votre candidature.",
                        confirmButtonColor: "var(--primary-color)"
                    });
                    $form[0].reset();
                    $('.upload-text').text(function() {
                        return $(this).closest('.file-upload-wrapper').find('input[name="cv"]').length ? 'Déposez votre CV ici ou cliquez' : 'Déposez votre lettre ou cliquez';
                    });
                    $('.file-upload-wrapper').css('border-color', 'var(--border-color)');
                    // Réinitialiser reCAPTCHA
                    if (typeof window.resetRecaptcha === 'function') {
                        window.resetRecaptcha();
                    }
                },
                error: function(jqXHR) {
                    if (jqXHR.status === 422) {
                        const errors = jqXHR.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            const field = $('[name="' + key + '"]');
                            field.addClass("is-invalid");
                            field.closest('.form-floating-group, .col-md-6').find(".invalid-feedback").text(value[0]).show();
                            if (field.attr('type') === 'file') {
                                field.closest('.file-upload-wrapper').addClass('is-invalid');
                            }
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur de validation',
                            text: 'Veuillez corriger les champs indiqués.',
                            confirmButtonColor: "var(--primary-color)"
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oups...",
                            text: "Une erreur est survenue. Veuillez réessayer.",
                            confirmButtonColor: "var(--primary-color)"
                        });
                    }
                },
                complete: function() {
                    $submitButton.prop("disabled", false);
                    $spinner.addClass('d-none');
                    $btnText.removeClass('d-none');
                }
            });
        });
    });
</script>
@endsection