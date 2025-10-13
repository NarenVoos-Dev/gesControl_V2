<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckClientAccess
{
    /**
     * Verifica que el usuario tenga el rol 'cliente', esté enlazado a una empresa y su estado sea 'activo'.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Si por alguna razón no hay usuario autenticado (aunque 'auth' middleware debería impedirlo)
        if (!$user) {
            return redirect()->route('login');
        }

        // --- INICIO DE LAS 3 VERIFICACIONES DE ACCESO B2B ---

        // 1. Verificar Rol (Asumiendo Spatie/Roles)
        if (!$user->hasRole('cliente')) {
            return redirect()->route('acceso-denegado')->with('error-message', 'Tu cuenta no tiene los permisos necesarios para acceder al Portal B2B.');
        }

        // 2. Verificar Enlace a Cliente (client_id)
        if (!$user->client_id) {
            return redirect()->route('acceso-denegado')->with('error-message', 'Tu usuario no está enlazado a un registro de empresa Cliente.');
        }

        // 3. Verificar Estado de Aprobación ('estado' = 'activo')
        if ($user->estado !== 'activo') {
            
            $message = 'Tu solicitud de acceso al portal está **pendiente de aprobación** por parte del equipo administrativo.';
            
            // Si el estado es 'inactivo' o 'pendiente', mostramos el mensaje de espera
            if ($user->estado === 'inactivo') {
                 $message = 'Tu acceso ha sido **desactivado**. Contacta a tu administrador para reactivarlo.';
            }

            return redirect()->route('acceso-denegado')->with('error-message', $message);
        }

        // --- Si pasa las 3 verificaciones, concede el acceso al Portal ---
        return $next($request);
    }
}