<x-layout>
    <main class="container py-5 page-section"><div class="row justify-content-center"><div class="col-lg-6">
        <h1 class="display-title display-4">Cambia password</h1>
        <form class="surface-card p-4 mt-4" action="{{ route('profile.update-password') }}" method="POST">
            @csrf @method('PUT')
            @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            <div class="mb-3"><label class="form-label" for="current_password">Password attuale</label><input type="password" class="form-control" id="current_password" name="current_password" required></div>
            <div class="mb-3"><label class="form-label" for="new_password">Nuova password</label><input type="password" class="form-control" id="new_password" name="new_password" required></div>
            <div class="mb-3"><label class="form-label" for="new_password_confirmation">Conferma nuova password</label><input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required></div>
            <button class="btn btn-brand" type="submit">Aggiorna password</button>
        </form>
        <form class="mt-5" action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Eliminare definitivamente il tuo account?')">@csrf @method('DELETE')<button class="btn btn-outline-danger" type="submit">Elimina account</button></form>
    </div></div></main>
</x-layout>
