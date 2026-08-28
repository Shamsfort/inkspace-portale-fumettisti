<x-layout>
    <main class="container py-5 page-section">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5">
                <p class="eyebrow text-dark mb-1">Bentornato</p>
                <h1 class="display-title display-4">Accedi a InkSpace</h1>

                <form class="surface-card p-4 p-lg-5 mt-4" method="POST" action="{{ route('login') }}">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input
                            name="email"
                            type="email"
                            class="form-control"
                            id="email"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            required
                            autofocus
                        >
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input
                            name="password"
                            type="password"
                            class="form-control"
                            id="password"
                            autocomplete="current-password"
                            required
                        >
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Ricordami</label>
                    </div>

                    <button type="submit" class="btn btn-brand w-100">Accedi</button>

                    <p class="text-center mt-4 mb-0">
                        Non hai ancora un account?
                        <a href="{{ route('register') }}">Registrati</a>
                    </p>
                </form>
            </div>
        </div>
    </main>
</x-layout>

