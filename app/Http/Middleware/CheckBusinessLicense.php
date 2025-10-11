<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\AuthenticationException;
use Filament\Notifications\Notification;

class CheckBusinessLicense
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Función auxiliar para manejar el logout y la notificación de forma limpia.
        $handleLogout = function (string $message, string $panelId = 'admin') {
            auth()->logout();

            Notification::make()
                ->title('Acceso Denegado')
                ->body($message)
                ->danger()
                ->send(); // Esto flashea la notificación a la sesión para la siguiente página

            // Redirigir a la página de login del panel correspondiente
            return redirect()->route("filament.{$panelId}.auth.login");
        };


        if (!$user->business) {
            return $handleLogout('Usuario no asociado a un negocio.');
        }        
        return $next($request);
    }
}