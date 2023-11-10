<?php

namespace App\Providers;

use App\Filament\Resources\ParameterResource;
use App\Filament\Resources\TypeParameterResource;
use App\Models\Article;
use App\Models\Parameter;
use App\Models\TypeParameter;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\UserMenuItem;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;

class AppServiceProvider extends ServiceProvider
{
    public $user;
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        setlocale(LC_TIME, 'fr_FR', 'fr', 'FR', 'French', 'fr_FR.UTF-8');
        Carbon::setLocale(config('app.locale'));

        Activity::saving(function (Activity $activity) {
            $activity->properties = $activity->properties->put('agent', [
                'ip' => request()->ip(),
                'agent' => request()->header('User-Agent'),
                'url' => request()->fullUrl(),
            ]);
        });
    }
}
