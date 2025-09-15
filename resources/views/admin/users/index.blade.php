@extends('layout.admin')

@section('title', 'Gestion des Utilisateurs')

@php
use Illuminate\Support\Str;
@endphp

@section('content')
@include('includes.admin.sidebar')
<main class="dashboard-main">
    @include('includes.admin.appbar')
    @include('includes.main.loading')

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Gestion des Utilisateurs</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Gestion des Utilisateurs</li>
            </ul>
        </div>

        <div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Gestion des Utilisateurs</h4>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-danger">
                         Créer un Compte
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                    <th>Statut</th>
                                    <th>Téléphone</th>
                                    <th>Date de création</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge bg-{{ $user->role->value === 'super_admin' ? 'danger1' : ($user->role->value === 'dg' ? 'warning1' : ($user->role->value === 'informaticien' ? 'primary' : 'success')) }}">
                                                {{ $user->role->getLabel() }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($user->isSuspended())
                                                <div class="d-flex flex-column align-items-start">
                                                    <span class="badge bg-danger mb-1">
                                                        <i class="fas fa-ban me-1"></i>
                                                        Suspendu
                                                    </span>
                                                    @if($user->suspended_at)
                                                        <small class="text-muted">
                                                            <i class="fas fa-clock me-1"></i>
                                                            {{ $user->suspended_at->format('d/m/Y H:i') }}
                                                        </small>
                                                    @endif
                                                    @if($user->suspension_reason)
                                                        <small class="text-danger mt-1" title="{{ $user->suspension_reason }}">
                                                            <i class="fas fa-info-circle me-1"></i>
                                                            {{ Str::limit($user->suspension_reason, 30) }}
                                                        </small>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i>
                                                    Actif
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $user->phone_num ?? 'N/A' }}</td>
                                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-10 justify-content-center">
                                                <!-- Bouton VOIR -->
                                                <a href="{{ route('admin.users.show', $user) }}" 
                                                   class="bg-info-focus text-info-600 bg-hover-info-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"
                                                   title="Voir">
                                                    <iconify-icon icon="lucide:eye" class="menu-icon"></iconify-icon>
                                                </a>

                                                <!-- Bouton MODIFIER -->
                                                <a href="{{ route('admin.users.edit', $user) }}" 
                                                   class="bg-warning-focus text-warning-600 bg-hover-warning-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"
                                                   title="Modifier">
                                                    <iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                                </a>

                                                <!-- Bouton SUSPENDRE/RÉACTIVER -->
                                                @if($user->id !== auth()->id())
                                                    @if($user->isSuspended())
                                                        <button type="button" 
                                                                class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#reactivateModal{{ $user->id }}"
                                                                title="Réactiver le compte">
                                                            <span class="text-success fw-bold">✓</span>
                                                        </button>
                                                    @else
                                                        <button type="button" 
                                                                class="bg-warning-focus text-warning-600 bg-hover-warning-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#suspendModal{{ $user->id }}"
                                                                title="Suspendre le compte">
                                                            <span class="text-warning fw-bold">⛔</span>
                                                        </button>
                                                    @endif
                                                @endif

                                                <!-- Bouton SUPPRIMER -->
                                                @if($user->id !== auth()->id())
                                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="remove-item-btn bg-danger-focus text-danger-600 bg-hover-danger-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle"
                                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')"
                                                                title="Supprimer">
                                                            <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Aucun utilisateur trouvé</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Modals de suspension -->
                    @foreach($users as $user)
                        @if(!$user->isSuspended() && $user->id !== auth()->id())
                        <!-- Modal de suspension pour {{ $user->name }} -->
                        <div class="modal fade" id="suspendModal{{ $user->id }}" tabindex="-1" aria-labelledby="suspendModalLabel{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="suspendModalLabel{{ $user->id }}">
                                            <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                            Suspendre le compte
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                    </div>
                                    <form action="{{ route('admin.users.suspend', $user) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="alert alert-warning">
                                                <i class="fas fa-info-circle me-2"></i>
                                                <strong>Attention :</strong> Vous êtes sur le point de suspendre le compte de <strong>{{ $user->name }}</strong> ({{ $user->email }}).
                                            </div>
                                            <p class="mb-3">L'utilisateur ne pourra plus se connecter à son compte jusqu'à ce qu'il soit réactivé.</p>
                                            
                                            <div class="mb-3">
                                                <label for="suspension_reason{{ $user->id }}" class="form-label">
                                                    Raison de la suspension <span class="text-muted">(optionnel)</span>
                                                </label>
                                                <textarea 
                                                    name="suspension_reason" 
                                                    id="suspension_reason{{ $user->id }}" 
                                                    class="form-control @error('suspension_reason') is-invalid @enderror" 
                                                    rows="4" 
                                                    placeholder="Ex: Congé de maladie, Suspension temporaire, etc. (optionnel)"
                                                >{{ old('suspension_reason') }}</textarea>
                                                @error('suspension_reason')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="form-text">Cette raison sera visible par l'utilisateur lors de sa prochaine tentative de connexion.</div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="fas fa-times me-1"></i>
                                                Annuler
                                            </button>
                                            <button type="submit" class="btn btn-warning">
                                                <i class="fas fa-ban me-1"></i>
                                                Suspendre le compte
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach

                    <!-- Modals de réactivation -->
                    @foreach($users as $user)
                        @if($user->isSuspended() && $user->id !== auth()->id())
                        <!-- Modal de réactivation pour {{ $user->name }} -->
                        <div class="modal fade" id="reactivateModal{{ $user->id }}" tabindex="-1" aria-labelledby="reactivateModalLabel{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title" id="reactivateModalLabel{{ $user->id }}">
                                            <span class="me-2">✓</span>
                                            Réactiver le compte
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                    </div>
                                    <form action="{{ route('admin.users.unsuspend', $user) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="alert alert-success">
                                                <i class="fas fa-check-circle me-2"></i>
                                                <strong>Confirmation :</strong> Vous êtes sur le point de réactiver le compte de <strong>{{ $user->name }}</strong> ({{ $user->email }}).
                                            </div>
                                            
                                            @if($user->suspension_reason)
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Raison de la suspension précédente :</label>
                                                <div class="p-3 bg-light rounded border">
                                                    <i class="fas fa-info-circle text-info me-2"></i>
                                                    {{ $user->suspension_reason }}
                                                </div>
                                                <small class="text-muted">Suspendu le {{ $user->suspended_at->format('d/m/Y à H:i') }}</small>
                                            </div>
                                            @endif
                                            
                                            <p class="mb-0">
                                                <i class="fas fa-arrow-right text-success me-2"></i>
                                                L'utilisateur pourra à nouveau se connecter à son compte immédiatement après la réactivation.
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="fas fa-times me-1"></i>
                                                Annuler
                                            </button>
                                            <button type="submit" class="btn btn-success">
                                                <span class="me-1">✓</span>
                                                Réactiver le compte
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach

                    @if($users->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
        </div>
    </main>
</div>
@endsection 

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Confirmation avant suppression
            document.querySelectorAll('.remove-item-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?")) {
                        this.closest('form').submit();
                    }
                });
            });
        });
    </script>
@endsection 