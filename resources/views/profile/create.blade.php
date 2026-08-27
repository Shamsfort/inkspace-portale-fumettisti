<x-layout>
    @guest
            <div class="container-fluid card">
                <div class="card-header">
                    Crea il Tuo Profilo
                </div>
                <div class="card-body">
                    <form action="{{route('profile.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nickname</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
        
                        <div class="mb-3">
                            <label for="phone" class="form-label">Numero di Telefono</label>
                            <input type="number" class="form-control" id="phone" name="phone">
                        </div>
            
                        <div class="mb-3">
                            <label for="company_address" class="form-label">Indirizzo della Società</label>
                            <input type="text" class="form-control" id="company_address" name="company_address">
                        </div>
        
                        {{-- <div class="mb-3">
                            <label for="img" class="form-label">Immagine Profilo</label>
                            <input type="file" class="form-control" id="img" name="img">
                        </div> --}}
            
                        <div class="mb-3">
                            <label for="short_description" class="form-label">Breve Descrizione</label>
                            <textarea class="form-control" id="short_description" name="short_description"></textarea>
                        </div>
            
                        <button type="submit" class="btn btn-primary">Crea Profilo</button>
                    </form>
                </div>
            </div>
            
    @endguest
    
    @auth
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <h1 class="display-1">hai già creato un account!</h1>
                <p>Torna al tuo <a href="{{route('profile.show')}}">Account!</a></p>
            </div>
        </div>
    @endauth
    </div>
    </x-layout>