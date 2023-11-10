<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use App\Mail\InvoiceStateMail;
use App\Models\Invoice;
use App\Models\User;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Builder;

class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;
    protected static string $view = 'filament.pages.invoice.view';

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),



            Actions\ActionGroup::make([

                // Validation de la commande
                /* Action::make('state_id')
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
                    ->modalSubheading(fn (Invoice $record) => 'La commande '.$record->code.' a-t-elle été récupérée?'),*/
            ])
        ];
    }
    protected function getTitle(): string
    {
        return static::$title ?? __('Détail de la commande : '.$this->record->code);
    }

    protected function getBreadcrumbs(): array
    {
        return [
            route('filament.resources.invoices.index') => __('Commandes'),
            "#" => __('Détails'),
        ];
    }
}
