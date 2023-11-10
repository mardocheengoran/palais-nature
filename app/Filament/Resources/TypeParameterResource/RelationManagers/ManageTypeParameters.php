<?php

namespace App\Filament\Resources\TypeParameterResource\RelationManagers;

use App\Filament\Resources\TypeParameterResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTypeParameters extends ManageRecords
{
    protected static string $resource = TypeParameterResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
