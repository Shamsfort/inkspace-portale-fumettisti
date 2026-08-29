<x-layout>
    <main class="container py-5 page-section">
        <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 align-items-lg-end mb-4">
            <div>
                <p class="eyebrow text-dark mb-1">Community</p>
                <h1 class="display-title display-3 mb-0">Post degli iscritti</h1>
            </div>
            @auth
                <a class="btn btn-accent" href="{{ route('community.create') }}">Pubblica un post</a>
            @endauth
        </div>

        <div class="row g-4">
            @forelse($posts as $post)
                <div class="col-12">
                    <div class="card shadow-sm border-0 overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <strong>{{ $post->author?->username ?? $post->author?->name }}</strong>
                                    <div class="text-secondary small">{{ $post->created_at->format('d/m/Y H:i') }}</div>
                                </div>
                                <a href="{{ route('community.show', $post) }}">Apri</a>
                            </div>

                            @if($post->images->count())
                                <div id="postCarousel{{ $post->id }}" class="carousel slide mb-3" data-bs-ride="false">
                                    <div class="carousel-inner rounded-4">
                                        @foreach($post->images as $image)
                                            <div class="carousel-item @if($loop->first) active @endif">
                                                <img src="{{ $image->url }}" class="d-block w-100 bg-light" style="height: min(65vh, 520px); object-fit: contain;" loading="{{ $loop->parent->first && $loop->first ? 'eager' : 'lazy' }}" alt="Foto {{ $loop->iteration }} di {{ $post->images->count() }} pubblicata da {{ $post->author?->username ?? $post->author?->name }}">
                                            </div>
                                        @endforeach
                                    </div>
                                    @if($post->images->count() > 1)
                                        <button class="carousel-control-prev" type="button" data-bs-target="#postCarousel{{ $post->id }}" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Foto precedente</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#postCarousel{{ $post->id }}" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Foto successiva</span>
                                        </button>
                                    @endif
                                </div>
                            @endif

                            <p class="mb-2">{{ \Illuminate\Support\Str::limit($post->body, 240) }}</p>
                            <div class="text-secondary small">{{ $post->comments_count }} commenti</div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">Nessun post approvato ancora.</div>
                </div>
            @endforelse
        </div>

        <div class="mt-5">{{ $posts->links() }}</div>
    </main>
</x-layout>

