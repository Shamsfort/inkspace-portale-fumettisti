<x-layout>
    <main class="container py-5 page-section">
        <div class="row justify-content-center"><div class="col-lg-9">
            <p class="eyebrow text-dark mb-1">Nuova pubblicazione</p><h1 class="display-title display-4">Pubblica un fumetto</h1>
            <form class="surface-card p-4 p-lg-5 mt-4" action="{{ route('article.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('article._form')
                <button class="btn btn-brand mt-4" type="submit">Pubblica fumetto</button>
            </form>
        </div></div>
    </main>
</x-layout>
