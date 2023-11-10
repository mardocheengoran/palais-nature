<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationLabel = 'Réglages';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Grid::make(3)->schema([
                    TextInput::make('title')
                    ->label('Titre')
                    ->required()
                    ->maxLength(255),

                    TextInput::make('subtitle')
                    ->label('Sous titre')
                    ->maxLength(255),

                    /* TextInput::make('email')
                    ->email()
                    ->maxLength(255), */

                    TagsInput::make('email')
                    ->label('Emails')
                    ->placeholder(''),

                    TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),

                    TextInput::make('address')
                    ->maxLength(255),

                    Select::make('template_id')
                    ->label('Template')
                    ->required()
                    ->relationship('template', 'title', fn (Builder $query) => $query->whereType_parameter_id(25)),
                ]),

                Grid::make(3)->schema([
                    Radio::make('mode')
                    ->label('Mode')
                    ->required()
                    ->inline()
                    ->options([
                        'dev' => 'Dev',
                        'prod' => 'Prod',
                    ]),

                    TagsInput::make('keywords')
                    ->label('Mots clés')
                    ->placeholder('Nouveau mot clé'),

                    Textarea::make('content')
                    ->label('Breve description'),
                ]),


                Grid::make(3)->schema([
                    SpatieMediaLibraryFileUpload::make('logo')
                    ->label('Logo')
                    ->required()
                    ->collection('logo'),

                    SpatieMediaLibraryFileUpload::make('icon')
                    ->label('Icône')
                    ->required()
                    ->collection('icon'),

                    SpatieMediaLibraryFileUpload::make('cover')
                    ->label('Couverture')
                    ->required()
                    ->collection('cover'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('logo')
                ->collection('logo'),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('address'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
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


                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
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
            'index' => Pages\ListSettings::route('/'),
            //'create' => Pages\CreateSetting::route('/create'),
            'view' => Pages\ViewSetting::route('/{record}'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
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
