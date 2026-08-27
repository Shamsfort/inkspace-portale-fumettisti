<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function create(): View
    {
        return view('contact.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ]);

        Mail::to(config('mail.contact_address'))->send(new ContactMessageMail($data));
        Mail::to($data['email'])->send(new ContactMessageMail($data, true));

        return back()->with('message', 'Messaggio inviato. Ti abbiamo mandato una conferma via e-mail.');
    }
}
