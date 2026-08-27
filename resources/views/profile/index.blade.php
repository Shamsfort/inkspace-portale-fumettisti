<x-layout>
    <main class="container py-5 page-section">
        <p class="eyebrow text-dark mb-1">Dietro ogni tavola</p>
        <h1 class="display-title display-3 mb-4">I fumettisti</h1>
        <div class="row g-4">
            @forelse($users as $user)
                <div class="col-12 col-md-6 col-lg-4">
                    <article class="surface-card p-3 h-100 d-flex gap-3">
                        @if($user->profile?->image)
                            <img src="{{ Storage::url($user->profile->image) }}" class="rounded-3 object-fit-cover" width="110" height="110" alt="Profilo di {{ $user->name }}">
                        @else
                            <div class="rounded-3 bg-dark text-white d-flex align-items-center justify-content-center display-title display-5" style="width:110px;height:110px">{{ mb_substr($user->name, 0, 1) }}</div>
                        @endif
                        <div><h2 class="h4 mb-1">{{ $user->username ?: $user->name }}</h2><p class="small text-secondary">{{ Str::limit($user->profile?->short_description, 90) }}</p><a href="{{ route('profile.user', $user) }}" class="stretched-link">Scopri l’autore</a></div>
                    </article>
                </div>
            @empty
                <p>Nessun fumettista ha ancora pubblicato.</p>
            @endforelse
        </div>
        <div class="mt-5">{{ $users->links() }}</div>
    </main>
</x-layout>
