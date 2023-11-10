<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Parameter;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ParameterResource\Pages;
use App\Filament\Resources\ParameterResource\Pages\CreateParameter;
use App\Filament\Resources\ParameterResource\Pages\EditParameter;
use App\Filament\Resources\ParameterResource\Pages\ListParameters;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\ParameterResource\RelationManagers;
use App\Filament\Resources\ParameterResource\RelationManagers\ManageParameters;
use App\Models\TypeParameter;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms\Components\BelongsToManyMultiSelect;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use RyanChandler\FilamentNavigation\Facades\FilamentNavigation;

class ParameterResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Parameter::class;
    protected static bool $shouldRegisterNavigation = false;

    public $type;


    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    protected static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'warning' : 'primary';
    }

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
        $type_parameters = TypeParameter::pluck('slug')->toArray();
        //$type_parameters = preg_filter('/^/', 'tp_', $type_parameters);
        $array = array_merge($arr, $type_parameters);
        return $array;
    }

    // protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Parametre';

    public static function form(Form $form): Form
    {
        /* if (!Cookie::get('type')) {
            Redirect::route('filament.pages.dashboard');
            //header("Location: ".route('filament.pages.dashboard'));
            //dd(request('type'));
        } */
        $retVal = (request('type')) ? request('type') : Cookie::get('type');
        $type = TypeParameter::find($retVal);
        //$type = $type ? $type : $type;
        //dd($type->toArray());
        return $form
            ->schema([

                Grid::make(3)->schema([
                    TextInput::make('title')
                    ->label('Titre')
                    ->required()
                    ->maxLength(255),

                    TextInput::make('icon')
                    ->label('Icône')
                    ->helperText('Titre pour la page d\accueil')
                    ->maxLength(255),

                    TextInput::make('subtitle')
                    ->label('Sous titre')
                    ->maxLength(255),
                ]),

                Grid::make(3)->schema([
                    TextInput::make('link')
                    ->label('Route statique')
                    ->visible(in_array($type->id, [24]))
                    ->maxLength(255),

                    Select::make('link_id')
                    ->label('Lien dynamique rubrique, categorie etc.')
                    //->searchable()
                    ->visible(in_array($type->id, [24]))
                    ->relationship('link_rubric', 'title', fn (Builder $query) => $query->whereType_parameter_id(1)),

                    Select::make('link_article_id')
                    ->label('Lien dynamique vers un article')
                    //->searchable()
                    ->visible(in_array($type->id, [24]))
                    ->relationship('link_article', 'title', fn (Builder $query) => $query->whereIn('rubric_id', [20, 21, 64])),

                    Select::make('parent_id')
                    ->label('Parent')
                    //->searchable()
                    ->visible(in_array($type->id, [17, 24]))
                    ->relationship('parent_filament', 'title', fn (Builder $query) => $query->whereType_parameter_id($type->id)),

                    TextInput::make('board')
                        ->label('Commission')
                        ->helperText('Inserez le pourcentage de la commission')
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

                Section::make('Sous menu')->schema([
                    Grid::make(4)->schema([
                        Toggle::make('submenu')
                        ->label('Sous menu')
                        ->required()
                        //->helperText('S\'il est désactivé il ne sera pas visible sur le site')
                        ->default(0),

                        Toggle::make('ecommerce')
                        ->label('Menu ecommerce')
                        ->required()
                        ->default(0),

                        Select::make('item_type_parameter_id')
                        ->label('Sous menu Type Parameter')
                        //->searchable()
                        ->relationship('item_type_parameter', 'title'),

                        Select::make('item_rubric_id')
                        ->label('Sous menu rubrique')
                        //->searchable()
                        ->relationship('item_rubric', 'title', fn (Builder $query) => $query->whereType_parameter_id(1)),

                    ]),
                ])
                ->collapsed()
                ->collapsible()
                ->visible(in_array($type->id, [24])),


                Grid::make(3)->schema([
                    /* Select::make('type_parameter_id')
                    ->label('Type de paramètre')
                    ->required()
                    ->default($type->id)
                    ->relationship('typeParameter', 'title')
                    ->disabled(), */

                    SpatieMediaLibraryFileUpload::make('image')
                    ->collection('image'),

                    SpatieMediaLibraryFileUpload::make('icons')
                    ->collection('icon')
                    ->label('Icône image')
                    ->visible(in_array($type->id, [17])),

                    SpatieMediaLibraryFileUpload::make('cover')
                    ->collection('cover')
                    ->label('Couverture')
                    ->visible(in_array($type->id, [17])),
                ]),


                /* Grid::make(1)
                ->schema([
                    RichEditor::make('content'),
                ]), */


                Section::make('Réglage composant')->schema([
                    Grid::make(3)
                    ->schema([
                        TextInput::make('component')
                        ->maxLength(255),

                        TextInput::make('component_detail')
                        ->maxLength(255),

                        TextInput::make('grid')
                        ->maxLength(255),

                        TextInput::make('class')
                        ->maxLength(255),

                        TextInput::make('color')
                        ->maxLength(255),
                    ]),
                ])
                ->hidden($type->id != 1),

                Grid::make(1)
                ->schema([
                    CheckboxList::make('field')
                    ->options([
                        'title' => 'title',
                        'subtitle' => 'subtitle',
                        'icon' => 'icon',
                        'content' => 'content',
                        'image' => 'image',
                        'link' => 'link',
                        'link_video' => 'link_video',
                        'pricing' => 'pricing',
                        'price_new' => 'price_new',
                        'price_old' => 'price_old',
                        'periodicite' => 'periodicite',
                        'offer' => 'offer',
                        'property' => 'property',
                        'local' => 'local',
                        'city' => 'city',
                        'address' => 'address',
                        'job' => 'job',
                        'vehicle' => 'vehicle',
                        'category' => 'category',
                        //'board' => 'board',
                        'brand' => 'brand',
                        'available' => 'available',
                        'size' => 'size',
                        'product' => 'product',
                        'repeater' => 'repeater',
                        'supplier' => 'supplier',
                        'resume' => 'resume',
                        'sheet' => 'sheet',
                        'quantity' => 'quantity',
                    ])
                    ->columns(4),
                ])
                ->hidden($type->id != 1),

                //BelongsToManyMultiSelect::make('roles')->relationship('roles', 'name')
            ]);
    }

    public static function table(Table $table): Table
    {
        if (request('type')) {
            $cookie = Cookie::queue(Cookie::make('type', request('type'), 60*60*24*365));
            //return redirect()->route('filament.resources.parameters.index')->cookie($cookie);
            //redirect(route('filament.resources.parameters.index').'?type='.Cookie::get('type'));
            //dd(Cookie::get('type'));
        }
        //$type = TypeParameter::find(Cookie::get('type'));
        $retVal = (request('type')) ? request('type') : Cookie::get('type');
        $type = TypeParameter::find($retVal);
        return $table
            ->columns([
                TextColumn::make('code')
                ->toggleable()
                ->toggledHiddenByDefault(),

                TextColumn::make('rank')
                ->label('Rang')
                ->sortable()
                ->toggleable()
                ->toggledHiddenByDefault(),

                SpatieMediaLibraryImageColumn::make('icons')
                ->collection('icon')
                ->label('Icône image')
                ->visible(in_array($type->id, [17])),

                TextColumn::make('title')
                ->label('Titre')
                ->searchable()
                ->sortable(),

                TextColumn::make('typeParameter.title')
                ->label('Type Parametre')
                ->toggleable()
                ->toggledHiddenByDefault()
                ->searchable(),

                TextColumn::make('products_count')
                ->label('Nbr. produits')
                ->extraAttributes(['class' => 'flex justify-center'])
                ->html()
                ->sortable()
                ->counts('products')
                ->visible(in_array($type->id, [17])),

                TextColumn::make('parent.title')
                ->searchable()
                ->sortable()
                ->toggleable()
                ->toggledHiddenByDefault()
                ->visible(in_array($type->id, [17])),

                TextColumn::make('slug')
                ->toggleable()
                ->toggledHiddenByDefault(),

                TextColumn::make('icon')
                ->searchable()
                ->sortable()
                ->toggleable()
                ->toggledHiddenByDefault(),

                SpatieMediaLibraryImageColumn::make('image')
                ->collection('image')
                ->toggleable()
                ->toggledHiddenByDefault(),

                ToggleColumn::make('home')
                ->label('Accueil')
                ->visible(in_array($type->id, [17])),

                ToggleColumn::make('status')
                ->toggleable()
                ->toggledHiddenByDefault(),

                TextColumn::make('created_at')
                ->since()
                ->label('Date')
                ->sortable(),
            ])
            ->defaultSort(column:'parent_id', direction:'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),

                SelectFilter::make('Type Parametre')
                ->relationship('typeParameter', 'title'),

                Filter::make('Grande categorie')
                ->query(fn (Builder $query): Builder => $query->where('parent_id', null))
                ->visible(in_array($type->id, [17])),

                /* Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('Catégorie niveau 1')
                ->relationship('parent', 'title', fn (Builder $query) => $query->whereType_parameter_id(17)->whereParent_id(null)), */

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
            ->reorderable('rank');;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListParameters::route('/'),
            'create' => CreateParameter::route('/create'),
            'edit' => EditParameter::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            //->whereUser_created(auth()->user()->id)
            //->whereNull('parent_id')
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
