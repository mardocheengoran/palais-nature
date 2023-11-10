<?php

namespace App\Filament\Resources\FlashResource\Pages;

use App\Filament\Resources\FlashResource;
use App\Models\Article;
use App\Models\ArticleFlash;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFlash extends CreateRecord
{
    protected static string $resource = FlashResource::class;
    protected function getTitle(): string
    {
        return static::$title ?? __('Créer une vente flash');
    }
    protected function afterCreate(): void
    {
        $model = $this->record;
        //dd($model->articles->toArray());
        foreach ($model->articles as $key => $article) {
            /* $item = ArticleFlash::where([
                'article_id' => $article->id,
                'flash_id' => $model->id,
            ])
            ->first();
            if ($item) {
                $item->update([
                    'price_new' => $article->price_new - ($article->price_new * $item->price_discount/100),
                ]);
            } */
            $article->pivot->update([
                'price_new' => $article->price_new - ($article->price_new * $article->pivot->price_discount/100),
            ]);
        }
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
