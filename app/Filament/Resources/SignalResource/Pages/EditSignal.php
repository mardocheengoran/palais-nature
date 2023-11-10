<?php

namespace App\Filament\Resources\SignalResource\Pages;

use App\Filament\Resources\SignalResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSignal extends EditRecord
{
    protected static string $resource = SignalResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
