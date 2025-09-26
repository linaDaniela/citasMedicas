<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Administrador;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario autenticado es una instancia de Administrador
        if ($request->user() instanceof Administrador) {
            return $next($request);
        }

        return response()->json(['message' => 'Acceso no autorizado. Solo administradores.'], 403);
    }
}