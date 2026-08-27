<x-layout>
    
    
    <div class="container-fluid p-5 bg-info text-center text-white">
        <div class="row justify-content-center">
            <h1 class="display-1">Bentornato Admin</h1>
        </div>
    </div>
    
    @if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        </button>
    </div>
    @endif
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2>
                    Richieste di Amministrazione
                </h2>
                <x-request-table
                :roleRequests="$adminRequests" role="admin"
                />
            </div>
        </div>
        
        
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h2>
                        Richieste di Scrittore
                    </h2>
                    <x-request-table
                    :roleRequests="$writerRequests" role="writer"
                    />
                </div>
            </div>
        </div>
        
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h2>
                        Richieste di Revisore
                    </h2>
                    <x-request-table
                    :roleRequests="$revisorRequests" role="revisor"
                    />
                </div>
            </div>
        </div>
    </div>
    </x-layout>