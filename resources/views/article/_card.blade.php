<article class="comic-card">
    @if ($article->image)
        <img
            class="comic-cover"
            src="{{ $article->image_url }}"
            alt="Copertina di {{ $article->title }}"
            loading="{{ ($loop->first ?? false) ? 'eager' : 'lazy' }}"
            decoding="async"
            @if ($loop->first ?? false) fetchpriority="high" @endif
        >
    @else
        <div class="comic-cover d-flex align-items-center justify-content-center display-title display-4">NO COVER</div>
    @endif
    <div class="p-4">
        <div class="d-flex flex-wrap gap-1 mb-2">
            @foreach($article->categories as $category)
                <span class="badge badge-category">{{ $category->name }}</span>
            @endforeach
        </div>
        <h2 class="h4 fw-bold mb-1">{{ $article->title }}</h2>
        <p class="small text-secondary mb-3">di {{ $article->user?->username ?: $article->user?->name ?: 'Autore non disponibile' }}</p>
        <a class="stretched-link fw-semibold" href="{{ route('article.show', $article) }}">Scopri il fumetto</a>
    </div>
</article>

