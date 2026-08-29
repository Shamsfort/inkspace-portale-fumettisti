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
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Utente</th>
                                <th>Stato</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($adminRequests as $request)
                                <tr>
                                    <td>{{ $request->user?->username ?? $request->user?->name }}</td>
                                    <td>{{ $request->status }}</td>
                                    <td class="d-flex gap-2">
                                        <form method="POST" action="{{ route('community-admin.admin-requests.approve', $request) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-sm btn-success">Approva</button>
                                        </form>
                                        <form method="POST" action="{{ route('community-admin.admin-requests.reject', $request) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-sm btn-outline-danger">Rifiuta</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">Nessuna richiesta disponibile.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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

