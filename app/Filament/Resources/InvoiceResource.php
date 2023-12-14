<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Mail\InvoiceStateMail;
use App\Models\Invoice;
use App\Models\User;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::when(auth()->user()->hasRole(['fournisseur']), function ($q) {
            $q->whereSupplier_id(auth()->user()->id);
        })
            ->count();
    }

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationLabel = 'Commandes';

    protected static ?string $navigationGroup = 'Ecommerce';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->label('Code')
                    ->hiddenOn(['edit', 'create']),

                TextInput::make('quantity')
                    ->label('Quantité')
                    ->hiddenOn(['edit', 'create']),

                TextInput::make('price_ht')
                    ->label('Sous total')
                    ->hiddenOn(['edit', 'create']),

                TextInput::make('price_tax')
                    ->label('Taxe')
                    ->hiddenOn(['edit', 'create']),

                TextInput::make('price_delivery')
                    ->label('Cout de livraison')
                    ->hiddenOn(['edit', 'create']),

                TextInput::make('price_discount')
                    ->label('Réduction')
                    ->hiddenOn(['edit', 'create']),

                TextInput::make('price_final')
                    ->label('Montant total')
                    ->hiddenOn(['edit', 'create']),

                TextInput::make('planned_at')
                    ->label('Date de livraison prévu')
                    ->hiddenOn(['edit', 'create']),

                TextInput::make('exacted_at')
                    ->label('Date exacte de livraison')
                    ->hiddenOn(['edit', 'create']),

                Select::make('delivery_mode_id')
                    ->label('Mode de livraison')
                    ->relationship('deliveryMode', 'title')
                    ->hiddenOn(['edit', 'create']),

                Select::make('relay_id')
                    ->label('Point de relai')
                    ->relationship('relay', 'title')
                    ->hiddenOn(['edit', 'create']),

                Select::make('address_id')
                    ->label('Adresse de livraison')
                    ->relationship('address', 'title')
                    ->hiddenOn(['edit', 'create']),

                Select::make('state_id')
                    ->label('Etat')
                    ->required()
                //->relationship('available', 'title', fn (Builder $query) => $query->whereType_parameter_id(20))
                    ->relationship('state', 'title', fn (Builder $query) => $query->where([
                        'type_parameter_id' => 22,
                    ])
                        ->whereNotIn('id', [47])
                    ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('supplier.store')
                    ->label('Fournisseur')
                    ->wrap()
                    ->searchable()
                    ->sortable(),

                BadgeColumn::make('state.title')
                    ->label('Etat')
                    ->wrap()
                    ->searchable()
                    ->sortable()
                    ->colors([
                        'info' => 'Affectée',
                        'green-300' => 'Validée',
                        'indigo' => 'Récupérée',
                        'yellow-400' => 'En attente',
                        'yellow-200' => 'En cours',
                        'green-500' => 'Livrée',
                        'danger' => 'Annulée',
                    ])
                    ->icons([
                        'heroicon-o-refresh' => 'En attente',
                        'heroicon-o-check' => 'Validée',
                        'heroicon-o-user' => 'Affectée',
                        'heroicon-o-shopping-bag' => 'Récupérée',
                        'heroicon-o-document' => 'En cours',
                        'heroicon-o-x' => 'Annulée',
                        'heroicon-o-truck' => 'Livrée',
                    ]),

                TextColumn::make('quantity')
                    ->label('Nbr. produits')
                    ->wrap()
                    ->searchable()
                    ->sortable(),

                BadgeColumn::make('price_ht')
                    ->colors(['success'])
                    ->icons(['heroicon-o-currency-dollar'])
                    ->label('Montant')
                    ->wrap()
                    ->searchable()
                    ->sortable()
                    ->money('xof'),

                TextColumn::make('price_delivery')
                    ->label('Coût de livraison')
                    ->wrap()
                    ->searchable()
                    ->money('xof')
                    ->sortable(),

                BadgeColumn::make('price_final')
                    ->colors(['success'])
                    ->icons(['heroicon-o-currency-dollar'])
                    ->label('Montant total')
                    ->wrap()
                    ->searchable()
                    ->sortable()
                    ->money('xof'),

                /* TextColumn::make('benefit')
                ->label('Commission')
                ->wrap()
                ->searchable()
                ->money('xof')
                ->sortable(), */

                /* TextColumn::make('partfournisseur')
                    ->label('Part Fournisseur')
                    ->wrap()
                    ->sortable()
                    ->money('xof')
                    ->getStateUsing(function (Invoice $record): float {
                        return $record->price_ht - $record->benefit;
                    }), */

                TextColumn::make('customer.fullname')
                    ->label('Client')
                    ->wrap()
                    ->searchable([
                        'first_name',
                        'name',
                    ])
                    ->sortable(),

                TextColumn::make('deliveryMode.title')
                    ->label('Mode de livraison')
                    ->wrap()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('address.title')
                    ->label('Adresse de livraison')
                    ->wrap()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('planned_at')
                    ->since()
                    ->label('Date de livraison prévue')
                    ->wrap()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->since()
                    ->label('Date')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),

                // Tables\Filters\SelectFilter::make('customer_id')
                //     ->label('Client')
                //    // ->options(User::all()->pluck('all_name', 'id')),
                //     ->relationship('customer', 'slug'),

                /* SelectFilter::make('Etat')
                ->relationship('state', 'title', fn (Builder $query)
                    => $query->where([
                        'type_parameter_id' => 22,
                    ])
                    //->whereIn('id', [48, 49, 50, 51, 52])
                )
                ->multiple()
                ->default([48, 49, 50, 51, 52]), */
                SelectFilter::make('Etat')
                    ->relationship('state', 'title', fn (Builder $query) => $query->where([
                        'type_parameter_id' => 22,
                    ])
                        //->whereIn('id', [48, 49, 50, 51, 52])
                    )
                    ->multiple()
                    ->default([48, 49, 50, 51, 52, 269, 447, 269]),

                Tables\Filters\SelectFilter::make('customer_id')
                    ->label('Client')
                    ->relationship('customer', 'first_name'),

                Tables\Filters\SelectFilter::make('supplier_id')
                    ->label('Fournisseur')
                    ->relationship('supplier', 'first_name'),

                Tables\Filters\SelectFilter::make('delivery_mode_id')
                    ->label('Mode de livraison')
                    ->relationship('deliveryMode', 'title', fn (Builder $query) => $query->whereId([
                        175,
                    ])),

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
                Tables\Actions\ActionGroup::make([

                    // Validation de la commande
                    Action::make('state_id')
                        ->label('Valider la commande')
                        ->action(fn (Invoice $record) => $record->update([
                            'state_id' => 269,
                        ]))
                        ->after(function (Invoice $record) {
                            $record->states()->attach(269, [
                                'user_created' => Auth::id(),
                            ]);

                            foreach ($record->articles as $key => $value) {

                                $value->update([
                                    'quantity' => $value->quantity - $value->pivot->quantity,
                                ]);
                            }
                            //dd($record->title);
                            Mail::to(setting()->email)->send(new InvoiceStateMail($record, 'admin'));
                            Mail::to($record->customer->email)->send(new InvoiceStateMail($record, 'client'));
                            Mail::to($record->supplier->email)->send(new InvoiceStateMail($record, 'fournisseur'));
                            Notification::make()
                                ->title('commande validée avec succès')
                                ->success()
                                ->icon('heroicon-o-information-circle')
                                ->duration(5000)
                                ->send();

                            return $record;
                        })
                        ->color('secondary')
                        ->icon('heroicon-o-check-circle')
                        ->visible(fn (Invoice $record) => $record->state_id == 48)
                        ->requiresConfirmation()
                        ->modalHeading('Validation de la commande')
                        ->modalSubheading(fn (Invoice $record) => 'Voulez-vous valider la commande "'.$record->code.'" ? Après ça elle ne pourra plus être modifiée'),

                    Action::make('state_livree')
                        ->label('Commande livrée')
                        ->action(fn (Invoice $record) => $record->update([
                            'state_id' => 51,
                        ]))
                        ->after(function (Invoice $record) {
                            //       //dd($record->title);
                            Mail::to(setting()->email)->send(new InvoiceStateMail($record, 'admin'));
                            Mail::to($record->customer->email)->send(new InvoiceStateMail($record, 'client'));
                            Mail::to($record->supplier->email)->send(new InvoiceStateMail($record, 'fournisseur'));

                            if ($record->state_id == 51) {
                                Notification::make()
                                    ->title('Statut de la commande mis à jour avec succès')
                                    ->success()
                                    ->icon('heroicon-o-information-circle')
                                    ->duration(5000)
                                    ->send();

                                return $record;
                            }
                        })
                        ->color('success')
                        ->icon('heroicon-o-truck')
                        ->visible(fn (Invoice $record) => $record->state_id == 50)
                        ->requiresConfirmation()
                        ->modalHeading('Livraison de la commande ')
                        ->modalSubheading(fn (Invoice $record) => 'La commande'.$record->code.' a-t-elle été livrée ?'),

                    // Annulation de la commande
                    Action::make('state_annulation')
                        ->label('Commande annulée')
                        ->action(fn (Invoice $record) => $record->update([
                          'state_id' => 52,
                        ]))
                        ->after(function (Invoice $record) {
                            $record->states()->attach(52, [
                                'user_created' => Auth::id(),
                            ]);
                            //       //dd($record->title);
                            Mail::to(setting()->email)->send(new InvoiceStateMail($record, 'admin'));
                            Mail::to($record->customer->email)->send(new InvoiceStateMail($record, 'client'));
                            Mail::to($record->supplier->email)->send(new InvoiceStateMail($record, 'fournisseur'));

                            if ($record->state_id == 52) {
                                Notification::make()
                                    ->title('Commande annulée avec succès')
                                    ->success()
                                    ->icon('heroicon-o-information-circle')
                                    ->duration(5000)
                                    ->send();

                                return $record;
                            }
                        })
                        ->color('danger')
                        ->icon('heroicon-o-x')
                        ->hidden(fn (Invoice $record) => $record->state_id == 51)
                        ->requiresConfirmation()
                        ->modalHeading('Annulation de la commande')
                        ->modalSubheading(fn (Invoice $record) => 'Voulez-vous annuler la commande'.$record->code.' ?'),

                    Action::make('state_affecte')
                        ->label('Affectée la commande')
                        ->action(fn (Invoice $record) => $record->update([
                             'state_id' => 49,
                         ]))
                        ->after(function (Invoice $record) {
                            $record->states()->attach(49, [
                                'user_created' => Auth::id(),
                            ]);
                            //dd($record->title);
                            Mail::to(setting()->email)->send(new InvoiceStateMail($record, 'admin'));
                            Mail::to($record->deliveryman->email)->send(new InvoiceStateMail($record, 'livreur'));
                            Mail::to($record->supplier->email)->send(new InvoiceStateMail($record, 'fournisseur'));

                            Notification::make()
                                ->title('La commande "'.$record->code.'" a été affectée à un livreur('.$record->deliveryman->fullname.') avec succès')
                                ->success()
                                ->icon('heroicon-o-information-circle')
                                ->duration(15000)
                                ->send();

                            return $record;
                        })
                        ->mountUsing(fn (ComponentContainer $form, Invoice $record) => $form->fill([
                            'deliveryman_id' => $record->deliveryman_id,
                        ]))
                        //->url(fn (Need $record): string => route('filament.resources.needs.edit', $record))
                        ->form([
                            Select::make('deliveryman_id')
                                ->label('Livreur')
                                ->options(User::role('livreur')->pluck('name', 'id'))
                                ->relationship('deliveryman', 'name', fn (Builder $query) => $query->role('livreur')->orderBy('created_at', 'asc'))
                                ->required(),
                        ])
                        ->color('primary')
                        ->icon('heroicon-o-truck')
                        //->requiresConfirmation()
                        ->visible(fn (Invoice $record) => $record->state_id == 269)
                        ->modalHeading('Affectation de la commande')
                        ->modalSubheading(fn (Invoice $record) => 'Affecter cette commande "'.$record->code.'" à un livreur !'),

                    Action::make('state_recupere')
                        ->label('Commande récupérée')
                        ->action(fn (Invoice $record) => $record->update([
                            'state_id' => 50,
                        ]))
                        ->after(function (Invoice $record) {
                            $record->states()->attach(50, [
                                'user_created' => Auth::id(),
                            ]);
                            //dd($record->title);
                            Mail::to(setting()->email)->send(new InvoiceStateMail($record, 'admin'));

                            Mail::to($record->supplier->email)->send(new InvoiceStateMail($record, 'fournisseur'));
                            Mail::to($record->customer->email)->send(new InvoiceStateMail($record, 'client'));

                            if ($record->state_id == 50) {
                                Notification::make()
                                    ->title('Statut de la commande mis à jour avec succès')
                                    ->success()
                                    ->icon('heroicon-o-information-circle')
                                    ->duration(5000)
                                    ->send();

                                return $record;
                            }
                        })
                        ->color('primary')
                        ->icon('heroicon-o-shopping-bag')
                        ->visible(fn (Invoice $record) => $record->state_id == 49)
                        ->requiresConfirmation()
                        ->modalHeading('Commande récupérée ?')
                        ->modalSubheading(fn (Invoice $record) => 'La commande '.$record->code.' a-t-elle été récupérée?'),

                ]),
                Action::make('imprimer')
                    ->label('')
                    ->color('danger')
                    ->icon('heroicon-o-download')
                    ->action(function (Invoice $record) {
                        return $record;
                    })
                    // ->modalContent(fn ($record) => view('filament.resources.event.actions.imprimer', ['record' => $record]))
                    ->url(fn (Invoice $record): string => route('imprimer', $record->code)),
                Tables\Actions\ViewAction::make(),
                //Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListInvoices::route('/'),
            //'create' => Pages\CreateInvoice::route('/create'),
            'view' => Pages\ViewInvoice::route('/{record}'),
            //'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->when(auth()->user()->hasRole(['fournisseur']), function ($q) {
                $q->whereSupplier_id(auth()->user()->id);
            })
            ->when(auth()->user()->hasRole(['livreur']), function ($q) {
                $q->whereDeliveryman_id(auth()->user()->id);
            })
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
