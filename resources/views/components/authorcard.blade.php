<div class="card mb-4" style="width: 18rem;">
    <img class="card-img-top" src="{{ Storage::url($img) }}" alt="Immagine di {{ $name }}">
    <div class="card-body">
        <h4 class="card-title">{{ $username }}</h4>
        <h5 class="card-text">{{ $phone }}</h5>
        <p class="card-text">{{ Str::limit($bio, 50) }}</p>
        <a href="{{ $hrefProfile }}" class="btn btn-primary">Vai al profilo</a>
    </div>
</div>

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
    #btn:hover,
    :focus {
        color: #ffffff;
        background: #008cff;
        border: 1px solid #008cff;
        text-shadow: 0 0 5px #ffffff, 0 0 10px #ffffff, 0 0 20px #ffffff;
        box-shadow: 0 0 5px #008cff, 0 0 20px #008cff, 0 0 50px #008cff,
        0 0 100px #008cff;
    }
</style>
