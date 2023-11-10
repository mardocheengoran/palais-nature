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


class WireWishlist extends Component
{
    use WithFileUploads, LivewireAlert;

    public $quantity;
    public $price_delivery;
    public $cart;
    public $valeur;
    public $name, $rowId;
    public $setting, $articles, $categories;

    public function mount()
    {
        journalisation('wishlist');
        $this->setting = setting();
        $this->articles = all_articles();
        $this->categories = Parameter::where('type_parameter_id', 17)
        ->orderByRaw('rank asc, created_at desc')
        ->whereNull('parent_id')
        ->get();
    }

    public function clear()
    {
        Cart::instance('wishlist')->destroy();
        $this->alert('success', 'Panier vidé avec succès', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
            'showCancelButton' => true,
            'cancelButtonText' => 'Fermer',
            'onDismissed' => '',
            'timerProgressBar' => true,
        ]);
        $this->emit('formClose');
    }

    public function destroy()
    {
        Cart::instance('wishlist')->remove($this->rowId);
        $this->cart = Cart::instance('wishlist')->content();
        journalisation('cart delete');
        $this->alert('success', $this->name.' supprimé du panier avec succès', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
            'showCancelButton' => true,
            'cancelButtonText' => 'Fermer',
            'onDismissed' => '',
            'timerProgressBar' => true,
        ]);
        $this->emit('formClose');
    }

    public function openModal($rowId, $name)
    {
        journalisation('cart openModal delete');
        $this->name = $name;
        $this->rowId = $rowId;
    }

    public function render()
    {
        $this->cart = Cart::instance('wishlist')->content();
        $this->price_delivery = coutLivraison(Cart::instance('wishlist')->subtotal());
        return view('livewire.checkout.wishlist')
        //->layout('layouts.guest')
        ->extends('layouts.app', [
            'title' => 'Panier',
            'setting' => $this->setting,
            'articles' => $this->articles,
            'categories' => $this->categories,
        ]);
    }
}
