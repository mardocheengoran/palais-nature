<?php

namespace App\Filament\Resources\SignalResource\Pages;

use App\Filament\Resources\SignalResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSignal extends ViewRecord
{
    protected static string $resource = SignalResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
