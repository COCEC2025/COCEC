@extends('layout.admin')

@section('content')
<body>
    @include('includes.main.loading')

    <style>
        .auth-left {
            height: 100vh;
            /* Toute la hauteur de l'écran */
            width: 50%;
            /* Ajuste selon ton design */
            position: relative;
        }

        .auth-left img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Remplit sans déformer */
            display: block;
        }
    </style>

    <section class="auth bg-base d-flex flex-wrap">
        <div class="auth-left d-lg-block d-none">
            <div class="d-flex align-items-center flex-column h-100 justify-content-center">
                <!-- <img src="{{ URL::asset('assets/images/cocec-service-accompagnement-financier.jpg') }}" alt="" > -->
                <img src="{{ URL::asset('assets/images/admin.jpg') }}" alt="">

            </div>
        </div>
        <div class="auth-right py-32 px-24 d-flex flex-column justify-content-center">
            <div class="max-w-464-px mx-auto w-100">
                <div>
                    <div class="text-center">
                        <a href="index.html" class="mb-40 max-w-290-px">
                            <img src="{{ URL::asset('assets/images/logo.png') }}" alt="" style="max-width: 120px; height: auto;">
                        </a>
                    </div>
                    <h4 class="mb-12">Connectez-vous à votre compte</h4>
                    <p class="mb-32 text-secondary-light text-lg">Bienvenue! Veuillez entrer vos informations</p>
                </div>

                @if ($errors->any())
                <ul class="alert alert-danger" style="color: red; list-style: none;">
                    {!! implode('', $errors->all('<li>:message</li>')) !!}
                </ul>
                @endif

                @if ($message = Session::get('error'))
                <div style="color: red;">{{ $message }}</div><br>
                @endif

                <form id="loginForm" action="{{ route('login.process') }}" method="POST">
                    @csrf
                    
                    {{-- Champs honeypot pour détecter les bots --}}
                    @include('components.honeypot')
                    <div class="icon-field mb-16">
                        <span class="icon top-50 translate-middle-y">
                            <iconify-icon icon="mage:email"></iconify-icon>
                        </span>
                        <input type="email" required class="form-control h-56-px bg-neutral-50 radius-12" name="email" placeholder="Email">
                    </div>
                    <div class="position-relative mb-20">
                        <div class="icon-field">
                            <span class="icon top-50 translate-middle-y">
                                <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                            </span>
                            <input type="password" required class="form-control h-56-px bg-neutral-50 radius-12" id="password" name="password" placeholder="Mot de passe">
                        </div>
                        <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light" data-toggle="#password"></span>
                    </div>
                    <!-- <div class="">
                        <div class="d-flex justify-content-between gap-2">
                            <div class="form-check style-check d-flex align-items-center">
                                <input class="form-check-input border border-neutral-300" type="checkbox" value="" id="remeber">
                                <label class="form-check-label" for="remeber">Se souvenir de moi</label>
                            </div>
                        </div>
                    </div> -->

                    {{-- Widget reCAPTCHA --}}
                    <div class="mt-3 text-center">
                        @include('components.recaptcha', ['action' => 'admin_login'])
                    </div>

                    <button type="submit" class="btn btn-danger text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32"> Se connecter</button>

                </form>
            </div>
        </div>
    </section>
</body>
@endsection
@section('js')
<script>
    // ================== Password Show Hide Js Start ==========
    function initializePasswordToggle(toggleSelector) {
        $(toggleSelector).on('click', function() {
            $(this).toggleClass("ri-eye-off-line");
            var input = $($(this).attr("data-toggle"));
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    }
    // Call the function
    initializePasswordToggle('.toggle-password');
    // ========================= Password Show Hide Js End ===========================

    // Gestion du loading lors de la soumission du formulaire
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const form = this;
        
        // Vérifier les champs honeypot
        if (form.querySelector('input[name="website_url"]').value !== '' || form.querySelector('input[name="phone_number"]').value !== '') {
            e.preventDefault();
            alert('Soumission détectée comme spam.');
            return;
        }

        // Vérifier si reCAPTCHA est résolu
        if (!window.isRecaptchaResolved()) {
            e.preventDefault();
            alert('Veuillez patienter pendant la vérification reCAPTCHA.');
            return;
        }
        
        // Afficher le loading
        const preloader = document.getElementById('preloader');
        if (preloader) {
            preloader.style.display = 'flex';
            preloader.style.zIndex = '9999';
            preloader.style.position = 'fixed';
            preloader.style.top = '0';
            preloader.style.left = '0';
            preloader.style.width = '100%';
            preloader.style.height = '100%';
            preloader.style.backgroundColor = 'var(--secondary-color)';
        }
        
        // Désactiver le bouton de soumission
        const submitBtn = document.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Connexion...';
        }
    });
</script>


@endsection