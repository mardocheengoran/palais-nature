<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            //

            /* Card::make("Nombre d'articles", '192.1k'),
            Card::make('Bounce rate', '21%'),
            Card::make('Average time on page', '3:12'),

            $articles = Article::select('created_at','title')->count(),

            Card::make('Nombre des articles', Article::select('created_at','title')->count(),)
            ->description('32k increase')
            ->descriptionIcon('heroicon-s-trending-up')
            ->color('success'),

            Card::make('Bounce rate', '21%')
                ->description('7% increase')
                ->descriptionIcon('heroicon-s-trending-down')
                ->color('danger'),
            Card::make('Average time on page', '3:12')
                ->description('3% increase')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'), */
        ];
    }
}
