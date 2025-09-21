@extends('layout.admin')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
            width: 100%;
        }

        .modal-map {
            height: 200px;
        }
    </style>
@endsection

@section('content')
    @include('includes.admin.sidebar')

    <main class="dashboard-main">
        @include('includes.admin.appbar')
        @include('includes.main.loading')

        <div class="dashboard-main-body">
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

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
                <h6 class="fw-semibold mb-0">Localisations des agences</h6>
                <ul class="d-flex align-items-center gap-2">
                    <li class="fw-medium">
                        <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                            <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                            Dashboard
                        </a>
                    </li>
                    <li>-</li>
                    <li class="fw-medium">Localisations des agences</li>
                </ul>
            </div>

            <div class="card h-100 p-0 radius-12 mb-24">
                <div class="card-header border-bottom bg-base py-16 px-24">
                    <h6 class="fw-semibold mb-0">Carte des agences</h6>
                </div>
                <div class="card-body p-24">
                    @if ($agencies->isEmpty())
                        <p class="text-center text-secondary">Aucune agence disponible pour afficher sur la carte.</p>
                    @else
                        <div id="map"></div>
                    @endif
                </div>
            </div>

            <div class="card h-100 p-0 radius-12">
                <div
                    class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                    <form action="{{ route('agency.index') }}" method="GET"
                        class="d-flex align-items-center flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <span class="text-md fw-medium text-secondary-light mb-0">Afficher</span>
                            <select name="per_page" class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px"
                                onchange="this.form.submit()">
                                <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            </select>
                        </div>
                        <div class="navbar-search">
                            <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="Rechercher..."
                                value="{{ request('search') }}">
                            <button type="submit" style="border:none; background:transparent; cursor:pointer;">
                                <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                            </button>
                        </div>
                    </form>
                    <a href="{{ route('agency.create') }}"
                        class="btn btn-danger text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
                        <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                        Ajouter une agence
                    </a>
                </div>

                <div class="card-body p-24">
                    <div class="table-responsive scroll-sm">
                        <table class="table bordered-table sm-table mb-0">
                            <thead>
                                <tr>
                                    <th>Date de Création</th>
                                    <th>Nom</th>
                                    <th>Coordonnées</th>
                                    <th>Téléphone</th>
                                    <th class="text-center">Statut</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($agencies as $agency)
                                    <tr>
                                        <td>{{ $agency->created_at->format('d M Y') }}</td>
                                        <td>{{ $agency->name }}</td>
                                        <td>{{ $agency->latitude }}, {{ $agency->longitude }}</td>
                                        <td>{{ $agency->phone }}</td>
                                        <td class="text-center">
                                            @if ($agency->status === 'Open')
                                                <span
                                                    class="bg-success-focus text-success-600 border border-success-main px-24 py-4 radius-4 fw-medium text-sm">Ouverte les samedi</span>
                                            @elseif ($agency->status === 'Close')
                                                <span
                                                    class="bg-danger-200 text-neutral-600 border border-danger-400 px-24 py-4 radius-4 fw-medium text-sm">Fermée les samedi</span>
                                            @else
                                                <span
                                                    class="bg-neutral-200 text-neutral-600 border border-neutral-400 px-24 py-4 radius-4 fw-medium text-sm">Non
                                                    défini</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center gap-10 justify-content-center">
                                                <!-- Bouton VOIR -->
                                                <button type="button"
                                                    class="bg-info-focus text-info-600 bg-hover-info-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#viewAgencyModal{{ $agency->id }}">
                                                    <iconify-icon icon="lucide:eye" class="menu-icon"></iconify-icon>
                                                </button>

                                                <!-- Bouton EDITION -->
                                                <button type="button"
                                                    class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editAgencyModal{{ $agency->id }}">
                                                    <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                                </button>

                                                <!-- Bouton SUPPRIMER -->
                                                <form method="POST" action="{{ route('agency.destroy', $agency->id) }}"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                                        <iconify-icon icon="fluent:delete-24-regular"
                                                            class="menu-icon"></iconify-icon>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Aucune agence trouvée.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-24">
                        {{ $agencies->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Modals placés en dehors du tableau -->
        @foreach ($agencies as $agency)
            <!-- Modal de visualisation -->
            <div class="modal fade" id="viewAgencyModal{{ $agency->id }}" tabindex="-1"
                aria-labelledby="viewAgencyModalLabel{{ $agency->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewAgencyModalLabel{{ $agency->id }}">Détails de l'agence :
                                {{ $agency->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Nom :</strong> {{ $agency->name }}</p>
                                    <p><strong>Latitude :</strong> {{ $agency->latitude }}</p>
                                    <p><strong>Longitude :</strong> {{ $agency->longitude }}</p>
                                    <p><strong>Adresse :</strong> {{ $agency->address }}</p>
                                    <p><strong>Téléphone :</strong> {{ $agency->phone }}</p>
                                    <p><strong>Statut :</strong> {{ $agency->status ?? 'Non défini' }}</p>
                                    <p><strong>Date de création :</strong> {{ $agency->created_at->format('d M Y') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <div id="view-map-{{ $agency->id }}" class="modal-map" style="height: 250px;">
                                    </div>
                                </div>

                                <div class="w-100 max-h-250-px radius-8 overflow-hidden mb-20">
                                    @if ($agency->image)
                                        <img src="{{ \App\Helpers\FileHelper::getStorageImageUrl($agency->image, 'assets/images/agency.jpg') }}"
                                            alt="{{ $agency->title }}" class="w-100 h-100 object-fit-cover">
                                    @else
                                        <div
                                            class="w-100 h-194-px bg-neutral-100 d-flex align-items-center justify-content-center radius-8">
                                            <iconify-icon icon="solar:image-outline" class="text-neutral-400"
                                                style="font-size: 48px;"></iconify-icon>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal de modification -->
            <div class="modal fade" id="editAgencyModal{{ $agency->id }}" tabindex="-1"
                aria-labelledby="editAgencyModalLabel{{ $agency->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <form method="POST" action="{{ route('agency.update', $agency->id) }}" class="modal-content" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editAgencyModalLabel{{ $agency->id }}">Modifier l'agence :
                                {{ $agency->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name{{ $agency->id }}" class="form-label">Nom de l'agence</label>
                                        <input type="text" name="name" id="name{{ $agency->id }}"
                                            class="form-control @error('name', 'update-' . $agency->id) is-invalid @enderror"
                                            value="{{ old('name', $agency->name) }}" required>
                                        @error('name', 'update-' . $agency->id)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="latitude{{ $agency->id }}" class="form-label">Latitude</label>
                                        <input type="number" step="any" name="latitude"
                                            id="latitude{{ $agency->id }}"
                                            class="form-control @error('latitude', 'update-' . $agency->id) is-invalid @enderror"
                                            value="{{ old('latitude', $agency->latitude) }}" required>
                                        @error('latitude', 'update-' . $agency->id)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="longitude{{ $agency->id }}" class="form-label">Longitude</label>
                                        <input type="number" step="any" name="longitude"
                                            id="longitude{{ $agency->id }}"
                                            class="form-control @error('longitude', 'update-' . $agency->id) is-invalid @enderror"
                                            value="{{ old('longitude', $agency->longitude) }}" required>
                                        @error('longitude', 'update-' . $agency->id)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="address{{ $agency->id }}" class="form-label">Adresse</label>
                                        <textarea name="address" id="address{{ $agency->id }}"
                                            class="form-control @error('address', 'update-' . $agency->id) is-invalid @enderror" rows="3" required>{{ old('address', $agency->address) }}</textarea>
                                        @error('address', 'update-' . $agency->id)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone{{ $agency->id }}" class="form-label">Téléphone</label>
                                        <input type="text" name="phone" id="phone{{ $agency->id }}"
                                            class="form-control @error('phone', 'update-' . $agency->id) is-invalid @enderror"
                                            value="{{ old('phone', $agency->phone) }}" required>
                                        @error('phone', 'update-' . $agency->id)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="status{{ $agency->id }}" class="form-label">Statut</label>
                                        <select name="status" id="status{{ $agency->id }}"
                                            class="form-select @error('status', 'update-' . $agency->id) is-invalid @enderror">
                                            <option value=""
                                                {{ old('status', $agency->status) == null ? 'selected' : '' }}>Non défini
                                            </option>
                                            <option value="Open"
                                                {{ old('status', $agency->status) == 'Open' ? 'selected' : '' }}>Ouverte
                                            </option>
                                            <option value="Close"
                                                {{ old('status', $agency->status) == 'Close' ? 'selected' : '' }}>Fermée
                                            </option>
                                        </select>
                                        @error('status', 'update-' . $agency->id)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Localisation sur la carte</label>
                                    <div id="edit-map-{{ $agency->id }}" class="modal-map" style="height: 300px;">
                                    </div>
                                    <small class="text-muted">Cliquez sur la carte pour changer la position du
                                        marqueur</small>
                                </div>


                                <div class="w-100 max-h-250-px radius-8 overflow-hidden mb-20">
                                    @if ($agency->image)
                                        <img src="{{ \App\Helpers\FileHelper::getStorageImageUrl($agency->image, 'assets/images/agency.jpg') }}"
                                            alt="{{ $agency->title }}" class="w-100 h-100 object-fit-cover">
                                    @else
                                        <div
                                            class="w-100 h-194-px bg-neutral-100 d-flex align-items-center justify-content-center radius-8">
                                            <iconify-icon icon="solar:image-outline" class="text-neutral-400"
                                                style="font-size: 48px;"></iconify-icon>
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="image{{ $agency->id }}" class="form-label">Changer l'image (laisser
                                        vide pour conserver l'actuelle)</label>
                                    <input type="file" name="image" id="image{{ $agency->id }}"
                                        class="form-control @error('image', 'update-' . $agency->id) is-invalid @enderror"
                                        accept="image/*">
                                    @error('image', 'update-' . $agency->id)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-danger">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach

        @include('includes.admin.footer')
    </main>
@endsection

@section('js')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Variables globales pour stocker les cartes
            let mainMap;
            let viewMaps = {};
            let editMaps = {};
            let editMarkers = {};

            // Initialisation de la carte principale
            if (document.getElementById('map')) {
                // Coordonnées par défaut du Togo (Lomé)
                const defaultLat = 6.1375;
                const defaultLng = 1.2123;

                mainMap = L.map('map').setView([defaultLat, defaultLng], 8);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(mainMap);

                // Récupération des données des agences
                var agencies = @json($agencies->items());
                console.log('Agences:', agencies);

                // Ajout des marqueurs pour chaque agence avec validation
                if (agencies && Array.isArray(agencies) && agencies.length > 0) {
                    let validMarkers = [];
                    agencies.forEach(function(agency) {
                        // Vérifier que latitude et longitude sont des nombres valides
                        var lat = parseFloat(agency.latitude);
                        var lng = parseFloat(agency.longitude);

                        if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <=
                            180) {
                            let marker = L.marker([lat, lng])
                                .addTo(mainMap)
                                .bindPopup('<b>' + (agency.name || 'Nom non défini') + '</b><br>' + (agency
                                    .address || 'Adresse non définie') + '<br>Tél: ' + (agency.phone ||
                                    'Non défini'));
                            validMarkers.push([lat, lng]);
                        } else {
                            console.warn('Coordonnées invalides pour l\'agence:', agency);
                        }
                    });

                    // Ajuster la vue pour inclure tous les marqueurs valides
                    if (validMarkers.length > 0) {
                        if (validMarkers.length === 1) {
                            mainMap.setView(validMarkers[0], 10);
                        } else {
                            mainMap.fitBounds(validMarkers);
                        }
                    } else {
                        // Aucun marqueur valide, garder la vue par défaut sur le Togo
                        mainMap.setView([defaultLat, defaultLng], 8);
                    }
                } else {
                    console.log('Aucune agence à afficher ou données invalides.');
                    // Garder la vue par défaut sur le Togo
                    mainMap.setView([defaultLat, defaultLng], 8);
                }
            }

            // Fonction d'initialisation des cartes dans les modals
            function initModalMaps() {
                @foreach ($agencies as $agency)
                    // Carte de visualisation
                    if (document.getElementById('view-map-{{ $agency->id }}')) {
                        if (viewMaps[{{ $agency->id }}]) {
                            viewMaps[{{ $agency->id }}].remove();
                        }
                        viewMaps[{{ $agency->id }}] = L.map('view-map-{{ $agency->id }}').setView([
                            {{ $agency->latitude }}, {{ $agency->longitude }}
                        ], 13);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '© OpenStreetMap contributors'
                        }).addTo(viewMaps[{{ $agency->id }}]);
                        L.marker([{{ $agency->latitude }}, {{ $agency->longitude }}])
                            .addTo(viewMaps[{{ $agency->id }}])
                            .bindPopup(
                                '<b>{{ addslashes($agency->name) }}</b><br>{{ addslashes($agency->address) }}<br>Tél: {{ $agency->phone }}'
                            )
                            .openPopup();
                    }

                    // Carte de modification
                    if (document.getElementById('edit-map-{{ $agency->id }}')) {
                        if (editMaps[{{ $agency->id }}]) {
                            editMaps[{{ $agency->id }}].remove();
                        }
                        editMaps[{{ $agency->id }}] = L.map('edit-map-{{ $agency->id }}').setView([
                            {{ old('latitude', $agency->latitude) }},
                            {{ old('longitude', $agency->longitude) }}
                        ], 13);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '© OpenStreetMap contributors'
                        }).addTo(editMaps[{{ $agency->id }}]);

                        editMarkers[{{ $agency->id }}] = L.marker([{{ old('latitude', $agency->latitude) }},
                                {{ old('longitude', $agency->longitude) }}
                            ])
                            .addTo(editMaps[{{ $agency->id }}]);

                        // Événement de clic sur la carte
                        editMaps[{{ $agency->id }}].on('click', function(e) {
                            editMarkers[{{ $agency->id }}].setLatLng(e.latlng);
                            document.getElementById('latitude{{ $agency->id }}').value = e.latlng.lat
                                .toFixed(6);
                            document.getElementById('longitude{{ $agency->id }}').value = e.latlng.lng
                                .toFixed(6);
                        });

                        // Fonction de mise à jour du marqueur pour cette agence
                        function updateMarker{{ $agency->id }}() {
                            var lat = parseFloat(document.getElementById('latitude{{ $agency->id }}').value);
                            var lng = parseFloat(document.getElementById('longitude{{ $agency->id }}').value);
                            if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <=
                                180) {
                                editMarkers[{{ $agency->id }}].setLatLng([lat, lng]);
                                editMaps[{{ $agency->id }}].setView([lat, lng], 13);
                            }
                        }

                        // Écouteurs d'événements pour les champs de coordonnées
                        document.getElementById('latitude{{ $agency->id }}').addEventListener('input',
                            updateMarker{{ $agency->id }});
                        document.getElementById('longitude{{ $agency->id }}').addEventListener('input',
                            updateMarker{{ $agency->id }});
                    }
                @endforeach
            }

            // Événements des modals
            @foreach ($agencies as $agency)
                // Modal de visualisation
                document.getElementById('viewAgencyModal{{ $agency->id }}').addEventListener('shown.bs.modal',
                    function() {
                        setTimeout(function() {
                            if (viewMaps[{{ $agency->id }}]) {
                                viewMaps[{{ $agency->id }}].invalidateSize();
                            }
                        }, 100);
                    });

                // Modal de modification
                document.getElementById('editAgencyModal{{ $agency->id }}').addEventListener('shown.bs.modal',
                    function() {
                        setTimeout(function() {
                            if (editMaps[{{ $agency->id }}]) {
                                editMaps[{{ $agency->id }}].invalidateSize();
                            }
                        }, 100);
                    });
            @endforeach

            // Initialiser les cartes des modals
            initModalMaps();

            // Confirmation avant suppression
            document.querySelectorAll('.remove-item-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (confirm("Êtes-vous sûr de vouloir supprimer cette agence ?")) {
                        this.closest('form').submit();
                    }
                });
            });

            // Ouvre le modal de modification si des erreurs existent
            @if (session('edit_agency_id'))
                const modal = new bootstrap.Modal(document.getElementById(
                    'editAgencyModal{{ session('edit_agency_id') }}'), {
                    backdrop: 'static',
                    keyboard: false
                });
                modal.show();
            @endif

            // Prévisualisation d'image lors de la modification
            document.querySelectorAll('input[type="file"][name="image"]').forEach(input => {
                input.addEventListener('change', function(event) {
                    const file = event.target.files[0];

                    // On cherche l'image la plus proche dans le même modal (conteneur parent)
                    const modal = this.closest('.modal');
                    const previewImg = modal.querySelector('.w-100.h-100.object-fit-cover');

                    if (file && previewImg) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImg.src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });




        });
    </script>
@endsection
