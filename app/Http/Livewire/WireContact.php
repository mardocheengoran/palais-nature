<?php

namespace App\Http\Livewire;

use App\Mail\ContactMail;
use App\Models\Article;
use App\Models\Contact;
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


class WireContact extends Component
{
    use WithFileUploads, LivewireAlert;
    public $setting, $articles, $categories, $title = 'Contact';
    public $nom, $prenoms, $email, $phone, $sujet, $message;

    public function mount()
    {
        journalisation('contact');
        $this->articles = all_articles();
        $this->setting = setting();
        $this->categories = Parameter::where('type_parameter_id', 17)
        ->orderByRaw('rank asc, created_at desc')
        ->whereNull('parent_id')
        //->limit($limit)
        ->get();
    }

    public function render()
    {
        return view('contact')
        ->extends('layouts.app', [
            'setting' => $this->setting,
            'articles' => $this->articles,
            'categories' => $this->categories,
        ]);
    }

    public function store()
    {
        $this->validate([
            'nom' => 'required',
            'email' => 'required',
            'sujet' => 'required',
            'message' => 'required',
        ]);

        $user_id = (auth()->user()) ? auth()->user()->id : null;
        $contact = Contact::create([
            'nom' => $this->nom,
            'prenoms' => $this->prenoms,
            'phone' => $this->phone,
            'email' => $this->email,
            'sujet' => $this->sujet,
            'message' => $this->message,
            'user_created' => $user_id,
        ]);
        Mail::to($this->setting->email)->send(new ContactMail($contact, $this->setting));
        //Mail::to('developpeur@qenium.com')->send(new ContactMail($contact, $this->setting));

        $this->alert('success', 'Message envoyé avec succès', [
            'position' => 'top-end',
            'timer' => 10000,
            'toast' => true,
            'showCancelButton' => true,
            'cancelButtonText' => 'Fermer',
            'onDismissed' => '',
            'timerProgressBar' => true,
        ]);
        $this->resetInputFields();
    }

    private function resetInputFields(){
        $this->nom = null;
        $this->prenoms = null;
        $this->email = null;
        $this->phone = null;
        $this->sujet = null;
        $this->message = null;
    }
}
