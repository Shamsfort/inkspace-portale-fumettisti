<x-layout>
    <main class="container py-5 page-section">
        <p class="eyebrow text-dark mb-1">La biblioteca indipendente</p>
        <h1 class="display-title display-3 mb-4">Tutti i fumetti</h1>
        <div class="row g-4">
            @forelse($articles as $article)
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">@include('article._card', ['article' => $article])</div>
            @empty
                <div class="col"><div class="alert alert-info">Nessun fumetto pubblicato.</div></div>
            @endforelse
        </div>
        <div class="mt-5">{{ $articles->links() }}</div>
    </main>
</x-layout>
