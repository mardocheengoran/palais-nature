<?php

namespace App\Filament\Resources\FlashResource\Pages;

use App\Filament\Resources\FlashResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFlash extends ViewRecord
{
    protected static string $resource = FlashResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
