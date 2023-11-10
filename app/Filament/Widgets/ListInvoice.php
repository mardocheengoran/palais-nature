<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ArticleResource;
use App\Filament\Resources\InvoiceResource;
use App\Models\Article;
use App\Models\Invoice;
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

class ListInvoice extends BaseWidget
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
        return __('Commandes');
    }

    protected function getTableQuery(): Builder
    {
        return InvoiceResource::getEloquentQuery();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('code')
                ->label('Code')
                ->searchable()
                ->sortable(),

                TextColumn::make('supplier.store')
                ->label('Fournisseur')
                ->wrap()
                ->searchable()
                ->sortable(),

                BadgeColumn::make('state.title')
                ->label('Etat')
                ->wrap()
                ->searchable()
                ->sortable()
                ->colors([
                    'info' => 'Affectée',
                    'secondary' => 'Récupérée',
                    'primary' => 'En attente',
                    'warning' => 'En cours',
                    'success' => 'Livrée',
                    'danger' => 'Annulée',
                ])
                ->icons([
                    'heroicon-o-refresh' => 'En attente',
                    'heroicon-o-user' => 'Affectée',
                    'heroicon-o-shopping-bag' => 'Récupérée',
                    'heroicon-o-document' => 'En cours',
                    'heroicon-o-x' => 'Annulée',
                    'heroicon-o-truck' => 'Livrée',
                ]),

                TextColumn::make('quantity')
                ->label('Nbr. produits')
                ->wrap()
                ->searchable()
                ->sortable(),

                BadgeColumn::make('price_final')
                ->colors(['success'])
                ->icons(['heroicon-o-currency-dollar'])
                ->label('Montant')
                ->wrap()
                ->searchable()
                ->sortable()
                ->money('xof'),

                TextColumn::make('customer.fullname')
                ->label('Client')
                ->wrap()
                ->searchable()
                ->sortable(),

                TextColumn::make('deliveryMode.title')
                ->label('Mode de livraison')
                ->wrap()
                ->toggleable()
                ->toggledHiddenByDefault()
                ->searchable()
                ->sortable(),

                TextColumn::make('address.title')
                ->label('Adresse de livraison')
                ->wrap()
                ->toggleable()
                ->toggledHiddenByDefault()
                ->searchable()
                ->sortable(),

                TextColumn::make('planned_at')
                ->since()
                ->label('Date de livraison prévue')
                ->wrap()
                ->toggleable()
                ->toggledHiddenByDefault()
                ->sortable(),

                TextColumn::make('created_at')
                ->since()
                ->label('Date')
                ->sortable(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('Voir')
                ->url(fn (Invoice $record): string => InvoiceResource::getUrl('view', ['record' => $record])),
        ];
    }
}
