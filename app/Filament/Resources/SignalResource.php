<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SignalResource\Pages;
use App\Filament\Resources\SignalResource\RelationManagers;
use App\Models\Signal;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class SignalResource extends Resource
{
    protected static ?string $model = Signal::class;

    protected static ?string $navigationIcon = 'heroicon-o-ban';
    protected static ?string $navigationLabel = 'Produits signalés';
    protected static ?string $navigationGroup = 'Ecommerce';

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'warning' : 'primary';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('article.code')
                ->label('Code article'),

                Tables\Columns\TextColumn::make('article.title')
                ->label('Nom article'),

                Tables\Columns\TextColumn::make('userCreated.fullname')
                ->label('Signalé par'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date de signalement')
                    ->since(),
            ])
            ->filters([

                // SelectFilter::make('Etat')
                // ->relationship('state', 'title', fn (Builder $query)
                //     => $query->where([
                //         'type_parameter_id' => 22,
                //     ])
                //     ->whereIn('id', [48, 49, 50, 51, 52])
                // )
                // ->multiple()
                // ->default([48, 49, 50, 51, 52, 269]),

                Tables\Filters\SelectFilter::make('customer_id')
                ->label('Client')
                ->relationship('userCreated', 'first_name'),

                // Tables\Filters\SelectFilter::make('supplier_id')
                // ->label('Fournisseur')
                // ->relationship('supplier', 'first_name'),

                // Tables\Filters\SelectFilter::make('delivery_mode_id')
                // ->label('Mode de livraison')
                // ->relationship('deliveryMode', 'title', fn (Builder $query) => $query->whereId([
                //      175
                // ])),


                DateRangeFilter::make('created_at')
                ->label('Date d\'ajout')
                //Default Start Date
                //->startDate(Carbon::now())
                //Default EndDate
                //->endDate(Carbon::now())
                ->firstDayOfWeek(1)

                ->setTimePickerOption(true)
                ->setTimePickerIncrementOption(2)
                //No need for Apply button
                ->setAutoApplyOption(true)
                //Show two Calendars
                ->setLinkedCalendarsOption(true)
                //Filament Date Format (PHP)
                ->displayFormat('YYYY-MM-DD')
                //Picker dddd D MMMM YYYY (Javascript)
                //Updating Query
                ->query(
                    function (Builder $query, array $data) {
                        $created_from = substr($data['created_at'], 0, 10);
                        $created_until = substr($data['created_at'], 13, 10);
                        //dd($created_from, $created_until);
                        return $query->when(
                            $created_from,
                            function (Builder $query) use($created_from): Builder {
                                //dd($created_from);
                                return $query->whereDate('created_at', '>=', $created_from);
                            }
                            //fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $created_until,
                            function (Builder $query) use($created_until): Builder {
                                return $query->whereDate('created_at', '<=', $created_until);
                            }
                            //fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                        //return $query->where('created_at', '>=','created_at');
                    }
                    //fn(Builder $query) => $query->where('created_at', '<=','created_at')
                )->withIndicator(),

                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
               //
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSignals::route('/'),
            'create' => Pages\CreateSignal::route('/create'),
            'view' => Pages\ViewSignal::route('/{record}'),
            'edit' => Pages\EditSignal::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
