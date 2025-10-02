@extends('layout.main')

{{-- ============================================= --}}
{{-- SECTION CSS DÉDIÉE À LA PAGE         --}}
{{-- ============================================= --}}
@section('css')
<style>
    /* 1. DÉFINITION DES VARIABLES DE COULEURS */
    :root {
        --primary-color: #EC281C;
        --secondary-color: #FFCC00;
        --text-dark: #212529;
        --text-light: #6c757d;
        --bg-light: #f8f9fa;
        --white: #ffffff;
        --border-color: #dee2e6;
        --error-color: #dc3545;
        /* Couleur standard pour les erreurs */
    }

    /* 2. STYLES GÉNÉRAUX & SECTIONS */
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

    .section-subtitle {
        font-weight: 600;
        color: var(--secondary-color);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .section-intro {
        color: var(--text-light);
        max-width: 650px;
        margin: 15px auto 0 auto;
    }

    /* 3. SECTION D'INTRODUCTION ("Rejoignez-nous") */
    .career-intro-content h1 {
        font-weight: 700;
    }

    .career-intro-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }

    /* 4. CARTES D'OFFRES D'EMPLOI */
    .job-offer-card-revisited {
        background: var(--white);
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.07);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
    }

    .job-offer-card-revisited:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        border-color: var(--primary-color);
    }

    .job-card-header {
        padding: 25px 30px;
        border-bottom: 1px solid var(--border-color);
    }

    .job-card-header h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 10px;
    }

    .job-meta-list {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        color: var(--text-light);
        font-size: 0.9rem;
    }

    .job-meta-list i {
        margin-right: 8px;
        color: var(--primary-color);
    }

    .job-card-body {
        padding: 25px 30px;
        flex-grow: 1;
    }

    .job-card-body p {
        color: #555;
    }

    .job-card-footer {
        padding: 20px 30px;
        background-color: var(--bg-light);
        border-radius: 0 0 12px 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
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

    /* 5. FORMULAIRE DE CANDIDATURE */
    .application-form-wrapper {
        background: var(--white);
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 10px 50px rgba(0, 0, 0, 0.1);
        max-width: 850px;
        margin: 0 auto;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid var(--border-color);
        padding: 12px 15px;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(236, 40, 28, 0.15);
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 8px;
    }

    /* CHAMP D'UPLOAD PERSONNALISÉ */
    .custom-file-upload {
        border: 2px dashed var(--border-color);
        border-radius: 8px;
        padding: 30px;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.3s ease, background-color 0.3s ease;
    }

    .custom-file-upload:hover {
        border-color: var(--primary-color);
        background-color: #ec281c09;
    }

    .custom-file-upload .upload-icon {
        font-size: 2rem;
        color: var(--primary-color);
        margin-bottom: 10px;
    }

    .custom-file-upload .upload-text {
        color: var(--text-dark);
        font-weight: 500;
    }

    .custom-file-upload .upload-hint {
        color: var(--text-light);
        font-size: 0.9rem;
    }

    .custom-file-upload input[type="file"] {
        display: none;
    }



    /* 6. STYLES POUR LA VALIDATION DES ERREURS */
    .form-control.is-invalid {
        border-color: var(--error-color);
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
    }

    .invalid-feedback {
        display: none;
        width: 100%;
        margin-top: 0.25rem;
        font-size: .875em;
        color: var(--error-color);
    }

    .is-invalid+.invalid-feedback,
    .is-invalid~.invalid-feedback {
        display: block;
    }

    .custom-file-upload.is-invalid {
        border-color: var(--error-color);
    }
</style>
@endsection


@section('content')

<body>
    @include('includes.main.loading')
    @include('includes.main.header')

    <!-- HERO DE LA PAGE -->
    <section class="page-header-pro">
        <div class="page-header-overlay"></div>
        <div class="container">
            <div class="page-header-content-pro" data-aos="fade-up">
                <h1 class="title-pro">Carrières</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb-pro">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Accueil</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Carrières</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <!-- SECTION D'INTRODUCTION -->
    <section class="career-intro-section page-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="career-intro-content">
                        <h4 class="section-subtitle">Rejoignez l'aventure</h4>
                        <h1 class="section-title mb-3">Bâtissez votre avenir avec la COCEC</h1>
                        <p class="text-secondary text-justify">Nous croyons que notre plus grande force réside dans les personnes qui composent notre équipe. Nous sommes toujours à la recherche de talents passionnés et dévoués pour nous aider à grandir et à mieux servir nos membres.</p>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                    <div class="career-intro-image-wrapper">
                        <img src="{{ URL::asset('assets/images/job-team.jpg') }}" alt="Équipe dynamique de la COCEC">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION DES OFFRES D'EMPLOI -->
    <section class="offers-section page-section-light">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="section-title">Nos Opportunités Actuelles</h2>
            </div>
            <div class="row">
                @forelse($jobOffers as $offer)
                <div class="col-md-12">
                    <div class="job-offer-card-revisited" data-aos="fade-up">
                        <div class="job-card-header">
                            <h3>{{ $offer->title }}</h3>
                            <div class="job-meta-list">
                                <span class="job-meta-item"><i class="fas fa-map-marker-alt"></i>Lomé, Togo</span>
                                <span class="job-meta-item"><i class="fas fa-calendar-alt"></i>Publié {{ $offer->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="job-card-body">
                            <p>{{ \Illuminate\Support\Str::limit($offer->bref_description, 180) }}</p>
                        </div>
                        <div class="job-card-footer">
                            <span class="job-type-badge {{ $offer->type }}">{{ $offer->type }}</span>
                            <a href="{{ route('career.details', $offer->id) }}" class="btn btn-primary">Voir les détails</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center" data-aos="fade-up">
                    {{-- Pensez à ajouter une image SVG ou PNG pertinente dans votre dossier public --}}
                    {{-- <img src="{{ asset('images/no-offers.svg') }}" alt="Aucune offre" style="max-width: 200px; margin-bottom: 20px;"> --}}
                    <h4 class="mb-3">Aucune offre disponible pour le moment</h4>
                    <p class="lead text-secondary">Revenez bientôt ou envoyez-nous une candidature spontanée ci-dessous.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- SECTION FORMULAIRE DE CANDIDATURE SPONTANÉE -->
    <section class="form-section page-section">
        <div class="container">
            <div class="section-header text-center">
                <h2 class="section-title">Candidature Spontanée</h2>
                <p class="section-intro">Aucune offre ne vous correspond ? Prenez l'initiative ! Nous sommes toujours intéressés par des profils exceptionnels.</p>
            </div>

            <div class="application-form-wrapper" data-aos="fade-up">
                {{-- LA CORRECTION CLÉ EST ICI : l'attribut novalidate --}}
                <form id="application-form" action="{{ route('career.apply') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    
                    {{-- Champs honeypot pour détecter les bots --}}
                    @include('components.honeypot')
                    
                    <div class="row g-4">
                        <div class="col-md-6"><label class="form-label">Nom</label><input type="text" class="form-control" name="last_name" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6"><label class="form-label">Prénom</label><input type="text" class="form-control" name="first_name" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6"><label class="form-label">Téléphone</label><input type="tel" class="form-control" name="phone" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6"><label class="form-label">Email</label><input type="email" class="form-control" name="email" required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6"><label class="form-label">Intitulé du poste souhaité</label><input type="text" class="form-control" name="intitule" placeholder="Ex: Comptable, Agent de crédit..." required>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6"><label class="form-label">Type de Poste</label><select class="form-control" name="application_type" required>
                                <option value="">Sélectionnez...</option>
                                <option value="emploi">Emploi</option>
                                <option value="stage">Stage</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Votre CV (PDF)</label>
                            <label class="custom-file-upload"><input type="file" name="cv" accept=".pdf" required>
                                <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div><span class="upload-text">Cliquez ou déposez votre CV</span>
                                <div class="upload-hint">Fichier PDF, max 2Mo</div>
                            </label>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Lettre de motivation (PDF)</label>
                            <label class="custom-file-upload"><input type="file" name="motivation_letter" accept=".pdf" required>
                                <div class="upload-icon"><i class="fas fa-file-alt"></i></div><span class="upload-text">Cliquez ou déposez votre lettre</span>
                                <div class="upload-hint">Fichier PDF, max 2Mo</div>
                            </label>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Document d'identité (PDF, JPG, PNG)</label>
                            <label class="custom-file-upload"><input type="file" name="identity_document" accept=".pdf,.jpg,.jpeg,.png" required>
                                <div class="upload-icon"><i class="fas fa-id-card"></i></div><span class="upload-text">Cliquez ou déposez votre document</span>
                                <div class="upload-hint">PDF, JPG ou PNG, max 30Mo</div>
                            </label>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Photo passeport (JPG, PNG)</label>
                            <label class="custom-file-upload"><input type="file" name="passport_photo" accept=".jpg,.jpeg,.png" required>
                                <div class="upload-icon"><i class="fas fa-camera"></i></div><span class="upload-text">Cliquez ou déposez votre photo</span>
                                <div class="upload-hint">JPG ou PNG, max 5Mo</div>
                            </label>
                            <div class="invalid-feedback"></div>
                        </div>

                    </div>
                    
                    {{-- Widget reCAPTCHA --}}
                    <div class="mt-4 text-center">
                        @include('components.recaptcha', ['action' => 'job_application'])
                    </div>
                    
                    <div class="text-center mt-5">
                        <button type="submit" id="submit-button" class="bz-primary-btn">
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
{{-- SECTION JS DÉDIÉE À LA PAGE           --}}
{{-- ============================================= --}}
@section('js')
<script>
    $(document).ready(function() {
        // GESTION DU FEEDBACK VISUEL POUR LES CHAMPS D'UPLOAD
        $('.custom-file-upload input[type="file"]').on('change', function(e) {
            const uploadLabel = $(this).closest('.custom-file-upload');
            const uploadText = uploadLabel.find('.upload-text');
            uploadLabel.removeClass('is-invalid'); // Retire le style d'erreur si on sélectionne un fichier
            if (this.files && this.files.length > 0) {
                uploadText.text(this.files[0].name);
                uploadLabel.css('border-color', '#28a745');
            } else {
                uploadText.text('Cliquez ou déposez votre fichier');
                uploadLabel.css('border-color', 'var(--border-color)');
            }
        });

        // SOUMISSION DU FORMULAIRE VIA AJAX AVEC SWEETALERT2
        $("#application-form").on("submit", function(e) {
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

            // Réinitialiser les erreurs de validation précédentes
            $form.find(".form-control, .custom-file-upload").removeClass("is-invalid");
            $form.find(".invalid-feedback").text("");

            // Activer l'état de chargement
            $submitButton.prop("disabled", true);
            $btnText.addClass('d-none');
            $spinner.removeClass('d-none');

        // Fonction pour soumettre le formulaire
        function submitForm() {

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
                        confirmButtonColor: "var(--primary-color)",
                    });
                    $form[0].reset();
                    $('.upload-text').text(function() {
                        return $(this).parent().find('input[name="cv"]').length ? 'Cliquez ou déposez votre CV' : 'Cliquez ou déposez votre lettre';
                    });
                    $('.custom-file-upload').css('border-color', 'var(--border-color)');
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
                            const container = field.closest('.col-md-6, .col-md-12');
                            field.addClass("is-invalid");
                            container.find(".invalid-feedback").text(value[0]).show();
                            if (field.attr('type') === 'file') {
                                field.closest('.custom-file-upload').addClass('is-invalid');
                            }
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur de validation',
                            text: 'Veuillez corriger les champs en rouge.',
                            confirmButtonColor: "var(--primary-color)",
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oups... Une erreur est survenue.",
                            text: "Impossible d'envoyer votre candidature pour le moment. Veuillez réessayer plus tard.",
                            confirmButtonColor: "var(--primary-color)",
                        });
                    }
                },
                complete: function() {
                    // Désactiver l'état de chargement
                    $submitButton.prop("disabled", false);
                    $spinner.addClass('d-none');
                    $btnText.removeClass('d-none');
                }
            });
        }

        // Vérifier si reCAPTCHA est résolu
        window.waitForRecaptcha(function(isReady) {
            if (!isReady) {
                Swal.fire({ 
                    icon: 'warning', 
                    title: 'Vérification requise', 
                    text: 'Veuillez patienter pendant la vérification reCAPTCHA.', 
                    confirmButtonColor: "var(--primary-color)"
                });
                $submitButton.prop("disabled", false);
                $btnText.removeClass('d-none');
                $spinner.addClass('d-none');
                return;
            }
            
            // Continuer avec la soumission
            submitForm();
        });
    });
});
</script>
@endsection