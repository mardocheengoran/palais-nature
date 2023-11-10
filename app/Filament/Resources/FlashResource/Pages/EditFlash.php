<?php

namespace App\Filament\Resources\FlashResource\Pages;

use App\Filament\Resources\FlashResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFlash extends EditRecord
{
    protected static string $resource = FlashResource::class;

    protected function getTitle(): string
    {
        return static::$title ?? __('Modification de la vente flash');
    }
    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function afterSave(): void
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
}
