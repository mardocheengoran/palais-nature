<?php

namespace App\Filament\Resources\DiscountResource\Pages;

use App\Filament\Resources\DiscountResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDiscount extends ViewRecord
{
    protected static string $resource = DiscountResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
