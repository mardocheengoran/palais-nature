<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArticles extends ListRecords
{
    protected static string $resource = ArticleResource::class;

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

    /* protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [50, 100];
    } */
}
