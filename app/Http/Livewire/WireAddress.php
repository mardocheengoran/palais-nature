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


class WireAddress extends Component
{

    use WithFileUploads, LivewireAlert;

    public $setting;
    public $price_delivery, $invoice;
    public $valeur;
    public $title, $subtitle, $city, $location;
    public $addresses, $cities;

    public function mount()
    {
        $this->setting = Setting::find(1);
    }

    public function render()
    {
        $this->price_delivery = coutLivraison(Cart::instance('shopping')->subtotal());
        $this->addresses = Address::where([
            'user_id' => auth()->user()->id,
        ])
        ->orderBy('created_at', 'desc')
        ->get();

        $this->cities = Parameter::where([
            'type_parameter_id' => 2,
        ])
        ->orderBy('title', 'asc')
        ->get();

        $this->invoice = user_cart(Cookie::get('customer'))->cart->first();

        return view('livewire.checkout.address.index')
        ->layout('layouts.guest');
    }

    public function store()
    {
         $this->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'city' => 'required',
        ]); 
        if ($this->city == 270) {
            $this->validate([
                'location' => 'required',
            ]);
        }

        if ($this->valeur) {
            $this->valeur->update([
                'title' => $this->title,
                'subtitle' => $this->subtitle,
                'city_id' => $this->city,
                'location' => $this->location,

                'user_updated' => auth()->user()->id,
            ]);
            $message = 'Modification effectuée avec succès';
        }
        else {
            if ($this->city == 270) {
                Address::create([
                    'title' => $this->title,
                    'subtitle' => $this->subtitle,
                    'city_id' => $this->city,
                    'location' => $this->location,
                    'user_id' => auth()->user()->id,
                ]);
            } else {
                Address::create([
                    'title' => $this->title,
                    'subtitle' => $this->subtitle,
                    'city_id' => $this->city,
                    'user_id' => auth()->user()->id,
                ]);
            }
            $message = 'Ajout effectué avec succès';
        }

        $this->alert('success', $message, [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
            'showCancelButton' => true,
            'cancelButtonText' => 'Fermer',
            'onDismissed' => '',
            'timerProgressBar' => true,
        ]);
        $this->resetInputFields();
        $this->emit('formClose');
    }

    public function edit($address)
    {
        $this->valeur = $this->addresses->filter(function($value) use($address){
            return $value->id == $address;
        })
        ->first();
        //dd($this->valeur->toArray());
        journalisation('address openModal edit');
        $this->title = $this->valeur->title;
        $this->subtitle = $this->valeur->subtitle;
        $this->city = $this->valeur->city_id;
        $this->location = $this->valeur->location;
    }

    public function destroy()
    {
        $this->valeur->delete();
        $this->alert('success', 'Suppression effectuée avec succès', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
            'showCancelButton' => true,
            'cancelButtonText' => 'Fermer',
            'onDismissed' => '',
            'timerProgressBar' => true,
        ]);
        $this->resetInputFields();
        $this->emit('formClose');
    }

    public function choice($address)
    {
        $this->valeur = $this->addresses->filter(function($value) use($address){
            return $value->id == $address;
        })
        ->first();
        //dd($this->valeur->toArray());

        if (!$this->valeur) {
            /* $this->alert('error', 'Adresse inexistente', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
                'showCancelButton' => true,
                'cancelButtonText' => 'Fermer',
                'onDismissed' => '',
                'timerProgressBar' => true,
            ]); */
            toast('Adresse inexistente', 'warning')->autoClose(15000);
            redirect()->route('checkout.cart');
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
        $invoice->update([
            'address_id' => $address,
            'user_updated' => auth()->user()->id
        ]);
        redirect()->route('checkout.date');
    }

    private function resetInputFields(){
        $this->title = null;
        $this->subtitle = null;
        $this->city = null;
        $this->location = null;
    }
}
