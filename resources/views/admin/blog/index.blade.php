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
                                <a href="{{ route('blog.edit', $blog->id) }}" class="btn btn-outline-primary btn-sm">
                                    <iconify-icon icon="ri:edit-line" class="icon"></iconify-icon>
                                    Éditer
                                </a>
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

    </div>
    @include('includes.admin.footer')
</main>
@endsection