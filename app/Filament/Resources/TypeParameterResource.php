<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use App\Models\TypeParameter;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\BooleanColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TypeParameterResource\Pages;
use App\Filament\Resources\TypeParameterResource\Pages\CreateTypeParameter;
use App\Filament\Resources\TypeParameterResource\Pages\EditTypeParameter;
use App\Filament\Resources\TypeParameterResource\Pages\ListTypeParameter;
use Filament\Forms\Components\BelongsToManyMultiSelect;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\TypeParameterResource\RelationManagers;
use App\Filament\Resources\TypeParameterResource\RelationManagers\ManageTypeParameters;
use Filament\Pages\Actions\CreateAction;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Support\Facades\Auth;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class TypeParameterResource extends Resource
{
    protected static ?string $model = TypeParameter::class;
    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    protected static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'warning' : 'primary';
    }

    protected static ?string $navigationIcon = 'heroicon-o-sun';
    protected static ?string $navigationGroup = 'Paramètre';
    //protected static bool $shouldRegisterNavigation = false;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('title')
                ->label('Titre')
                ->required()
                ->maxLength(255),

                TextInput::make('subtitle')
                ->maxLength(255),

                TextInput::make('icon')
                ->required()
                ->default('heroicon-o-')
                ->maxLength(255),

                SpatieMediaLibraryFileUpload::make('image')
                ->collection('image'),

                Grid::make(1)
                ->schema([
                    RichEditor::make('content')
                    // ->columnSpan(2),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('code'),

                TextColumn::make('title')
                ->label('Titre')
                ->searchable()
                ->sortable(),

                TextColumn::make('slug')
                ->sortable()
                ->toggleable()
                ->toggledHiddenByDefault(),

                TextColumn::make('icon'),

                ToggleColumn::make('status')
                ->toggleable()
                ->toggledHiddenByDefault(),

                SpatieMediaLibraryImageColumn::make('image')->collection('image'),

                TextColumn::make('created_at')
                ->since()
                ->label('Date')
                ->sortable(),

                TextColumn::make('rank')
                ->sortable()
                ->toggleable()
                ->toggledHiddenByDefault(),
            ])
            ->defaultSort(column:'created_at', direction:'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),

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
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ])
            ->reorderable('rank');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTypeParameter::route('/'),
            'create' => CreateTypeParameter::route('/create'),
            'edit' => EditTypeParameter::route('/{record}/edit'),
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
