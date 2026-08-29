<x-layout>
    <main class="container py-5 page-section">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="eyebrow text-dark mb-1">Community</p>
                            <h1 class="display-title display-5 mb-0">{{ $post->author?->username ?? $post->author?->name }}</h1>
                        </div>
                        <span class="badge {{ $post->status === 'approved' ? 'text-bg-success' : ($post->status === 'rejected' ? 'text-bg-danger' : 'text-bg-warning') }}">{{ ['approved' => 'Approvato', 'rejected' => 'Rifiutato', 'pending' => 'In attesa'][ $post->status ] ?? $post->status }}</span>
                    </div>

                    @if($post->images->count())
                        <div id="singlePostCarousel" class="carousel slide mb-4" data-bs-ride="false">
                            <div class="carousel-inner rounded-4">
                                @foreach($post->images as $image)
                                    <div class="carousel-item @if($loop->first) active @endif">
                                        <img src="{{ $image->url }}" class="d-block w-100 bg-light" style="height: min(75vh, 680px); object-fit: contain;" alt="Foto {{ $loop->iteration }} di {{ $post->images->count() }} pubblicata da {{ $post->author?->username ?? $post->author?->name }}">
                                    </div>
                                @endforeach
                            </div>
                            @if($post->images->count() > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#singlePostCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Foto precedente</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#singlePostCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Foto successiva</span>
                                </button>
                            @endif
                        </div>
                    @endif

                    <p class="fs-5">{{ $post->body }}</p>
                </div>

                <div class="mt-4 card border-0 shadow-sm p-4">
                    <h2 class="display-title display-6 mb-3">Commenti</h2>
                    @auth
                      @if($post->status === 'approved')
                        <form method="POST" action="{{ route('community.comment', $post) }}" class="mb-4">
                            @csrf
                            <label class="form-label" for="comment-body">Scrivi un commento</label>
                            <textarea id="comment-body" name="body" class="form-control mb-2 @error('body') is-invalid @enderror" rows="3" minlength="2" maxlength="1000" required>{{ old('body') }}</textarea>
                            @error('body') <div class="invalid-feedback d-block mb-2">{{ $message }}</div> @enderror
                            <button class="btn btn-accent" type="submit">Invia commento</button>
                        </form>
                      @else
                        <div class="alert alert-info">I commenti saranno disponibili dopo l'approvazione del post.</div>
                      @endif
                    @else
                      @if($post->status === 'approved')
                        <p><a href="{{ route('login') }}">Accedi</a> per partecipare alla conversazione.</p>
                      @endif
                    @endauth

                    <div class="d-grid gap-3">
                        @forelse($post->comments as $comment)
                            <div class="border rounded-4 p-3">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $comment->user?->username ?? $comment->user?->name }}</strong>
                                    <span class="text-secondary small">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <p class="mb-0 mt-2">{{ $comment->body }}</p>
                            </div>
                        @empty
                            <p class="text-secondary mb-0">Nessun commento ancora.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>

