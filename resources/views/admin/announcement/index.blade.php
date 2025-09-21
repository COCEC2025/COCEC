@extends('layout.admin')

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
            <h6 class="fw-semibold mb-0">Liste des annonces</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Annonces</li>
            </ul>
        </div>

        <!-- Barre de contrôles -->
        <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between mb-24">
            <form action="{{ route('announcement.index') }}" method="GET" class="d-flex align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <span class="text-md fw-medium text-secondary-light mb-0">Afficher</span>
                    <select name="per_page" class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px" onchange="this.form.submit()">
                        <option value="8" {{ request('per_page', 8) == 8 ? 'selected' : '' }}>8</option>
                        <option value="12" {{ request('per_page') == 12 ? 'selected' : '' }}>12</option>
                        <option value="16" {{ request('per_page') == 16 ? 'selected' : '' }}>16</option>
                        <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>24</option>
                    </select>
                </div>
                <div class="navbar-search">
                    <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="Rechercher..." value="{{ request('search') }}">
                    <button type="submit" style="border:none; background:transparent; cursor:pointer;">
                        <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                    </button>
                </div>
            </form>
            <a href="{{ route('announcement.create') }}" class="btn btn-danger text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
                <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                Ajouter une annonce
            </a>
        </div>

        <!-- Affichage en grille de cartes -->
        <div class="row gy-4">
            @forelse ($announcements as $announcement)
            <div class="col-xxl-3 col-lg-4 col-sm-6">
                <div class="card h-100 p-0 radius-12 overflow-hidden">
                    <div class="card-body p-24">
                        <!-- Image de l'annonce -->
                        <div class="w-100 max-h-194-px radius-8 overflow-hidden mb-20">
                            @if ($announcement->image)
                            <img src="{{ \App\Helpers\FileHelper::getStorageImageUrl($announcement->image, 'assets/images/announcements.jpg') }}" alt="{{ $announcement->title }}" class="w-100 h-100 object-fit-cover">
                            @else
                            <div class="w-100 h-194-px bg-neutral-100 d-flex align-items-center justify-content-center radius-8">
                                <iconify-icon icon="solar:image-outline" class="text-neutral-400" style="font-size: 48px;"></iconify-icon>
                            </div>
                            @endif
                        </div>

                        <div class="mt-20">
                            <!-- Statut et Date -->
                            <div class="d-flex align-items-center gap-6 justify-content-between flex-wrap mb-16">
                                @if ($announcement->status === 'publier')
                                <span class="px-20 py-6 rounded-pill fw-medium text-white bg-success">Publiée</span>
                                @elseif ($announcement->status === 'non publier')
                                <span class="px-20 py-6 rounded-pill fw-medium text-white bg-secondary">Non publiée</span>
                                @elseif ($announcement->status === 'expirer')
                                <span class="px-20 py-6 rounded-pill fw-medium text-white bg-danger">Expirée</span>
                                @endif
                                <div class="d-flex align-items-center gap-8 text-neutral-500 fw-medium">
                                    <iconify-icon icon="solar:calendar-outline" class="icon"></iconify-icon>
                                    {{ $announcement->created_at->format('M d, Y') }}
                                </div>
                            </div>

                            <!-- Titre -->
                            <h6 class="mb-16">
                                <span class="text-line-2 text-xl">{{ $announcement->title }}</span>
                            </h6>

                            <!-- Description -->
                            <p class="text-line-3 text-neutral-500 mb-16">
                                {{ $announcement->description ?? 'Aucune description disponible...' }}
                            </p>

                            <!-- Boutons d'action -->
                            <div class="d-flex gap-2 mt-16">
                                <!-- Bouton VOIR -->
                                <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewAnnouncementModal{{ $announcement->id }}">
                                    <iconify-icon icon="lucide:eye" class="icon"></iconify-icon>
                                    Voir
                                </button>

                                <!-- Bouton ÉDITER -->
                                <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#editAnnouncementModal{{ $announcement->id }}">
                                    <iconify-icon icon="lucide:edit" class="icon"></iconify-icon>
                                    Éditer
                                </button>

                                <!-- Bouton SUPPRIMER -->
                                <form method="POST" action="{{ route('announcement.destroy', $announcement->id) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm remove-item-btn">
                                        <iconify-icon icon="fluent:delete-24-regular" class="icon"></iconify-icon>
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal de visualisation -->
            <div class="modal fade" id="viewAnnouncementModal{{ $announcement->id }}" tabindex="-1" aria-labelledby="viewAnnouncementModalLabel{{ $announcement->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewAnnouncementModalLabel{{ $announcement->id }}">Détails de l'annonce : {{ $announcement->title }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Titre :</strong> {{ $announcement->title }}</p>
                                    <p><strong>Description :</strong></p>
                                    <p class="text-muted">{{ $announcement->description ?? 'Non définie' }}</p>
                                    <p><strong>Statut :</strong>
                                        @if ($announcement->status === 'publier')
                                        <span class="badge bg-success">Publiée</span>
                                        @elseif ($announcement->status === 'non publier')
                                        <span class="badge bg-secondary">Non publiée</span>
                                        @elseif ($announcement->status === 'expirer')
                                        <span class="badge bg-danger">Expirée</span>
                                        @endif
                                    </p>
                                    <p><strong>Date de création :</strong> {{ $announcement->created_at->format('d M Y à H:i') }}</p>
                                </div>
                                <div class="col-md-6">
                                    @if ($announcement->image)
                                    <p><strong>Image :</strong></p>
                                    <img src="{{ \App\Helpers\FileHelper::getStorageImageUrl($announcement->image) }}" alt="{{ $announcement->title }}" class="img-fluid radius-8" style="max-width: 100%; max-height: 300px;">
                                    @else
                                    <div class="text-center py-5">
                                        <iconify-icon icon="solar:image-outline" class="text-neutral-300" style="font-size: 80px;"></iconify-icon>
                                        <p class="text-muted mt-2">Aucune image</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal de modification -->
            <div class="modal fade" id="editAnnouncementModal{{ $announcement->id }}" tabindex="-1" aria-labelledby="editAnnouncementModalLabel{{ $announcement->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <form method="POST" action="{{ route('announcement.update', $announcement->id) }}" enctype="multipart/form-data" class="modal-content">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editAnnouncementModalLabel{{ $announcement->id }}">Modifier l'annonce : {{ $announcement->title }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title{{ $announcement->id }}" class="form-label">Titre</label>
                                        <input type="text" name="title" id="title{{ $announcement->id }}" class="form-control @error('title', 'update-'.$announcement->id) is-invalid @enderror" value="{{ old('title', $announcement->title) }}" required>
                                        @error('title', 'update-'.$announcement->id)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="status{{ $announcement->id }}" class="form-label">Statut</label>
                                        <select name="status" id="status{{ $announcement->id }}" class="form-select @error('status', 'update-'.$announcement->id) is-invalid @enderror" required>
                                            <option value="publier" {{ old('status', $announcement->status) == 'publier' ? 'selected' : '' }}>Publiée</option>
                                            <option value="non publier" {{ old('status', $announcement->status) == 'non publier' ? 'selected' : '' }}>Non publiée</option>
                                            <option value="expirer" {{ old('status', $announcement->status) == 'expirer' ? 'selected' : '' }}>Expirée</option>
                                        </select>
                                        <div class="form-text text-warning">
                                            <i class="fas fa-info-circle me-1"></i>
                                            <strong>Note :</strong> Seule une annonce peut être publiée à la fois. Publier cette annonce dépublichera automatiquement toutes les autres.
                                        </div>
                                        @error('status', 'update-'.$announcement->id)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="description{{ $announcement->id }}" class="form-label">Description</label>
                                        <textarea name="description" id="description{{ $announcement->id }}" class="form-control @error('description', 'update-'.$announcement->id) is-invalid @enderror" rows="4">{{ old('description', $announcement->description) }}</textarea>
                                        @error('description', 'update-'.$announcement->id)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="image{{ $announcement->id }}" class="form-label">Changer l'image (laisser vide pour conserver l'actuelle)</label>
                                        <input type="file" name="image" id="image{{ $announcement->id }}" class="form-control @error('image', 'update-'.$announcement->id) is-invalid @enderror" accept="image/*">
                                        @error('image', 'update-'.$announcement->id)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="text-center">
                                        <p class="small text-muted mb-1">Image actuelle :</p>
                                        @if ($announcement->image)
                                        <img src="{{ \App\Helpers\FileHelper::getStorageImageUrl($announcement->image) }}" alt="{{ $announcement->title }}" class="img-fluid radius-8" style="max-width: 100%; max-height: 200px;">
                                        @else
                                        <div class="bg-neutral-100 d-flex align-items-center justify-content-center radius-8" style="height: 150px;">
                                            <iconify-icon icon="solar:image-outline" class="text-neutral-400" style="font-size: 48px;"></iconify-icon>
                                        </div>
                                        @endif
                                    </div>
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
            @empty
            <div class="col-12">
                <div class="card text-center p-5">
                    <div class="announcement-card justify-center">
                        <iconify-icon icon="solar:document-outline" class="text-neutral-300 mb-3" style="font-size: 80px;"></iconify-icon>
                        <h5 class="text-neutral-500">Aucune annonce trouvée</h5>
                        <p class="text-neutral-400">Commencez par créer votre première annonce.</p>
                        <a href="{{ route('announcement.create') }}" class="btn btn-danger">
                            Créer une annonce
                        </a>
                    </div>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($announcements->hasPages())
        <div class="mt-4 d-flex justify-content-center">
            {{ $announcements->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

    @include('includes.admin.footer')
</main>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Confirmation avant suppression
        document.querySelectorAll('.remove-item-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm("Êtes-vous sûr de vouloir supprimer cette annonce ?")) {
                    this.closest('form').submit();
                }
            });
        });

        // Prévisualisation d'image lors de la modification
        document.querySelectorAll('input[type="file"][name="image"]').forEach(input => {
            input.addEventListener('change', function(event) {
                const file = event.target.files[0];
                const modalId = this.getAttribute('id').replace('image', '');
                const previewImg = document.querySelector(`#editAnnouncementModal${modalId} img`);

                if (file && previewImg) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        });

        // Ouvre le modal de modification si des erreurs existent
        @if(session('edit_announcement_id'))
        const modal = new bootstrap.Modal(document.getElementById('editAnnouncementModal{{ session('
            edit_announcement_id ') }}'), {
            backdrop: 'static',
            keyboard: false
        });
        modal.show();
        @endif
    });
</script>
@endsection