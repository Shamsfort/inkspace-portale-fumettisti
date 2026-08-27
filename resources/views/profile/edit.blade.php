<x-layout>
    <main class="container py-5 page-section"><div class="row justify-content-center"><div class="col-lg-9">
        <p class="eyebrow text-dark mb-1">Il tuo spazio</p><h1 class="display-title display-4">Modifica profilo</h1>
        <form class="surface-card p-4 p-lg-5 mt-4" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label" for="name">Nome</label><input class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required></div>
                <div class="col-md-6"><label class="form-label" for="surname">Cognome</label><input class="form-control" id="surname" name="surname" value="{{ old('surname', $user->surname) }}"></div>
                <div class="col-md-6"><label class="form-label" for="username">Nome d’arte</label><input class="form-control" id="username" name="username" value="{{ old('username', $user->username) }}"></div>
                <div class="col-md-6"><label class="form-label" for="email">E-mail</label><input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required></div>
                <div class="col-md-6"><label class="form-label" for="phone">Telefono (unico)</label><input class="form-control" id="phone" name="phone" value="{{ old('phone', $user->profile?->phone) }}"></div>
                <div class="col-md-6"><label class="form-label" for="company_address">Sede legale (facoltativa)</label><input class="form-control" id="company_address" name="company_address" value="{{ old('company_address', $user->profile?->company_address) }}"></div>
                <div class="col-12"><label class="form-label" for="short_description">Breve descrizione</label><textarea class="form-control" id="short_description" name="short_description" rows="5">{{ old('short_description', $user->profile?->short_description) }}</textarea></div>
                <div class="col-12"><label class="form-label" for="image">Immagine profilo</label><input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/png,image/webp"></div>
            </div>
            <button class="btn btn-brand mt-4" type="submit">Salva profilo</button>
            <a class="btn btn-outline-dark mt-4" href="{{ route('profile.editPassword') }}">Cambia password</a>
        </form>
    </div></div></main>
</x-layout>
