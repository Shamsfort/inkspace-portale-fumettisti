<x-layout>
    <main class="container py-5 page-section">
        <p class="eyebrow text-dark mb-1">Bibliografia</p><h1 class="display-title display-3">I fumetti di {{ $user->username ?: $user->name }}</h1>
        <div class="row g-4 mt-2">@forelse($articles as $article)<div class="col-12 col-sm-6 col-lg-4 col-xl-3">@include('article._card')</div>@empty<p>Nessun fumetto pubblicato.</p>@endforelse</div>
    </main>
</x-layout>
