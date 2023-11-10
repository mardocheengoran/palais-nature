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


class WireDate extends Component
{

    use WithFileUploads, LivewireAlert;

    public $setting;
    public $price_delivery, $invoice;
    public $valeur;
    public $date;

    public function mount()
    {
    }

    public function render()
    {
        $this->setting = Setting::find(1);
        $this->price_delivery = coutLivraison(Cart::instance('shopping')->subtotal());
        $this->invoice = user_cart(Cookie::get('customer'))->cart->first();

        return view('livewire.checkout.date')
        ->layout('layouts.guest');
    }

    public function choice($type = 1)
    {
        if ($type == 1) {
            $this->validate([
                'date' => 'required|date',
            ]);
            $this->date = Carbon::createFromDate($this->date);
        }
        else {
            $this->date = Carbon::tomorrow();
        }
        $user = user_cart(Cookie::get('customer'));
        if (count($user->cart) == 0) {
            /* $this->alert('error', 'Panier vide', [
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
        $invoice = $user->cart->first();
        if($this->date->format('D') == 'Sun'){
            $this->date->addDay();
            toast('La date de la livraison de votre commande étant un dimanche sera reportée au '.$this->date->formatLocalized('%A %d %B %Y'),'warning')->autoClose(60000);
        }
        $invoice->update([
            'planned_at' => $this->date,
            'user_updated' => auth()->user()->id
        ]);
        redirect()->route('checkout.payment');
    }

    private function resetInputFields(){
        $this->title = null;
        $this->subtitle = null;
        $this->city = null;
    }
}
