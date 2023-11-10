<?php

namespace App\Http\Livewire;

use App\Models\Address;
use App\Models\Article;
use App\Models\Country;
use App\Models\Parameter;
use App\Models\Setting;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class WireRelay extends Component
{
    use WithFileUploads, LivewireAlert;

    public $setting;
    public $price_delivery, $invoice;
    public $valeur;
    public $relays;
    public $relay = 53;

    public function mount()
    {
    }

    public function render()
    {
        $this->setting = Setting::find(1);
        $this->price_delivery = coutLivraison(Cart::instance('shopping')->subtotal());
        $this->relays = Parameter::where([
            'type_parameter_id' => 23,
        ])
        ->orderBy('title', 'asc')
        ->get();
        $this->invoice = user_cart(Cookie::get('customer'))->cart->first();

        return view('livewire.checkout.payment')
        ->layout('layouts.guest');
    }

    public function next()
    {
        $this->validate([
            'payment' => 'required',
        ]);
        $user = user_cart(Cookie::get('customer'));
        if (count($user->cart) == 0) {
            $this->alert('error', 'Panier vide', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
                'showCancelButton' => true,
                'cancelButtonText' => 'Fermer',
                'onDismissed' => '',
                'timerProgressBar' => true,
            ]);
            redirect()->route('checkout.cart');
        }
        $invoice = $user->cart->first();
        $invoice->update([
            'payment_method_id' => $this->payment,
            'user_updated' => auth()->user()->id
        ]);
        if ($this->payment == 53) {
            redirect()->route('checkout.resume');
        }
        else {
            $this->alert('warning', 'Choix indisponible', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
                'showCancelButton' => true,
                'cancelButtonText' => 'Fermer',
                'onDismissed' => '',
                'timerProgressBar' => true,
            ]);
        }
    }

    private function resetInputFields(){
        $this->title = null;
        $this->subtitle = null;
        $this->city = null;
    }
}
