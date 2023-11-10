<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliveryResource\Pages;
use App\Filament\Resources\DeliveryResource\RelationManagers;
use App\Models\Delivery;
use App\Models\Parameter;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class DeliveryResource extends Resource
{
    protected static ?string $model = Delivery::class;

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    //protected static ?string $recordTitleAttribute = 'amount';
    protected static ?string $navigationLabel = 'Cout de livraison';
    protected static ?string $navigationGroup = 'Ecommerce';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)->schema([
                    Select::make('start_id')
                    ->label('Lieu de départ')
                    ->required()
                    ->searchable()
                    ->relationship('start', 'title', fn (Builder $query) => $query->whereType_parameter_id(2))
                    ->options(Parameter::whereType_parameter_id(2)->orderBy('title', 'asc')->get()->pluck('title', 'id')),

                    Select::make('end_id')
                    ->label('Lieu d\'arrivé')
                    ->required()
                    ->searchable()
                    ->relationship('end', 'title', fn (Builder $query) => $query->whereType_parameter_id(2))
                    ->options(Parameter::whereType_parameter_id(2)->orderBy('title', 'asc')->get()->pluck('title', 'id')),

                    TextInput::make('amount')
                    ->label('Cout')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->mask(fn (TextInput\Mask $mask) => $mask
                        ->numeric()
                        ->decimalPlaces(2) // Set the number of digits after the decimal point.
                        ->decimalSeparator(',') // Add a separator for decimal numbers.
                        ->minValue(1) // Set the minimum value that the number can be.
                        ->thousandsSeparator(' '), // Add a separator for thousands.
                    )
                    ->maxLength(255),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('start.title')
                ->label('Départ')
                ->searchable()
                ->sortable(),

                Tables\Columns\TextColumn::make('end.title')
                ->label('Arrivée')
                ->searchable()
                ->sortable(),

                Tables\Columns\TextColumn::make('amount')
                ->label('Prix')
                ->money('xof'),

                TextColumn::make('created_at')
                ->label('Date')
                ->since()
                ->sortable()
                ->searchable(),
            ])
            ->defaultSort(column:'created_at', direction:'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),

                DateRangeFilter::make('created_at')
                ->label('Date de commande')
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
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListDeliveries::route('/'),
            'create' => Pages\CreateDelivery::route('/create'),
            'view' => Pages\ViewDelivery::route('/{record}'),
            'edit' => Pages\EditDelivery::route('/{record}/edit'),
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
