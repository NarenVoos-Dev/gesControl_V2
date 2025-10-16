<?php

namespace App\Filament\Resources\LocationResource\Pages;

use App\Filament\Resources\LocationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Location;

class CreateLocation extends CreateRecord
{
    protected static string $resource = LocationResource::class;

     // Este método se ejecuta DESPUÉS de que la nueva bodega ha sido creada.
    protected function afterCreate(): void
    {
        // Obtenemos el registro que acabamos de crear
        $record = $this->getRecord();

        // Si marcamos esta nueva bodega como la del catálogo B2B...
        if ($record->is_b2b_warehouse) {
            // ...buscamos todas las OTRAS bodegas y les quitamos la marca.
            Location::where('id', '!=', $record->id)
                ->where('business_id', $record->business_id)
                ->update(['is_b2b_warehouse' => false]);
        }
    }
}
