<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $bootstrapEmail = mb_strtolower(trim((string) config('app.admin_email')));

        if ($user && ! $user->is_admin && $bootstrapEmail !== '' && mb_strtolower($user->email) === $bootstrapEmail) {
            $user->forceFill(['is_admin' => true])->save();
        }

        if ($user && $user->is_admin) {
            return $next($request);
        }

        return redirect()->route('home')->with('message', 'Non sei autorizzato ad accedere a questa pagina');
    }
}

