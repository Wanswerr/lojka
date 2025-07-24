<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            // Verifica se a rota que o usuário tentou acessar pertence ao grupo 'admin'
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            }
            
            // Para todas as outras rotas, mantém o comportamento padrão
            return route('login');
        }

        return null;
    }
}