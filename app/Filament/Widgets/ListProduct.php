<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ArticleResource;
use App\Models\Article;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Widgets\Widget;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cookie;

class ListProduct extends BaseWidget
{
    //protected static string $view = 'filament.resources.need-resource.widgets.list-need';

    /* protected function getWidgets(): array
    {
        return [
            //Filament::getWidgets(),
            ListProduct::class,
        ];
    } */

    protected static ?int $sort = 2;

    protected function getColumns(): int | array
    {
        return 2;
    }

    public function getDefaultTableRecordsPerPageSelectOption(): int
    {
        return 10;
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'created_at';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }

    protected function getTableHeading(): string
    {
        return __('Produits');
    }

    protected function getTableQuery(): Builder
    {
        return ArticleResource::getEloquentQuery()
        ->when(auth()->user()->hasRole(['fournisseur']), function($q){
            $q->whereSupplier_id(auth()->user()->id);
        })
        ->whereRubric_id(125)
        ->withoutGlobalScopes([
            SoftDeletingScope::class,
        ]);
    }

    protected function getTableColumns(): array
    {
        return [
            SpatieMediaLibraryImageColumn::make('image')
            ->conversion('thumb')
            ->collection('image'),

            TextColumn::make('title')
            ->label('Titre')
            ->wrap()
            ->searchable()
            ->sortable(),

            TextColumn::make('sizes.title')
            ->searchable()
            ->toggleable()
            ->toggledHiddenByDefault()
            ->sortable()
            ->label('Tailles')
            ->visible(Cookie::get('rubric') == 125),

            BadgeColumn::make('active_size')
            ->label('Taille')
            ->sortable()
            ->enum([
                1 => 'Oui',
                null => 'Non',
            ])
            ->colors([
                'success' => 1,
                'warning' => null,
            ]),

            TextColumn::make('quantity')
            ->label('Quantité')
            ->sortable(),

            TextColumn::make('categories.title')
            ->searchable()
            ->sortable()
            ->label('Catégories'),

            TextColumn::make('price_new')
            ->label('Prix')
            ->toggleable()
            ->toggledHiddenByDefault()
            ->money('xof'),

            BadgeColumn::make('available.title')
            ->label('Disponibilité')
            ->toggleable()
            ->toggledHiddenByDefault()
            ->colors([
                'danger' => 'Rupture',
                'warning' => 'Bientôt',
                'success' => fn ($state) => in_array($state, ['delivered', 'Disponible']),
            ]),

            ToggleColumn::make('enable')
            ->label('Cacher')
            ->toggleable()
            ->toggledHiddenByDefault(),

            TextColumn::make('created_at')
            ->label('Date création')
            ->since(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('Modifier')
                ->url(fn (Article $record): string => ArticleResource::getUrl('edit', ['record' => $record])),
        ];
    }
}
