
    <div>
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="{{ Storage::url($img) }}" alt="Card image cap">
            <div class="card-body">
                <h4 class="card-title">{{ $title }}</h4>
                <h5 class="card-text">{{ $subtitle }}</h5>
                <p class="card-text">{{ Str::limit($body, 10) }}</p>
                <h5 class="text-danger ">TAGS:</h5>
                <div></div>
                @forelse ($tags as $tag)
                    <small class="">#{{ $tag->name }} </small>
                @empty
                    <p>Questo articolo non ha Tags.</p>
                @endforelse
                <span>Pubblicato da: 
                    @if($writer)
                        <a href="{{ $profile }}" style="text-decoration: none;">{{ $writer }}</a>
                    @else
                        Unknown Author
                    @endif
                </span>
            </div>
            <button id="btnx" style="background-color: rgb(0, 140, 255);">
                <a href="{{ $hrefShow }}" class="leggianchorindex">Vai al dettaglio</a>
            </button>
    
            <style>
                button {
                    padding: 10px 20px !important;
                    text-transform: uppercase;
                    border-radius: 8px;
                    font-size: 17px;
                    font-weight: 500;
                    color: #ffffff80;
                    text-shadow: none;
                    background: transparent;
                    cursor: pointer;
                    box-shadow: transparent;
                    border: 1px solid #ffffff80;
                    transition: 0.5s ease;
                    user-select: none;
                }
                .leggianchorindex {
                    text-decoration: none;
                    color: whitesmoke;
                }
                
            </style>        
        </div>
    </div>
    