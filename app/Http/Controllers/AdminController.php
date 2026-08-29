<?php

namespace App\Http\Controllers;

use App\Models\AdminRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    //
    public function dashboard(): View
    {
        $adminRequests = AdminRequest::with('user:id,name,username')->where('status', 'pending')->latest()->get();
        $revisorRequests = User::whereNull('is_revisor')->orderBy('name')->get();
        $writerRequests = User::whereNull('is_writer')->orderBy('name')->get();

        return view('admin.dashboard', compact('adminRequests', 'revisorRequests', 'writerRequests'));
    }

    public function setAdmin(User $user): RedirectResponse
    {
        $user->is_admin = true;
        $user->save();
        return redirect()->route('admin.dashboard')->with('message', 'Admin Set!');
    }

    public function setRevisor(User $user): RedirectResponse
    {
        $user->is_revisor = true;
        $user->save();
        return redirect()->route('admin.dashboard')->with('message', 'Revisor Set!');
    }


    public function setWriter(User $user): RedirectResponse
    {
        $user->is_writer = true;
        $user->save();
        return redirect()->route('admin.dashboard')->with('message', 'Writer Set!');
    }
}

