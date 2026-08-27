<x-layout>
    <style>
        body {
            background-color: rgb(52, 112, 146)!important;
            margin-top: 10px!important;
            display: flex!important;
            justify-content: center!important;
            align-items: center!important;
            height: 80vh!important;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(5px);
            border-radius: 20px;
            padding: 20px;
            animation: fadeInDown 1s ease-out;
            max-width: 400px;
            width: 100%;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="form-container">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <h3 class="text-center mb-4">Benvenuto Utente</h3>
            <p class="text-center mb-4">Accedi con i tuoi dati</p>
            <div class="mb-3">
                <label for="email" class="form-label">E-Mail</label>
                <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="E-Mail">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input name="password" type="password" class="form-control" id="password" placeholder="Password">
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Invia</button>
            </div>
        </form>
        <p class="text-center mt-3">Se non sei ancora registrato <a href="{{ route('register') }}">clicca qui</a></p>
    </div>
</x-layout>
