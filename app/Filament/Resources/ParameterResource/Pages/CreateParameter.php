<?php

namespace App\Filament\Resources\ParameterResource\Pages;

use App\Filament\Resources\ParameterResource;
use App\Models\Parameter;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Cookie;
use Spatie\Permission\Models\Permission;

class CreateParameter extends CreateRecord
{
    protected static string $resource = ParameterResource::class;


   /*  protected function beforeCreate(): void
    {
        $model = $this->form->getState();
        dd($model);
            
        } */
    protected function getRedirectUrl(): string
    {
        if (Cookie::get('type')) {
            $cookie = '?type='.Cookie::get('type').'&tableFilters[Type+Parametre][value]='.Cookie::get('type');
        }
        else {
            $cookie = null;
        }
        return $this->getResource()::getUrl('index').$cookie;
    }

    protected function afterCreate(): void
    {
        $model = $this->record;
        if ($model->type_parameter_id == 1) {
            $permission = Permission::create([
                'name' => $model->slug.'_article',
            ]);
            $permission->assignRole('super_admin');
        }
        $model->update([
            'type_parameter_id' => Cookie::get('type'),
        ]);
    }
}

