@if ($errors->any())
    <div class="alert alert-danger"><strong>Controlla i campi evidenziati.</strong><ul class="mb-0 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label" for="title">Titolo</label>
        <input class="form-control" id="title" name="title" value="{{ old('title', $article->title ?? '') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label" for="comic_number">Numero</label>
        <input type="number" min="1" class="form-control" id="comic_number" name="comic_number" value="{{ old('comic_number', $article->comic_number ?? 1) }}" required>
    </div>
    <div class="col-md-8">
        <label class="form-label" for="subtitle">Sottotitolo <span class="text-secondary">(facoltativo)</span></label>
        <input class="form-control" id="subtitle" name="subtitle" value="{{ old('subtitle', $article->subtitle ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label" for="comic_year">Anno</label>
        <input type="number" min="1900" max="{{ date('Y') + 1 }}" class="form-control" id="comic_year" name="comic_year" value="{{ old('comic_year', $article->comic_year ?? date('Y')) }}" required>
    </div>
    <div class="col-12">
        <label class="form-label" for="article_description">Trama</label>
        <textarea class="form-control" id="article_description" name="article_description" rows="6" required>{{ old('article_description', $article->article_description ?? '') }}</textarea>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="categories">Categorie <span class="text-secondary">(selezione multipla)</span></label>
        @php($selectedCategories = old('categories', isset($article) ? $article->categories->pluck('id')->all() : []))
        <select class="form-select" id="categories" name="categories[]" multiple size="6" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(in_array($category->id, $selectedCategories))>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="rivista_id">Rivista <span class="text-secondary">(facoltativa)</span></label>
        <select class="form-select" id="rivista_id" name="rivista_id">
            <option value="">Nessuna rivista</option>
            @foreach($rivistas as $rivista)
                <option value="{{ $rivista->id }}" @selected(old('rivista_id', $article->rivista_id ?? '') == $rivista->id)>{{ $rivista->nome }} — {{ $rivista->nazione }}</option>
            @endforeach
        </select>
        <label class="form-label mt-3" for="image">Copertina {{ isset($article) ? '(lascia vuoto per mantenerla)' : '' }}</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/png,image/webp" {{ isset($article) ? '' : 'required' }}>
    </div>
</div>
