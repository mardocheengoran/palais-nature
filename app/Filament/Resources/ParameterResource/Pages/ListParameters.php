<?php

namespace App\Filament\Resources\ParameterResource\Pages;

use App\Filament\Resources\ParameterResource;
use App\Models\TypeParameter;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class ListParameters extends ListRecords
{
    protected static string $resource = ParameterResource::class;

    public $type;

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

    protected function getTitle(): string
    {
        $type = TypeParameter::find(request('type'));
        $this->type = $this->type ? $this->type : $type;
        //dd($this->big);
        return static::$title ?? __($this->type->title);
    }

    /* protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [25, 50];
    } */
}
