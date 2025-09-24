<?php

namespace App\Filament\Resources\PurchaseResource\Pages;

use App\Filament\Resources\PurchaseResource;
use App\Filament\Resources\PurchaseResource\Widgets\PurchaseStatsOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchases extends ListRecords
{
    protected static string $resource = PurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->icon('heroicon-o-plus-circle'), // Puedes usar cualquier ícono de Heroicons,
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            PurchaseStatsOverview::class,
        ];
    }
}
