<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Mail\CareerRequestMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PublicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('home');
    }
    
    public function home(){
        // Fetch the latest accepted articles
        $articles = Article::with(['user:id,name,username', 'categories'])->where('is_accepted', true)
                            ->orderBy('created_at', 'desc')
                            ->take(3)
                            ->get();
        return view('welcome', compact('articles'));
    }
    
    public function careers()
    {
        return view('careers');
    }
    
    public function carreersSubmit(Request $request)
    {
        $request->validate([
            'role' =>'required',
            'email' =>'required',
            'message' =>'required',
        ]);
        $user = Auth::user();
        $role = $request->role;
        $email = $request->email;
        $message = $request->message;
        
        Mail::to(config('mail.contact_address'))->send(new CareerRequestMail(compact('user', 'role', 'email', 'message')));
        switch ($role)
        {
            case 'admin':
            $user->is_admin = null;
            $user->save();
            break;

            case'revisor':
            $user->is_revisor = null;
            $user->save();
            break;

            case 'writer':
            $user->is_writer = null;
            $user->save();
            break;

        }
        // Log::info('Modifiche utente prima del salvataggio:', ['user' => $user]);
        // $user->save();
        return redirect(route('home'))->with('message', 'La tua richiesta è stata inviata con successo');
    }
}

