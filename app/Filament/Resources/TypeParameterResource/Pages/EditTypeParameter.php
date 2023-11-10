<?php

namespace App\Filament\Resources\TypeParameterResource\Pages;

use App\Filament\Resources\TypeParameterResource;
use App\Models\Parameter;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Cookie;
use Spatie\Permission\Models\Permission;

class EditTypeParameter extends EditRecord
{
    protected static string $resource = TypeParameterResource::class;

    /* protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    } */

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        /* $model = $this->record;
        $actions = Parameter::whereType_parameter_id(18)->get();
        foreach ($actions as $key => $value) {
            $permission = Permission::create([
                'name' => 't-'.$model->slug.'-'.$value->slug,
            ]);
            $permission->assignRole('super_admin');
        } */
    }
}
