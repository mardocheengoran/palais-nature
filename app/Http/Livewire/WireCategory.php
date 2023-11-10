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


class WireCategory extends Component
{
    use WithFileUploads, LivewireAlert;
    public $setting, $articles, $categories, $title;

    // Propiétés propres au listing des articles
    public $slug, $rubric;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->rubric = Parameter::whereSlug($this->slug)->firstOrFail();
        journalisation('article index', $this->rubric);
        $this->title = $this->rubric->title;
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
        $posts = Article::with([
            'rubric',
            'audience',
            'brand',
            'categories',
        ])
        ->orderByRaw('rank asc, created_at desc')
        ->whereDate('published_at', '<=', Carbon::now())
        ->whereEnable(1)
        ->whereRubric_id($this->rubric->id)
        ->when(request('offer'), function ($q) {
            $item = Parameter::whereSlug(request('offer'))->first();
            if ($item) {
                $q->whereOffer_id($item->id);
            }
        })
        ->when(request('type'), function ($q) {
            $item = Parameter::whereSlug(request('type'))->first();
            if ($item) {
                $q->whereProperty_id($item->id);
            }
        })
        ->when(request('commune'), function ($q) {
            $item = Parameter::whereSlug(request('commune'))->first();
            if ($item) {
                $q->whereCity_id($item->id);
            }
        })
        ->when(request('brand'), function ($q) {
            $item = Parameter::whereSlug(request('brand'))->first();
            if ($item) {
                $q->whereBrand_id($item->id);
            }
        })
        ->when(request('contract'), function ($q) {
            $item = Parameter::whereSlug(request('contract'))->first();
            if ($item) {
                $q->whereContract_id($item->id);
            }
        })
        ->when(request('job'), function ($q) {
            $item = Parameter::whereSlug(request('job'))->first();
            if ($item) {
                $q->whereHas('jobs', function ($q) use($item) {
                    $q->where('parameters.id', $item->id);
                });
            }
        })
        ->when(request('category'), function ($q) {
            $category = Parameter::whereSlug(request('category'))->first();
            if ($category) {
                $q->whereHas('categories', function ($q) use($category) {
                    $q->where('parameters.id', $category->id);
                });
            }
        })
        ->paginate(28);
        //dd($posts->toArray());
        if (!isset($category)) {
            $category = (object)array();
        }

        // Eléments du menu
        /* $this->menu = Parameter::where([
            'parent_id' => null,
            'type_parameter_id' => 24
        ])
        ->with([
            'childrens' => function($q){
                $q->with([
                    'childrens' => function($q){
                        $q->with([
                            'childrens'
                        ]);
                    }
                ]);
            },
        ])
        ->get(); */

        if (in_array($this->rubric->type_parameter_id, [16, 17])) {
            $my_view = 'category';
        }
        else {
            $my_view = 'category_rubric';
        }

        $products = Article::orderByRaw('rank asc, created_at desc')
        ->when($this->rubric->type_parameter_id == 17, function ($q) {
            $q->whereHas('categories', function ($q) {
                $q->where('parameters.id', $this->rubric->id);
            });
        })
        ->when($this->rubric->type_parameter_id == 16, function ($q) {
            $q->whereBrand_id($this->rubric->id);
        })
        ->whereDate('published_at', '<=', Carbon::now())
        ->whereEnable(1)
        ->paginate(12);
        //dd($products->toArray());

        return view($my_view)
        ->with([
            'products' => $products,
        ])
        ->extends('layouts.app', [
            'title' => $this->rubric->title,
            'setting' => $this->setting,
            'categories' => $this->categories,
            'articles' => $this->articles,
            'posts' => $posts,
        ]);
    }



    private function resetInputFields(){

    }
}
