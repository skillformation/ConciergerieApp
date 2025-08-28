<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('filament.admin.auth.login');
        }

        $user = auth()->user();

        // Vérifier si l'utilisateur est actif
        if (!$user->is_active) {
            auth()->logout();
            return redirect()->route('filament.admin.auth.login')
                ->withErrors(['email' => 'Votre compte est désactivé. Contactez l\'administrateur.']);
        }

        // Si aucun rôle n'est spécifié, on accepte tous les utilisateurs authentifiés et actifs
        if (empty($roles)) {
            return $next($request);
        }

        // Vérifier si l'utilisateur a l'un des rôles requis
        if ($user->hasAnyRole($roles)) {
            return $next($request);
        }

        // Si l'utilisateur n'a pas les permissions, rediriger avec un message d'erreur
        abort(403, 'Accès refusé. Vous n\'avez pas les permissions nécessaires.');
    }
}