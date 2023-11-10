<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Foundation\Vite;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\ServiceProvider;
use App\Filament\Resources\RoleResource;
use App\Filament\Resources\UserResource;
use App\Filament\Resources\PermissionResource;
use App\Models\Parameter;
use App\Models\TypeParameter;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\HtmlString;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yepsua\Filament\Themes\Facades\FilamentThemes;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {

        if (!Cookie::get('type')) {
            Cookie::queue(Cookie::make('type', 1, 60*60*24*365));
        }
        if (!Cookie::get('rubric')) {
            Cookie::queue(Cookie::make('rubric', 1, 60*60*24*365));
        }

        Filament::serving(function() {
            if (auth()->user()) {
                $types = TypeParameter::withCount('parameters')
                //->whereStatus(1)
                ->orderByRaw('type_parameters.rank asc, title asc')
                ->get();

                //dd($types->toArray());

                /* $arr = [
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
                $type_parameters = preg_filter('/^/', 'tp_', $type_parameters);
                $array = array_merge($arr, $type_parameters);
                dd($array); */

                foreach ($types as $key => $value) {
                    $permission = Permission::whereName($value->slug.'_parameter')
                    ->first();
                    if ($permission) {
                        if(auth()->user()->hasPermissionTo($value->slug.'_parameter')){
                            Filament::registerNavigationItems([
                                NavigationItem::make($value->title)
                                ->url(route('filament.resources.parameters.index').'?type='.$value->id.'&tableFilters[Type+Parametre][value]='.$value->id)
                                ->icon($value->icon)
                                ->isActiveWhen(fn (): bool => (request('type') == $value->id and request()->routeIs('filament.resources.parameters.*')) or (Cookie::get('type') == $value->id and !request('type') and request()->routeIs('filament.resources.parameters.*'))  )
                                ->group($value->subtitle)
                                ->badge($value->parameters_count)
                                ->sort(3),
                            ]);
                        }
                    }
                }
                $rubrics = Parameter::withCount('articles')
                //->whereStatus(1)
                ->where([
                    'type_parameter_id' => 1,
                ])
                ->orderByRaw('parameters.rank asc, title asc')
                ->get();
                //dd($rubrics->toArray());
                foreach ($rubrics as $key => $value) {
                    $permission = Permission::whereName($value->slug.'_article')
                    ->first();
                    if ($permission) {
                        if(auth()->user()->hasPermissionTo($value->slug.'_article')){
                            if (auth()->user()->hasRole(['fournisseur'])) {
                                $count = $value->articles->where('supplier_id', auth()->user()->id)->count();
                            }
                            else {
                                $count = $value->articles_count;
                            }
                            Filament::registerNavigationItems([
                                NavigationItem::make($value->title)
                                ->url(route('filament.resources.articles.index').'?rubric='.$value->id.'&tableFilters[Rubrique][value]='.$value->id)
                                ->icon($value->icon)
                                ->isActiveWhen(fn (): bool => (request('rubric') == $value->id and request()->routeIs('filament.resources.articles.*')) or (Cookie::get('rubric') == $value->id and !request('rubric') and request()->routeIs('filament.resources.articles.*'))  )
                                ->group($value->subtitle)
                                ->badge($count)
                                ->sort(3),
                            ]);
                        }
                    }
                }

                $roles = Role::withCount('users')
                ->orderBy('name', 'asc')
                ->get();
                foreach ($roles as $key => $value) {
                    if(auth()->user()->hasPermissionTo($value->name.'_user')){
                        switch ($value->name) {
                            case 'super_admin':
                                $icon = 'heroicon-o-cog';
                                break;
                            case 'admin':
                                $icon = 'heroicon-o-user-circle';
                                break;
                            case 'fournisseur':
                                $icon = 'heroicon-o-support';
                                break;
                            case 'livreur':
                                $icon = 'heroicon-o-globe';
                                break;

                            default:
                            $icon = 'heroicon-o-user-group';
                                break;
                        }
                        $role_name = $value->name;
                        if ($value->name == 'demandeur') {
                            $role_name = 'bénéficiaire';
                        }
                        Filament::registerNavigationItems([
                            NavigationItem::make( str_replace('_', ' ', ucfirst($role_name)))
                            ->url(route('filament.resources.users.index').'?tableFilters[Role][value]='.$value->id)
                            ->icon($icon)
                            //->isActiveWhen(fn (): bool => (request('type') == $value->id and request()->routeIs('filament.resources.parameters.*')) or (Cookie::get('type') == $value->id and !request('type') and request()->routeIs('filament.resources.parameters.*'))  )
                            ->isActiveWhen(fn (): bool => ((isset($_GET['tableFilters']['Role']['value']) and $_GET['tableFilters']['Role']['value'] == $value->id) and request()->routeIs('filament.resources.users.*')))
                            ->group('Utilisateurs')
                            ->badge($value->users_count)
                            ->sort(2),
                        ]);
                    }
                }
                 Filament::registerUserMenuItems([
                    'setting' => UserMenuItem::make()
                    ->label('Réglages')
                    ->url(route('filament.resources.settings.index'))
                    ->icon('heroicon-s-cog'),

                    /* 'users' => UserMenuItem::make()
                    ->label('Utilisateurs')
                    ->icon('heroicon-s-user-group')
                    ->url(route('filament.resources.users.index')), */
                ]);
            }

            /* Filament::registerTheme(
                app(Vite::class)('resources/css/app.css'),
            ); */
        });

        FilamentThemes::register(function($path) {
            // Using Vite:
            return app(\Illuminate\Foundation\Vite::class)('resources/' . $path);
            // Using Mix:
            return app(\Illuminate\Foundation\Mix::class)($path);
            // Using asset()
            return asset($path);
        });
    }
}
