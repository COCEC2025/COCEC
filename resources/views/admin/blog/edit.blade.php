@extends('layout.admin')

@section('css')
<link href="{{ URL::asset('assets/summernote/summernote.min.css') }}" rel="stylesheet">
@endsection

@section('content')
@include('includes.admin.sidebar')

<main class="dashboard-main">
    @include('includes.admin.appbar')
    @include('includes.main.loading')

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h4 class="fw-semibold mb-0">Modifier le blog</h4>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">
                    <a href="{{ route('admin.blogs') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        Blog
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Modifier</li>
            </ul>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card basic-data-table">
            <div class="card-body">
                <form action="{{ route('blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data" class="row g-4">
                    @csrf
                    @method('PATCH')

                    <div class="col-12">
                        <label for="title" class="form-label">Titre</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $blog->title) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="is_published" class="form-label">Statut</label>
                        <select name="is_published" id="is_published" class="form-select" required>
                            <option value="1" {{ old('is_published', $blog->is_published) ? 'selected' : '' }}>Publié</option>
                            <option value="0" {{ !old('is_published', $blog->is_published) ? 'selected' : '' }}>Non publié</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="image" class="form-label">Changer l'image (laisser vide pour conserver l'actuelle)</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        @if($blog->image)
                        <div class="mt-3">
                            <p class="small text-muted mb-1">Image actuelle :</p>
                            <img src="{{ \App\Helpers\FileHelper::getStorageImageUrl($blog->image, 'assets/images/blog.jpg') }}" alt="Image actuelle" class="img-fluid radius-8" style="max-height: 150px;">
                        </div>
                        @endif
                    </div>

                    <div class="col-12">
                        <label for="short_description" class="form-label">Brève description</label>
                        <textarea name="short_description" id="short_description" class="form-control" rows="3" required>{{ old('short_description', $blog->short_description) }}</textarea>
                    </div>

                    <div class="col-12">
                        <label for="long_description" class="form-label">Longue description</label>
                        <textarea name="long_description" id="summernote" class="form-control" required>{{ old('long_description', $blog->long_description) }}</textarea>
                    </div>

                    <div class="col-12">
                        <div class="d-flex flex-wrap gap-3 mt-24">
                            <button type="submit" class="btn btn-danger">Mettre à jour</button>
                            <a href="{{ route('admin.blogs') }}" class="btn btn-outline-secondary">Annuler</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('includes.admin.footer')
</main>
@endsection

@section('js')
<script src="{{ URL::asset('assets/summernote/summernote.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 400,
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
    });
</script>
@endsection
