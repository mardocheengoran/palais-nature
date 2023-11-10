<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DevisResource\Pages;
use App\Filament\Resources\DevisResource\RelationManagers;
use App\Models\Devis;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class DevisResource extends Resource
{
    protected static ?string $model = Devis::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->maxLength(255),
                TextInput::make('entreprise')
                    ->maxLength(255),
                TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                TextInput::make('nature')
                    ->maxLength(255),
                TextInput::make('hscode')
                    ->maxLength(255),
                TextInput::make('poids')
                    ->maxLength(255),
                TextInput::make('shipping')
                    ->maxLength(255),
                TextInput::make('conteneur')
                    ->maxLength(255),
                TextInput::make('port')
                    ->maxLength(255),
                TextInput::make('enlevement')
                    ->maxLength(255),
                TextInput::make('dechargement')
                    ->maxLength(255),
                TextInput::make('livraison')
                    ->maxLength(255),
                Textarea::make('commentaire'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('entreprise'),

                TextColumn::make('phone')
                ->label('Téléphone'),

                TextColumn::make('email'),

                TextColumn::make('nature')
                ->label('Nature de la marchandise'),

                TextColumn::make('hscode')
                ->label('HS Code')
                ->toggleable()
                ->toggledHiddenByDefault(),

                TextColumn::make('poids'),

                TextColumn::make('shipping')
                ->label('Shipping Terms'),

                TextColumn::make('conteneur')
                ->label('Type de conteneur'),

                TextColumn::make('port')
                ->label('Port de chargement'),

                TextColumn::make('enlevement')
                ->label('Adresse d’enlèvement'),

                TextColumn::make('dechargement')
                ->label('Port de déchargement'),

                TextColumn::make('livraison')
                ->label('Adresse de livraison'),

                TextColumn::make('commentaire')
                ->label('Commentaire')
                ->wrap()
                ->limit(50)
                ->toggleable()
                ->toggledHiddenByDefault(),

                TextColumn::make('created_at')
                ->label('Création')
                ->since(),
            ])
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
            'index' => Pages\ListDevis::route('/'),
            'create' => Pages\CreateDevis::route('/create'),
            'view' => Pages\ViewDevis::route('/{record}'),
            'edit' => Pages\EditDevis::route('/{record}/edit'),
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
