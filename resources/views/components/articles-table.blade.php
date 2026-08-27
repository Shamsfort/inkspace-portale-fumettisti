
    <table class="table table-striped table-hover border">
        <thead class="table-dark">
            <tr>
                <th scope="col-12">#</th>
                <th scope="col-12">Titolo</th>
                <th scope="col-12">Sottotitolo</th>
                <th scope="col-12">Autore</th>
                <th scope="col-12">Azioni</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($articles as $article)
            <tr>
                <th scope="row"> {{$article->id}} </th>
                <td>{{$article->title}}</td>
                <td> {{$article->subtitle}} </td>
                <td> {{$article->author}} </td>
                <td>
                    @if (is_null($article->is_accepted))
                    <a href="{{route('article.show', compact('article')) }}" class="btn btn-info text-white">Leggi l'articolo</a>
                    @else
                    <form action="{{route('revisor.undo', compact('article'))}}" method="POST">
                        @csrf
                        <button class="btn btn-info text-white">Riporta in revisione</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
   
    