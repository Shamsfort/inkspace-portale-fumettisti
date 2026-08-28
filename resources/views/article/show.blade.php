<x-layout>
    <main class="container py-5 page-section">
        <div class="row g-5 align-items-start">
            <div class="col-md-5 col-lg-4">
                @if($article->image)<img class="comic-cover rounded-4 shadow" src="{{ $article->image_url }}" alt="Copertina di {{ $article->title }}">@endif
            </div>
            <div class="col-md-7 col-lg-8">
                <div class="d-flex gap-2 flex-wrap mb-3">@foreach($article->categories as $category)<span class="badge badge-category">{{ $category->name }}</span>@endforeach</div>
                <h1 class="display-title display-3">{{ $article->title }}</h1>
                @if($article->subtitle)<p class="lead text-secondary">{{ $article->subtitle }}</p>@endif
                <dl class="row mt-4">
                    <dt class="col-sm-3">Autore</dt><dd class="col-sm-9">@if($article->user)<a href="{{ route('profile.user', $article->user) }}">{{ $article->user->username ?: $article->user->name }}</a>@else Non disponibile @endif</dd>
                    <dt class="col-sm-3">Numero</dt><dd class="col-sm-9">{{ $article->comic_number }}</dd>
                    <dt class="col-sm-3">Anno</dt><dd class="col-sm-9">{{ $article->comic_year }}</dd>
                    <dt class="col-sm-3">Rivista</dt><dd class="col-sm-9">{{ $article->rivista ? $article->rivista->nome.' ('.$article->rivista->nazione.')' : 'Autoproduzione' }}</dd>
                </dl>
                <hr><h2 class="h4">Trama</h2><p class="fs-5" style="white-space: pre-line">{{ $article->article_description }}</p>
                @auth @if(auth()->id() === $article->author_id)
                    <div class="d-flex gap-2 mt-4"><a class="btn btn-brand" href="{{ route('article.edit', $article) }}">Modifica</a>
                    <form action="{{ route('article.destroy', $article) }}" method="POST" onsubmit="return confirm('Eliminare questo fumetto?')">@csrf @method('DELETE')<button class="btn btn-outline-danger" type="submit">Elimina</button></form></div>
                @endif @endauth
            </div>
        </div>
    </main>
</x-layout>

