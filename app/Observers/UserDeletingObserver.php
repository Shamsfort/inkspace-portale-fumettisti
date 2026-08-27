<?php
namespace App\Observers;

use App\Models\User;

class UserDeletingObserver
{
    public function deleting(User $user)
    {
        $user->articles()->delete();
    }
}