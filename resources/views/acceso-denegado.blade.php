<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Pendiente - JF Products SAS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .brand-gradient { 
            background: linear-gradient(135deg, #0f4db3 0%, #028dff 100%); 
        }
        .btn-primary-custom {
            background: linear-gradient(135deg, #0f4db3 0%, #028dff 100%);
            transition: all 0.3s ease;
        }
        .btn-primary-custom:hover {
            box-shadow: 0 5px 15px rgba(15, 77, 179, 0.4);
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="h-full bg-gray-50 flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-xl shadow-2xl overflow-hidden transform hover:scale-[1.01] transition duration-300">
        
        <!-- Header con Branding -->
        <div class="brand-gradient p-8 text-white text-center">
            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.948 3.376c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.007H12v-.007z" />
            </svg>
            <h1 class="text-3xl font-bold">Acceso Pendiente</h1>
        </div>
        
        <!-- Cuerpo del Mensaje -->
        <div class="p-8 text-center">
            <p class="text-gray-700 mb-6 font-medium">
                <!-- Muestra el mensaje enviado por el middleware -->
                {{ session('error-message') ?: 'Tu cuenta requiere validación. El acceso al Portal B2B está pendiente de aprobación por parte de nuestro equipo.' }}
            </p>
            
            <p class="text-sm text-gray-500 mb-6">
                Te notificaremos por correo electrónico una vez que tu solicitud sea revisada y tu acceso sea activado.
            </p>
            
            <!-- Botón de Cerrar Sesión -->
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="btn-primary-custom inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white shadow-md">
                Cerrar Sesión
            </a>
            
            <div class="mt-4 text-xs text-gray-400">
                ¿Intentas acceder como administrador? <a href="{{ route('filament.admin.auth.login') }}" class="text-blue-500 hover:underline">Ir al panel de administración.</a>
            </div>
        </div>
    </div>
    
    <!-- Formulario de Logout oculto para seguridad -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</body>
</html>
