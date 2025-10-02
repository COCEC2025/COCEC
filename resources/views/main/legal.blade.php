@extends('layout.main')

@section('title', 'Mentions Légales et Politique de Confidentialité - COCEC')

@section('content')
<body>
    @include('includes.main.loading')
    @include('includes.main.header')

    {{-- HERO DE PAGE --}}
    <section class="page-header-pro">
        <div class="page-header-overlay"></div>
        <div class="container">
            <div class="page-header-content-pro" data-aos="fade-up">
                <h1 class="title-pro">Mentions Légales et Politique de Confidentialité</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb-pro">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Accueil</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Mentions Légales</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    {{-- CONTENU PRINCIPAL --}}
    <section class="legal-content py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="legal-document">
                        
                        {{-- MENTIONS LÉGALES --}}
                        <div class="legal-section mb-5">
                            <h2 class="section-title mb-4">Mentions légales</h2>
                            
                            <div class="legal-item mb-4">
                                <h3 class="item-title">1. Éditeur du site</h3>
                                <p>Le présent site est édité par :</p>
                                <p><strong>Coopérative Chrétienne d'Epargne et de Crédit</strong></p>
                                <p>Siège social : Kanyikopé, à 50 mètres du lycée FOLLY-BEBE</p>
                                <p>Régie par la Loi 2011-009 du 12 Mai 2011, agréée sous le N°016/MEFP/SG/CAS-IMEC et inscrite sur le registre des IMEC sous le n° T/1/GFLM/2006/128A</p>
                                <p>Téléphone : 00228 91 12 64 71</p>
                                <p>E-mail : cocec@cocectogo.org</p>
                                <p>Responsable de la publication : CSVTI</p>
                            </div>

                            <div class="legal-item mb-4">
                                <h3 class="item-title">2. Hébergement</h3>
                                <p>Le site est hébergé par PLANETHOSTER inc</p>
                                <p>Adresse : 4416 Louis B. Mayer, Laval (Québec) H7P 0G1, Canada</p>
                                <p>Téléphone :</p>
                                <ul>
                                    <li>FR (Nº Vert): 0 805 080 426</li>
                                    <li>FR: +33 1 76 60 41 43</li>
                                    <li>BE: +32 28 08 13 21</li>
                                    <li>CH: +41 31 528 01 41</li>
                                    <li>UK: +44 (0)808 189 0423</li>
                                    <li>AU: +61 18 0035 1172</li>
                                    <li>US: +1 855 774 4678</li>
                                    <li>CA: +1 855 774 4678</li>
                                    <li>QC: +1 514 802 1644</li>
                                </ul>
                                <p>Site web : <a href="https://www.planethoster.fr/" target="_blank">https://www.planethoster.fr/</a></p>
                            </div>

                            <div class="legal-item mb-4">
                                <h3 class="item-title">3. Activité réglementée</h3>
                                <p>La COCEC exerce des activités de microfinance depuis 2001 et est dûment agréée par le Ministère de l'Économie et des Finances du Togo et placée sous la supervision de la Banque Centrale des États de l'Afrique de l'Ouest (BCEAO).</p>
                                <p>Les services proposés s'adressent exclusivement aux personnes éligibles conformément à la réglementation en vigueur.</p>
                            </div>

                            <div class="legal-item mb-4">
                                <h3 class="item-title">4. Propriété intellectuelle</h3>
                                <p>Le site cocectogo.org, ainsi que l'ensemble de son contenu (textes, images, graphismes, logo, icônes, vidéos, base de données, structure du site, etc.) sont la propriété exclusive de la COCEC, sauf mention contraire.</p>
                                <p>Toute reproduction, représentation, modification, publication, transmission, dénaturation, totale ou partielle du site ou de son contenu, par quelque procédé que ce soit et sur quelque support que ce soit, est interdite sans l'autorisation écrite préalable de la coopérative.</p>
                                <p>Toute exploitation non autorisée du site ou de son contenu engage la responsabilité de l'utilisateur et constitue une contrefaçon sanctionnée par la législation en vigueur au Togo et par les conventions internationales relatives à la protection de la propriété intellectuelle.</p>
                                
                                <h4 class="sub-item-title">Exceptions</h4>
                                <ul>
                                    <li>Les images issues de banques d'images libres de droits (Pixabay, Unsplash, Pexels, etc.) restent la propriété de leurs auteurs respectifs et sont utilisées conformément à leurs conditions d'utilisation.</li>
                                    <li>Dans ce cas, les crédits photographiques sont indiqués dans la section Crédits des présentes mentions légales.</li>
                                </ul>
                            </div>

                            <div class="legal-item mb-4">
                                <h3 class="item-title">5. Données personnelles</h3>
                                <p>Les informations recueillies via les formulaires du site (contact, demande d'informations, demande d'adhésion, demande de souscription à la finance digitale, etc.) font l'objet d'un traitement destiné uniquement à la gestion des demandes des utilisateurs et à la relation avec la coopérative.</p>
                                <p>Conformément à la réglementation applicable en matière de protection des données personnelles :</p>
                                <ul>
                                    <li>Vous disposez d'un droit d'accès, de rectification et d'opposition concernant vos données.</li>
                                    <li>Vous pouvez exercer ces droits en écrivant à : <a href="mailto:cocec@cocectogo.org">cocec@cocectogo.org</a></li>
                                </ul>
                                <p>Une politique de confidentialité détaillant les modalités de collecte et de traitement des données est disponible sur le site.</p>
                            </div>

                            <div class="legal-item mb-4">
                                <h3 class="item-title">6. Limitation de responsabilité</h3>
                                <p>Les informations communiquées sur ce site sont fournies à titre informatif et peuvent être modifiées à tout moment.</p>
                                <p>La COCEC ne saurait être tenue responsable :</p>
                                <ul>
                                    <li>d'une mauvaise utilisation du site par l'utilisateur,</li>
                                    <li>des éventuels dommages directs ou indirects liés à l'accès ou à l'utilisation du site,</li>
                                    <li>du contenu des sites tiers accessibles par des liens hypertextes.</li>
                                </ul>
                            </div>

                            <div class="legal-item mb-4">
                                <h3 class="item-title">7. Sources</h3>
                                <p><strong>Textes et contenus :</strong> COCEC</p>
                                <p><strong>Crédits photos :</strong></p>
                                <ul>
                                    <li>Certaines images sont la propriété exclusive de la COCEC</li>
                                    <li>D'autres images proviennent de banques d'images libres de droits et sont utilisées conformément à leurs conditions d'utilisation.</li>
                                </ul>
                            </div>
                        </div>

                        {{-- POLITIQUE DE CONFIDENTIALITÉ --}}
                        <div class="legal-section" id="politique-confidentialite">
                            <h2 class="section-title mb-4">Politique de confidentialité</h2>
                            
                            <div class="legal-item mb-4">
                                <h3 class="item-title">1. Objet de la présente politique</h3>
                                <p>La présente politique de confidentialité a pour objectif d'informer les utilisateurs du site cocectogo.org sur la manière dont leurs données personnelles sont collectées, utilisées, stockées et protégées.</p>
                            </div>

                            <div class="legal-item mb-4">
                                <h3 class="item-title">2. Responsable du traitement</h3>
                                <p>Le responsable du traitement des données est : COCEC</p>
                                <p>Adresse : Kanyikopé, à 50 mètres du lycée FOLLY-BEBE</p>
                                <p>Téléphone : 00228 91 12 64 71</p>
                                <p>E-mail : cocec@cocectogo.org</p>
                            </div>

                            <div class="legal-item mb-4">
                                <h3 class="item-title">3. Données collectées</h3>
                                <p>Lors de la navigation et de l'utilisation du site, la COCEC peut collecter les informations suivantes :</p>
                                <ul>
                                    <li>Nom, prénom</li>
                                    <li>Coordonnées (adresse, téléphone, e-mail, géolocalisation)</li>
                                    <li>Informations transmises via les formulaires (demandes d'informations, dépôt de candidature, demande d'adhésion, etc.)</li>
                                    <li>Données techniques liées à la navigation (adresse IP, type de navigateur, pages consultées – à des fins statistiques uniquement)</li>
                                </ul>
                                <p>Aucune donnée sensible (opinions politiques, santé, religion, etc.) n'est collectée.</p>
                            </div>

                            <div class="legal-item mb-4">
                                <h3 class="item-title">4. Finalités du traitement</h3>
                                <p>Les données collectées sont utilisées uniquement pour :</p>
                                <ul>
                                    <li>répondre aux demandes d'information et de contact,</li>
                                    <li>gérer les demandes liées aux services de la coopérative,</li>
                                    <li>améliorer le fonctionnement du site et l'expérience utilisateur,</li>
                                    <li>respecter les obligations légales et réglementaires applicables à la microfinance.</li>
                                </ul>
                            </div>

                            <div class="legal-item mb-4">
                                <h3 class="item-title">5. Destinataires des données</h3>
                                <p>Les données sont traitées exclusivement par la COCEC et ne sont transmises à aucun tiers, sauf :</p>
                                <ul>
                                    <li>aux autorités administratives ou judiciaires si la loi l'exige,</li>
                                    <li>aux prestataires techniques intervenant pour l'hébergement ou la maintenance du site, dans la stricte limite de leurs missions.</li>
                                </ul>
                            </div>

                            <div class="legal-item mb-4">
                                <h3 class="item-title">6. Durée de conservation</h3>
                                <p>Les données personnelles sont conservées pendant une durée n'excédant pas celle nécessaire aux finalités pour lesquelles elles sont collectées, soit :</p>
                                <ul>
                                    <li>3 ans après le dernier contact pour les demandes d'information,</li>
                                    <li>la durée légale applicable aux dossiers clients pour les services financiers.</li>
                                </ul>
                            </div>

                            <div class="legal-item mb-4">
                                <h3 class="item-title">7. Sécurité des données</h3>
                                <p>La COCEC met en œuvre toutes les mesures techniques et organisationnelles appropriées afin de garantir la confidentialité, l'intégrité et la sécurité des données personnelles collectées.</p>
                            </div>

                            <div class="legal-item mb-4">
                                <h3 class="item-title">8. Droits des utilisateurs</h3>
                                <p>Conformément à la réglementation applicable, chaque utilisateur dispose des droits suivants :</p>
                                <ul>
                                    <li>droit d'accès à ses données,</li>
                                    <li>droit de rectification,</li>
                                    <li>droit d'opposition au traitement de ses données pour des motifs légitimes,</li>
                                    <li>droit à l'effacement lorsque cela est applicable.</li>
                                </ul>
                                <p>Pour exercer ces droits, vous pouvez nous contacter à l'adresse suivante : <a href="mailto:cocec@cocectogo.org">cocec@cocectogo.org</a></p>
                            </div>

                            <div class="legal-item mb-4">
                                <h3 class="item-title">9. Cookies</h3>
                                <p>Le site peut utiliser des cookies afin de faciliter la navigation et mesurer la fréquentation.</p>
                                <p>L'utilisateur peut configurer son navigateur pour refuser ou limiter l'enregistrement des cookies.</p>
                            </div>

                            <div class="legal-item mb-4">
                                <h3 class="item-title">10. Modification de la politique</h3>
                                <p>La présente politique de confidentialité peut être mise à jour à tout moment afin de se conformer aux évolutions légales, réglementaires ou techniques.</p>
                                <p>La date de la dernière mise à jour est : 01/10/2025.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('includes.main.footer')
</body>

<style>
.legal-content {
    background-color: #f8f9fa;
    min-height: 100vh;
}

.legal-document {
    background: white;
    padding: 3rem;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    margin: 2rem 0;
}

.section-title {
    color: #EC281C;
    font-size: 2rem;
    font-weight: 700;
    border-bottom: 3px solid #EC281C;
    padding-bottom: 0.5rem;
    margin-bottom: 2rem;
}

.item-title {
    color: #333;
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 1rem;
    margin-top: 2rem;
}

.sub-item-title {
    color: #555;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    margin-top: 1rem;
}

.legal-item {
    margin-bottom: 2rem;
}

.legal-item p {
    line-height: 1.6;
    margin-bottom: 1rem;
    color: #555;
}

.legal-item ul {
    margin-left: 1.5rem;
    margin-bottom: 1rem;
}

.legal-item li {
    margin-bottom: 0.5rem;
    line-height: 1.5;
    color: #555;
}

.legal-item a {
    color: #EC281C;
    text-decoration: none;
}

.legal-item a:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .legal-document {
        padding: 1.5rem;
        margin: 1rem 0;
    }
    
    .section-title {
        font-size: 1.5rem;
    }
    
    .item-title {
        font-size: 1.1rem;
    }
}
</style>
@endsection
