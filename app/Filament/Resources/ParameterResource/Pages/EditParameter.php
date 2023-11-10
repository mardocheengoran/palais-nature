<?php

namespace App\Filament\Resources\ParameterResource\Pages;

use App\Filament\Resources\ParameterResource;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Cookie;
use App\Models\Article;

class EditParameter extends EditRecord
{
    protected static string $resource = ParameterResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function afterSave(): void
    {
        $article = Article::all()->where('category2',$this->record->id);

        foreach ($article as $key => $value) {
            $value->update([
                'board' => $this->record->board,
            ]); 
        }
        //dd($this->record->board,$article->toArray());
    }

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
}
