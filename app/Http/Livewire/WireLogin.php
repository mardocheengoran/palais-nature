<?php

namespace App\Http\Livewire;

use App\Models\Article;
use App\Models\Parameter;
use App\Models\Setting;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class WireLogin extends Component
{
    use WithFileUploads, LivewireAlert;
    public $setting, $articles, $categories;

    public function mount()
    {
        journalisation('home');
        $this->setting = setting();
        $this->articles = all_articles();
        $this->categories = Parameter::where('type_parameter_id', 17)
        ->orderByRaw('rank asc, created_at desc')
        ->whereNull('parent_id')
        ->get();


    }

    public function render()
    {
        return view('auth.login')
        ->extends('layouts.app', [
            'title' => 'Accueil',
            'setting' => $this->setting,
            'categories' => $this->categories,
            'articles' => $this->articles,
        ]);
    }
}
