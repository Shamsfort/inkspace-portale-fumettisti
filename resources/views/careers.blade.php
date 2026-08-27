<x-layout>
    <style>
        html, body{
            margin-top: 10px!important;
            overflow: hidden;
        }
        
    </style>
    <div class="container-fluidd p-5 bg-info text-center text-white">
        <div class="row justify-content-center">
            <h1 class="display-1">
                Lavora Con Noi
            </h1>
        </div>
    </div>
    <div class="container my-5">
        <div class="row justify-content-center align-items-center border rounded p-3 shadow">
            <div class="col-12 col-md-6">
                <h2>Lavora Come Amministratore
                </h2>
                <p>Lorem ipsum dolor sit.</p>
                
                <h2>Lavora Come Revisore
                </h2>
                <p>Lorem ipsum dolor sit.</p>
                
                <h2>Lavora Come Scrittore
                </h2>
                <p>Lorem ipsum dolor sit.</p>
                
                
            </div>
            <div class="col-12 col-md-6">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error )
                        <li>
                            {{ $error }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <form action="{{route('careers.submit')}}" method="POST" class="p-5">
                    @csrf
                    <div class="mb-3">
                        <label for="role" class="form-label">A Quale Ruolo Ambisci?</label>
                        <select name="role" id="role" class="form-control">
                            <option value="">Scegli Qui</option>
                            <option value="admin">Amministratore</option>
                            <option value="revisor">Revisore</option>
                            <option value="writer">Scrittore</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') ?? Auth::user()->email }}">
                    </div>
                    <div class="mb-3">
                        <label for="Message" class="form-label">Parlaci di te</label>
                        <textarea name="message" id="message" cols="30" rows="7" class="form-control">{{old('message')}}</textarea>
                    </div>
                    <div class="mt-2">
                        <button class="btn btn-info text-white">Invia Candidatura</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>