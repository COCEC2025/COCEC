        <!-- header-area-start -->
        <header class="header header-3 sticky-active" style="--bz-color-theme-primary: #EC281C">
            <div class="overlay"></div>
            <div class="top-bar">
                <div class="container-2">
                    <div class="top-bar-inner">
                        <ul class="top-bar-list">
                            <li><i class="fa-sharp fa-regular fa-phone"></i><a href="tel:+22891126471">(+228) 91 12 64 71 /</a> <a href="tel:+2288989">8989</a></li>
                            <li><i class="fa-sharp fa-regular fa-location-dot"></i><span>KANYIKOPE près du Lycée FOLLY-BEBE</span></li>
                            <li><i class="fa-sharp fa-regular fa-envelope"></i><a href="mailto:cocec@cocectogo.org">cocec@cocectogo.org</a></li>
                        </ul>
                        <ul class="social-list">
                            <li>
                                <a href="https://www.facebook.com/COCEC-105458737978835" target="_blank">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://wa.me/22891126471" target="_blank">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="primary-header">
                <div class="container-2">
                    <div class="primary-header-inner">
                        <div class="inner-left">
                            <div class="header-logo">
                                <a href="{{ route("index") }}">
                                    <img src="{{ URL::asset('assets/images/Logo.png') }}" alt="logo">
                                </a>
                            </div>
                            <div class="header-menu-wrap">
                                <ul>
                                    <li class="{{ request()->routeIs('index') ? 'active' : '' }}">
                                        <a href="{{ route("index") }}">Accueil</a>
                                    </li>
                                    <li class="{{ request()->routeIs('product.*') ? 'active' : '' }}">
                                        <a href="{{ route("product.index") }}">Produits</a>
                                    </li>
                                    <li class="{{ request()->routeIs('agencies') ? 'active' : '' }}">
                                        <a href="{{ route("agencies") }}">Agences</a>
                                    </li>
                                    <li class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                                        <a href="{{ route('contact') }}">Contact</a>
                                    </li>
                                    <li>
                                        <a href="https://www.ebindoo.com/" target="_blank">Compte en ligne</a>
                                    </li>
                                    <li class="{{ request()->routeIs('main.finance') ? 'active' : '' }}">
                                        <a href="{{ route('main.finance')}}">Finance Digitale</a>
                                    </li>
                                    <li class="menu-item-has-children {{ request()->routeIs('career') || request()->routeIs('about') ||  request()->routeIs('blogs') || request()->routeIs('main.faq') || request()->routeIs('complaint') ? 'active' : '' }}">
                                        <a href="#">Autres <i class="fa-solid fa-chevron-down"></i></a>
                                        <ul>
                                            <li class="{{ request()->routeIs('career') ? 'active' : '' }}">
                                                <a href="{{ route('career') }}">Carrière & Emploi</a>
                                            </li>
                                            <li class="{{ request()->routeIs('about') ? 'active' : '' }}">
                                                <a href="{{ route('about')}}">À propos</a>
                                            </li>
                                            <li class="{{ request()->routeIs('blogs') ? 'active' : '' }}">
                                                <a href="{{ route("blogs") }}">Blog</a>
                                            </li>
                                            <li class="{{ request()->routeIs('main.faq') ? 'active' : '' }}">
                                                <a href="{{ route('main.faq') }}">Faq</a>
                                            </li>
                                            <li class="{{ request()->routeIs('complaint') ? 'active' : '' }}">
                                                <a href="{{ route('complaint') }}">Gestion des plaintes</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <!-- /.header-menu-wrap -->
                        </div>
                        <div class="header-right-wrap">
                            <div class="header-right">
                                <a href="{{ route('main.account') }}" class="bz-primary-btn">Ouvrir un compte</a>
                                <div class="sidebar-icon-2">
                                    <button class="sidebar-trigger open">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </button>
                                </div>
                            </div>
                            <!-- /.header-right -->
                        </div>
                    </div>
                    <!-- /.primary-header-inner -->
                </div>
            </div>
        </header>
        <!-- /.Main Header -->


        <div id="sidebar-area" class="sidebar-area" style="--bz-color-theme-primary: #EC281C">
            <button class="sidebar-trigger close">
                <svg
                    class="sidebar-close"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    x="0px"
                    y="0px"
                    width="16px"
                    height="12.7px"
                    viewBox="0 0 16 12.7"
                    style="enable-background: new 0 0 16 12.7"
                    xml:space="preserve">
                    <g>
                        <rect
                            x="0"
                            y="5.4"
                            transform="matrix(0.7071 -0.7071 0.7071 0.7071 -2.1569 7.5208)"
                            width="16"
                            height="2"></rect>
                        <rect
                            x="0"
                            y="5.4"
                            transform="matrix(0.7071 0.7071 -0.7071 0.7071 6.8431 -3.7929)"
                            width="16"
                            height="2"></rect>
                    </g>
                </svg>
            </button>
            <div class="side-menu-content">
                <div class="side-menu-logo">
                    <a href="{{ route("index") }}"><img src="{{ URL::asset('assets/images/Logo.png') }}" alt="logo"></a>
                </div>
                <div class="side-menu-wrap">
                    <ul>
                        <li class="{{ request()->routeIs('index') ? 'active' : '' }}">
                            <a href="{{ route("index") }}">Accueil</a>
                        </li>
                        <li class="{{ request()->routeIs('product.*') ? 'active' : '' }}">
                            <a href="{{ route("product.index") }}">Produits</a>
                        </li>
                        <li class="{{ request()->routeIs('agencies') ? 'active' : '' }}">
                            <a href="{{ route("agencies") }}">Agences</a>
                        </li>
                        <li class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                            <a href="{{ route('contact') }}">Contact</a>
                        </li>
                        <li>
                            <a href="https://www.ebindoo.com/" target="_blank">Compte en ligne</a>
                        </li>
                        <li class="{{ request()->routeIs('main.finance') ? 'active' : '' }}">
                            <a href="{{ route('main.finance')}}">Finance Digitale</a>
                        </li>
                        <li class="{{ request()->routeIs('career') ? 'active' : '' }}">
                            <a href="{{ route('career') }}">Carrière & Emploi</a>
                        </li>
                        <li class="{{ request()->routeIs('about') ? 'active' : '' }}">
                            <a href="{{ route('about')}}">À propos</a>
                        </li>
                        <li class="{{ request()->routeIs('blogs') ? 'active' : '' }}">
                            <a href="{{ route("blogs") }}">Blog</a>
                        </li>
                        <li class="{{ request()->routeIs('main.faq') ? 'active' : '' }}">
                            <a href="{{ route('main.faq') }}">Faq</a>
                        </li>
                        <li>
                            <a href="{{ route('complaint') }}">Gestion des plaintes</a>
                        </li>
                    </ul>
                </div>
                <div class="side-menu-about">
                    <div class="side-menu-header">
                        <h3>À Propos</h3>
                    </div>
                    {{-- Texte "À Propos" complété et adapté à COCEC --}}
                    <p class="text-justify">La COCEC est votre partenaire financier de confiance, dédié à la réussite de ses membres. Nous offrons des services accessibles et innovants pour accompagner vos projets et améliorer vos conditions de vie.</p>
                    <a href="{{ route('contact') }}" class="bz-primary-btn">Contactez-nous</a>
                </div>
                <div class="side-menu-contact">
                    <div class="side-menu-header">
                        <h3>Contactez-nous</h3>
                    </div>
                    <ul class="side-menu-list">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <p>Quartier KANYIKOPE à 50m du Lycée FOLLY-BEBE en allant vers KAGOME </p>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <a href="tel:+22891126471">+228 91 12 64 71 / +228 22 71 41 48</a>
                        </li>
                        <li>
                            <i class="fas fa-envelope-open-text"></i>
                            <a href="mailto:cocec@cocectogo.org">cocec@cocectogo.org</a>
                        </li>
                    </ul>
                </div>
                {{-- Réseaux sociaux mis à jour pour n'inclure que Facebook et WhatsApp --}}
                <ul class="side-menu-social">
                    <li class="facebook"><a href="https://www.facebook.com/COCEC-105458737978835"><i class="fab fa-facebook-f"></i></a></li>
                    {{-- Ajout de WhatsApp avec le lien et l'icône corrects --}}
                    <li class="whatsapp"><a href="https://wa.me/22891126471" target="_blank"><i class="fab fa-whatsapp"></i></a></li>
                </ul>
            </div>
        </div>
        <!--/.sidebar-area-->