<!doctype html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Portale per fumettisti indipendenti e lettori curiosi">
    <title>{{ $title ?? 'InkSpace — Fumettisti indipendenti' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <x-navbar />

    @if (session('message'))
        <div class="container pt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Chiudi"></button>
            </div>
        </div>
    @endif

    {{ $slot }}

    <footer class="border-top mt-5 py-4">
        <div class="container d-flex flex-column flex-sm-row justify-content-between gap-2">
            <span>© {{ date('Y') }} InkSpace</span>
            <a href="{{ route('contact.create') }}">Contatti</a>
        </div>
    </footer>
</body>
</html>
