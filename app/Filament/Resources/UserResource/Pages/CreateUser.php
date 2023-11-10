<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Spatie\Permission\Models\Permission;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    /* protected function afterCreate(): void
    {
        $permission = Permission::create([
            'name' => $this->record->slug.'-index',
        ]);
        $permission->assignRole('super_admin');
    } */
}
