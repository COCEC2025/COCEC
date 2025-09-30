@extends('layout.main')

{{-- ============================================= --}}
{{--        SECTION CSS DÉDIÉE À LA PAGE         --}}
{{-- ============================================= --}}
@section('css')
<style>
    /* 1. VARIABLES & STYLES DE BASE */
    :root {
        --primary-color: #EC281C;
        --secondary-color: #FFCC00;
        --text-dark: #212529;
        --text-light: #6c757d;
        --bg-light: #f8f9fa;
        --white: #ffffff;
        --border-color: #e0e0e0;
        --error-color: #dc3545;
    }
    body { font-family: 'Poppins', sans-serif; background-color: var(--bg-light); }
    .page-section { padding: 0; }

    /* 2. NOUVEAU LAYOUT UNIFIÉ */
    /* Le conteneur global qui porte l'ombre et le fond */
    .contact-unified-wrapper {
        background-color: var(--white);
        box-shadow: 0 25px 80px rgba(0,0,0,0.15);
        border-radius: 8px;
    }

    /* Le bloc Formulaire/Info (partie haute) */
    .contact-prestige-layout {
        display: flex;
        background-color: transparent; /* Le fond est maintenant sur le parent */
        box-shadow: none;               /* L'ombre est maintenant sur le parent */
        border-radius: 8px 8px 0 0;     /* Uniquement les coins supérieurs arrondis */
        overflow: hidden;
    }
    .info-panel {
        flex-basis: 40%;
        background-color: var(--primary-color);
        color: var(--white);
        padding: 60px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .form-space {
        flex-basis: 60%;
        padding: 60px;
    }
    
    /* 3. INFO PANEL (GAUCHE) - Inchangé */
    .info-panel h2 { font-weight: 700; font-size: 2.5rem; color: var(--white); margin-bottom: 15px; }
    .info-panel .panel-intro { font-size: 1.1rem; color: rgba(255,255,255,0.85); line-height: 1.7; margin-bottom: 40px; }
    .info-list { list-style: none; padding: 0; }
    .info-item { display: flex; align-items: flex-start; margin-bottom: 25px; }
    .info-item .icon { font-size: 1.2rem; margin-right: 20px; width: 25px; text-align: center; color: var(--secondary-color); margin-top: 5px; }
    .info-item .content h4 { font-size: 1rem; font-weight: 600; margin-bottom: 5px; color: var(--white); }
    .info-item .content p, .info-item .content a { color: rgba(255,255,255,0.85); text-decoration: none; margin-bottom: 0; transition: color 0.3s ease; }
    .info-item .content a:hover { color: var(--white); }

    /* 4. FORMULAIRE (DROITE) - Inchangé */
    .form-space h2 { font-weight: 700; color: var(--text-dark); margin-bottom: 40px; }
    .input-line-group { position: relative; margin-bottom: 2rem; }
    .input-line-group .form-label { font-size: 0.9rem; font-weight: 500; color: var(--text-light); }
    .input-line-group .form-control {
        border: none; border-radius: 0; box-shadow: none; padding: 10px 0;
        background-color: transparent; border-bottom: 2px solid var(--border-color);
        transition: border-color 0.3s ease;
    }
    .input-line-group .form-control:focus { border-color: var(--primary-color); }
    .input-line-group .form-control::placeholder { color: #ccc; }
    
    .btn-submit-prestige {
        width: 100%; background: linear-gradient(45deg, var(--primary-color), #c41e12);
        color: var(--white); padding: 16px; font-size: 1.1rem; font-weight: 600;
        border-radius: 8px; border: none; transition: transform 0.2s ease, box-shadow 0.3s ease;
        box-shadow: 0 5px 20px rgba(236, 40, 28, 0.3);
    }
    .btn-submit-prestige:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(236, 40, 28, 0.4); }

    .form-control.is-invalid { border-bottom-color: var(--error-color) !important; }
    .invalid-feedback { display: none; width: 100%; margin-top: 0.25rem; font-size: .875em; color: var(--error-color); }
    .is-invalid ~ .invalid-feedback { display: block; }

    /* 5. NOUVELLE ZONE DE LA CARTE (Partie basse du bloc unifié) */
    .map-area {
        padding: 40px 60px 60px 60px; /* Ajoute de l'espace pour le titre et autour */
        border-top: 1px solid var(--border-color); /* Ligne de séparation subtile */
    }
    .map-area h2 {
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 30px;
        text-align: center;
        font-size: 1.8rem;
    }
    .map-iframe-container {
        border-radius: 8px; /* Bords arrondis pour l'iframe */
        overflow: hidden;   /* Force l'iframe à respecter les bords */
        line-height: 0;
    }
    .map-iframe-container iframe {
        width: 100%;
        height: 400px;
        border: 0;
    }
    
    /* Responsive */
    @media (max-width: 991px) {
        .contact-prestige-layout { flex-direction: column; }
        .info-panel, .form-space { padding: 40px; }
        .map-area { padding: 40px; }
    }
</style>
@endsection


@section('content')
<body>
    @include('includes.main.loading')
    @include('includes.main.header')

    {{-- HERO DE PAGE --}}
    <section class="page-header-pro">
        <div class="page-header-overlay"></div>
        <div class="container">
            <div class="page-header-content-pro" data-aos="fade-up">
                <h1 class="title-pro">Prendre Contact</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb-pro">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Accueil</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    {{-- SECTION CONTACT ET CARTE UNIFIÉE --}}
    <section class="page-section">
        <div class="container my-5">
            {{-- Le nouveau conteneur qui unifie tout --}}
            <div class="contact-unified-wrapper" data-aos="fade-up">

                {{-- PARTIE 1 : FORMULAIRE ET INFOS --}}
                <div class="contact-prestige-layout">
                    <!-- PANNEAU D'INFORMATION (GAUCHE) -->
                    <div class="info-panel">
                        <h2>Nos Coordonnées</h2>
                        <p class="panel-intro">Nous sommes à votre écoute. Utilisez les informations ci-dessous ou remplissez le formulaire pour une réponse rapide.</p>
                        <ul class="info-list">
                            <li class="info-item"><div class="icon"><i class="fas fa-map-marker-alt"></i></div><div class="content"><h4>Notre Siège</h4><p>Kangnikopé à 50m du lycée Folly Bébé, Lomé, Togo</p></div></li>
                            <li class="info-item"><div class="icon"><i class="fas fa-phone-alt"></i></div><div class="content"><h4>Téléphone</h4><a href="tel:+22891126471">(+228) 91 12 64 71</a></div></li>
                            <li class="info-item"><div class="icon"><i class="fas fa-envelope"></i></div><div class="content"><h4>Email</h4><a href="mailto:cocec@cocectogo.org">cocec@cocectogo.org</a></div></li>
                            <li class="info-item"><div class="icon"><i class="fas fa-clock"></i></div><div class="content"><h4>Heures d'ouverture</h4><p>Lundi - Vendredi : 7h30 - 15h00<br>Samedi : 8h00 - 12h00</p></div></li>
                        </ul>
                    </div>

                    <!-- ESPACE FORMULAIRE (DROITE) -->
                    <div class="form-space">
                        <h2>Envoyez-nous un message</h2>
                        <form id="contact-prestige-form" action="{{ route('contact.store') }}" method="POST" novalidate>
                            @csrf
                            
                            {{-- Champs honeypot pour détecter les bots --}}
                            @include('components.honeypot')
                            
                            <div class="row">
                                <div class="col-md-6 input-line-group"><label for="fullname" class="form-label">Nom Complet</label><input type="text" class="form-control" id="fullname" name="fullname" placeholder="Ex: Jean Dupont" required><div class="invalid-feedback"></div></div>
                                <div class="col-md-6 input-line-group"><label for="email" class="form-label">Votre Email</label><input type="email" class="form-control" id="email" name="email" placeholder="Ex: jean.dupont@email.com" required><div class="invalid-feedback"></div></div>
                                <div class="col-12 input-line-group"><label for="subject" class="form-label">Sujet</label><input type="text" class="form-control" id="subject" name="subject" placeholder="Ex: Information sur un produit" required><div class="invalid-feedback"></div></div>
                                <div class="col-12 input-line-group"><label for="message" class="form-label">Votre message</label><textarea class="form-control" id="message" name="message" rows="4" placeholder="Écrivez votre message ici..." required></textarea><div class="invalid-feedback"></div></div>
                            </div>
                            
                            {{-- Widget reCAPTCHA --}}
                            <div class="mt-3">
                                @include('components.recaptcha', ['action' => 'contact'])
                            </div>
                            
                            <div class="mt-4">
                                <button type="submit" id="submit-button" class="btn-submit-prestige"><span class="btn-text">Envoyer</span><span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span></button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- PARTIE 2 : CARTE GOOGLE MAPS --}}
                <div class="map-area">
                    <h2>Retrouvez-nous sur la carte</h2>
                    <div class="map-iframe-container">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.082008301511!2d1.2951526747458148!3d6.167871493774653!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1023e40dcdc28751%3A0xda710ee60c192b18!2sCOCEC!5e0!3m2!1sfr!2stg!4v1721669431412!5m2!1sfr!2stg" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
$(document).ready(function() {
    $("#contact-prestige-form").on("submit", function (e) {
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

        $form.find(".form-control").removeClass("is-invalid");
        $form.find(".invalid-feedback").text("");

        $submitButton.prop("disabled", true);
        $btnText.addClass('d-none');
        $spinner.removeClass('d-none');

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

        $.ajax({
                url: $form.attr("action"),
                method: "POST",
                data: new FormData(this),
                processData: false,
                contentType: false,
                headers: { "X-CSRF-TOKEN": $form.find('input[name="_token"]').val() },
                success: function (data) {
                    Swal.fire({
                        icon: "success", title: "Message envoyé ! 🎉",
                        text: "Merci, nous avons bien reçu votre message.",
                        confirmButtonColor: "var(--primary-color)",
                    });
                    $form[0].reset();
                    // Réinitialiser reCAPTCHA
                    if (typeof window.resetRecaptcha === 'function') {
                        window.resetRecaptcha();
                    }
                },
                error: function (jqXHR) {
                    if (jqXHR.status === 422) {
                        const errors = jqXHR.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            const field = $('[name="' + key + '"]');
                            field.addClass("is-invalid");
                            field.closest('.input-line-group').find(".invalid-feedback").text(value[0]).show();
                        });
                        Swal.fire({ icon: 'error', title: 'Erreur', text: 'Veuillez corriger les champs indiqués.', confirmButtonColor: "var(--primary-color)" });
                    } else {
                        Swal.fire({ icon: "error", title: "Oups...", text: "Une erreur est survenue.", confirmButtonColor: "var(--primary-color)" });
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
});
</script>
@endsection