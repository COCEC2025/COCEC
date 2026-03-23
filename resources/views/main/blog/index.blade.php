@extends('layout.main')

@section('content')

<body>
    @include('includes.main.loading')
    @include('includes.main.header')

    <section class="page-header-pro">
        <div class="page-header-overlay"></div>
        <div class="container"><div class="page-header-content-pro" data-aos="fade-up"><h1 class="title-pro">Blog</h1><nav aria-label="breadcrumb"><ol class="breadcrumb-pro"><li class="breadcrumb-item"><a href="{{ route('index') }}">Accueil</a></li><li class="breadcrumb-item active" aria-current="page">Blog</li></ol></nav></div></div>
    </section>

    <section class="blog-section pt-130 pb-130">
        <div class="container">
            <div class="row gy-5">
                <!-- Colonne principale (liste des articles) -->
                <div class="col-lg-8 col-md-12" id="blog-posts-container">
                    {{-- Les articles seront injectés ici par le JavaScript --}}
                </div>

                <!-- Barre latérale -->
                <div class="col-lg-4">
                    <div class="sidebar-widget">
                        <h3 class="widget-title">Rechercher</h3>
                        <div class="search-widget">
                            <input type="text" id="blog-search-input" placeholder="Rechercher un article...">
                        </div>
                    </div>
                    <div class="sidebar-widget">
                        <h3 class="widget-title">Posts Récents</h3>
                        @forelse ($blogs->take(4) as $recentPost)
                            <div class="sidebar-post">
                                <a href="{{ route('blogs.show', ['id' => $recentPost->id]) }}">
                                    <img src="{{ \App\Helpers\FileHelper::getStorageImageUrl($recentPost->image) }}" alt="{{ $recentPost->title }}">
                                </a>
                                <div class="post-content">
                                    <h3 class="title"><a href="{{ route('blogs.show', ['id' => $recentPost->id]) }}">{{ $recentPost->title }}</a></h3>
                                    <ul class="post-meta">
                                        <li><i class="fa-regular fa-calendar-alt"></i>{{ $recentPost->created_at->translatedFormat('d M Y') }}</li>
                                    </ul>
                                </div>
                            </div>
                        @empty
                            <p>Aucun article récent.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Conteneur caché avec tous les articles pour le script JS -->
    <div id="all-posts-data" style="display: none;">
        @foreach ($blogs as $blog)
            {{-- On utilise VOTRE structure de carte ici --}}
            <div class="post-card post-inner blog-post-item" data-title="{{ strtolower($blog->title) }}">
                <a href="{{ route('blogs.show', $blog->id) }}">
                    <div class="post-thumb">
                        <img src="{{ \App\Helpers\FileHelper::getStorageImageUrl($blog->image) }}" alt="{{ $blog->title }}">
                    </div>
                </a>
                <div class="post-content-wrap">
                    <div class="post-content">
                        <ul class="post-meta">
                            <li><i class="fa-regular fa-calendar"></i>{{ $blog->created_at->translatedFormat('d F Y à H:i') }}</li>
                            <li><i class="fa-regular fa-user"></i>{{ $blog->author ?? 'Admin' }}</li>
                        </ul>
                        <h3 class="title"><a href="{{ route('blogs.show', $blog->id) }}">{{ $blog->title }}</a></h3>
                        <p>{{ $blog->short_description }}</p>
                    </div>
                    <div class="post-bottom">
                        <a class="read-more" href="{{ route('blogs.show', $blog->id) }}">Lire plus<i class="fa-solid fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @include('includes.main.scroll')
    @include('includes.main.footer')
</body>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('blog-search-input');
    const postsContainer = document.getElementById('blog-posts-container');
    
    const allPosts = Array.from(document.querySelectorAll('#all-posts-data .blog-post-item'));
    const itemsPerPage = 3; // Moins d'articles par page pour un layout en liste
    let currentPage = 1;
    let filteredPosts = allPosts;

    function displayPage(page) {
        currentPage = page;
        postsContainer.innerHTML = ''; // Toujours vider avant de remplir

        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const pageItems = filteredPosts.slice(startIndex, endIndex);

        if (pageItems.length === 0) {
            postsContainer.innerHTML = `<div class="no-results"><p>Aucun article ne correspond à votre recherche.</p></div>`;
        } else {
            pageItems.forEach(item => {
                postsContainer.appendChild(item.cloneNode(true));
            });
        }
        
        setupPagination();
    }

    function setupPagination() {
        // Supprimer l'ancienne pagination avant de reconstruire
        const oldPagination = postsContainer.querySelector('.pagination-wrap');
        if (oldPagination) {
            oldPagination.remove();
        }

        const pageCount = Math.ceil(filteredPosts.length / itemsPerPage);
        if (pageCount <= 1) return;

        const paginationList = document.createElement('ul');
        paginationList.className = 'pagination-wrap mt-20';

        // Bouton Précédent
        const prevLi = document.createElement('li');
        const prevBtn = document.createElement('button');
        prevBtn.innerHTML = '<i class="fa-sharp fa-regular fa-arrow-left"></i>';
        prevBtn.className = 'pagination-btn';
        prevBtn.disabled = currentPage === 1;
        prevBtn.addEventListener('click', () => displayPage(currentPage - 1));
        prevLi.appendChild(prevBtn);
        paginationList.appendChild(prevLi);

        // Boutons numérotés
        for (let i = 1; i <= pageCount; i++) {
            const pageLi = document.createElement('li');
            const pageBtn = document.createElement('a'); // Utilise 'a' comme dans votre style
            pageBtn.href = '#';
            pageBtn.innerText = i;
            if (i === currentPage) { pageBtn.classList.add('active'); }
            pageBtn.addEventListener('click', (e) => { e.preventDefault(); displayPage(i); });
            pageLi.appendChild(pageBtn);
            paginationList.appendChild(pageLi);
        }

        // Bouton Suivant
        const nextLi = document.createElement('li');
        const nextBtn = document.createElement('button');
        nextBtn.innerHTML = '<i class="fa-sharp fa-regular fa-arrow-right"></i>';
        nextBtn.className = 'pagination-btn';
        nextBtn.disabled = currentPage === pageCount;
        nextBtn.addEventListener('click', () => displayPage(currentPage + 1));
        nextLi.appendChild(nextBtn);
        paginationList.appendChild(nextLi);

        postsContainer.appendChild(paginationList);
    }

    function handleSearch() {
        const searchTerm = searchInput.value.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        filteredPosts = allPosts.filter(post => {
            const title = post.dataset.title.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
            return title.includes(searchTerm);
        });
        displayPage(1);
    }

    searchInput.addEventListener('input', handleSearch);
    displayPage(1);
});
</script>
@endsection