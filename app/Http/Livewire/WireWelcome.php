<?php

namespace App\Http\Livewire;

use App\Models\Article;
use App\Models\Flash;
use App\Models\Parameter;
use App\Models\Setting;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class WireWelcome extends Component
{
    use WithFileUploads, LivewireAlert;
    public $setting, $articles, $categories, $email, $categoriesHome;

    public $showdiv = false;
    public $search = "";
    public $records;

    public function mount()
    {
        journalisation('home');
        $this->setting = setting();
        $this->articles = all_articles();
        $this->categories = Parameter::where('type_parameter_id', 17)
        ->withCount('products')
        ->orderByRaw('rank asc, created_at desc')
        ->whereNull('parent_id')
        //->whereHome(1)
        //->limit($limit)
        ->get();

        $this->categoriesHome = Parameter::where('type_parameter_id', 17)
        ->with([
            'products' => function ($query) {
                $query->orderByRaw('rank asc, created_at desc');
            },
        ])
        ->withCount('products')
        ->orderByRaw('rank asc, products_count desc, created_at desc')
        ->whereNull('parent_id')
        //->whereHome(1)
        //->limit($limit)
        ->get();
    }

    public function render()
    {
        return view('welcome')
        ->extends('layouts.app', [
            'title' => 'Accueil',
            'setting' => $this->setting,
            'articles' => $this->articles,
            'categories' => $this->categories,
        ]);
    }

    public function sending()
    {
        //dd(3);
        $this->validate([
            'email' => 'required|email',
        ]);

        $this->alert('success', 'Souscription effectuée avec succès', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
            'showCancelButton' => true,
            'cancelButtonText' => 'Fermer',
            'onDismissed' => '',
            'timerProgressBar' => true,
        ]);
    }

    // Fetch records
    public function searchResult()
    {
        if(!empty($this->search)){
            $this->records = Article::whereRubric_id(125)
            ->orderby('title', 'asc')
            ->select('*')
            ->where('title','like','%'.$this->search.'%')
            ->limit(5)
            ->get();
            $this->showdiv = true;
        }else{
            $this->showdiv = false;
        }
    }
}
