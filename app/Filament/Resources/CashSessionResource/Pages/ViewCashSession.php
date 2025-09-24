<?php

namespace App\Filament\Resources\CashSessionResource\Pages;

use App\Filament\Resources\CashSessionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCashSession extends ViewRecord
{
    protected static string $resource = CashSessionResource::class;
    protected static string $view = 'filament.resources.cash-session-resource.pages.view-cash-session';
}
