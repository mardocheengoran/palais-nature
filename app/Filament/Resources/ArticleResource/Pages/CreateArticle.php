<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Cookie;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Parameter;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;
    public $category1, $category2, $category3, $board, $rubric;

    protected function beforeCreate(): void
    {
        $model = $this->form->getState();
        $this->rubric = $model['rubric_id'];
        if ($this->rubric == 125) {
            $this->category1 =  $model['category1'];
            $this->category2 =  $model['category2'];
            $this->category3 =  $model['category3'];
        }
        //$this->categorie = [$categorie1, $categorie2, $categorie3];
        //dd($model, $this->category1, $this->category2, $this->category3);

        //$this->form->model($post)->saveRelationships();

    }

    protected function afterCreate(): void
    {
        if (auth()->user()->hasRole(['fournisseur'])) {
            $this->record->update([
                'supplier_id' => auth()->user()->id,
            ]);
        }
        if (auth()->user()->hasRole(['admin', 'super_admin'])) {
            $this->record->update([
                'status' => 1,
            ]);
        }
        if ($this->rubric == 125) {
            $this->record->categories()->attach($this->category1, [
                'user_created' => Auth::id(),
            ]);
            $this->record->categories()->attach($this->category2, [
                'user_created' => Auth::id(),
            ]);
            $this->record->categories()->attach($this->category3, [
                'user_created' => Auth::id(),
            ]);


            $this->board = Parameter::where('id',$this->category2)->first();
            $this->record->update([
                'board' => $this->board->board,
            ]);
        }
        //dd($this->record);
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
}

