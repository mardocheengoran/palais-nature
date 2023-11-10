<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Cookie;
use App\Models\Parameter;
use Illuminate\Support\Facades\Auth;

class EditArticle extends EditRecord
{
    protected static string $resource = ArticleResource::class;
    public $category, $category1, $category2, $category3, $board, $rubric;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];

    }

    protected function getRedirectUrl(): string
    {
        if (Cookie::get('rubric')) {
            $cookie = '?tableFilters[Rubrique][value]='.Cookie::get('rubric');
        }
        else {
            $cookie = null;
        }
        return $this->getResource()::getUrl('index').$cookie;
    }

    protected function beforeSave(): void
    {
        $model = $this->form->getState();
        $this->rubric = $model['rubric_id'];
        if ($this->rubric == 125) {
            /* $this->category1 =  $model['category1'];
            $this->category2 =  $model['category2'];
            $this->category3 =  $model['category3'];
            $this->category = [$this->category1, $this->category2, $this->category3]; */
            //dd($this->category);
        }
    }


    protected function afterSave(): void
    {
        /* if ($this->rubric == 125) {
            $category = Parameter::where('id', $this->record->category2)->first();
            $this->record->update([
                'board' => $category->board,
            ]);
        } */
        /* $this->record->categories()->sync($this->category, [
            'user_updated' => Auth::id(),
        ]); */
        /* $this->record->categories()->attach($this->category2, [
            'user_updated' => Auth::id(),
        ]);
        $this->record->categories()->attach($this->category3, [
            'user_updated' => Auth::id(),
        ]); */
        //dd($this->record->category2,$this->record->board, $category->title, $category->board);
    }
}
