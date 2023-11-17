<?php

namespace App\Http\Livewire;

use App\Models\Address;
use App\Models\Article;
use App\Models\Country;
use App\Models\Invoice;
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


class WireProfil extends Component
{
    use WithFileUploads, LivewireAlert;
    public $setting, $articles, $categories;
    public $user;
    public $valeur, $invoice;
    public $title, $subtitle, $city;
    public $addresses, $cities, $countries, $country, $location;

    public function mount()
    {
        journalisation('profil index');
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

        $this->countries = Country::all()
        ->sortBy('title');
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
        return view('livewire.profil.index')
        ->extends('layouts.app', [
            'title' => 'Accueil',
            'setting' => $this->setting,
            'articles' => $this->articles,
            'categories' => $this->categories,
        ]);
    }


    public function addressStore()
    {
         $this->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'country' => 'required',
        ]);

        if ($this->city == 270) {
            $this->validate([
                'location' => 'required',
            ]);
        }
        if ($this->country == 110) {
            $this->validate([
                'city' => 'required',
            ]);
        }

        if ($this->valeur) {
            if ($this->city == 270) {
                $this->valeur->update([
                    'title' => $this->title,
                    'subtitle' => $this->subtitle,
                    'city_id' => $this->city,
                    'country_id' => $this->country,
                    'location' => $this->location,

                    'user_updated' => auth()->user()->id,
                ]);
            }
            else{
                $this->valeur->update([
                    'title' => $this->title,
                    'subtitle' => $this->subtitle,
                    'city_id' => $this->city,
                    'country_id' => $this->country,
                    'user_updated' => auth()->user()->id,
                ]);
            }

            $message = 'Modification effectuée avec succès';
        }
        else {
            if ($this->city == 270) {
                Address::create([
                    'title' => $this->title,
                    'subtitle' => $this->subtitle,
                    'city_id' => $this->city,
                    'country_id' => $this->country,
                    'location' => $this->location,
                    'user_id' => auth()->user()->id,
                ]);
            }
            else{
                Address::create([
                    'title' => $this->title,
                    'subtitle' => $this->subtitle,
                    'city_id' => $this->city,
                    'country_id' => $this->country,
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

    public function addressEdit($address)
    {
        $this->valeur = $this->addresses->filter(function ($value) use ($address) {
            return $value->id == $address;
        })
            ->first();
        //dd($this->valeur->toArray());
        journalisation('address openModal edit');
        $this->title = $this->valeur->title;
        $this->subtitle = $this->valeur->subtitle;
        $this->city = $this->valeur->city_id;
        $this->country = $this->valeur->country_id;
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

    public function invoice_show($id)
    {
        $this->invoice = $this->user->invoices_check->filter(function($value) use($id){
            return $value->id == $id;
        })
        ->first();
        //dd($this->invoice->toArray());
        journalisation('invoice show');
    }

    public function openModal()
    {
        $this->resetInputFields();
    }

    private function resetInputFields(){
        $this->title = null;
        $this->subtitle = null;
        $this->city = null;
    }
}
