<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Flash;
use App\Models\Article;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\FlashResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FlashResource\RelationManagers;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class FlashResource extends Resource
{
    protected static ?string $model = Flash::class;

    protected static ?string $navigationIcon = 'heroicon-o-lightning-bolt';
    protected static ?string $navigationLabel = 'Vente Flash';
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
                        Grid::make(2)
                        ->schema([
                            TextInput::make('title')
                            ->label('Titre de la vente flash')
                            ->required()
                            ->maxLength(255),

                            DateTimePicker::make('limit_at')
                            ->label('Date limite de la vente flash')
                            ->minDate(now())
                            ->required(),
                        ]),
                        RichEditor::make('content')
                        ->label('Description de la vente flash')
                        ->maxLength(255),

                        SpatieMediaLibraryFileUpload::make('image')
                        ->label('Image')
                        ->collection('image'),
                    ])
                ]),
                Group::make()
                ->schema([
                    Card::make()
                    ->schema([
                        Repeater::make('articleflashes')
                        ->label('Ajouter les produits de la vente flash')
                        ->relationship()
                        ->schema([
                            Select::make('article_id')
                            ->label('Selectionner le produit à vendre')
                            ->relationship('article', 'title', fn (Builder $query) => $query->whereRubric_id(125))
                            //->options(Article::whereRubric_id(125)->pluck('title', 'id'))
                            ->searchable()
                            ->preload()
                            ->columnSpan(['md' => 4])
                            ->required()
                            ->getOptionLabelFromRecordUsing(fn (Article $record) => "{$record->title} - {$record->price_new} Fcfa")
                            ->reactive(),

                            TextInput::make('price_discount')
                            ->label('Pourcentage de remise')
                            ->required()
                            ->numeric(),
                        ])
                        ->createItemButtonLabel('Ajouter vos produits'),
                    ])
                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('code')
                ->label('Code'),

                Tables\Columns\TextColumn::make('title')
                ->label('Titre de la vente flash'),

                Tables\Columns\TextColumn::make('limit_at')
                ->label('Date limite')
                ->dateTime('d-M-y H:i:s'),

                Tables\Columns\TextColumn::make('price_discount')
                ->label('Pourcentage de remise'),

                Tables\Columns\TextColumn::make('created_at')
                ->label('Date de création')
                ->dateTime('d-M-y'),

            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make()
                ->label(''),

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
            'index' => Pages\ListFlashes::route('/'),
            'create' => Pages\CreateFlash::route('/create'),
            'view' => Pages\ViewFlash::route('/{record}'),
            'edit' => Pages\EditFlash::route('/{record}/edit'),
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


