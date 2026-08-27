<x-layout>
    <main class="container py-5 page-section">
        <div class="row justify-content-center"><div class="col-lg-9">
            <p class="eyebrow text-dark mb-1">La tua pubblicazione</p><h1 class="display-title display-4">Modifica fumetto</h1>
            <form class="surface-card p-4 p-lg-5 mt-4" action="{{ route('article.update', $article) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                @include('article._form')
                <button class="btn btn-brand mt-4" type="submit">Salva modifiche</button>
            </form>
        </div></div>
    </main>
</x-layout>
