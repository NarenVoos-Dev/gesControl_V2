<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    /**
     * Definir los tabs para filtrar usuarios
     */
    public function getTabs(): array
    {
        $businessId = auth()->user()->business_id;

        return [
            /*'todos' => Tab::make('Todos')
                ->badge(User::where('business_id', $businessId)->count()),*/

            'admin_vendedores' => Tab::make('Administradores')
                ->badge(User::where('business_id', $businessId)->whereNull('client_id')->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('client_id')),

            'clientes_b2b' => Tab::make('Clientes (Portal)')
                ->badge(User::where('business_id', NULL)
                    ->whereNotNull('client_id')
                    ->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNotNull('client_id')),
        ];
    }
}