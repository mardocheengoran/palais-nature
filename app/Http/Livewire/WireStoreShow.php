<?php

namespace App\Http\Livewire;

use App\Models\Article;
use App\Models\Parameter;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class WireStoreShow extends Component
{
    use WithFileUploads, LivewireAlert;
    public $setting, $articles, $categories, $users, $title;

    public function mount($users)
    {
       $this->users = User::find($users);
       $this->title = 'Tous nos produits';
       journalisation('boutique show', $this->users);
       $this->setting = setting();
       $this->categories = Parameter::where('type_parameter_id', 17)
       ->orderByRaw('rank asc, created_at desc')
       ->whereNull('parent_id')
       ->get();
    }

    public function render()
    {
        $this->articles = all_articles();
        $products = Article::whereSupplier_id($this->users->id)
        ->orderByRaw('articles.rank asc, created_at desc')
        ->whereDate('published_at', '<=', Carbon::now())
        ->whereEnable(1)
        ->whereIn('rubric_id', [125])
        ->paginate(12);
        //dd($products->toArray());

        return view('boutique.show')->with([
            'products' => $products,
        ])
        ->extends('layouts.app', [
            'title' => $this->title,
            'setting' => $this->setting,
            'categories' => $this->categories,
            'articles' => $this->articles,
        ]);
    }
}
