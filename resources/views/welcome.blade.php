<x-layout>
    <section class="hero py-5 py-lg-6">
        <div class="container py-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <p class="eyebrow">Fumetti indipendenti, senza filtri</p>
                    <h1>Storie che lasciano il segno.</h1>
                    <p class="lead text-white-50 mt-4 mb-4">Scopri nuove tavole, incontra gli autori e pubblica il fumetto che hai nel cassetto.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a class="btn btn-accent btn-lg" href="{{ route('article.index') }}">Esplora i fumetti</a>
                        @auth
                            <a class="btn btn-outline-light btn-lg" href="{{ route('article.create') }}">Pubblica il tuo</a>
                        @else
                            <a class="btn btn-outline-light btn-lg" href="{{ route('register') }}">Diventa autore</a>
                        @endauth
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="hero-panel p-5 text-center">
                        <div class="display-title display-1">BANG!</div>
                        <p class="fs-4 mb-0">Il prossimo universo narrativo può iniziare qui.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container py-5">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div><p class="eyebrow text-dark mb-1">Appena pubblicati</p><h2 class="display-title display-5 mb-0">Nuovi fumetti</h2></div>
            <a href="{{ route('article.index') }}">Vedi tutti →</a>
        </div>
        <div class="row g-4">
            @forelse($articles as $article)
                <div class="col-12 col-sm-6 col-lg-4">
                    @include('article._card', ['article' => $article])
                </div>
            @empty
                <p class="text-secondary">Non ci sono ancora fumetti pubblicati. Potresti essere il primo.</p>
            @endforelse
        </div>
    </section>
</x-layout>
