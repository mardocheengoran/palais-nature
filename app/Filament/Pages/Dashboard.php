<?php

namespace App\Filament\Pages;

use Closure;
use Filament\Pages\Page;
use Filament\Facades\Filament;
use App\Filament\Widgets\GlobalChart;
use App\Filament\Widgets\ListInvoice;
use App\Filament\Widgets\ListProduct;
use Illuminate\Support\Facades\Route;
use App\Filament\Widgets\InvoiceChart;
use App\Filament\Widgets\StatsOverviewWidget;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use App\Filament\Resources\NeedResource\Widgets\ListNeed;

class Dashboard extends Page
{
    //use HasPageShield;
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?int $navigationSort = -2;

    protected static string $view = 'filament.pages.dashboard';

    //protected static ?string $slug = '/admin';


    /* protected function getShieldRedirectPath(): string {
        return '/admin/needs'; // redirect to the root index...
    } */

    protected static function getNavigationLabel(): string
    {
        return static::$navigationLabel ?? static::$title ?? __('filament::pages/dashboard.title');
    }

    public static function getRoutes(): Closure
    {
        return function () {
            Route::get('/', static::class)->name(static::getSlug());
        };
    }

    protected function getWidgets(): array
    {
        if (auth()->user()->hasRole(['livreur'])){
            return [
                ListInvoice::class,
            ];
        }
        else
        {
            return [
                "Filament\Widgets\AccountWidget",
                GlobalChart::class,
                //StatsOverviewWidget::class,
                ListInvoice::class,
                ListProduct::class,
                InvoiceChart::class,
            ];
        }
        //return Filament::getWidgets();
    }

    protected function getColumns(): int | array
    {
        return 1;
    }

    protected function getTitle(): string
    {
        if (auth()->user()->hasRole(['fournisseur'])){
            return __('Bienvenue dans le Tableau de bord fournisseur');
        }
        elseif (auth()->user()->hasRole(['admin', 'super_admin'])) {
            return __('Tableau de bord administrateur');
        }
        elseif (auth()->user()->hasRole(['livreur'])) {
            return __('Tableau de bord livreur');
        }
        else {
            return __('Tableau de bord');
        }
    }
}
