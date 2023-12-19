<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Parameter;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\CheckboxList;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use Spatie\Permission\Models\Role;


class UserResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Utilisateurs';
    protected static ?string $navigationGroup = 'Utilisateurs';

    protected static bool $shouldRegisterNavigation = false;

    protected static $permissionsCollection;

    public static function getPermissionPrefixes(): array
    {
        $arr = [
            'view_any',
            'view',
            'create',
            'update',
            'delete',
            'delete_any',
            'force_delete',
            'force_delete_any',
            'restore',
            'restore_any',
            'replicate',
            'reorder',
        ];
        $roles = Role::pluck('name')->toArray();
        $array = array_merge($arr, $roles);
        return $array;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->label('Nom')
                ->required()
                ->maxLength(255),

                TextInput::make('first_name')
                ->label('Prénoms')
                ->maxLength(255),

                TextInput::make('email')
                ->label('Email')
                ->email()
                ->unique(ignoreRecord: true)
                ->required()
                ->maxLength(255),

                TextInput::make('password')
                ->password()
                ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                ->required()
                ->hiddenOn('edit')
                ->visibleOn('create'),

                Select::make('roles')
                ->relationship('roles', 'name', function (Builder $query) {
                    //$query->whereIn('name', auth()->user()->roles->pluck('name')->toArray());
                    return $query->when(!auth()->user()->hasRole(['super_admin']), function($q){
                        if (auth()->user()->hasRole(['admin'])) {
                            $q->whereNotIn('name', ['super_admin', 'livreur', 'fournisseur']);
                        }
                        else {
                            $q->whereIn('name', auth()->user()->roles->pluck('name')->toArray());
                        }
                    })
                    /* ->when(auth()->user()->hasRole(['admin']), function($q){
                        $q->whereNotIn('name', ['super_admin']);
                    }) */;
                })
                ->options(
                    Role::when(!auth()->user()->hasRole(['super_admin']), function($q){
                        if (auth()->user()->hasRole(['admin'])) {
                            $q->whereNotIn('name', ['super_admin', 'livreur', 'fournisseur']);
                        }
                        else {
                            $q->whereIn('name', auth()->user()->roles->pluck('name')->toArray());
                        }
                    })
                    /* ->when(auth()->user()->hasRole(['admin']), function($q){
                        $q->whereNotIn('name', ['super_admin']);
                    }) */
                    ->get()
                    ->pluck('name', 'id')
                )
                ->multiple()
                ->required(),

                TextInput::make('phone')
                ->label('Téléphone')
                ->maxLength(255),

                SpatieMediaLibraryFileUpload::make('image')
                ->label('Image')
                ->collection('image'),

                /* Select::make('city_id')
                ->label('Zone')
                ->required()
                ->options(
                    Parameter::orderBy('title', 'asc')
                    ->whereType_parameter_id(2)
                    ->get()
                    ->pluck('title', 'id')
                ),

                TextInput::make('address')
                ->label('Adresse')
                ->maxLength(255), */

                Grid::make(1)
                ->schema([
                    RichEditor::make('content')
                    ->label('Bio')
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code'),

                TextColumn::make('name')
                ->label('Nom')
                ->searchable()
                ->sortable(),

                TextColumn::make('first_name')
                ->label('Prénoms')
                ->searchable()
                ->sortable(),

                TextColumn::make('email')
                ->label('Email')
                ->searchable()
                ->sortable(),

                TextColumn::make('roles.name')
                ->label('Role')
                ->searchable()
                ->sortable(),

                TextColumn::make('phone')
                ->label('Téléphone')
                ->toggleable()
                ->toggledHiddenByDefault(),

                TextColumn::make('address')
                ->label('Localisation')
                ->toggleable()
                ->toggledHiddenByDefault(),

                TextColumn::make('slug')
                ->label('Slug')
                ->toggleable()
                ->toggledHiddenByDefault(),

                SpatieMediaLibraryImageColumn::make('image')
                ->label('Photo')
                ->collection('image')
                ->toggleable()
                ->toggledHiddenByDefault(),

                TextColumn::make('created_at')
                ->since()
                ->label('Date')
                ->sortable(),
            ])
            ->defaultSort(column:'created_at', direction:'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('Role')
                ->relationship('roles', 'name'),

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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            //'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->when(!auth()->user()->hasRole(['super_admin']), function (Builder $query) {
                $query->whereHas('roles', function (Builder $query) {
                    $query->where('name', '!=', 'super_admin');
                });
            })
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
