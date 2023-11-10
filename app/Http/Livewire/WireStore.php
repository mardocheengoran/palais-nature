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


class WireStore extends Component
{
    use WithFileUploads, LivewireAlert;
    public $setting, $articles, $categories, $users;

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
        $this->users = User::Role(['fournisseur'])->get();

        return view('boutique.index')
        ->extends('layouts.app', [
            'title' => 'Boutiques',
            'setting' => $this->setting,
            'categories' => $this->categories,
            'articles' => $this->articles,
        ]);
    }
}
