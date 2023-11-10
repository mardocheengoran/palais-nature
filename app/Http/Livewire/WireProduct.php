<?php

namespace App\Http\Livewire;

use App\Mail\ContactMail;
use App\Models\Article;
use App\Models\Contact;
use App\Models\Parameter;
use App\Models\Setting;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class WireProduct extends Component
{
    use WithFileUploads, LivewireAlert;
    public $setting, $articles, $categories, $title, $filter = "", $search;

    public function mount()
    {
        $this->title = 'Tous les produits';
        $this->setting = setting();
        $this->articles = all_articles();
        $this->categories = Parameter::where('type_parameter_id', 17)
        ->orderByRaw('rank asc, created_at desc')
        ->whereNull('parent_id')
        //->paginate(8);
        //->limit($limit)
        ->get();
    }

    public function render()
    {
        //dd(request()->all());
        $this->search = request('search');
        $products = Article::with([
            'rubric',
            'audience',
            'categories',
        ])
        ->whereStatus(1)
        ->when($this->filter == "tous", function ($query) {
            $query->orderByRaw('articles.rank asc, created_at desc');
        })
        ->when($this->filter == "recent", function ($query) {
            $query->orderByRaw('created_at desc, articles.rank asc');
        })
        ->when($this->filter == "croissant", function ($query) {
            $query->orderByRaw('price_new asc, articles.rank asc');
        })
        ->when($this->filter == "decroissant", function ($query) {
            $query->orderByRaw('price_new desc, articles.rank asc');
        })
        ->when($this->search, function ($query) {
            $query->where('title','like','%'.$this->search.'%');
        })
        ->whereDate('published_at', '<=', Carbon::now())
        ->whereEnable(1)
        ->whereIn('rubric_id', [125])
        ->paginate(12);

        return view('products')->with([
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
