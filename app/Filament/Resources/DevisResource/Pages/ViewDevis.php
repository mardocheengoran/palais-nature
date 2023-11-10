<?php

namespace App\Filament\Resources\DevisResource\Pages;

use App\Filament\Resources\DevisResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDevis extends ViewRecord
{
    protected static string $resource = DevisResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
