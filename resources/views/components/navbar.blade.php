<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">INK<span>SPACE</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Apri navigazione">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="{{ route('article.index') }}">Fumetti</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('profile.index') }}">Fumettisti</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contact.create') }}">Contatti</a></li>
            </ul>
            <div class="d-flex align-items-lg-center gap-2 flex-column flex-lg-row">
                @auth
                    <a class="btn btn-sm btn-outline-light" href="{{ route('profile.show') }}">Il mio profilo</a>
                    <a class="btn btn-sm btn-accent" href="{{ route('article.create') }}">Pubblica fumetto</a>
                    <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-sm btn-link text-white" type="submit">Esci</button></form>
                @else
                    <a class="btn btn-sm btn-link text-white" href="{{ route('login') }}">Accedi</a>
                    <a class="btn btn-sm btn-accent" href="{{ route('register') }}">Registrati</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
