<?php

namespace App\Http\Livewire;

use App\Models\Article;
use App\Models\Parameter;
use App\Models\Setting;
use App\Models\Signal;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class WireArticleShow extends Component
{

    use WithFileUploads, LivewireAlert;

    public $articles, $article, $similaries, $setting, $categories;
    public $quantity = 1, $size = [];
    public $slug;
    public $cartId;
    public $content;

    public $amount;

    private function resetInputFields(){
    }

    public function mount($slug)
    {
        $this->slug = $slug;

        $this->articles = all_articles();
        $this->setting = setting();
        $this->categories = Parameter::where('type_parameter_id', 17)
        ->orderByRaw('rank asc, created_at desc')
        ->whereNull('parent_id')
        //->limit($limit)
        ->get();

        $this->article = Article::with([
            'city',
            'rubric',
            'audience',
            'property',
            'offer',
            'brand',
            'jobs',
            'equipments',
            'categories' => function($q){
                $q->orderBy('parent_id', 'desc');
            },
            'available',
            'sizes'
        ])
        ->whereDate('published_at', '<=', Carbon::now())
        ->whereEnable(1)
        ->whereSlug($this->slug)
        ->firstOrFail();
        if ($this->article->rubric_id == 125) {
            $description = 'article show';
        }
        else {
            $description = 'article show';
        }
        journalisation('article show', $this->article);
        $this->similaries = Article::with([
            'city',
            'rubric',
            'audience',
            'property',
            'offer',
            'brand',
            'jobs',
            'equipments',
            'categories',
            'available',
            'sizes'
        ])
        ->when(in_array('product', $this->article->rubric->field), function ($q) {
            $q->whereHas('categories', function($q){
                $q->whereIn('parameters.id', $this->article->categories->pluck('id', 'id')->toArray());
            });
        })
        ->whereRubric_id($this->article->rubric_id)
        ->whereDate('published_at', '<=', Carbon::now())
        ->whereEnable(1)
        ->whereNotIn('id', [$this->article->id])
        ->orderBy('id', 'desc')
        ->limit(12)
        ->get();

        // calcule cout de l'article
        if ($flash = new_price($this->article->id)){
            $this->amount = $flash->price_new;
        }
        else {
            $this->amount = $this->article->price_new;
        }
    }

    public function render()
    {
        $this->cartId = Cart::instance('shopping')->search(function ($cartItem) {
            return $cartItem->id == $this->article->code;
        });
        //dd($this->cartId->toArray());
        //$this->quantity = $filtered->first()->qty + $value;

        if ($this->article->rubric_id == 125) {
            $my_view = 'show';
        }
        else {
            $my_view = 'show_rubric';
        }
        return view($my_view)
        ->extends('layouts.app', [
            'title' => $this->article->title,
            'setting' => $this->setting,
            'articles' => $this->articles,
            'categories' => $this->categories,
        ]);
    }

    public function addCart()
    {
        //dd($this->quantity);
        $this->validate([
            'quantity' => 'required',
        ]);
        if (empty($this->quantity)) {
            $this->quantity = 1;
        }
        if ($this->article->active_size) {
            $this->validate([
                'size' => 'required',
            ]);
            // Déterminer la quantité d'article d'un produit en fonction de sa taille
            $sizes = $this->article->sizes->filter(function ($size) {
                return $size->title == $this->size;
            })->first();
            // Déterminer la quantité et la taille d'un produit
            $cart = Cart::instance('shopping')->content()->filter(function ($value) {
                return $value->id == $this->article->code;
            });
            $cart = $cart->filter(function ($value) {
                return $value->options->size == $this->size;
            });
            //dd($sizes->toArray());
            if ($sizes and $sizes->pivot->quantity < $this->quantity) {
                return $this->alert('error', 'Impossible d\'ajouter '.$this->quantity.' article(s) du produit "'.$this->article->title.'" de la taille "'.$this->size.'" au panier', [
                    'position' => 'top-end',
                    'timer' => 50000,
                    'toast' => true,
                    'showCancelButton' => true,
                    'cancelButtonText' => 'Fermer',
                ]);
            }
            //dd($sizes->toArray());
        }

        Cart::instance('shopping')->add($this->article->code, $this->article->title, $this->quantity, $this->amount, 0, [
            'size' => $this->size,
        ]);
        $this->alert('success', 'Ajout de "'.$this->article->title.'" au panier effectué avec succès', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'showCancelButton' => true,
            'cancelButtonText' => 'Fermer',
        ]);
    }

    public function signal()
    {
        if (Auth::check()) {
            $this->validate([
                'content' => 'required',
            ]);

            Signal::create([
                'article_id' => $this->article->id,
                'content' => $this->content,
                'user_created' => Auth::id(),
            ]);
            $this->alert('success', 'Vous avez signalé ce produit avec succès', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'showCancelButton' => true,
                'cancelButtonText' => 'Fermer',
            ]);
            $this->emit('formClose');
            $this->content = '';
        }
        else {
            toast('Vous devez vous connecter pour signaler ce produit','warning')->autoClose(10000);
            Cookie::queue(Cookie::make('return', url()->current(), 60*60*24));
            redirect()->route('register');
        }
    }

    // wishlist
    public function wishlist()
    {
        if (Auth::check()) {
            Cart::instance('wishlist')->add($this->article->code, $this->article->title, $this->quantity, $this->article->price_new);
            $this->alert('success', 'Ajout de "'.$this->article->title.'" à la liste de souhaits avec succès', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'showCancelButton' => true,
                'cancelButtonText' => 'Fermer',
            ]);
            Cart::instance('wishlist')->store(auth()->user()->fullname);
        }
        else {
            toast('Vous devez vous connecter avant d\'ajouter ce produit à la liste de d\'envie', 'warning')->autoClose(20000);
            Cookie::queue(Cookie::make('return', url()->current(), 60*60*24));
            redirect()->route('register');
        }
    }
}
