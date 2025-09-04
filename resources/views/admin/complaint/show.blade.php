@extends('layout.admin')

@section('title', 'Détails de la Plainte - Admin')

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
            <h6 class="fw-semibold mb-0">Détails de la Plainte</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">
                    <a href="{{ route('admin.complaint.index') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="mdi:message-text-outline" class="icon text-lg"></iconify-icon>
                        Gestion des Plaintes
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Détails</li>
            </ul>
        </div>

        <!-- Informations de la Plainte -->
        <div class="row mb-24">
            <div class="col-12">
                <div class="card shadow-none border">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Informations de la Plainte</h5>
                        <div class="d-flex gap-2">
                            <span class="badge bg-{{ $complaint->status === 'pending' ? 'warning' : ($complaint->status === 'processing' ? 'info' : ($complaint->status === 'resolved' ? 'success' : 'secondary')) }} fs-6">
                                {{ ucfirst($complaint->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-20">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-medium text-muted">Référence</label>
                                    <div class="form-control-plaintext">{{ $complaint->reference }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-medium text-muted">Date de création</label>
                                    <div class="form-control-plaintext">{{ $complaint->created_at->format('d/m/Y H:i') }}</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-medium text-muted">Catégorie</label>
                                    <div class="form-control-plaintext">
                                        <span class="badge bg-{{ $complaint->category === 'service' ? 'primary' : ($complaint->category === 'credit' ? 'warning' : ($complaint->category === 'epargne' ? 'info' : ($complaint->category === 'technique' ? 'danger' : 'secondary'))) }}">
                                            {{ ucfirst($complaint->category) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-medium text-muted">Statut actuel</label>
                                    <div class="form-control-plaintext">
                                        <span class="badge bg-{{ $complaint->status === 'pending' ? 'warning' : ($complaint->status === 'processing' ? 'info' : ($complaint->status === 'resolved' ? 'success' : 'secondary')) }}">
                                            {{ ucfirst($complaint->status) }}
                                        </span>
                                    </div>
                                </div>
                                @if($complaint->resolved_at)
                                <div class="mb-3">
                                    <label class="form-label fw-medium text-muted">Date de résolution</label>
                                    <div class="form-control-plaintext">{{ $complaint->resolved_at->format('d/m/Y H:i') }}</div>
                                </div>
                                @endif
                                <div class="mb-3">
                                    <label class="form-label fw-medium text-muted">Dernière mise à jour</label>
                                    <div class="form-control-plaintext">{{ $complaint->updated_at->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations du Membre -->
        <div class="row mb-24">
            <div class="col-12">
                <div class="card shadow-none border">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informations du Membre</h5>
                    </div>
                    <div class="card-body p-20">
                        <div class="row">
                            <div class="col-md-6">
                                @if($complaint->member_name)
                                <div class="mb-3">
                                    <label class="form-label fw-medium text-muted">Nom complet</label>
                                    <div class="form-control-plaintext">{{ $complaint->member_name }}</div>
                                </div>
                                @endif
                                @if($complaint->member_number)
                                <div class="mb-3">
                                    <label class="form-label fw-medium text-muted">Numéro d'adhérent</label>
                                    <div class="form-control-plaintext">{{ $complaint->member_number }}</div>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                @if($complaint->member_phone)
                                <div class="mb-3">
                                    <label class="form-label fw-medium text-muted">Téléphone</label>
                                    <div class="form-control-plaintext">{{ $complaint->member_phone }}</div>
                                </div>
                                @endif
                                @if($complaint->member_email)
                                <div class="mb-3">
                                    <label class="form-label fw-medium text-muted">Email</label>
                                    <div class="form-control-plaintext">{{ $complaint->member_email }}</div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Détails de la Plainte -->
        <div class="row mb-24">
            <div class="col-12">
                <div class="card shadow-none border">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Détails de la Plainte</h5>
                    </div>
                    <div class="card-body p-20">
                        <div class="mb-3">
                            <label class="form-label fw-medium text-muted">Objet</label>
                            <div class="form-control-plaintext">{{ $complaint->subject }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-medium text-muted">Description détaillée</label>
                            <div class="form-control-plaintext" style="white-space: pre-wrap;">{{ $complaint->description }}</div>
                        </div>
                        
                        @if($complaint->attachments && !empty($complaint->attachments))
                        <div class="mb-3">
                            <label class="form-label fw-medium text-muted">Pièces jointes</label>
                            <div class="d-flex flex-wrap gap-2">
                                @php
                                    // Les attachments sont stockés comme chaînes séparées par des virgules
                                    $attachments = explode(',', $complaint->attachments);
                                    $attachments = array_map('trim', $attachments); // Enlever les espaces
                                @endphp
                                @if($attachments && is_array($attachments))
                                    @foreach($attachments as $attachment)
                                        @if(!empty($attachment))
                                        <div class="border rounded p-2">
                                            @php
                                                $filePath = storage_path('app/public/' . $attachment);
                                                $fileExists = file_exists($filePath);
                                            @endphp
                                            @if($fileExists)
                                                <a href="{{ asset('storage/' . $attachment) }}" target="_blank" class="text-decoration-none">
                                                    <iconify-icon icon="ph:file-text" class="me-1"></iconify-icon>
                                                    {{ basename($attachment) }}
                                                </a>
                                            @else
                                                <div class="text-danger">
                                                    <iconify-icon icon="ph:warning" class="me-1"></iconify-icon>
                                                    {{ basename($attachment) }} (fichier non trouvé)
                                                </div>
                                            @endif
                                        </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="text-muted">Aucune pièce jointe valide</div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Mise à jour du Statut -->
        <div class="row mb-24">
            <div class="col-12">
                <div class="card shadow-none border">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Mise à jour du Statut</h5>
                    </div>
                    <div class="card-body p-20">
                        <form id="statusUpdateForm" action="{{ route('admin.complaint.updateStatus', $complaint->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Nouveau statut *</label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="pending" {{ $complaint->status === 'pending' ? 'selected' : '' }}>En attente</option>
                                            <option value="processing" {{ $complaint->status === 'processing' ? 'selected' : '' }}>En traitement</option>
                                            <option value="resolved" {{ $complaint->status === 'resolved' ? 'selected' : '' }}>Résolue</option>
                                            <option value="closed" {{ $complaint->status === 'closed' ? 'selected' : '' }}>Fermée</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="admin_notes" class="form-label">Notes administratives</label>
                                        <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3" placeholder="Ajoutez des notes sur le traitement de cette plainte...">{{ $complaint->admin_notes }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn" style="background-color: #EC281C; border-color: #EC281C; color: white;">
                                    Mettre à jour le statut
                                </button>
                                <a href="{{ route('admin.complaint.index') }}" class="btn btn-outline-secondary">
                                    Retour à la liste
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historique des Notes -->
        @if($complaint->admin_notes)
        <div class="row mb-24">
            <div class="col-12">
                <div class="card shadow-none border">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Notes Administratives</h5>
                    </div>
                    <div class="card-body p-20">
                        <div class="bg-light p-3 rounded">
                            <div style="white-space: pre-wrap;">{{ $complaint->admin_notes }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Informations Techniques -->
        <div class="row mb-24">
            <div class="col-12">
                <div class="card shadow-none border">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informations Techniques</h5>
                    </div>
                    <div class="card-body p-20">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-medium text-muted">Adresse IP</label>
                                    <div class="form-control-plaintext">{{ $complaint->ip_address ?? 'Non disponible' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-medium text-muted">User Agent</label>
                                    <div class="form-control-plaintext text-truncate" title="{{ $complaint->user_agent ?? 'Non disponible' }}">
                                        {{ $complaint->user_agent ?? 'Non disponible' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.admin.footer')
</main>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestionnaire de soumission du formulaire de mise à jour
    document.getElementById('statusUpdateForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        // Désactiver le bouton et afficher le loader
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Mise à jour...';
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Afficher le message de succès
                alert('✅ ' + (data.message || 'Le statut de la plainte a été mis à jour avec succès.'));
                // Recharger la page pour afficher les nouvelles informations
                window.location.reload();
            } else {
                throw new Error(data.message || 'Une erreur est survenue');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            
            // Afficher le message d'erreur
            alert('❌ ' + (error.message || 'Une erreur est survenue lors de la mise à jour du statut.'));
        })
        .finally(() => {
            // Réactiver le bouton
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
});
</script>
@endsection
