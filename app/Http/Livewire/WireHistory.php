<?php

namespace App\Http\Livewire;

use App\Models\Address;
use App\Models\Article;
use App\Models\Country;
use App\Models\Invoice;
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
use Spatie\Activitylog\Models\Activity;

class WireHistory extends Component
{
    use WithFileUploads, LivewireAlert;
    public $setting, $articles, $categories;
    public $user;
    public $valeur, $invoice;
    public $title, $subtitle, $city;
    public $addresses, $cities;

    public function mount()
    {
        journalisation('profil history');
        $this->setting = setting();
        $this->articles = all_articles();
        $this->categories = Parameter::where('type_parameter_id', 17)
        ->orderByRaw('rank asc, created_at desc')
        ->whereNull('parent_id')
        ->get();
        $this->title = 'Produits vus récemment';
    }

    public function render()
    {
        $this->user = User::with([
            'childrens',
            'parent',
            'invoices_check',
            'addresses',
        ])
        ->find(auth()->user()->id);

        $activities = Activity::where([
            'causer_type' => "App\Models\User",
            'causer_id' => auth()->user()->id,
            'description' => "article show",
        ])
        ->orderBy('id', 'desc')
        ->get()
        ->unique('subject_id')
        ->pluck('subject_id')
        ->toArray();
        $products = Article::with([
            'rubric',
            'audience',
            'categories',
        ])
        ->orderByRaw('articles.rank asc, created_at desc')
        ->whereDate('published_at', '<=', Carbon::now())
        ->whereEnable(1)
        ->whereIn('rubric_id', [125])
        ->whereIn('id', $activities)
        ->paginate(12);
        //dd($products->toArray());

        return view('livewire.profil.history')->with([
            'products' => $products,
        ])
        ->extends('layouts.app', [
            'title' => $this->title,
            'setting' => $this->setting,
            'articles' => $this->articles,
            'categories' => $this->categories,
        ]);
    }
}
