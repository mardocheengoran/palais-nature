<?php

namespace App\Http\Livewire;

use App\Models\Address;
use App\Models\Article;
use App\Models\Country;
use App\Models\Invoice;
use App\Models\Parameter;
use App\Models\Setting;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class WireCongrat extends Component
{
    use WithFileUploads, LivewireAlert;
    public $setting, $invoice, $categories, $articles;

    public function mount($code)
    {
        journalisation('cart');
        $this->setting = setting();
        $this->categories = Parameter::where('type_parameter_id', 17)
        ->orderByRaw('rank asc, created_at desc')
        ->whereNull('parent_id')
        ->get();
        $this->articles = all_articles();

        $this->invoice = Invoice::with([
            'articles',
            'deliveryMode',
            'address',
            'relay',
            'paymentMethod',
            'customer',
        ])
        ->whereCode($code)
        ->first();
    }

    public function render()
    {
        return view('livewire.checkout.congrat')
        ->extends('layouts.app', [
            'title' => 'Commande validé',
            'setting' => $this->setting,
            'categories' => $this->categories,
            'articles' => $this->articles,
        ]);
    }
}
