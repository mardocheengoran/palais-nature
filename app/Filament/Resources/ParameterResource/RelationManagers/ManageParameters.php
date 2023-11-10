<?php

namespace App\Filament\Resources\ParameterResource\RelationManagers;

use App\Filament\Resources\ParameterResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageParameters extends ManageRecords
{
    protected static string $resource = ParameterResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
