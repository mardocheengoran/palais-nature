<?php

namespace App\Filament\Resources\FlashResource\Pages;

use App\Filament\Resources\FlashResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFlashes extends ListRecords
{
    protected static string $resource = FlashResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTitle(): string
    {
        return static::$title ?? __('Vente flash');
    }
}
