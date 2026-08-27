<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class adminController extends Controller
{
    //
    public function dashboard()
    {
        
        $adminRequests = User::whereNull('is_admin')->get();
        $revisorRequests = User::whereNull('is_revisor')->get();
        $writerRequests = User::whereNull('is_writer')->get();
        
        return view('admin.dashboard', compact('adminRequests', 'revisorRequests', 'writerRequests'));
        
    }

    public function setAdmin(User $user)
    {
        $user->is_admin = true;
        $user->save();
        return redirect()->route('admin.dashboard')->with('message', 'Admin Set!');
    }

    public function setRevisor(User $user)
    {
        $user->is_revisor = true;
        $user->save();
        return redirect()->route('admin.dashboard')->with('message', 'Revisor Set!');
    }


    public function setWriter(User $user)
    {
        $user->is_writer = true;
        $user->save();
        return redirect()->route('admin.dashboard')->with('message', 'Writer Set!');
    }
}
