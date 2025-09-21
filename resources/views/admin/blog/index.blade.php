@extends('layout.admin')

@section('content')
@include('includes.admin.sidebar')
<main class="dashboard-main">
    @include('includes.admin.appbar')
    @include('includes.main.loading')

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Liste des Blogs</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Blog</li>
            </ul>


        </div>

        <div class="card-header border-bottom bg-base py-16 px-24 d-flex justify-content-end">
            <a href="{{ route('blog.create') }}" class="btn btn-danger text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
                <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                Ajouter un blog
            </a>
        </div>


        @if ($message = Session::get('success'))
        <ul class="alert alert-success">
            <li>{{ $message }}</li>
        </ul>
        @endif

        @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif

        <div class="row gy-4">
            @foreach ($blogs as $blog)
            <div class="col-xxl-3 col-lg-4 col-sm-6">
                <div class="card h-100 p-0 radius-12 overflow-hidden">
                    <div class="card-body p-24">
                        <a href="{{ route('blogs.show', $blog->id) }}" class="w-100 max-h-194-px radius-8 overflow-hidden">
                            <img src="{{ \App\Helpers\FileHelper::getStorageImageUrl($blog->image, 'assets/images/blog.jpg') }}" alt="{{ $blog->title }}" class="w-100 h-100 object-fit-cover">
                        </a>
                        <div class="mt-20">
                            <div class="d-flex align-items-center gap-6 justify-content-between flex-wrap mb-16">
                                <span class="px-20 py-6 rounded-pill fw-medium text-white {{ $blog->is_published ? 'bg-success' : 'bg-danger' }}">
                                    {{ $blog->is_published ? 'Publié' : 'Non publié' }}
                                </span>
                                <div class="d-flex align-items-center gap-8 text-neutral-500 fw-medium">
                                    <i class="ri-calendar-2-line"></i>
                                    {{ $blog->created_at->format('M d, Y') }}
                                </div>
                            </div>
                            <h6 class="mb-16">
                                <a href="{{ route('blogs.show', $blog->id) }}" class="text-line-2 text-hover-primary-600 text-xl transition-2">{{ $blog->title }}</a>
                            </h6>
                            <p class="text-line-3 text-neutral-500">{{ $blog->short_description }}</p>
                            <a href="{{ route('blogs.show', $blog->id) }}" class="d-flex align-items-center gap-8 fw-semibold text-neutral-900 text-hover-primary-600 transition-2">
                                Lire plus
                                <i class="ri-arrow-right-double-line text-xl d-flex line-height-1"></i>
                            </a>
                            <div class="d-flex gap-2 mt-16">
                                <button type="button" class="btn btn-outline-primary btn-sm edit-blog-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editBlogModal"
                                    data-id="{{ $blog->id }}"
                                    data-title="{{ $blog->title }}"
                                    data-short-description="{{ $blog->short_description }}"
                                    data-long-description="{{ $blog->long_description }}"
                                    data-image-url="{{ \App\Helpers\FileHelper::getStorageImageUrl($blog->image, 'assets/images/blog.jpg') }}"
                                    data-is-published="{{ $blog->is_published }}"
                                    data-action-url="{{ route('blog.edit', $blog->id) }}">
                                    <iconify-icon icon="ri:edit-line" class="icon"></iconify-icon>
                                    Éditer
                                </button>
                                <form action="{{ route('blog.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce blog ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <iconify-icon icon="ri:delete-bin-line" class="icon"></iconify-icon>
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>



        <!-- Edit Blog Modal -->
        <div class="modal fade" id="editBlogModal" tabindex="-1" aria-labelledby="editBlogModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editBlogModalLabel">Modifier le blog</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editBlogForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label for="editBlogTitle" class="form-label">Titre</label>
                                <input type="text" class="form-control" id="editBlogTitle" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="editIsPublished" class="form-label">Statut</label>
                                <select class="form-select" id="editIsPublished" name="is_published" required>
                                    <option value="1">Publié</option>
                                    <option value="0">Non publié</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editBlogImage" class="form-label">Changer l'image (laisser vide pour conserver l'actuelle)</label>
                                <input type="file" class="form-control" id="editBlogImage" name="image" accept="image/*">
                                <div class="mt-3 text-center">
                                    <p class="small text-muted mb-1">Image actuelle :</p>
                                    <img id="editImagePreview" src="#" alt="Prévisualisation de l'image actuelle" class="img-fluid" style="max-height: 200px;">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="editBlogShortDescription" class="form-label">Brève description</label>
                                <textarea class="form-control" id="editBlogShortDescription" name="short_description" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="editBlogLongDescription" class="form-label">Longue description</label>
                                <textarea class="form-control" id="editBlogLongDescription" name="long_description" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger">Mettre à jour</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
    @include('includes.admin.footer')
</main>
@endsection

@section('js')
<!-- Summernote JS -->
<script src="{{ URL::asset('assets/summernote/summernote.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // Initialize Summernote for ADD modal
        $('#blogLongDescription').summernote({
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        // Initialize Summernote for EDIT modal
        $('#editBlogLongDescription').summernote({
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        // Image Preview for ADD modal
        $('#blogImage').on('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result).show();
                };
                reader.readAsDataURL(file);
            } else {
                $('#imagePreview').hide();
            }
        });

        // Image Preview for EDIT modal
        $('#editBlogImage').on('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#editImagePreview').attr('src', e.target.result).show();
                };
                reader.readAsDataURL(file);
            }
        });

        // Handle EDIT modal population
        $('#editBlogModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);

            // Extract info from data-* attributes
            var title = button.data('title');
            var shortDescription = button.data('short-description');
            var longDescription = button.data('long-description');
            var imageUrl = button.data('image-url');
            var actionUrl = button.data('action-url');
            var isPublished = button.data('is-published');

            // Update the modal's content
            var modal = $(this);
            modal.find('form').attr('action', actionUrl);
            modal.find('#editBlogTitle').val(title);
            modal.find('#editIsPublished').val(isPublished ? '1' : '0');
            modal.find('#editBlogShortDescription').val(shortDescription);
            modal.find('#editBlogLongDescription').summernote('code', longDescription);
            modal.find('#editImagePreview').attr('src', imageUrl).show();
            modal.find('#editBlogImage').val('');
        });
    });
</script>
@endsection