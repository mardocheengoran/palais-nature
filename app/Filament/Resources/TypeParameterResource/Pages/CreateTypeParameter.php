<?php

namespace App\Filament\Resources\TypeParameterResource\Pages;

use App\Filament\Resources\TypeParameterResource;
use App\Models\Parameter;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Cookie;
use Spatie\Permission\Models\Permission;

class CreateTypeParameter extends CreateRecord
{
    protected static string $resource = TypeParameterResource::class;

    protected function afterCreate(): void
    {
        $model = $this->record;
        $actions = Parameter::whereType_parameter_id(18)->get();
        foreach ($actions as $key => $value) {
            $permission = Permission::create([
                'name' => 't-'.$model->slug.'-'.$value->slug,
            ]);
            $permission->assignRole('super_admin');
        }
    }
}

