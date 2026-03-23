@extends('layout.main')

@section('css')
<style>
    /* Styles pour les commentaires */
    .support-tag {
        background: var(--bz-color-theme-primary);
        color: white;
        font-size: 0.7rem;
        padding: 2px 6px;
        border-radius: 3px;
        margin-left: 8px;
        font-weight: 500;
    }

    .comment-reply-btn, .comment-delete-btn {
        background: none;
        border: none;
        color: var(--bz-color-theme-primary);
        font-size: 0.9rem;
        cursor: pointer;
        padding: 5px 10px;
        margin-right: 10px;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .comment-reply-btn:hover, .comment-delete-btn:hover {
        background: rgba(236, 40, 28, 0.1);
    }

    .comment-delete-btn {
        color: #dc3545;
    }

    .comment-delete-btn:hover {
        background: rgba(220, 53, 69, 0.1);
    }

    .reply-form-wrapper {
        margin-top: 15px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 3px solid var(--bz-color-theme-primary);
    }

    .reply-form textarea {
        width: 300px !important;
        min-width: 100% !important;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 10px;
        resize: vertical;
        box-sizing: border-box;
    }

    .reply-form-wrapper {
        display: none; /* Comme dans FAQ - masqué par défaut */
        margin-top: 20px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 3px solid var(--bz-color-theme-primary);
        width: 100%;
    }

    /* Avatar avec initiales */
    .comment-thumb {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--bz-color-theme-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
        text-transform: uppercase;
        flex-shrink: 0;
    }

    .comment-thumb img {
        display: none;
    }

    .btn-submit-comment {
        background: var(--bz-color-theme-primary);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-submit-comment:hover {
        background: #c82116;
        transform: translateY(-1px);
    }

    .comment-replies {
        margin-left: 30px;
        margin-top: 15px;
        padding-left: 20px;
        border-left: 2px solid #eee;
        display: block;
    }

    .invalid-feedback {
        display: none;
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
    }

    .is-invalid + .invalid-feedback {
        display: block;
    }
    /* Nouvelle classe spécifique pour les réponses */
    .comment-reply-info {
        width: 100% !important;
        max-width: none !important;
        flex: 1 !important;
        min-width: 0 !important;
    }

    /* S'assurer que les réponses prennent toute la largeur disponible */
    .comment-replies {
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }

    /* Styles spécifiques pour les réponses - VALEURS FIXES EN PX */
    .comment-item.item-2 {
        display: flex !important;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 20px;
        padding: 15px !important;
        padding-left: 15px !important;
        background: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #e9ecef;
        width: 800px !important;
        max-width: 800px !important;
        min-width: 800px !important;
        box-sizing: border-box;
        position: relative !important;
        grid-template-columns: unset !important;
        grid-gap: unset !important;
    }

    .comment-item.item-2:last-child {
        margin-bottom: 0;
    }

    /* Largeur fixe pour le conteneur des réponses */
    .comment-replies {
        width: 800px !important;
        max-width: 800px !important;
        min-width: 800px !important;
        box-sizing: border-box;
        margin-left: 30px;
        padding-left: 20px;
        border-left: 2px solid #eee;
    }

    /* Largeur fixe pour le contenu des réponses */
    .comment-reply-info {
        width: 720px !important;
        max-width: 720px !important;
        min-width: 720px !important;
        flex: 1;
        box-sizing: border-box;
    }

    .comment-reply-info .author {
        margin-bottom: 8px;
        font-size: 1rem;
    }

    .comment-reply-info p {
        margin-bottom: 10px;
        line-height: 1.5;
    }

    .comment-reply-info .comments-meta {
        margin-bottom: 5px;
    }

    .comment-reply-info .comments-meta span {
        font-size: 0.85rem;
        color: #6c757d;
    }

    /* Forcer la largeur complète pour les réponses */
    .comment-replies .comment-item.item-2 {
        margin-left: 0 !important;
        margin-right: 0 !important;
        padding-left: 15px !important;
        padding-right: 15px !important;
        left: 0 !important;
        right: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
        min-width: 100% !important;
        flex: 1 1 100% !important;
        /* Désactiver complètement la grille */
        display: flex !important;
        grid-template-columns: none !important;
        grid-template-rows: none !important;
        grid-area: unset !important;
    }

    /* Responsive mobile - VALEURS FIXES EN PX */
    @media (max-width: 768px) {
        .comment-item.item-2 {
            width: 350px !important;
            max-width: 350px !important;
            min-width: 350px !important;
            padding: 10px !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
        
        .comment-replies {
            width: 350px !important;
            max-width: 350px !important;
            min-width: 350px !important;
            margin-left: 0 !important;
            padding-left: 10px !important;
        }

        .comment-reply-info {
            width: 280px !important;
            max-width: 280px !important;
            min-width: 280px !important;
        }
    }

    /* Responsive tablette - VALEURS FIXES EN PX */
    @media (min-width: 769px) and (max-width: 1024px) {
        .comment-item.item-2 {
            width: 600px !important;
            max-width: 600px !important;
            min-width: 600px !important;
        }
        
        .comment-replies {
            width: 600px !important;
            max-width: 600px !important;
            min-width: 600px !important;
        }

        .comment-reply-info {
            width: 520px !important;
            max-width: 520px !important;
            min-width: 520px !important;
        }
    }

    /* Forcer l'avatar à rester fixe */
    .comment-item.item-2 .comment-thumb {
        width: 50px !important;
        height: 50px !important;
        flex-shrink: 0 !important;
        flex-grow: 0 !important;
        flex-basis: 50px !important;
        min-width: 50px !important;
        max-width: 50px !important;
    }

    /* Forcer le contenu à prendre toute la largeur */
    .comment-reply-info {
        flex: 1 !important;
        min-width: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
        flex-grow: 1 !important;
        flex-shrink: 1 !important;
        flex-basis: auto !important;
    }

    /* S'assurer que le formulaire s'affiche correctement */
    .comment-item .reply-form-wrapper {
        margin-top: 20px;
        margin-bottom: 20px;
    }
    

</style>
@endsection

@section('content')

<body>
    @include('includes.main.loading')
    @include('includes.main.header')

    <section class="page-header-pro">
        <div class="page-header-overlay"></div>
        <div class="container">
            <div class="page-header-content-pro" data-aos="fade-up">
                <h1 class="title-pro">Blog</h1>

                {{-- Utilisation d'une structure sémantique pour le fil d'Ariane --}}
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb-pro">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Accueil</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Blog</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <!-- ./ page-header -->

    <section class="blog-details pt-130 pb-130">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-8 col-md-12">
                    <div class="blog-details-wrap">
                        <div class="blog-details-img mb-40">
                            <img src="{{ \App\Helpers\FileHelper::getStorageImageUrl($blog->image, 'assets/images/blog.jpg') }}" alt="{{ $blog->title }}">
                        </div>
                        <ul class="post-meta">
                            <li><i class="fa-regular fa-calendar"></i>{{ $blog->created_at->translatedFormat('d M Y à H:i') }}</li>
                            <li><i class="fa-regular fa-user"></i>{{ $blog->author ?? 'Admin' }}</li>
                        </ul>
                        <div class="blog-details-content">
                            <h2 class="details-title mb-25">{{ $blog->title }}</h2>
                            <p>
                                {{ $blog->short_description }}
                            </p>

                            {!! $blog->long_description !!}
                        </div>

                        <div class="comments-area">
                            <div class="section-heading">
                                <h2 class="section-title">{{ $comments->count() }} Commentaire(s)</h2>
                            </div>
                            @forelse ($comments as $comment)
                            <div class="comment-item" id="comment-{{ $comment->id }}">
                                <div class="comment-thumb">
                                    {{ strtoupper(substr($comment->name, 0, 2)) }}
                                </div>
                                <div class="comment-info">
                                    <div class="comments-meta">
                                        <span>{{ $comment->created_at->translatedFormat('d M Y à H:i') }}</span>
                                    </div>
                                    <h3 class="author">{{ $comment->name }} 
                                        @if ($comment->user && $comment->user->is_admin)
                                            <span class="support-tag">Officiel</span>
                                        @endif
                                    </h3>
                                    <p>{{ $comment->body }}</p>
                                    @auth
                                    <button class="reply comment-reply-btn" data-comment-id="{{ $comment->id }}">
                                        <i class="fa-solid fa-reply"></i> Répondre
                                    </button>
                                    @if (Auth::user()->is_admin || Auth::id() == $comment->user_id)
                                    <button class="comment-delete-btn" data-comment-id="{{ $comment->id }}" 
                                            data-delete-url="{{ route('blog.comments.destroy', $comment) }}" 
                                            data-csrf="{{ csrf_token() }}">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                    @endif
                                    @else
                                    <p class="text-muted small">Connectez-vous pour répondre</p>
                                    @endauth
                                </div>
                                
                                <!-- Formulaire de réponse -->
                                <div class="reply-form-wrapper" id="reply-form-{{ $comment->id }}" style="display: none;">
                                    <form class="reply-form" action="{{ route('blog.comments.store') }}" method="POST" novalidate>
                                        @csrf
                                        <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                        <input type="hidden" name="name" value="{{ auth()->user()->name ?? '' }}">
                                        <input type="hidden" name="email" value="{{ auth()->user()->email ?? '' }}">
                                        <div class="form-group">
                                            <textarea name="body" class="form-control" rows="3" 
                                                      placeholder="Écrivez votre réponse à {{ $comment->name }}..." required></textarea>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <br>
                                        <button type="submit" class="btn-submit-comment">
                                            <span>Répondre</span>
                                        </button>
                                    </form>
                                </div>

                                <!-- Réponses -->
                                @if ($comment->replies->isNotEmpty())
                                <div class="comment-replies">
                                    @foreach ($comment->replies as $reply)
                                    <div class="comment-item item-2" id="comment-{{ $reply->id }}">
                                        <div class="comment-thumb">
                                            {{ strtoupper(substr($reply->name, 0, 2)) }}
                                        </div>
                                        <div class="comment-reply-info">
                                            <div class="comments-meta">
                                                <span>{{ $reply->created_at->translatedFormat('d M Y à H:i') }}</span>
                                            </div>
                                            <h3 class="author">{{ $reply->name }}
                                                @if ($reply->user && $reply->user->is_admin)
                                                    <span class="support-tag">Officiel</span>
                                                @endif
                                            </h3>
                                            <p>{{ $reply->body }}</p>
                                            @auth
                                            @if (Auth::user()->is_admin || Auth::id() == $reply->user_id)
                                            <button class="comment-delete-btn" data-comment-id="{{ $reply->id }}" 
                                                    data-delete-url="{{ route('blog.comments.destroy', $reply) }}" 
                                                    data-csrf="{{ csrf_token() }}">
                                                <i class="fas fa-trash"></i> Supprimer
                                            </button>
                                            @endif
                                            @else
                                            <p class="text-muted small">Connectez-vous pour répondre</p>
                                            @endauth
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            @empty
                            <p class="text-center text-muted">Soyez la première personne à laisser un commentaire !</p>
                            @endforelse
                        </div>
                        <!-- ./ comments-area -->
                        <div class="form-wrap pt-70">
                            <div class="blog-contact-form">
                                <h2 class="title">Laisser un commentaire</h2>
                                <div class="request-form">
                                    <form id="main-comment-form" action="{{ route('blog.comments.store') }}" method="POST" novalidate>
                                        @csrf
                                        <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <div class="form-item">
                                                    <input type="text" id="comment-name" name="name" class="form-control" 
                                                           placeholder="Votre Nom" required 
                                                           value="{{ auth()->user()->name ?? '' }}">
                                                    <div class="icon"><i class="fa-regular fa-user"></i></div>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-item">
                                                    <input type="email" id="comment-email" name="email" class="form-control" 
                                                           placeholder="Votre Email" required 
                                                           value="{{ auth()->user()->email ?? '' }}">
                                                    <div class="icon"><i class="fa-sharp fa-regular fa-envelope"></i></div>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <div class="form-item message-item">
                                                    <textarea id="comment-message" name="body" cols="30" rows="5" 
                                                              class="form-control" placeholder="Votre commentaire..." required></textarea>
                                                    <div class="icon"><i class="fa-light fa-messages"></i></div>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="submit-btn">
                                            <button type="submit" class="btn-submit-comment">
                                                <i class="fas fa-paper-plane"></i>
                                                <span>Soumettre</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- ./ form-wrap -->
                    </div>
                </div>
                <!-- Sidebar Widgets -->
                <div class="col-lg-4">
                    <div class="sidebar-widget">
                        <h3 class="widget-title">Recent Posts</h3>
                        @foreach ($blogs as $blog)
                        @if (!$blog)
                        <p>Aucun autre poste</p>
                        @endif
                        <div class="sidebar-post">
                            <img src="{{ \App\Helpers\FileHelper::getStorageImageUrl($blog->image, 'assets/images/blog.jpg') }}" alt="{{ $blog->title }}">
                            <div class="post-content">
                                <ul class="post-meta">
                                    <li><i class="fa-light fa-circle-user"></i>{{ $blog->author ?? 'Admin' }}</li>
                                </ul>
                                <h3 class="title"><a href="#">{{ $blog->title }}</a></h3>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ./ Blog Details -->
    @include('includes.main.scroll')
    @include('includes.main.footer')
</body>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // GESTION DES BOUTONS RÉPONDRE
        $(document).on('click', '.comment-reply-btn', function() {
            const commentId = $(this).data('comment-id');
            const replyForm = $(`#reply-form-${commentId}`);
            
            // Masquer tous les autres formulaires de réponse
            $('.reply-form-wrapper').not(replyForm).hide();
            
            // Afficher/masquer le formulaire de réponse
            replyForm.toggle();
        });

        // SOUMISSION DU FORMULAIRE PRINCIPAL VIA AJAX
        $("#main-comment-form").on("submit", function(e) {
            e.preventDefault();

            const $form = $(this);
            const $submitBtn = $form.find('.btn-submit-comment');
            const $btnText = $submitBtn.find('span');
            const $btnIcon = $submitBtn.find('i');

            // Réinitialiser les erreurs
            $form.find(".form-control").removeClass("is-invalid");
            $form.find(".invalid-feedback").text("");

            // État de chargement
            $submitBtn.prop("disabled", true);
            $btnText.text("Envoi en cours...");
            $btnIcon.removeClass('fa-paper-plane').addClass('fa-spinner fa-spin');

            $.ajax({
                url: $form.attr("action"),
                method: "POST",
                data: $form.serialize(),
                headers: {
                    "X-CSRF-TOKEN": $form.find('input[name="_token"]').val()
                },
                success: function(data) {
                    Swal.fire({
                        icon: "success",
                        title: "Commentaire envoyé ! 🎉",
                        text: data.message,
                        confirmButtonColor: "var(--bz-color-theme-primary)",
                    });
                    
                    // Recharger la page pour afficher le nouveau commentaire
                    location.reload();
                },
                error: function(jqXHR) {
                    if (jqXHR.status === 422) {
                        const errors = jqXHR.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            const field = $form.find(`[name="${key}"]`);
                            field.addClass("is-invalid");
                            field.siblings(".invalid-feedback").text(value[0]);
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: 'Une erreur est survenue. Veuillez réessayer.',
                            confirmButtonColor: "var(--bz-color-theme-primary)",
                        });
                    }
                },
                complete: function() {
                    // Restaurer l'état normal du bouton
                    $submitBtn.prop("disabled", false);
                    $btnText.text("Soumettre");
                    $btnIcon.removeClass('fa-spinner fa-spin').addClass('fa-paper-plane');
                }
            });
        });

        // SOUMISSION DES FORMULAIRES DE RÉPONSE VIA AJAX
        $(document).on("submit", ".reply-form", function(e) {
            e.preventDefault();

            const $form = $(this);
            const $submitBtn = $form.find('.btn-submit-comment');
            const $btnText = $submitBtn.find('span');

            // Réinitialiser les erreurs
            $form.find(".form-control").removeClass("is-invalid");
            $form.find(".invalid-feedback").text("");

            // État de chargement
            $submitBtn.prop("disabled", true);
            $btnText.text("Envoi...");

            $.ajax({
                url: $form.attr("action"),
                method: "POST",
                data: $form.serialize(),
                headers: {
                    "X-CSRF-TOKEN": $form.find('input[name="_token"]').val()
                },
                success: function(data) {
                    Swal.fire({
                        icon: "success",
                        title: "Réponse envoyée ! 🎉",
                        text: data.message,
                        confirmButtonColor: "var(--bz-color-theme-primary)",
                    });
                    
                    // Recharger la page pour afficher la nouvelle réponse
                    location.reload();
                },
                error: function(jqXHR) {
                    if (jqXHR.status === 422) {
                        const errors = jqXHR.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            const field = $form.find(`[name="${key}"]`);
                            field.addClass("is-invalid");
                            field.siblings(".invalid-feedback").text(value[0]);
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: 'Une erreur est survenue. Veuillez réessayer.',
                            confirmButtonColor: "var(--bz-color-theme-primary)",
                        });
                    }
                },
                complete: function() {
                    // Restaurer l'état normal du bouton
                    $submitBtn.prop("disabled", false);
                    $btnText.text("Répondre");
                }
            });
        });

        // SUPPRESSION DES COMMENTAIRES
        $(document).on("click", ".comment-delete-btn", function() {
            const commentId = $(this).data('comment-id');
            const deleteUrl = $(this).data('delete-url');
            const csrfToken = $(this).data('csrf');

            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Cette action est irréversible !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: deleteUrl,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function(data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Supprimé !',
                                text: data.message,
                                confirmButtonColor: "var(--bz-color-theme-primary)",
                            });
                            
                            // Supprimer l'élément du DOM
                            $(`#comment-${commentId}`).fadeOut(300, function() {
                                $(this).remove();
                                
                                // Mettre à jour le compteur de commentaires
                                const commentCount = $('.comment-item').length;
                                $('.section-title').text(commentCount + ' Commentaire(s)');
                            });
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: 'Impossible de supprimer le commentaire.',
                                confirmButtonColor: "var(--bz-color-theme-primary)",
                            });
                        }
                    });
                }
            });
        });
    });
</script>
@endsection