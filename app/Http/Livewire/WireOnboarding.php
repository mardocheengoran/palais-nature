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
use Filament\Notifications\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class WireOnboarding extends Component
{
    use WithFileUploads, LivewireAlert;
    public $setting, $articles, $categories;
    public $status;


    public function mount()
    {
        journalisation('onboarding');
        $this->setting = setting();
    }

    public function render()
    {
        return view('livewire.profil.onboarding')
        ->extends('layouts.guest');
    }

    public function next()
    {
        $this->validate([
            'status' => ['accepted', 'required'],
        ]);
        auth()->user()->update([
            'status' => 1,
        ]);

        Notification::make()
        ->title('Bienvenue dans votre espace vendeur')
        ->success()
        ->duration(5000)
        ->send();

        redirect()->route('filament.pages.dashboard');
    }
}
