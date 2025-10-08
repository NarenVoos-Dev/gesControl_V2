<x-guest-layout>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .brand-gradient {
            background: linear-gradient(135deg, #0f4db3 0%, #028dff 100%);
        }
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .pulse-glow {
            box-shadow: 0 0 20px rgba(15, 77, 179, 0.3);
            animation: pulse-glow 2s infinite;
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(15, 77, 179, 0.3); }
            50% { box-shadow: 0 0 30px rgba(15, 77, 179, 0.5); }
        }
        .input-focus:focus {
            border-color: #0f4db3;
            box-shadow: 0 0 0 3px rgba(15, 77, 179, 0.1);
            outline: none;
        }
        .btn-primary-custom {
            background: linear-gradient(135deg, #0f4db3 0%, #028dff 100%);
            transition: all 0.3s ease;
        }
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(15, 77, 179, 0.3);
        }
        .medical-pattern {
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(156, 209, 254, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(2, 141, 255, 0.1) 0%, transparent 50%);
        }
    </style>

    <div class="min-h-screen flex">
        <!-- Columna Izquierda: Branding -->
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden brand-gradient">
            <div class="absolute inset-0 medical-pattern"></div>
            
            <!-- Elementos decorativos flotantes -->
            <div class="absolute top-20 left-10 w-16 h-16 bg-white bg-opacity-10 rounded-full floating-animation"></div>
            <div class="absolute top-20 right-50 w-8 h-8 bg-white bg-opacity-20 rounded-full floating-animation" style="animation-delay: -2s;"></div>
            <div class="absolute bottom-40 left-20 w-12 h-12 bg-white bg-opacity-15 rounded-full floating-animation" style="animation-delay: -4s;"></div>
            
            <div class="relative z-10 flex flex-col justify-center items-center p-12 text-white">
                <!-- Logo Principal -->
                <div class="mb-8 pulse-glow rounded-full p-4 bg-white bg-opacity-10">
                    <img src="{{ asset('img/logoNavbar.jpg') }}" alt="Logo JF Products" class="rounded-full object-cover bg-white p-1" style="width: 200px; height: 80px;">
                </div>
                
                <!-- Contenido Principal -->
                <div class="text-center max-w-md">
                    <h1 class="text-4xl font-bold mb-4 leading-tight">
                        Portal Institucional
                        <span class="block text-2xl font-medium text-blue-200 mt-2">JF Products SAS</span>
                    </h1>
                    
                    <p class="text-lg mb-6 text-blue-100 leading-relaxed">
                        Accede a nuestro catálogo completo, verifica inventario en tiempo real y gestiona tus pedidos institucionales con total confianza.
                    </p>
                    
                    <!-- Características destacadas -->
                    <div class="space-y-3 mb-8">
                        <div class="flex items-center justify-center space-x-3">
                            <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                            <span class="text-sm text-blue-100">Inventario en tiempo real</span>
                        </div>
                        <div class="flex items-center justify-center space-x-3">
                            <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                            <span class="text-sm text-blue-100">Gestión de pedidos institucionales</span>
                        </div>
                        <div class="flex items-center justify-center space-x-3">
                            <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                            <span class="text-sm text-blue-100">Soporte especializado</span>
                        </div>
                    </div>
                    
                    <blockquote class="text-sm italic text-blue-200 border-l-2 border-blue-300 pl-4">
                        "Distribuimos insumos y medicamentos de uso institucional con los más altos estándares de calidad."
                    </blockquote>
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Formulario de Login -->
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-20 xl:px-24 bg-gray-50">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <!-- Header del formulario -->
                <div class="text-center mb-8">
                    <!-- Logo móvil -->
                    <div class="lg:hidden mb-6">
                        <img src="{{ asset('img/logoNavbar.jpg') }}" alt="Logo JF Products" class=" mx-auto rounded-full object-cover shadow-lg" style="width: 150px; height: 60px;">
                    </div>
                    
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Bienvenido</h2>
                    <p class="text-gray-600 mb-1">Ingreso para Clientes Autorizados</p>
                    <p class="text-sm text-gray-500">¿No tienes acceso? Contacta a tu representante de ventas</p>
                </div>

                <!-- Validación de errores -->
                <x-validation-errors class="mb-4" />

                @if (session('status'))
                    <div class="mb-4 p-4 rounded-lg text-sm text-center bg-green-50 border border-green-200 text-green-800">
                        {{ session('status') }}
                    </div>
                @endif
                
                <!-- Formulario -->
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Campo Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Correo Electrónico
                        </label>
                        <div class="relative">
                            
                            <input 
                                id="email" 
                                name="email" 
                                type="email" 
                                required 
                                autofocus 
                                autocomplete="username" 
                                value="{{ old('email') }}"
                                class="input-focus block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                placeholder="tu@empresa.com"
                            >
                        </div>
                    </div>

                    <!-- Campo Contraseña -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Contraseña
                        </label>
                        <div class="relative">
                        
                            <input 
                                id="password" 
                                name="password" 
                                type="password" 
                                required 
                                autocomplete="current-password"
                                class="input-focus block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                placeholder="••••••••"
                            >
                            <button 
                                type="button" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                onclick="togglePassword()"
                            >
                                <svg id="eye-icon" class="h-5 w-5 text-gray-400 hover:text-gray-600 cursor-pointer transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Recordar sesión y recuperar contraseña -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input 
                                id="remember-me" 
                                name="remember" 
                                type="checkbox" 
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                            >
                            <label for="remember-me" class="ml-2 block text-sm text-gray-700">
                                Recordar sesión
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" class="font-medium text-blue-600 hover:text-blue-500 transition duration-200">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Botón de ingreso -->
                    <div>
                        <button 
                            type="submit" 
                            class="btn-primary-custom w-full justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            Ingresar al Portal
                        </button>
                    </div>
                    <div class="mt-6 text-center">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-sm font-medium text-[#028dff] hover:text-[#0f4db3] underline">
                                Registrar mi empresa (Solicitar Acceso)
                            </a>
                        @endif
                    </div>
                </form>

                <!-- Footer -->
                <div class="mt-8 text-center">
                    <p class="text-xs text-gray-500">
                        © 2024 JF Products SAS. Todos los derechos reservados.
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        Portal seguro para clientes institucionales
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/>
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            }
        }

        // Animación de entrada suave
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            if (form) {
                form.style.opacity = '0';
                form.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    form.style.transition = 'all 0.6s ease';
                    form.style.opacity = '1';
                    form.style.transform = 'translateY(0)';
                }, 300);
            }
        });
    </script>
</x-guest-layout>