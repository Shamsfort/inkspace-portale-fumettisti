<?php

namespace App\Models\Events;

use App\Models\Article;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class UserDeleting implements ShouldQueue
{
    use SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle($user)
    {
        // Elimina tutti gli articoli associati all'utente
        $user->articles()->delete();
    }
}
