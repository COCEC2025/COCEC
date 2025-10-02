        <!-- Styles pour les icônes des réseaux sociaux -->
        <style>
            .footer-social li a {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                transition: all 0.3s ease;
                text-decoration: none;
            }
            
            .footer-social li a:hover {
                transform: translateY(-3px);
                box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            }
            
            /* Facebook - Bleu */
            .footer-social li a[href*="facebook"] {
                background: #1877f2;
                color: white;
            }
            
            .footer-social li a[href*="facebook"]:hover {
                background: #166fe5;
            }
            
            /* WhatsApp - Vert */
            .footer-social li a[href*="whatsapp"] {
                background: #25d366;
                color: white;
            }
            
            .footer-social li a[href*="whatsapp"]:hover {
                background: #128c7e;
            }
            
            .footer-social li a i {
                font-size: 18px;
            }
        </style>

        <footer class="footer-section footer-2 overflow-hidden" style="--bz-color-theme-primary: #EC281C">
            <div class="shapes">
                <div class="shape shape-1"><img src="{{ URL::asset('assets/images/shapes/footer-shape-1.png') }}" alt="footer"></div>
                <div class="shape shape-2"><img src="{{ URL::asset('assets/images/shapes/footer-shape-2.png') }}" alt="footer"></div>
            </div>
            <div class="container">
                <div class="row footer-wrap">
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <div class="widget-header header-2">
                                <div class="footer-logo">
                                    <a href="{{ route('index') }}"><img src="{{ URL::asset('assets/images/Logo.png') }}" alt="logo"" alt=" img"></a>
                                </div>
                            </div>
                            <p>Quartier KANYIKOPE à 50m du Lycée FOLLY-BEBE en allant vers KAGOME</p>
                            <p>
                                <b>Tél:</b>
                                <a href="tel:+22891126471">+228 91 12 64 71</a> /
                                <a href="tel:+22822714148">+228 22 71 41 48</a>
                                <br>
                                <b>Email:</b>
                                <a href="mailto:cocec@cocectogo.org">cocec@cocectogo.org</a>
                            </p>
                            <ul class="footer-social">
                                <li><a href="https://www.facebook.com/COCEC-105458737978835"><i class="fa-brands fa-facebook-f"></i></a></li>
                                <li><a href="https://api.whatsapp.com/send?phone=22891126471" target="_blank"><i class="fa-brands fa-whatsapp"></i></a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="footer-widget widget-space">
                            <div class="widget-header header-2">
                                <h3 class="widget-title">Liens Rapides</h3>
                            </div>
                            <ul class="footer-list">
                                {{-- Les pages les plus consultées et les actions principales --}}
                                <li><a href="{{ route("index") }}">Accueil</a></li>
                                <li><a href="{{ route("products") }}">Nos Produits</a></li>
                                <li><a href="{{ route('main.finance')}}">Finance Digitale</a></li>
                                <li><a href="{{ route("agencies") }}">Nos Agences</a></li>
                                <li><a href="{{ route('contact') }}">Contactez-nous</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="footer-widget">
                            <div class="widget-header header-2">
                                {{-- Titre plus spécifique et engageant --}}
                                <h3 class="widget-title">À Propos de Nous</h3>
                            </div>
                            <ul class="footer-list">
                                {{-- Les pages d'information sur l'entreprise et les ressources --}}
                                <li><a href="{{ route('about')}}">Nous connaitre</a></li>
                                <li><a href="{{ route("blogs") }}">Actualités (Blog)</a></li>
                                <li><a href="{{ route('career') }}">Carrières</a></li>
                                <li><a href="{{ route('main.faq') }}">Aide & FAQ</a></li>
                            </ul>
                        </div>

                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="footer-widget widget-space">
                            <div class="widget-header header-2">
                                {{-- Titre traduit --}}
                                <h3 class="widget-title">Notre Newsletter</h3>
                            </div>
                            {{-- Paragraphe traduit et adapté à COCEC --}}
                            <p class="text-justify">Inscrivez-vous à notre newsletter pour ne rien manquer de nos actualités et de nos offres.</p>
                                    
        {{-- Intégration reCAPTCHA pour la newsletter --}}
        @include('components.recaptcha', ['action' => 'newsletter'])
                            <div class="footer-form form-2 mb-20">
                                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="rr-subscribe-form" id="footer-newsletter-form">
                                    @csrf
                                    
                                    {{-- Champs honeypot pour détecter les bots --}}
                                    @include('components.honeypot')
                                    
                                    <input class="form-control" type="email" name="email" placeholder="Votre adresse e-mail">
                                    <input type="hidden" name="action" value="mailchimpsubscribe">
                                    <input type="hidden" name="recaptcha_token" id="newsletter_recaptcha_token">
                                    <button class="submit" id="newsletter-submit-btn">
                                        <span class="btn-text">S'inscrire</span>
                                        <span class="btn-loading" style="display: none;">
                                            <i class="fas fa-spinner fa-spin"></i> Inscription en cours...
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="copyright-area area-2">
                <div class="container">
                    <div class="row copyright-content">
                        <div class="col-md-6">
                            <p>© {{ date('Y') }} COCEC. All Rights Reserved. | Powered by <a href="mailto:douvonangelotadn@gmail.com" style="color: inherit; text-decoration: none;">Angélot</a></p>
                        </div>
                        <div class="col-md-6">
                            <ul class="copy-list">
                                <li><a href="{{ route('legal') }}">Mentions Légales</a></li>
                                <li><a href="{{ route('legal') }}#politique-confidentialite">Politique de Confidentialité</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- ./ footer-section -->
