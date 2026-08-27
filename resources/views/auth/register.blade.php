<x-layout>
    <main class="container py-5 page-section"><div class="row justify-content-center"><div class="col-lg-7">
        <p class="eyebrow text-dark mb-1">Entra nella community</p><h1 class="display-title display-4">Crea il tuo account</h1>
        <form class="surface-card p-4 p-lg-5 mt-4" action="{{ route('register') }}" method="POST">
            @csrf
            @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label" for="name">Nome</label><input class="form-control" id="name" name="name" value="{{ old('name') }}" required></div>
                <div class="col-md-6"><label class="form-label" for="username">Nome d’arte</label><input class="form-control" id="username" name="username" value="{{ old('username') }}"></div>
                <div class="col-12"><label class="form-label" for="email">E-mail</label><input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required></div>
                <div class="col-md-6"><label class="form-label" for="password">Password</label><input type="password" class="form-control" id="password" name="password" required></div>
                <div class="col-md-6"><label class="form-label" for="password_confirmation">Conferma password</label><input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required></div>
                <div class="col-md-6"><label class="form-label" for="phone">Telefono</label><input class="form-control" id="phone" name="phone" value="{{ old('phone') }}"></div>
                <div class="col-md-6"><label class="form-label" for="company_address">Sede legale (facoltativa)</label><input class="form-control" id="company_address" name="company_address" value="{{ old('company_address') }}"></div>
                <div class="col-12"><label class="form-label" for="short_description">Breve descrizione</label><textarea class="form-control" id="short_description" name="short_description" rows="4">{{ old('short_description') }}</textarea></div>
            </div>
            <button class="btn btn-brand mt-4" type="submit">Registrati</button>
        </form>
    </div></div></main>
</x-layout>
