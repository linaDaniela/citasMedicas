<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Administrador;
use App\Models\Medicos;
use App\Models\Pacientes;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        // Determinar el rol basado en el tipo de modelo
        $userRole = null;
        if ($user instanceof Administrador) {
            $userRole = 'administrador';
        } elseif ($user instanceof Medicos) {
            $userRole = 'medico';
        } elseif ($user instanceof Pacientes) {
            $userRole = 'paciente';
        }

        if (!$userRole || !in_array($userRole, $roles)) {
            return response()->json(['error' => 'No tienes permisos'], 403);
        }

        return $next($request);
    }
}