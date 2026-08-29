<x-layout>
    <main class="container py-5 page-section">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="display-title display-4 mb-3">Nuovo post community</h1>
                <div class="alert alert-warning">I post vengono pubblicati solo dopo approvazione admin. Puoi caricare massimo 3 foto.</div>

                <form method="POST" action="{{ route('community.store') }}" enctype="multipart/form-data" class="card border-0 shadow-sm p-4">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="community-body">Testo</label>
                        <textarea id="community-body" name="body" class="form-control @error('body') is-invalid @enderror" rows="6" minlength="10" maxlength="2000" required>{{ old('body') }}</textarea>
                        @error('body') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="community-images">Foto</label>
                        <input id="community-images" type="file" name="images[]" class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror" accept="image/jpeg,image/png,image/webp,image/avif" multiple required>
                        <div class="form-text">Formato JPG, PNG, WebP o AVIF. Massimo 3 file.</div>
                        @error('images') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        @error('images.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <button class="btn btn-accent" type="submit">Invia per approvazione</button>
                </form>
            </div>
        </div>
    </main>
</x-layout>

