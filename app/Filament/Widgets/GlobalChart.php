<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\Budget;
use App\Models\Committee;
use App\Models\Invoice;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\Widget;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Illuminate\Support\Facades\Route;

class GlobalChart extends BaseWidget
{
    //protected static string $view = 'filament.widgets.budget-chart';

    protected static ?int $sort = 0;
    //protected static string $view = 'filament.pages.budget';
    protected static ?string $pollingInterval = '150s';

    protected function getCards(): array
    {
        $total_products = Article::whereRubric_id(125)
        ->when(auth()->user()->hasRole('fournisseur'), function ($query) {
            return $query->where('supplier_id', auth()->user()->id);
        })
        ->count();
        $total_invoice = Invoice::when(auth()->user()->hasRole('fournisseur'), function ($query) {
            return $query->where('supplier_id', auth()->user()->id);
        })
        ->get()
        ->count();
        $sum_invoice = Invoice::when(auth()->user()->hasRole('fournisseur'), function ($query) {
            return $query->where('supplier_id', auth()->user()->id);
        })
        ->sum('price_final');
        $total_customer = User::role('client')
        ->count();
        //dd($amount_popose, $amount_valid);
        return [
            Card::make('Total produits', $total_products)
                ->description('Nombre total des produits')
                ->descriptionIcon('heroicon-s-trending-down')
                //->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('warning'),
            Card::make('Toutes les commandes', $total_invoice)
                ->description('Nombre total de commandes')
                ->descriptionIcon('heroicon-s-trending-up')
                //->chart([17, 16, 14, 15, 14, 13, 12])
                ->color('primary'),
            Card::make('Chiffre d\'affaires', devise($sum_invoice))
                ->description('Cout total des commandes')
                ->descriptionIcon('heroicon-s-chart-pie')
                //->chart([17, 16, 14, 15, 14, 13, 12])
                ->color('danger'),
            /* Card::make('Total client', $total_customer)
                ->description('Tous les clients inscrits')
                ->descriptionIcon('heroicon-s-star')
                //->chart([17, 16, 14, 15, 14, 13, 12])
                ->color('success'), */
        ];
    }
}
