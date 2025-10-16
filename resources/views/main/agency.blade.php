@extends('layout.main')

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
{{-- NOUVEAU LIEN CSS : Requis pour GLightbox --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />

<style>
    /* 1. VARIABLES DE COULEURS */
    :root {
        --primary-color: #EC281C;
        --secondary-color: #FFCC00;
        --dark-charcoal: #2D3748;
        --text-color: #4A5568;
        --light-gray-bg: #F7FAFC;
        --border-color: #E2E8F0;
        --font-family: 'Poppins', sans-serif;
    }

    /* 2. STYLES GÉNÉRAUX */
    .agency-hero-section {
        padding: 80px 0;
        background-color: var(--dark-charcoal);
        color: #FFFFFF;
        font-family: var(--font-family);
    }

    .agency-hero-section .section-title {
        font-size: 2.8rem;
        font-weight: 700;
        letter-spacing: -1px;
    }

    .agency-hero-section .lead {
        font-size: 1.2rem;
        max-width: 700px;
        margin: 15px auto 30px auto;
        color: rgba(255, 255, 255, 0.8);
    }

    .agency-search-bar {
        position: relative;
        max-width: 500px;
        margin: 0 auto;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50px;
        padding: 8px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .agency-search-bar .search-icon {
        position: absolute;
        top: 50%;
        left: 25px;
        transform: translateY(-50%);
        color: rgba(255, 255, 255, 0.8);
        font-size: 1rem;
        z-index: 2;
        transition: all 0.3s ease;
    }

    .agency-search-bar input {
        width: 100%;
        padding: 15px 25px 15px 50px;
        border-radius: 50px;
        border: none;
        background: transparent;
        font-size: 1rem;
        color: #FFFFFF;
        outline: none;
        transition: all 0.3s ease;
    }

    .agency-search-bar input::placeholder {
        color: rgba(255, 255, 255, 0.7);
        font-weight: 400;
    }

    .agency-search-bar input:focus {
        background: rgba(255, 255, 255, 0.15);
    }

    .agency-search-bar input:focus+.search-icon {
        color: var(--primary-color);
    }

    /* 3. SECTION PRINCIPALE */
    .agency-main-section {
        padding: 80px 0;
        background-color: var(--light-gray-bg);
        font-family: var(--font-family);
    }

    .agency-page-layout {
        display: grid;
        grid-template-columns: 4fr 3fr;
        gap: 50px;
    }

    .agency-map-container {
        position: sticky;
        top: 120px;
        height: 85vh;
        border-radius: 16px;
        box-shadow: 0 15px 40px rgba(45, 55, 72, 0.1);
        z-index: 10;
        overflow: hidden;
    }

    #agency-map {
        width: 100%;
        height: 100%;
    }

    .agency-list-header {
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .agency-list-header h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--dark-charcoal);
        margin: 0;
    }

    #agency-count {
        background-color: #EDF2F7;
        color: var(--dark-charcoal);
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.9rem;
    }

    .agency-list-container {
        height: 80vh;
        overflow-y: auto;
        padding-right: 15px;
    }

    .agency-list-container::-webkit-scrollbar {
        width: 6px;
    }

    .agency-list-container::-webkit-scrollbar-track {
        background: #EDF2F7;
    }

    .agency-list-container::-webkit-scrollbar-thumb {
        background-color: #CBD5E0;
        border-radius: 6px;
    }

    /* 4. CARTE DE L'AGENCE */
    .agency-card {
        background: #FFFFFF;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        margin-bottom: 20px;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        cursor: pointer;
    }

    .agency-card:hover {
        transform: translateY(-4px) scale(1.01);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.07), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .agency-card.active {
        border-color: var(--primary-color);
        box-shadow: 0 10px 15px -3px rgba(236, 40, 28, 0.1), 0 4px 6px -2px rgba(236, 40, 28, 0.05);
    }

    /* Le lien autour de l'image pour le lightbox */
    .agency-image-link {
        display: block;
        /* Important pour que le lien prenne la place de l'image */
        cursor: zoom-in;
    }

    .agency-card-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 11px 11px 0 0;
        border-bottom: 1px solid var(--border-color);
        /* Optimisations de performance */
        will-change: auto;
        transform: translateZ(0);
        backface-visibility: hidden;
        image-rendering: -webkit-optimize-contrast;
        image-rendering: crisp-edges;
    }



    .agency-card .card-content {
        padding: 25px;
    }

    .agency-card .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .agency-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--dark-charcoal);
        margin: 0;
    }

    .status-dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 8px;
    }

    .status-dot[data-status="Open"] {
        background-color: #38A169;
    }

    .status-dot[data-status="Close"] {
        background-color: #E53E3E;
    }

    .agency-status {
        font-weight: 500;
        font-size: 0.9rem;
    }

    .agency-info {
        list-style: none;
        padding: 0;
        margin: 0 0 20px 0;
    }

    .agency-info li {
        display: flex;
        align-items: flex-start;
        margin-bottom: 12px;
        color: var(--text-color);
    }

    .agency-info .info-icon {
        color: var(--primary-color);
        font-size: 1rem;
        width: 20px;
        text-align: center;
        margin-right: 15px;
        margin-top: 2px;
    }

    .agency-actions {
        display: flex;
        gap: 10px;
    }

    .btn-action {
        flex: 1;
        padding: 10px 15px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        text-align: center;
        transition: all 0.2s ease;
        border: 2px solid transparent;
    }

    .btn-route {
        background-color: var(--primary-color);
        color: #FFFFFF;
    }

    .btn-route:hover {
        background-color: var(--secondary-color);
    }

    .btn-call {
        background-color: transparent;
        color: var(--dark-charcoal);
        border-color: var(--border-color);
    }

    .btn-call:hover {
        background-color: var(--light-gray-bg);
    }

    .no-results-message {
        text-align: center;
        padding: 40px 20px;
        background-color: #fff;
        border-radius: 12px;
        border: 1px solid var(--border-color);
    }

    .no-results-message i {
        font-size: 2.5rem;
        color: #CBD5E0;
        margin-bottom: 15px;
    }

    .no-results-message p {
        font-size: 1.1rem;
        color: var(--text-color);
        font-weight: 500;
        margin: 0;
    }

    @media (max-width: 991px) {
        .agency-page-layout {
            grid-template-columns: 1fr;
        }

        .agency-map-container {
            position: relative;
            top: 0;
            height: 50vh;
        }

        .agency-list-container {
            height: auto;
            overflow-y: visible;
        }
    }
</style>
@endsection

@section('content')
@include('includes.main.loading')
@include('includes.main.header')


<section class="page-header-pro">
    <div class="page-header-overlay"></div>
    <div class="container">
        <div class="page-header-content-pro" data-aos="fade-up">
            <h1 class="title-pro">Notre réseau d'agences</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb-pro">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Accueil</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Agences</li>
                </ol>
            </nav>
            <br><br>
            <div class="agency-search-bar">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="agency-search-input" placeholder="Rechercher par nom ou par ville...">
            </div>
        </div>
    </div>
</section>

<section class="agency-main-section">
    <div class="container">
        <div class="agency-page-layout">
            <div class="agency-map-container">
                <div id="agency-map"></div>
            </div>
            <div>
                <div class="agency-list-header">
                    <h3>Nos agences</h3><span id="agency-count"></span>
                </div>
                <div class="agency-list-container" id="agency-list"></div>
            </div>
        </div>
    </div>
</section>

@include('includes.main.scroll')
@include('includes.main.footer')
@endsection

@section('js')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const agencies = @json($agencies ?? []);

        // Initialisation de GLightbox
        const lightbox = GLightbox({
            selector: '.agency-image-link' // Cible les liens avec cette classe
        });

        const map = L.map('agency-map').setView([6.30, 1.0], 9);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '© OpenStreetMap contributors © CARTO'
        }).addTo(map);
        const markersLayer = new L.LayerGroup().addTo(map);
        const agencyListContainer = document.getElementById('agency-list');
        const searchInput = document.getElementById('agency-search-input');
        const agencyCountSpan = document.getElementById('agency-count');

        console.log('Éléments DOM trouvés:');
        console.log('agencyListContainer:', agencyListContainer);
        console.log('searchInput:', searchInput);
        console.log('agencyCountSpan:', agencyCountSpan);
        const customIcon = L.icon({
            iconUrl: `data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="36" height="36"><path fill="%23EC281C" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/><path fill="none" d="M0 0h24v24H0z"/></svg>`,
            iconSize: [36, 36],
            iconAnchor: [18, 36],
            popupAnchor: [0, -36]
        });

        function getDynamicAgencyStatus(status) {
            const now = new Date();
            const day = now.getDay();
            const hour = now.getHours();
            const minute = now.getMinutes();
            const currentTime = hour + minute / 60; // Convertir en heures décimales
            
            // Dimanche : toujours fermé
            if (day === 0) {
                return {
                    text: 'Fermé',
                    className: 'Close'
                };
            }
            
            // Samedi : vérifier le statut de l'agence
            if (day === 6) {
                if (status === 'Open' && currentTime >= 8.0 && currentTime < 12.0) {
                    return {
                        text: 'Ouvert',
                        className: 'Open'
                    };
                } else {
                    return {
                        text: 'Fermé',
                        className: 'Close'
                    };
                }
            }
            
            // Lundi à Vendredi : 7h30-15h00
            if (currentTime >= 7.5 && currentTime < 15.0) {
                return {
                    text: 'Ouvert',
                    className: 'Open'
                };
            }
            
            return {
                text: 'Fermé',
                className: 'Close'
            };
        }

        function renderListAndMarkers(filteredAgencies) {
            console.log('renderListAndMarkers appelée avec:', filteredAgencies);
            console.log('Nombre d\'agences à afficher:', filteredAgencies.length);

            agencyListContainer.innerHTML = '';
            markersLayer.clearLayers();
            agencyCountSpan.textContent = `${filteredAgencies.length} agence(s) trouvée(s)`;

            if (filteredAgencies.length === 0) {
                console.log('Aucune agence à afficher');
                agencyListContainer.innerHTML = `<div class="no-results-message"><i class="fas fa-store-slash"></i><p>Aucune agence ne correspond à votre recherche.</p></div>`;
                return;
            }
            filteredAgencies.forEach(agency => {
                const statusText = getDynamicAgencyStatus(agency.status).text;
                const statusClass = getDynamicAgencyStatus(agency.status).className;
                // Optimisation des images : format WebP si supporté, sinon JPEG optimisé
                const imageUrl = agency.image ? `/storage/${agency.image}` : `/storage/agency/placeholder.jpg`;
                // Pour l'instant, utiliser la même image car WebP n'existe pas encore
                const optimizedImageUrl = imageUrl;

                const cardHTML = `
                <div class="agency-card" id="agency-${agency.id}" data-id="${agency.id}">
                    <a href="${imageUrl}" class="agency-image-link" data-gallery="agencies" data-title="${agency.name}">
                        <img src="${imageUrl}" alt="Façade de l'agence ${agency.name}" class="agency-card-image" loading="lazy" decoding="async" onerror="this.src='{{ asset('assets/images/placeholder-image.png') }}'">
                    </a>
                    <div class="card-content">
                        <div class="card-header">
                            <h3 class="agency-title">${agency.name}</h3>
                            <span class="agency-status"><span class="status-dot" data-status="${statusClass}"></span> ${statusText}</span>
                        </div>
                        <ul class="agency-info">
                            <li><i class="fas fa-map-marker-alt info-icon"></i> <div>${agency.address}</div></li>
                            <li><i class="fas fa-phone-alt info-icon"></i> <div>(+228) ${agency.phone}</div></li>
                            ${agency.distance ? `<li><i class="fas fa-ruler info-icon"></i> <div>${agency.distance.toFixed(1)} km de votre position</div></li>` : ''}
                        </ul>
                        <div class="agency-actions">
                            <a href="https://www.google.com/maps/dir/?api=1&destination=${agency.latitude},${agency.longitude}" target="_blank" class="btn-action btn-route"><i class="fas fa-directions"></i> Itinéraire</a>
                            <a href="tel:+228${agency.phone}" class="btn-action btn-call"><i class="fas fa-phone-alt"></i> Appeler</a>
                        </div>
                    </div>
                </div>`;

                agencyListContainer.insertAdjacentHTML('beforeend', cardHTML);
                const marker = L.marker([agency.latitude, agency.longitude], {
                    icon: customIcon,
                    riseOnHover: true
                }).bindPopup(`<b>${agency.name}</b><br>${agency.address}`).on('click', () => handleInteraction(agency.id, 'marker'));
                marker.agencyId = agency.id;
                markersLayer.addLayer(marker);
            });
            attachCardEventListeners();
            lightbox.reload(); // Indispensable pour que GLightbox détecte les nouvelles images après un filtre
        }

        function handleInteraction(id, source = 'card') {
            const agency = agencies.find(a => a.id === id);
            if (!agency) return;
            map.flyTo([agency.latitude, agency.longitude], 15);
            markersLayer.eachLayer(marker => {
                if (marker.agencyId === id) {
                    marker.openPopup();
                }
            });
            document.querySelectorAll('.agency-card').forEach(c => c.classList.remove('active'));
            const activeCard = document.getElementById(`agency-${id}`);
            if (activeCard) {
                activeCard.classList.add('active');
                if (source === 'marker') {
                    activeCard.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            }
        }

        function attachCardEventListeners() {
            document.querySelectorAll('.agency-card').forEach(card => {
                // L'événement clic est attaché à la carte entière
                card.addEventListener('click', function(event) {
                    // Si l'élément cliqué N'EST PAS le lien de l'image, on active la carte
                    if (!event.target.closest('.agency-image-link')) {
                        handleInteraction(parseInt(this.dataset.id));
                    }
                });
            });
        }

        function filterAgencies() {
            const searchTerm = searchInput.value.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
            const filtered = agencies.filter(agency => agency.name.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "").includes(searchTerm) || agency.address.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "").includes(searchTerm));
            renderListAndMarkers(filtered);
        }

        searchInput.addEventListener('input', filterAgencies);

        // Debug: vérifier les agences reçues
        console.log('=== DEBUG AGENCES ===');
        console.log('Agences reçues:', agencies);
        console.log('Nombre d\'agences:', agencies ? agencies.length : 'undefined');
        console.log('Type d\'agences:', typeof agencies);
        console.log('Est un tableau:', Array.isArray(agencies));

        // S'assurer que agencies est un tableau
        if (!agencies || !Array.isArray(agencies)) {
            console.error('Erreur: agencies n\'est pas un tableau valide');
            agencies = [];
        }

        console.log('Agences après vérification:', agencies);
        console.log('=== FIN DEBUG ===');

        // Toujours afficher les agences, avec ou sans géolocalisation
        renderListAndMarkers(agencies);

        // Si pas de coordonnées dans l'URL, essayer la géolocalisation
        if ('geolocation' in navigator && !window.location.search.includes('lat=')) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    const currentUrl = new URL(window.location);
                    currentUrl.searchParams.set('lat', lat);
                    currentUrl.searchParams.set('lng', lng);
                    window.location.href = currentUrl.toString();
                },
                function(error) {
                    console.log('Géolocalisation non disponible:', error.message);
                    // Les agences sont déjà affichées, pas besoin de refaire
                }, {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 300000
                }
            );
        }
    });
</script>
@endsection