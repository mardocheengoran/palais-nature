<?php

namespace App\Filament\Resources\TypeParameterResource\Pages;

use App\Filament\Resources\TypeParameterResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTypeParameter extends ListRecords
{
    protected static string $resource = TypeParameterResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function isTablePaginationEnabled(): bool
    {
        return true;
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [50, 100];
    }
}
