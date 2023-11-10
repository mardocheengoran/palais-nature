<?php

namespace App\Http\Livewire;

use App\Mail\InvoiceMail;
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
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class WireResume extends Component
{

    use WithFileUploads, LivewireAlert;

    public $setting;
    public $price_delivery, $invoice;
    public $cart;
    public $valeur;
    public $payments;
    public $payment = 53;

    public function mount()
    {
        $this->cart = Cart::instance('shopping')->content();
    }

    public function render()
    {
        $this->setting = Setting::find(1);
        $this->price_delivery = coutLivraison(Cart::instance('shopping')->subtotal());
        $this->invoice = user_cart(Cookie::get('customer'))->cart->first();
        return view('livewire.checkout.resume')
        ->layout('layouts.guest');
    }

    public function next()
    {
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
        $quantity = count(Cart::instance('shopping')->content());
        $price_ht = Cart::instance('shopping')->subtotal();
        $price_delivery = coutLivraison($price_ht);
        $price_final = $price_ht + $price_delivery;
        //dd($invoice->toArray());
        // Si on déjà une commande en cours. On fait une mise à jour et on continue
        $invoice->update([
            'type' => 'product',
            'quantity' => $quantity,
            'price_ht' => $price_ht,
            'price_delivery' => $price_delivery,
            'price_final' => $price_final,
            'customer_id' => Cookie::get('customer'),
            'state_id' => 48,
            'ip' => request()->ip(),
            'user_updated' => auth()->user()->id
        ]);
        pivot_invoice_MAJ($invoice);

         // Notifier l'adminitrateur
         foreach (['developpeur@qenium.com', $this->setting->email] as $recipient) {
            Mail::to($recipient)->send(new InvoiceMail($invoice, 'administrateur'));
        }
        // Notifier le client
        Mail::to(auth()->user()->email)->send(new InvoiceMail($invoice, 'client'));
        Cart::instance('shopping')->destroy();
        Cookie::queue(Cookie::forget('custom'));
        toast('Félicitation ','success')->autoClose(10000);

        redirect()->route('checkout.congrat', $invoice->code);
    }
}
