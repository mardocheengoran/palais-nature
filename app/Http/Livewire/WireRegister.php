<?php

namespace App\Http\Livewire;

use App\Actions\Fortify\PasswordValidationRules;
use App\Mail\InscriptionMail;
use App\Models\Article;
use App\Models\Parameter;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Livewire\Component;
use Livewire\WithFileUploads;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Laravel\Jetstream\Jetstream;

class WireRegister extends Component
{
    use WithFileUploads, LivewireAlert, PasswordValidationRules;
    public $setting, $articles, $categories, $cities, $entities, $vehicles;
    public $store, $image;
    public $last_name, $first_name, $email, $phone, $password, $password_confirmation, $terms, $city_id, $address, $entity_id, $vehicle_id, $content;
    public $supplier;

    public function mount()
    {
        $this->supplier = request('supplier');
        journalisation('register');
        $this->setting = setting();
        $this->categories = Parameter::where('type_parameter_id', 17)
        ->orderByRaw('rank asc, created_at desc')
        ->whereNull('parent_id')
        ->get();
        $this->cities = Parameter::where('type_parameter_id', 2)
        ->orderByRaw('rank asc, title asc')
        ->whereNull('parent_id')
        ->get();
        $this->entities = Parameter::where('type_parameter_id', 26)
        ->orderByRaw('rank asc, title asc')
        ->get();
        $this->vehicles = Parameter::where('type_parameter_id', 27)
        ->orderByRaw('rank asc, title asc')
        ->get();
        $this->articles = all_articles();
    }

    public function render()
    {
        //dd($this->supplier);
        return view('auth.register')
        ->extends('layouts.app', [
            'title' => 'Accueil',
            'setting' => $this->setting,
            'categories' => $this->categories,
            'articles' => $this->articles,
        ]);
    }

    public function next()
    {
        //dd($this->mode);
        $this->validate([
            'last_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'max:255'],
            'phone' => ['required', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => ['accepted', 'required'],

        ]);

        if ($this->supplier == 'fournisseur') {
            $this->validate([
                'store' => ['required', 'string', 'max:255'],
                'city_id' => ['required'],
                'address' => ['required', 'string', 'max:255'],
                'image' => 'nullable|max:6144',
            ]);
        }
        elseif ($this->supplier == 'livreur') {
            $this->validate([
                'entity_id' => ['required'],
                'vehicle_id' => ['required'],
            ]);
        }

        $user = User::create([
            'name' => $this->last_name,
            'first_name' => $this->first_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'store' => $this->store,
            'city_id' => $this->city_id,
            'address' => $this->address,
            'password' => Hash::make($this->password),
            'entity_id' => $this->entity_id,
            'vehicle_id' => $this->vehicle_id,
            'content' => $this->content,
        ]);

        if($this->image)
        {
            //dd($this->image);
            $extension = $this->image->getClientOriginalExtension();
            $name = $user->slug.'.'.$extension;
            $user->addMedia($this->image->getRealPath())
            ->usingFileName($name)
            ->toMediaCollection('image');
        }

        event(new Registered($user));
        Filament::auth()->login($user, true);
        if ($this->supplier == 'fournisseur') {
            $user->assignRole($this->supplier);

            /* Mail::to([
                'developpeur@qenium.com',
            ])->send(new InscriptionMail($user));
            return $user; */

            //redirect()->route('filament.pages.dashboard');
            redirect()->route('onboarding');
        }
        elseif ($this->supplier == 'livreur') {
                $user->assignRole($this->supplier);

                redirect()->route('filament.pages.dashboard');
        }
        else {
            $user->assignRole('client');
            toast('Inscription effectuée avec succès', 'success')->autoClose(15000);
            if (Cookie::get('return')) {
                redirect(Cookie::get('return'));
            }
            else {
                redirect()->route('profil.index');
            }
        }
    }
}
