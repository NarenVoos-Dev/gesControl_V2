<x-guest-layout>
    <link rel="stylesheet" href="{{ asset('css/branding.css') }}"> 
    <style>
        .brand-text { color: #0f4db3; }
        .input-focus:focus { 
            border-color: #0f4db3; 
            box-shadow: 0 0 0 3px rgba(15, 77, 179, 0.1); 
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

    <x-authentication-card>
        <x-slot name="logo">
            <img class="w-20 h-20 mx-auto rounded-full shadow-md" style="width: 100px;height: 100px;" src="{{ asset('img/logoNavbar.jpg') }}" alt="Logo JF Products">
        </x-slot>
        
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Registro de Empresa Cliente</h2>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- 1. NOMBRE DE LA EMPRESA -->
            <div>
                <x-label for="name" value="{{ __('Nombre de la Empresa/Cliente') }}" />
                <x-input id="name" class="block mt-1 w-full input-focus" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <!-- 2. DOCUMENTOS DE LA EMPRESA (Tipo y Número) -->
            <div class="mt-4 grid grid-cols-3 gap-4">
                <div class="col-span-1">
                    <x-label for="type_document" value="{{ __('Tipo Documento') }}" />
                    <select id="type_document" name="type_document" required
                        class="block mt-1 w-full border-gray-300 focus:border-[#0f4db3] focus:ring-[#0f4db3] rounded-md shadow-sm">
                        <option value="NIT" {{ old('type_document') === 'NIT' ? 'selected' : '' }}>NIT</option>
                        <option value="CC" {{ old('type_document') === 'CC' ? 'selected' : '' }}>Cédula (CC)</option>
                        <option value="CE" {{ old('type_document') === 'CE' ? 'selected' : '' }}>Cédula Extranjería (CE)</option>
                    </select>
                </div>
                <div class="col-span-2">
                    <x-label for="document" value="{{ __('Documento / NIT') }}" />
                    <x-input id="document" class="block mt-1 w-full input-focus" type="text" name="document" :value="old('document')" required autocomplete="off" />
                </div>
            </div>

            <!-- 3. CORREO ELECTRÓNICO (Usado para el login) -->
            <div class="mt-4">
                <x-label for="email" value="{{ __('Correo Electrónico') }}" />
                <x-input id="email" class="block mt-1 w-full input-focus" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <!-- 4. CONTRASEÑA -->
            <div class="mt-4">
                <x-label for="password" value="{{ __('Contraseña') }}" />
                <x-input id="password" class="block mt-1 w-full input-focus" type="password" name="password" required autocomplete="new-password" />
            </div>

            <!-- 5. CONFIRMACIÓN DE CONTRASEÑA -->
            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirmar Contraseña') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full input-focus" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <!-- 6. TELÉFONO (OPCIONAL) -->
            <div class="mt-4">
                <x-label for="phone1" value="{{ __('Teléfono de Contacto (Opcional)') }}" />
                <x-input id="phone1" class="block mt-1 w-full input-focus" type="tel" name="phone1" :value="old('phone1')" />
            </div>

            <!-- 7. DIRECCIÓN (OPCIONAL) -->
            <div class="mt-4">
                <x-label for="address" value="{{ __('Dirección (Opcional)') }}" />
                <x-input id="address" class="block mt-1 w-full input-focus" type="text" name="address" :value="old('address')" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" class="border-gray-300 text-brand-text focus:ring-brand-text rounded"/>
                            <div class="ms-2 text-sm text-gray-600">
                                {!! __('Acepto la :terms_of_service y la :privacy_policy', [
                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm brand-text hover:text-gray-900 focus:ring-indigo-500">'.__('política de términos').'</a>',
                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm brand-text hover:text-gray-900 focus:ring-indigo-500">'.__('política de privacidad').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-between mt-6">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('¿Ya estás registrado? Inicia Sesión') }}
                </a>

                <x-button class="btn-primary-custom">
                    {{ __('Solicitar Acceso') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>