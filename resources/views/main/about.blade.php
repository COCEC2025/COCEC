@extends('layout.main')

@section('content')

<body>
    @include('includes.main.loading')
    @include('includes.main.header')

    <!-- ================================== -->
    <!--          SECTION HÉROS             -->
    <!-- ================================== -->
    <section class="page-header-pro">
        <div class="page-header-overlay"></div>
        <div class="container">
            <div class="page-header-content-pro" data-aos="fade-up">
                <h1 class="title-pro">Découvrir la COCEC</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb-pro">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Accueil</a></li>
                        <li class="breadcrumb-item active" aria-current="page">À propos</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <!-- ================================== -->
    <!--       SECTION MOT DU DIRECTEUR       -->
    <!-- ================================== -->
    <section class="director-section-revisited page-section">

        <div class="container">
            <!-- Flèche de retour -->
            <div class="back-arrow-container" style="padding: 15px 0; text-align: left;">
                @include('includes.main.back-arrow', [
                    'url' => route('index'),
                    'text' => 'Retour à l\'accueil',
                    'color' => 'var(--bz-color-theme-secondary)',
                    'class' => 'about-style'
                ])
            </div>
            <div class="director-layout-revisited">
                <div class="director-image-wrapper" data-aos="fade-right">
                    <img src="{{ asset('assets/images/dg.jpeg') }}" alt="Photo du Directeur Général de la COCEC">
                </div>
                <div class="director-content-card" data-aos="fade-left" data-aos-delay="200">
                    <h2 class="section-subtitle">Le mot du directeur général</h2>
                    <blockquote>
                        <p class="text-justify">"

                            La réduction de la pauvreté a toujours été une préoccupation de premier ordre à travers le monde. James D. Wolfensohn disait : « Nous tous à la banque mondiale, nous sommes donnés pour mission de combattre la pauvreté avec passion et conscience professionnelle, et ce combat nous inspire dans notre tâche à chaque instant ». La COCEC aussi depuis sa création en 2001 a placé l’amélioration des conditions de vie de sa population cible au centre de ses stratégies d’intervention. Elle s’est démarquée comme un outil important de lutte efficace contre la pauvreté en offrant des services financiers bien étudiés et adaptés aux besoins de sa population cible. Nous avons reçu et continuons de recevoir des témoignages de personnes qui sont partis de rien et qui aujourd’hui arrivent à subvenir aux besoins de leur famille et à épargner grâce aux services financiers qu’ils ont eu à bénéficier de la COCEC. Notre grand défi est de continuer à proposer à la clientèle des produits innovants à moindre coût adaptés à leurs besoins à travers l’utilisation des nouvelles technologies d’information et de communication et aussi l’amélioration de la qualité des services. L’interconnexion de nos Agences, la collecte tontine par les téléphones portables, le passage d’un système de bases décentralisées à une base consolidée, la migration de notre SIG du client lourd au léger, la digitalisation des opérations avec l’introduction du Mobile Money, du Mobile Banking, du Web banking et des systèmes d’alerte témoignent de la volonté des premiers responsables de faire de la COCEC, une Institution moderne et modèle et résolument tournée vers l’avenir. Je sais une chose, avec Dieu à nos cotés et cette confiance accrue et renouvelée de nos clients ainsi que de nos partenaires que nous accomplirons des exploits.

                            "</p>
                        <cite>
                            <span class="director-name">M. Kokou GABIAM</span>
                            <span class="director-title">Directeur général, COCEC</span>
                        </cite>
                    </blockquote>
                </div>
            </div>
        </div>
    </section>

    <!-- ================================== -->
    <!--     SECTION PILIERS DE L'IDENTITÉ    -->
    <!-- ================================== -->
    <section class="identity-pillars-section page-section-light">
        <div class="container">
            <!-- Titre de la section -->
            <div class="section-header text-center" data-aos="fade-up">
                <h2 class="section-title">Les piliers de notre identité</h2>
                <p class="section-intro">Trois engagements qui définissent qui nous sommes, ce que nous visons, et comment nous y parvenons.</p>
            </div>

            <!-- Le conteneur en grille pour les trois piliers -->
            <div class="pillars-grid">

                <!-- Pilier 1: Mission -->
                <div class="pillar-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="pillar-icon-wrapper">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <div class="pillar-content">
                        <h4>Notre mission</h4>
                        <p class="text-justify">
                            Elle a l’ambition de contribuer à l’amélioration de la qualité de vie de la ation du Togo en général et de sa population cible en particulier, en œuvrant à la réduction de la pauvreté par la mise à la disposition de ces dernières des services d’épargne et de crédit à la base, adaptés à leurs besoins en veillant à la pérennité de ces services.</p>
                    </div>
                </div>

                <!-- Pilier 2: Vision -->
                <div class="pillar-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="pillar-icon-wrapper">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="pillar-content">
                        <h4>Notre vision</h4>
                        <p class="text-justify"> La COCEC compte devenir une Institution de référence dans le secteur de la micro finance au Togo et à l’extérieur en matière de bonnes pratiques de gouvernance, de contrôle et d’offres de produits et services de qualité et à moindre coût.</p>
                    </div>
                </div>

                <!-- Pilier 3: Valeurs -->
                <div class="pillar-card" data-aos="fade-up" data-aos-delay="500">
                    <div class="pillar-icon-wrapper">
                        <i class="fas fa-gem"></i>
                    </div>
                    <div class="pillar-content">
                        <h4>Nos valeurs</h4>
                        <ul class="values-sublist">
                            <li><i class="fas fa-cross"></i><span><strong>Crainte de Dieu :</strong> Le fondement de notre sagesse.</span></li>
                            <li><i class="fas fa-praying-hands"></i><span><strong>Foi :</strong> Le moteur de notre ambition.</span></li>
                            <li><i class="fas fa-users"></i><span><strong>Respect des membres :</strong> Notre raison d'être.</span></li>
                            <li><i class="fas fa-star"></i><span><strong>Qualité de service :</strong> Notre standard d'excellence.</span></li>
                            <li><i class="fas fa-balance-scale"></i><span><strong>Responsabilité :</strong> Notre engagement de transparence.</span></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ================================== -->
    <!--        SECTION ORGANIGRAMME          -->
    <!-- ================================== -->
    <section class="org-chart-section page-section">
        <div class="container">
            <div class="section-header text-center" data-aos="fade-up">
                <h2 class="section-title">Notre structure organisationnelle</h2>
                <p class="section-intro">Une organisation claire pour un service efficace.</p>
            </div>
            <!-- Le wrapper permet un défilement horizontal sur mobile si l'image est trop large -->
            <div class="org-chart-wrapper" data-aos="fade-up" data-aos-delay="100">
                <img src="{{ asset('assets/images/organigramme.png') }}" alt="Organigramme de la COCEC">
            </div>
        </div>
    </section>

    @include('includes.main.scroll')
    @include('includes.main.footer')

</body>
@endsection