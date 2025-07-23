<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    // Handle an incoming request.
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        if (!$user->isAdmin() && !$user->isModerator()) {
            abort(403, 'Accès non autorisé. Seuls les administrateurs et modérateurs peuvent accéder à cette section.');
        }

        return $next($request);
    }
}
