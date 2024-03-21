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


class WireCart extends Component
{
    use WithFileUploads, LivewireAlert;

    public $quantity;
    public $price_delivery;
    public $cart;
    public $valeur;
    public $name, $rowId;
    public $setting, $articles, $categories;
    public $content;

    public function mount()
    {
        journalisation('cart');
        $this->setting = setting();
        $this->articles = all_articles();
        $this->categories = Parameter::where('type_parameter_id', 17)
        ->orderByRaw('rank asc, created_at desc')
        ->whereNull('parent_id')
        ->get();
        /* $this->cart = [
            ['code' => null, 'jour_id' => null, 'title' => null, 'description' => null, 'demandes' => array()]
        ]; */
        //$this->cart = [];
        /* foreach (Cart::instance('shopping')->content() as $key => $value) {
            $this->cart[] = $value;
        } */
        //$this->cart = Cart::instance('shopping')->content();
        //dd($this->cart);
    }

    /* public function addCart()
    {
        $this->cart[] = [
            'code' => null, 'jour_id' => null, 'title' => null, 'description' => null, 'demandes' => array()
        ];
    } */

    public function removeCart($index)
    {
        //dd($this->orderProducts[$index]['id']);
        /* unset($this->cart[$index]);
        $this->orderProducts = array_values($this->orderProducts); */
    }

    public function updatedCart()
    {
        //$this->cart = collect($this->cart);
        //dd($this->cart);

        /* $this->orderProducts = collect($this->orderProducts)
        ->map(function ($product) {
            if ($product['prix'] != '' && $product['quantite'] != '') {
                $total = $product['prix'] * $product['quantite'];
                $product['total'] = round($total, 2);
            }
            return $product;
        })->toArray(); */
    }

    public function plus($rowId, $value)
    {
        //dd($this->cart);
        /* $filtered = Arr::first($this->cart, function ($value, $key) use($rowId) {
            dd($value['rowId'], $rowId);
            return $value['rowId'] == $rowId;
        });
        $this->quantity = $filtered['qty'] + $value; */
        //dd($this->quantity);

        $filtered = Cart::instance('shopping')->search(function ($cartItem) use($rowId) {
            return $cartItem->rowId == $rowId;
        });
        $this->quantity = $filtered->first()->qty + $value;
        //dd($this->quantity);
        if ($this->quantity > 0) {
            Cart::instance('shopping')->update($rowId, $this->quantity); // Will update the quantity
            $this->cart = Cart::instance('shopping')->content();
            $this->alert('success', 'Panier mise à jour avec succès', [
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

    public function clear()
    {
        Cart::instance('shopping')->destroy();
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
        Cart::instance('shopping')->remove($this->rowId);
        $this->cart = Cart::instance('shopping')->content();
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
        //dd($rowId, $name);
        /* $filtered = Cart::instance('shopping')->search(function ($cartItem) use($rowId) {
            return $cartItem->rowId == $rowId;
        });
        $this->valeur = $filtered; */
        //dd($this->valeur);
        journalisation('cart openModal delete');
        $this->name = $name;
        $this->rowId = $rowId;
    }

    public function next()
    {
        if (auth()->user()) {
            $this->validate([
                'content' => 'required',
            ]);
            $user = user_cart(auth()->user()->id);
            Cookie::queue(Cookie::make('customer', auth()->user()->id, 60*60*24*365));
            //dd($user->cart->toArray());
            if(count($user->cart)) {
                $invoice = $user->cart->first();
                invoice_MAJ($invoice);
            }
            else {
                $invoice = invoice_create();
            }
            $invoice->update([
                'content' => $this->content,
            ]);
            redirect()->route('checkout.index');
        }
        else {
            Cookie::queue(Cookie::make('mode', 1, 60*60*24*365));
            Cookie::queue(Cookie::make('return', route('checkout.cart'), 60*60*24));
            redirect()->route('register');
        }
    }

    public function render()
    {
        $this->cart = Cart::instance('shopping')->content();
        $this->price_delivery = coutLivraison(Cart::instance('shopping')->subtotal());
        return view('livewire.checkout.cart')
        //->layout('layouts.guest')
        ->extends('layouts.app', [
            'title' => 'Panier',
            'setting' => $this->setting,
            'articles' => $this->articles,
            'categories' => $this->categories,
        ]);
    }

    private function resetInputFields(){
    }
}
