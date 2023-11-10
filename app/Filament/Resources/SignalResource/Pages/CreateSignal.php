<?php

namespace App\Filament\Resources\SignalResource\Pages;

use App\Filament\Resources\SignalResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSignal extends CreateRecord
{
    protected static string $resource = SignalResource::class;

    protected function getTitle(): string
    {
        return static::$title ?? __('Produits signalés');
    }

}
