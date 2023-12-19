<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Filament\Resources\ArticleResource\RelationManagers\EquipmentsRelationManager;
use App\Models\Article;
use App\Models\Parameter;
use App\Models\User;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Carbon\Carbon;
use Closure;
use Filament\Facades\Filament;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
//use Illuminate\Support\Facades\Notification;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Livewire\Component as Livewire;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class ArticleResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Article::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    // protected static ?string $navigationGroup = 'heroicon-o-collection';

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
        $parameters = Parameter::whereType_parameter_id(1)
            ->pluck('slug')->toArray();
        $array = array_merge($arr, $parameters);

        return $array;

    }

    /*  public $categories;
     public $sous_categories; */

    public static function form(Form $form): Form
    {
        /* if (!Cookie::get('rubric')) {
            redirect()->route('filament.pages.dashboard');
        } */
        $rubric = Parameter::find(Cookie::get('rubric'));
        /* if ($rubric) {
            redirect()->route('filament.pages.dashboard');
        } */
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Card::make()
                            ->schema([
                                Grid::make(1)->schema([
                                    TextInput::make('title')
                                        ->label('Titre')
                                        ->required($rubric->id != 18)
                                        ->maxLength(255)
                                        ->hidden(! in_array('title', $rubric->field)),

                                    TextInput::make('subtitle')
                                        ->label('Sous-titre')
                                        ->maxLength(255)
                                        ->hidden(! in_array('subtitle', $rubric->field)),

                                    Select::make('available_id')
                                        ->required()
                                        ->label('Disponibilité')
                                        ->relationship('available', 'title', fn (Builder $query) => $query->whereType_parameter_id(20))
                                        ->hidden(! in_array('available', $rubric->field)),
                                ]),

                                RichEditor::make('resume')
                                    ->label('Résumé')
                                    ->placeholder('Résumé')
                                    ->hidden(! in_array('resume', $rubric->field)),

                                RichEditor::make('content')
                                    ->label($rubric->id == 125 ? 'Détails' : 'Description')
                                    //->required()
                                    ->hidden(! in_array('content', $rubric->field)),

                                SpatieMediaLibraryFileUpload::make('image')
                                    ->collection('image')
                                    ->multiple()
                                    ->maxFiles(5)
                                    ->disableLabel()
                                    ->hidden(! in_array('image', $rubric->field)),

                                Grid::make(2)->schema([
                                    TextInput::make('icon')
                                        ->label('Icône')
                                        ->placeholder('icofont-ui-home')
                                        ->maxLength(255)
                                        ->hidden(! in_array('icon', $rubric->field)),

                                    TextInput::make('link')
                                        ->label('Lien web')
                                        ->placeholder('https://www.qenium.com')
                                        ->maxLength(255)
                                        ->hidden(! in_array('link', $rubric->field)),

                                    TextInput::make('link_video')
                                        ->label('Vidéo')
                                        ->placeholder('https://www.youtube.com/embed/dVoEcZ60Fus')
                                        ->maxLength(255)
                                        ->hidden(! in_array('link_video', $rubric->field)),
                                ]),

                                Grid::make(2)->schema([
                                    Toggle::make('active_size')
                                        ->label('Ce produit a t-il des tailles')
                                    //->helperText('')
                                        ->afterStateUpdated(function (Closure $set, Closure $get) {
                                            if ($get('active_size') == true) {
                                                $set('sizes', null);
                                            }
                                        })
                                        ->reactive()
                                        ->hidden(! in_array('size', $rubric->field)),

                                    TextInput::make('quantity')
                                        ->label('Quantité')
                                        ->numeric()
                                        ->minValue(1)
                                        ->required()
                                        ->mask(fn (TextInput\Mask $mask) => $mask
                                            ->numeric()
                                            ->decimalPlaces(2) // Set the number of digits after the decimal point.
                                            ->decimalSeparator(',') // Add a separator for decimal numbers.
                                            ->minValue(1) // Set the minimum value that the number can be.
                                            ->thousandsSeparator(' '), // Add a separator for thousands.
                                        )
                                        ->maxLength(255)
                                        ->hidden(! in_array('quantity', $rubric->field))
                                        ->visible(fn (Closure $get): bool => $get('active_size') == false),
                                ]),

                                Repeater::make('sizes_pivot')
                                    ->relationship()
                                    ->label('') //Gestion des quantités des tailles
                                    ->disableItemMovement()
                                    ->createItemButtonLabel('Ajouter une taille')
                                    ->defaultItems(1)
                                    ->schema([
                                        Select::make('parameter_id')
                                            ->label('Taille')
                                        //->multiple()
                                        //->relationship('sizes', 'title', fn (Builder $query) => $query->whereType_parameter_id(19))
                                            ->options(Parameter::whereType_parameter_id(19)->orderBy('title', 'asc')->pluck('title', 'id')),

                                        TextInput::make('quantity')
                                            ->label('Quantité')
                                            ->numeric()
                                            ->minValue(1)
                                            ->required()
                                            ->mask(fn (TextInput\Mask $mask) => $mask
                                                ->numeric()
                                                ->decimalPlaces(2) // Set the number of digits after the decimal point.
                                                ->decimalSeparator(',') // Add a separator for decimal numbers.
                                                ->minValue(1) // Set the minimum value that the number can be.
                                                ->thousandsSeparator(' '), // Add a separator for thousands.
                                            )
                                            ->maxLength(255),
                                    ])
                                    ->columns(2)
                                    ->hidden(! in_array('size', $rubric->field))
                                    ->visible(fn (Closure $get): bool => $get('active_size') == true),

                                /* CheckboxList::make('sizes')
                        ->label('Tailles')
                        ->relationship('sizes', 'title', fn (Builder $query) => $query->whereType_parameter_id(19), 'size')
                        ->columns(4)
                        ->hidden(!in_array('size', $rubric->field))
                        ->visible(fn (Closure $get): bool => $get('active') == true), */
                            ]),
                        Section::make('Autres détails du produit')
                            ->schema([
                                Grid::make(1)->schema([
                                    KeyValue::make('other')
                                        ->label('')
                                        ->reorderable()
                                        ->keyLabel('Caractéristique')
                                        ->valueLabel('Valeur de la caractéristique')
                                        ->keyPlaceholder('Ex. Lieu d\'origine')
                                        ->valuePlaceholder('Ex. Wuan, Chine'),
                                ]),
                            ])
                        //->collapsed()
                            ->collapsible()
                            ->hidden(! in_array('repeater', $rubric->field)),

                        Section::make('Fiche technique (obligatoire)')
                            ->schema([
                                Repeater::make('other')
                                    ->label('')
                                    ->schema([
                                        TextInput::make('titre')
                                            ->label('Titre')
                                            ->required(),

                                        RichEditor::make('contenu')
                                            ->label('Description'),
                                    ])
                                    ->columns(1),
                            ])
                        //->collapsed()
                            ->collapsible()
                            ->hidden(! in_array('sheet', $rubric->field)),

                        Section::make('Bien immobilier')
                            ->schema([
                                Grid::make(3)->schema([
                                    Select::make('property_id')
                                        ->label('Type de Bien')
                                        ->relationship('property', 'title')
                                        ->options(Parameter::where('type_parameter_id', 3)->pluck('title', 'id')),

                                    TextInput::make('surface')
                                        ->label('Surface en m2')
                                        ->placeholder('800')
                                        ->numeric()
                                        ->minValue(1),

                                    TextInput::make('number_piece')
                                        ->label('Nombre de pièces')
                                        ->placeholder('3')
                                        ->numeric()
                                        ->minValue(1),
                                ]),
                                Grid::make(3)->schema([
                                    TextInput::make('bathroom')
                                        ->label('Salle de Bain')
                                        ->placeholder('2')
                                        ->numeric()
                                        ->minValue(1),

                                    TextInput::make('stage')
                                        ->label('Etage')
                                        ->placeholder('Rez de Chaussez')
                                        ->maxLength(255),

                                    TextInput::make('parking')
                                        ->label('Véhicule dans parking')
                                        ->placeholder('2')
                                        ->numeric()
                                        ->minValue(1),
                                ]),
                                CheckboxList::make('equipments')
                                    ->label('Equipements')
                                    ->relationship('equipments', 'title', fn (Builder $query) => $query->whereType_parameter_id(6), 'equipment')
                                    ->columns(4),
                                /* AttachAction::make('dd')
                        ->recordSelectOptionsQuery(fn (Builder $query) => $query->whereBelongsTo(auth()->user()), */
                            ])
                        //->collapsed()
                            ->collapsible()
                            ->hidden(! in_array('property', $rubric->field)),

                        Section::make('Offre d\'emploi')
                            ->schema([
                                Grid::make(3)->schema([
                                    Select::make('contract_id')
                                        ->label('Type de contrat')
                                        ->options(Parameter::where('type_parameter_id', '=', 12)->pluck('title', 'id')),

                                    Select::make('jobs')
                                        ->label('Métiers')
                                        ->multiple()
                                        ->relationship('jobs', 'title', fn (Builder $query) => $query->whereType_parameter_id(15)),

                                    TextInput::make('level')
                                        ->label('Niveaux d\'étude')
                                        ->placeholder('BAC, BAC +2, Master')
                                        ->maxLength(255),
                                ]),

                                Grid::make(3)->schema([
                                    TextInput::make('experience')
                                        ->label("Année d'expérience")
                                        ->placeholder('Minimum 2 ans')
                                        ->maxLength(255),

                                    TextInput::make('number_job')
                                        ->label('Nombre de poste')
                                        ->placeholder('2')
                                        ->numeric()
                                        ->minValue(1),

                                    DateTimePicker::make('end_at')
                                        ->withoutSeconds()
                                        ->label('Date limite')
                                        ->default(now()),
                                ]),
                            ])
                        //->collapsed()
                            ->collapsible()
                            ->hidden(! in_array('job', $rubric->field)),

                        Section::make('Véhicule')
                            ->schema([
                                Grid::make(3)->schema([
                                    Select::make('fuel_id')
                                        ->label('Type de Carburant')
                                        ->options(Parameter::where('type_parameter_id', '=', 13)->pluck('title', 'id')),

                                    Select::make('transmission_id')
                                        ->label('Type de transmission')
                                        ->options(Parameter::where('type_parameter_id', '=', 14)->pluck('title', 'id')),

                                    Select::make('climatisation')
                                        ->label('Climatisation')
                                        ->options([
                                            'Oui',
                                            'Non',
                                        ])
                                        ->disablePlaceholderSelection()
                                        ->default('Oui'),
                                ]),

                                Grid::make(3)->schema([
                                    TextInput::make('number_place')
                                        ->label('Nombre de place')
                                        ->numeric()
                                        ->minValue(1)
                                        ->maxLength(255),

                                    TextInput::make('door')
                                        ->label('Nombre de porte')
                                        ->numeric()
                                        ->minValue(1)
                                        ->maxLength(255),

                                    TextInput::make('luggage')
                                        ->label('Nombre de bagage')
                                        ->numeric()
                                        ->minValue(1),
                                ]),
                            ])
                        //->collapsed()
                            ->collapsible()
                            ->hidden(! in_array('vehicle', $rubric->field)),
                    ])
                    ->columnSpan(['lg' => 2]),

                Group::make()
                    ->schema([
                        Section::make('Status')
                            ->schema([
                                Select::make('rubric_id')
                                    ->label('Rubrique')
                                    ->required()
                                    ->default($rubric->id)
                                    ->options(Parameter::whereType_parameter_id(1)->orderBy('title', 'asc')->pluck('title', 'id'))
                                    ->disabled(),

                                Toggle::make('enable')
                                    ->label('Visible')
                                    ->required()
                                    ->helperText('S\'il est désactivé il ne sera pas visible sur le site')
                                    ->default(1),

                                DateTimePicker::make('published_at')
                                    ->withoutSeconds()
                                    ->label('Date de publication')
                                    ->default(now())
                                    ->required(),
                            ]),

                        Section::make('Coût')
                            ->schema([
                                TextInput::make('price_buy')
                                    ->label('Prix d\'achat')
                                    ->numeric()
                                    ->minValue(1)
                                    ->mask(fn (TextInput\Mask $mask) => $mask
                                        ->numeric()
                                        ->decimalPlaces(2) // Set the number of digits after the decimal point.
                                        ->decimalSeparator(',') // Add a separator for decimal numbers.
                                        ->minValue(1) // Set the minimum value that the number can be.
                                        ->thousandsSeparator(' '), // Add a separator for thousands.
                                    )
                                    ->maxLength(255)
                                    ->hidden(! in_array('price_buy', $rubric->field)),

                                TextInput::make('price_new')
                                    ->label('Prix')
                                    ->numeric()
                                    ->required()
                                    ->mask(fn (TextInput\Mask $mask) => $mask
                                        ->numeric()
                                        ->decimalPlaces(2) // Set the number of digits after the decimal point.
                                        ->decimalSeparator(',') // Add a separator for decimal numbers.
                                        ->minValue(1) // Set the minimum value that the number can be.
                                        ->thousandsSeparator(' '), // Add a separator for thousands.
                                    )
                                    ->maxLength(255)
                                    ->hidden(! in_array('price_new', $rubric->field)),

                                TextInput::make('price_old')
                                    ->label('Ancien prix')
                                    ->numeric()
                                    ->minValue(1)
                                    ->mask(fn (TextInput\Mask $mask) => $mask
                                        ->numeric()
                                        ->decimalPlaces(2) // Set the number of digits after the decimal point.
                                        ->decimalSeparator(',') // Add a separator for decimal numbers.
                                        ->minValue(1) // Set the minimum value that the number can be.
                                        ->thousandsSeparator(' '), // Add a separator for thousands.
                                    )
                                    ->maxLength(255)
                                    ->hidden(! in_array('price_old', $rubric->field)),

                                Toggle::make('delivery_free')
                                    ->label('Livraison gratuite')
                                    ->helperText('S\'il est défini le cout de livraison est gratuit')
                                    ->hidden(! in_array('delivery_free', $rubric->field)),

                                Select::make('periodicite')
                                    ->label('Périodicité')
                                    ->options(Parameter::where('type_parameter_id', 5)->pluck('title', 'title'))
                                    ->hidden(! in_array('periodicite', $rubric->field)),

                                Select::make('offer_id')
                                    ->label("Type d'offre")
                                    ->options(Parameter::where('type_parameter_id', 4)->pluck('title', 'id'))
                                    ->hidden(! in_array('offer', $rubric->field)),

                                /* TextInput::make('quantity')
                        ->label('Quantité')
                        ->numeric()
                        ->minValue(1)
                        ->mask(fn (TextInput\Mask $mask) => $mask
                            ->numeric()
                            ->decimalPlaces(2) // Set the number of digits after the decimal point.
                            ->decimalSeparator(',') // Add a separator for decimal numbers.
                            ->minValue(1) // Set the minimum value that the number can be.
                            ->thousandsSeparator(' '), // Add a separator for thousands.
                        )
                        ->maxLength(255)
                        ->hidden(!in_array('quantity', $rubric->field)), */
                            ])
                        //->collapsed()
                            ->collapsible()
                            ->hidden(! in_array('pricing', $rubric->field)),

                        Section::make('Localisation')
                            ->schema([
                                Select::make('city_id')
                                    ->label('Commune')
                                    ->options(Parameter::where('type_parameter_id', '=', 2)->orderBy('title', 'asc')->pluck('title', 'id'))
                                    ->searchable()
                                    ->hidden(! in_array('city', $rubric->field)),

                                TextInput::make('address')
                                    ->label('Lieu exacte')
                                    ->placeholder('Abidjan')
                                    ->maxLength(255)
                                    ->hidden(! in_array('address', $rubric->field)),
                            ])
                            ->collapsible()
                            ->hidden(! in_array('local', $rubric->field)),

                        Section::make('Catégorisation')
                            ->schema([
                                Select::make('brand_id')
                                    ->label('Marque')
                                    ->options(Parameter::whereType_parameter_id(16)->orderBy('title', 'asc')->pluck('title', 'id'))
                                    ->searchable()
                                    ->hidden(! in_array('brand', $rubric->field)),

                                /* Select::make('jobs')
                                    ->label('Métiers')
                                    ->multiple()
                                    ->relationship('jobs', 'title', fn (Builder $query) => $query->whereType_parameter_id(15)), */

                                CheckboxList::make('categories')
                                    ->label('Catégorie')
                                    ->required()
                                    ->relationship('categories', 'title', fn (Builder $query) => $query->whereType_parameter_id(17))
                                    //->options(Parameter::whereType_parameter_id(17)->orderBy('title', 'asc')->pluck('title', 'id'))
                                    ->searchable(),

                                /* Select::make('category1')
                                    ->label('Grande catégorie')
                                    ->required()
                                    ->placeholder('Selectionnez une grande catégorie')
                                    //->helperText('Exemple : Maison')
                                    /* ->default(function (Builder $query, Article $article, string $content) {
                                        if ($content === 'edit') {
                                            $filter = $article->categories->filter(function ($category) {
                                                return $category->parent_id == null;
                                            });
                                            return $filter->pluck('id', 'id');
                                        }
                                    }) */
                                   /*  ->options(Parameter::whereType_parameter_id(17)->where('parent_id', null)->orderBy('title', 'asc')->pluck('title', 'id'))
                                    ->reactive()
                                    ->afterStateUpdated(fn (callable $set) => $set('category2', null)), */

                                /* Select::make('category2')
                                    ->label('Catégorie')
                                    //->required()
                                    ->reactive()
                                    ->placeholder('Selectionnez une catégorie')
                                    //->helperText('Exemple : Electroménager')
                                    ->options(function (callable $get) {
                                        $sous_category = Parameter::find($get('category1'));
                                        if (! $sous_category) {
                                            return [];
                                        }
                                        return $sous_category->childrens()->pluck('title', 'id')->toarray();
                                    })
                                    ->afterStateUpdated(fn (callable $set) => $set('category3', null)), */

                                /* Select::make('category3')
                                    ->label('Sous categorie')
                                    //->required()
                                    ->reactive()
                                    ->placeholder('Selectionnez une sous catégorie')
                                    //->helperText('Exemple : Mixeurs')
                                    ->options(function (callable $get) {
                                        $sous_category2 = Parameter::find($get('category2') );
                                        if (! $sous_category2) {
                                            return [];
                                        }
                                        return $sous_category2->childrens()->pluck('title', 'id')->toarray();
                                    }),


                                    Select::make('supplier_id')
                                    ->label('Fournisseur')
                                    ->relationship('supplier', 'store', fn (Builder $query) => $query->role('fournisseur'))
                                    //->options(User::role('fournisseur')->orderBy('store', 'asc')->pluck('store', 'id'))
                                    ->hidden(!in_array('supplier', $rubric->field) or auth()->user()->hasRole(['fournisseur'])), */
                            ])
                            ->collapsible()
                            ->hidden(! in_array('category', $rubric->field)),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        if (request('rubric')) {
            Cookie::queue(Cookie::make('rubric', request('rubric'), 60 * 60 * 24 * 365));
        }
        return $table
            ->columns([
                // TextColumn::make('code'),
                SpatieMediaLibraryImageColumn::make('image')
                    ->conversion('thumb')
                    ->collection('image'),

                /* TextColumn::make('supplier.store')
                    ->searchable()
                    ->sortable()
                    ->label('Fournisseur')
                    ->visible(Cookie::get('rubric') == 125), */

                TextColumn::make('title')
                    ->label('Titre')
                    ->wrap()
                    ->searchable()
                    ->sortable(),

                /* TextColumn::make('sizes.title')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable()
                    ->label('Tailles')
                    ->visible(Cookie::get('rubric') == 125), */

                /* BadgeColumn::make('active_size')
                    ->label('Taille')
                    ->sortable()
                    ->enum([
                        1 => 'Oui',
                        null => 'Non',
                    ])
                    ->colors([
                        'success' => 1,
                        'warning' => null,
                    ])
                    ->visible(Cookie::get('rubric') == 125), */

                TextColumn::make('quantity')
                    ->label('Quantité')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->visible(Cookie::get('rubric') == 125),

                TextColumn::make('rubric.title')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->label('Rubrique'),

                TextColumn::make('categories.title')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->label('Catégories'),

                TextColumn::make('price_new')
                    ->label('Prix')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->money('xof'),

                TextColumn::make('periodicite')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->label('Périodicité'),

                TextColumn::make('city.title')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->label('Commune'),

                TextColumn::make('location')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->label('Localisation'),

                TextColumn::make('slug')
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                TextColumn::make('icon')
                    ->toggleable()
                    ->toggledHiddenByDefault(),

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

                /* IconColumn::make('enable')
                ->label('Visibilité')
                ->boolean()
                ->trueIcon('heroicon-o-badge-check')
                ->falseIcon('heroicon-o-x-circle')
                ->trueColor('success')
                ->falseColor('danger'), */

                ToggleColumn::make('active_size')
                    ->sortable()
                    ->label('Gamme actif')
                    /* ->toggleable()
                    ->toggledHiddenByDefault() */
                    /* ->visible((auth()->user()->hasRole(['super_admin', 'admin']) and Cookie::get('rubric') == 125)) */,

                /* ToggleColumn::make('home')
                    ->label('Gamme actif')
                    ->visible(auth()->user()->hasRole(['super_admin', 'admin']) and Cookie::get('rubric') == 125), */

                TextColumn::make('created_at')
                    ->label('Date')
                    ->since()
                    ->sortable()
                    ->searchable(),
            ])
            ->defaultSort(column: 'created_at', direction: 'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('Rubrique')
                    ->relationship('rubric', 'title', fn (Builder $query) => $query->whereType_parameter_id(1)),

                 SelectFilter::make('Catégories')
                    ->relationship('categories', 'title', fn (Builder $query) => $query->where([
                        'type_parameter_id' => 17,
                    ]))
                    ->multiple(),

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
                                function (Builder $query) use ($created_from): Builder {
                                    //dd($created_from);
                                    return $query->whereDate('created_at', '>=', $created_from);
                                }
                                //fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                                ->when(
                                    $created_until,
                                    function (Builder $query) use ($created_until): Builder {
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
                //Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->label(''),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ])
            ->reorderable('rank');
    }

    public static function getRelations(): array
    {
        return [
            //EquipmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->when(auth()->user()->hasRole(['fournisseur']), function ($q) {
                $q->whereSupplier_id(auth()->user()->id);
            })
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    /* protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('');
    } */
}
