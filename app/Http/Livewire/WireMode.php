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


class WireMode extends Component
{
    use WithFileUploads, LivewireAlert;

    public $setting, $categories;
    public $price_delivery, $invoice;
    public $valeur;
    public $modes;
    public $mode = 175;

    public function mount()
    {
        journalisation('cart');
        $this->setting = setting();
        $this->categories = Parameter::where('type_parameter_id', 17)
        ->orderByRaw('rank asc, created_at desc')
        ->whereNull('parent_id')
        ->get();
    }

    public function render()
    {
        $this->price_delivery = coutLivraison(Cart::instance('shopping')->subtotal());
        $this->invoice = user_cart(Cookie::get('customer'))->cart->first();
        //dd($this->invoice->cart->first()->deliveryMode->toArray());

        $this->modes = Parameter::where([
            'type_parameter_id' => 21,
        ])
        ->orderBy('title', 'asc')
        ->get();

        return view('livewire.checkout.mode')
        ->extends('layouts.app', [
            'title' => 'PanMode de livraisonier',
            'setting' => $this->setting,
            'categories' => $this->categories,
        ]);
    }

    public function next()
    {
        //dd($this->mode);
        $this->validate([
            'mode' => 'required',
        ]);
        $user = user_cart(Cookie::get('customer'));
        if (count($user->cart) == 0) {
            //dd(count($user->cart));
            /* $this->alert('error', 'Utilisateur non valide', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
                'showCancelButton' => true,
                'cancelButtonText' => 'Fermer',
                'onDismissed' => '',
                'timerProgressBar' => true,
            ]); */
            toast('Panier vide', 'warning')->autoClose(15000);
            redirect()->route('checkout.cart');
        }
        else {
            $invoice = $user->cart->first();
            $invoice->update([
                'delivery_mode_id' => $this->mode,
                'user_updated' => auth()->user()->id
            ]);
            redirect()->route('checkout.address');
        }
    }

    private function resetInputFields(){
        $this->title = null;
    }
}
