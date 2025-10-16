<?php

namespace App\Filament\Resources\LocationResource\Pages;

use App\Filament\Resources\LocationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\Location;

class EditLocation extends EditRecord
{
    protected static string $resource = LocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

     // Este método se ejecuta DESPUÉS de que se guardan los cambios en una bodega.
    protected function afterSave(): void
    {
        // Obtenemos el registro que acabamos de editar
        $record = $this->getRecord();

        // Si marcamos esta bodega como la del catálogo B2B...
        if ($record->is_b2b_warehouse) {
            // ...buscamos todas las OTRAS bodegas y les quitamos la marca.
            Location::where('id', '!=', $record->id)
                ->where('business_id', $record->business_id)
                ->update(['is_b2b_warehouse' => false]);
        }
    }
}
