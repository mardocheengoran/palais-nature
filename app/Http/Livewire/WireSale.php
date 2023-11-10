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
use Jantinnerezo\LivewireAlert\LivewireAlert;


class WireSale extends Component
{

    use WithFileUploads, LivewireAlert;

    public $setting;
    public $quantity;
    public $price_delivery;
    public $cart;
    public $valeur;

    public function mount()
    {
    }

    public function render()
    {
        $this->setting = Setting::find(1);
        $this->price_delivery = coutLivraison(Cart::instance('shopping')->subtotal());
        return view('livewire.checkout.cart')
        ->layout('layouts.guest');
    }

    private function resetInputFields(){
        $this->title = null;
    }
}
