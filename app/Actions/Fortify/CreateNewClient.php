<?php

namespace App\Actions\Fortify;

use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewClient implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Valida y crea un nuevo registro de cliente en la tabla 'clients'.
     * Retorna un User temporal para que Fortify no falle.
     *
     * @param array<string, string> $input
     * @return User
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:clients,email'],
            'type_document' => ['required', 'string', 'in:NIT,CC,CE'],
            'document' => ['required', 'string', 'max:255', 'unique:clients,document'],
            'password' => $this->passwordRules(),
            // CORRECCIÓN: Removemos la validación de terms si no lo usas
            // 'terms' => ['nullable', 'accepted'],
        ])->validate();

        return DB::transaction(function () use ($input) {
            // 1. Crear el registro del cliente con estado 'pendiente' (is_active = 0)
            $client = Client::create([
                'name' => $input['name'],
                'type_document' => $input['type_document'],
                'document' => $input['document'],
                'email' => $input['email'],
                'phone1' => $input['phone1'] ?? null,
                'address' => $input['address'] ?? null,
                'is_active' => false, // Pendiente de aprobación
            ]);

            // 2. Crear un usuario temporal CON ESTADO PENDIENTE (NO activo)
            // Este usuario NO podrá iniciar sesión hasta que el admin lo active
            $user = User::create([
                'name' => $client->name,
                'email' => $client->email,
                'password' => Hash::make($input['password']),
                'client_id' => $client->id,
                'estado' => 'inactivo', // IMPORTANTE: Estado pendiente
            ]);

            // 3. Asignar rol de cliente si usas Spatie Permissions
            $user->assignRole('cliente');

            // IMPORTANTE: Retornar el User para que Fortify no falle
            // Pero este usuario NO podrá hacer login porque está en estado 'pendiente'
             return $client; // Fortify requiere devolver el objeto creado (el cliente)
        });
    }
}