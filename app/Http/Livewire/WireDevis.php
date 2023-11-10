<?php

namespace App\Http\Livewire;

use App\Mail\ContactMail;
use App\Mail\DevisMail;
use App\Models\Article;
use App\Models\Contact;
use App\Models\Devis;
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


class WireDevis extends Component
{
    use WithFileUploads, LivewireAlert;
    public $setting, $articles, $menu;
    public $entreprise, $email, $phone, $nature, $hscode, $poids, $shipping, $conteneur, $port, $enlevement, $dechargement, $livraison, $commentaire;

    public function mount()
    {
        journalisation('devis');
        $this->setting = setting();
        $this->menu = all_menu();
        $this->articles = all_articles();
    }

    public function render()
    {
        return view('devis')
        ->extends('component.'.$this->setting->template->title.'.layouts.app', [
            'title' => 'Contact',
            'setting' => $this->setting,
            'articles' => $this->articles,
            'menu' => $this->menu,
        ]);
    }

    public function store()
    {
        $this->validate([
            'entreprise' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'nature' => 'required',
            'poids' => 'required',
            'shipping' => 'required',
            'conteneur' => 'required',
            'port' => 'required',
            'dechargement' => 'required',
            'commentaire' => 'required',
        ]);

        $user_id = (auth()->user()) ? auth()->user()->id : null;
        $contact = Devis::create([
            'entreprise' => $this->entreprise,
            'phone' => $this->phone,
            'email' => $this->email,
            'nature' => $this->nature,
            'hscode' => $this->hscode,
            'poids' => $this->poids,
            'shipping' => $this->shipping,
            'conteneur' => $this->conteneur,
            'port' => $this->port,
            'enlevement' => $this->enlevement,
            'dechargement' => $this->dechargement,
            'livraison' => $this->livraison,
            'commentaire' => $this->commentaire,

            'user_created' => $user_id,
        ]);
        Mail::to($this->setting->email)->send(new DevisMail($contact, $this->setting));
        Mail::to('developpeur@qenium.com')->send(new DevisMail($contact, $this->setting));

        $this->alert('success', 'Devis envoyé avec succès', [
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
        $this->entreprise = null;
        $this->phone = null;
        $this->email = null;
        $this->nature = null;
        $this->hscode = null;
        $this->poids = null;
        $this->shipping = null;
        $this->conteneur = null;
        $this->port = null;
        $this->enlevement = null;
        $this->dechargement = null;
        $this->livraison = null;
        $this->commentaire = null;
    }
}
