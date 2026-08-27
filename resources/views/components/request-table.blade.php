{{-- @if ($roleRequests->isEmpty())
    <p>Non Ci sono Notifiche!</p>
    @else --}}
    
    
    <table class="table table-striped table-hover border">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Azioni</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roleRequests as $user)
            <tr>
                <th scope="row">{{ $user->id }}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @switch($role)
                    @case('admin')
                    <form action="{{ route('admin.setAdmin', ['user' => $user->id]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-info text-white">Attiva {{ $role }}</button>
                    </form>
                    @break
                    
                    @case('revisor')
                    <form action="{{ route('admin.setRevisor', ['user' => $user->id]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-info text-white">Attiva {{ $role }}</button>
                    </form>
                    @break
                    
                    @case('writer')
                    <form action="{{ route('admin.setWriter', ['user' => $user->id]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-info text-white">Attiva {{ $role }}</button>
                    </form>
                    @break
                    @endswitch
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{-- @endif --}}
    