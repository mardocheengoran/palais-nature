<?php

namespace App\Http\Livewire;

use App\Models\Address;
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


class WireAllInvoice extends Component
{
    use WithFileUploads, LivewireAlert;
    public $user;
    public $valeur, $invoice, $slug;
    public $title, $subtitle, $city;

    public $setting, $articles, $categories;
    public $addresses, $cities;

    public function mount()
    {
        journalisation('all invoices');
        $this->setting = setting();
        $this->articles = all_articles();
        $this->categories = Parameter::where('type_parameter_id', 17)
        ->orderByRaw('rank asc, created_at desc')
        ->whereNull('parent_id')
        //->limit($limit)
        ->get();
        // Eléments du menu
        //$this->menu = all_menu();
        //dd($this->menu->toArray());
    }

    public function render()
    {
        $this->user = User::with([
            'childrens' => function($q){
                $q -> with([
                    'childrens' => function($q){
                        $q->with([
                            'childrens' => function($q){
                                $q->with([
                                    'childrens' => function($q){
                                        $q->with([
                                            'childrens' => function($q){
                                                $q->with([
                                                    'childrens' => function($q){
                                                        $q->with([
                                                            'childrens' => function($q){
                                                                $q->with([
                                                                    'childrens' => function($q){
                                                                        $q->with([
                                                                            'childrens' => function($q){
                                                                                $q->with([
                                                                                    'childrens'
                                                                                ]);
                                                                            }
                                                                        ]);
                                                                    }
                                                                ]);
                                                            }
                                                        ]);
                                                    }
                                                ]);
                                            }
                                        ]);
                                    }
                                ]);
                            }
                        ]);
                    }]
                );
            },
            'parent',
            'invoices_check' => function($q){
                $q->with([
                    'articles',
                    'deliveryMode',
                    'address',
                    'relay',
                    'paymentMethod',
                    'state',
                    'customer',
                ]);
            },
            'addresses',
        ])
        ->find(auth()->user()->id);
        //dd($this->user->toArray());

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

        return view('livewire.profil.invoice.all')
        ->extends('layouts.app', [
            'title' => 'Toutes les commandes',
            'setting' => $this->setting,
            'categories' => $this->categories,
            'articles' => $this->articles,
        ]);
    }
}
