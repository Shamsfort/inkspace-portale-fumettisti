<x-layout>
    <main class="container py-5 page-section">
        <div class="row g-5 align-items-start">
            <div class="col-md-4">
                @if($user->profile?->image)<img class="profile-avatar shadow" src="{{ $user->profile->image_url }}" alt="Profilo di {{ $user->name }}">@else<div class="profile-avatar bg-dark text-white d-flex align-items-center justify-content-center display-title display-1">{{ mb_substr($user->name, 0, 1) }}</div>@endif
            </div>
            <div class="col-md-8">
                <p class="eyebrow text-dark mb-1">Fumettista indipendente</p>
                <h1 class="display-title display-3">{{ $user->username ?: $user->name }}</h1>
                <p class="lead">{{ $user->profile?->short_description ?: 'Questo autore non ha ancora aggiunto una biografia.' }}</p>
                <div class="surface-card p-4 mt-4"><h2 class="h5">Contatti</h2><p class="mb-1"><strong>E-mail:</strong> {{ $user->email }}</p>@if($user->profile?->phone)<p class="mb-1"><strong>Telefono:</strong> {{ $user->profile->phone }}</p>@endif @if($user->profile?->company_address)<p class="mb-0"><strong>Sede legale:</strong> {{ $user->profile->company_address }}</p>@endif</div>
                @auth @if(auth()->id() === $user->id)<a class="btn btn-brand mt-3" href="{{ route('profile.edit') }}">Modifica profilo</a>@endif @endauth
            </div>
        </div>

        <section class="mt-5 pt-4"><h2 class="display-title display-5">Fumetti pubblicati</h2><div class="row g-4 mt-1">@forelse($user->articles as $article)<div class="col-12 col-sm-6 col-lg-3">@include('article._card')</div>@empty<p>Nessun fumetto pubblicato.</p>@endforelse</div></section>
    </main>
</x-layout>

