<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPosAccess
{
    /**
     * Verifica que el usuario autenticado tenga permiso de acceso B2B.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // 1. Verificación B2B
        // Si el usuario no tiene un negocio asignado O el acceso B2B no está activado
        if (!$user->business || !$user->business->has_pos_access) {
            
            // Redirige al cliente a la página de acceso denegado con un mensaje.
            // Esto evita que el usuario vea un error de servidor.
            return redirect()->route('acceso-denegado')->with('error-message', 'Tu cuenta está pendiente de aprobación. Por favor, espera la activación de un administrador.');
        }

        // Si el usuario tiene acceso (está autorizado), permite la solicitud.
        return $next($request);
    }
}
