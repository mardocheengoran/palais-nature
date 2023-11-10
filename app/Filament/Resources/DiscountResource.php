<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DiscountResource\Pages;
use App\Filament\Resources\DiscountResource\RelationManagers;
use App\Models\Discount;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DiscountResource extends Resource
{
    protected static ?string $model = Discount::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark';
    protected static ?string $navigationLabel = 'Codes de réduction';
    protected static ?string $navigationGroup = 'Ecommerce';

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Group::make()
                    ->schema([
                        Card::make()
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                ->label('Intitulé')
                                ->maxLength(255)
                                ->required(),

                                Forms\Components\DateTimePicker::make('limit_at')
                                ->label('Date limite')
                                ->required(),

                                Forms\Components\RichEditor::make('content')
                                ->label('Description'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Group::make()
                    ->schema([
                    Card::make()
                        ->schema([
                            Forms\Components\Select::make('type')
                            ->options([
                                'percent' => 'Pourcentage',
                                'amount' => 'Montant',
                            ])
                            ->afterStateUpdated(function (Closure $set, Closure $get) {
                                if($get('type') == 'percent') {
                                    $set('percent', null);
                                }
                                if($get('type') == 'amount') {
                                    $set('amount', null);
                                }
                            })
                            ->reactive()
                            ->label('Type')
                            ->required(),

                            Forms\Components\TextInput::make('percent')
                            ->label('Pourcentage')
                            ->placeholder('En %')
                            ->numeric()
                            ->minValue(1)
                            ->mask(fn (TextInput\Mask $mask) => $mask
                                ->numeric()
                                ->decimalPlaces(2) // Set the number of digits after the decimal point.
                                ->decimalSeparator(',') // Add a separator for decimal numbers.
                                ->minValue(1) // Set the minimum value that the number can be.
                                ->thousandsSeparator(' '), // Add a separator for thousands.
                            )
                            ->visible(fn (Closure $get): bool => $get('type') == 'percent'),

                            TextInput::make('amount')
                            ->label('Montant de la reduction')
                            ->placeholder('En Fcfa')
                            ->numeric()
                            ->minValue(1)
                            ->mask(fn (TextInput\Mask $mask) => $mask
                                ->numeric()
                                ->decimalPlaces(2) // Set the number of digits after the decimal point.
                                ->decimalSeparator(',') // Add a separator for decimal numbers.
                                ->minValue(1) // Set the minimum value that the number can be.
                                ->thousandsSeparator(' '), // Add a separator for thousands.
                            )
                            ->visible(fn (Closure $get): bool => $get('type') == 'amount'),

                            Forms\Components\TextInput::make('min')
                            ->label('Montant minimum de la commande')
                            ->numeric()
                            ->minValue(1)
                            ->mask(fn (TextInput\Mask $mask) => $mask
                                ->numeric()
                                ->decimalPlaces(2) // Set the number of digits after the decimal point.
                                ->decimalSeparator(',') // Add a separator for decimal numbers.
                                ->minValue(1) // Set the minimum value that the number can be.
                                ->thousandsSeparator(' '), // Add a separator for thousands.
                            )
                            ->placeholder('En Fcfa'),
                        ])
                    ])
                ->columnSpan(['lg' => 1])
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code'),

                Tables\Columns\TextColumn::make('Intitulé'),

                Tables\Columns\TextColumn::make('Pourcentage'),

                Tables\Columns\TextColumn::make('Montant'),

                Tables\Columns\TextColumn::make('Mt minimum'),

                Tables\Columns\TextColumn::make('Expiration')
                ->dateTime(),

                Tables\Columns\TextColumn::make('created_at')
                ->label('Date de création')
                ->since(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
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
            'index' => Pages\ListDiscounts::route('/'),
            'create' => Pages\CreateDiscount::route('/create'),
            'view' => Pages\ViewDiscount::route('/{record}'),
            'edit' => Pages\EditDiscount::route('/{record}/edit'),
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
