<x-layout>
    <main class="container py-5 page-section">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <p class="eyebrow">Parliamone</p>
                <h1 class="display-5 fw-bold">Contatta il portale</h1>
                <p class="text-secondary mb-4">Domande, proposte o segnalazioni: ti risponderemo appena possibile.</p>

                <form method="POST" action="{{ route('contact.store') }}" class="surface-card p-4">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="name">Nome</label>
                        <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">E-mail</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="message">Messaggio</label>
                        <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="6" required>{{ old('message') }}</textarea>
                        @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <button class="btn btn-brand" type="submit">Invia messaggio</button>
                </form>
            </div>
        </div>
    </main>
</x-layout>
