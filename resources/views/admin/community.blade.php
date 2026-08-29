<x-layout>
    <main class="container py-5 page-section">
        <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 align-items-lg-end mb-4">
            <div>
                <p class="eyebrow text-dark mb-1">Moderazione</p>
                <h1 class="display-title display-4 mb-0">Community Admin</h1>
            </div>
            <a class="btn btn-outline-dark" href="{{ route('admin.dashboard') }}">Dashboard ruoli</a>
        </div>

        @if($admins->count())
            <div class="alert alert-info">Admin attivi: {{ $admins->pluck('username')->filter()->join(', ') }}</div>
        @endif

        <section class="mb-5">
            <h2 class="display-title display-6 mb-3">Post in attesa</h2>
            <div class="row g-4">
                @forelse($pendingPosts as $post)
                    <div class="col-12">
                        <div class="card shadow-sm border-0 p-3">
                            <div class="d-flex justify-content-between mb-2">
                                <strong>{{ $post->author?->username ?? $post->author?->name }}</strong>
                                <span class="text-secondary small">{{ $post->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <p>{{ $post->body }}</p>
                            @if($post->images->count())
                                <div class="row g-2 mb-3">
                                    @foreach($post->images as $image)
                                        <div class="col-4"><img class="w-100 rounded-3 bg-light" style="aspect-ratio: 1; object-fit: contain;" src="{{ $image->url }}" alt="Foto {{ $loop->iteration }} da moderare"></div>
                                    @endforeach
                                </div>
                            @endif
                            <div class="d-flex gap-2">
                                <a class="btn btn-outline-dark btn-sm" href="{{ route('community.show', $post) }}">Apri dettaglio</a>
                                <form method="POST" action="{{ route('community-admin.posts.approve', $post) }}">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-success btn-sm">Approva</button>
                                </form>
                                <form method="POST" action="{{ route('community-admin.posts.reject', $post) }}">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-outline-danger btn-sm">Rifiuta</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-secondary">Nessun post da moderare.</p>
                @endforelse
            </div>
        </section>

        <section class="mb-5">
            <h2 class="display-title display-6 mb-3">Richieste dal form contatti</h2>
            <div class="d-grid gap-3">
                @forelse($contactMessages as $contact)
                    <article class="card border-0 shadow-sm p-3 {{ $contact->status === 'resolved' ? 'opacity-75' : '' }}">
                        <div class="d-flex flex-wrap justify-content-between gap-2">
                            <strong>{{ $contact->name }} · <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></strong>
                            <span class="badge {{ $contact->status === 'resolved' ? 'text-bg-success' : 'text-bg-warning' }}">{{ $contact->status === 'resolved' ? 'Gestita' : 'Da gestire' }}</span>
                        </div>
                        <p class="my-3">{{ $contact->message }}</p>
                        @if($contact->status !== 'resolved')
                            <form method="POST" action="{{ route('community-admin.contacts.resolve', $contact) }}">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-outline-success" type="submit">Segna come gestita</button>
                            </form>
                        @endif
                    </article>
                @empty
                    <p class="text-secondary">Nessuna richiesta ricevuta.</p>
                @endforelse
            </div>
        </section>

        <section class="mb-5">
            <h2 class="display-title display-6 mb-3">Richieste amministratore</h2>
            <div class="row g-4">
                @forelse($adminRequests as $request)
                    <div class="col-12">
                        <div class="card shadow-sm border-0 p-3">
                            <div class="d-flex justify-content-between mb-2">
                                <strong>{{ $request->user?->username ?? $request->user?->name }}</strong>
                                <span class="text-secondary small">{{ $request->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <p class="mb-3">{{ $request->note ?? 'Richiesta di promozione admin' }}</p>
                            <div class="d-flex gap-2">
                                <form method="POST" action="{{ route('community-admin.admin-requests.approve', $request) }}">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-success btn-sm">Approva admin</button>
                                </form>
                                <form method="POST" action="{{ route('community-admin.admin-requests.reject', $request) }}">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-outline-danger btn-sm">Rifiuta</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-secondary">Nessuna richiesta amministratore.</p>
                @endforelse
            </div>
        </section>

        <section class="mb-5">
            <h2 class="display-title display-6 mb-3">Post già approvati</h2>
            <div class="row g-4">
                @foreach($approvedPosts as $post)
                    <div class="col-12 col-md-6">
                        <div class="card border-0 shadow-sm p-3">
                            <strong>{{ $post->author?->username ?? $post->author?->name }}</strong>
                            <p class="mb-0 mt-2">{{ \Illuminate\Support\Str::limit($post->body, 140) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section>
            <h2 class="display-title display-6 mb-3">Post rifiutati</h2>
            <div class="row g-4">
                @forelse($rejectedPosts as $post)
                    <div class="col-12 col-md-6"><div class="card border-0 shadow-sm p-3"><strong>{{ $post->author?->username ?? $post->author?->name }}</strong><p class="mb-0 mt-2">{{ \Illuminate\Support\Str::limit($post->body, 140) }}</p></div></div>
                @empty
                    <p class="text-secondary">Nessun post rifiutato.</p>
                @endforelse
            </div>
        </section>
    </main>
</x-layout>

