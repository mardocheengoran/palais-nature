<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\Article;
use App\Models\Contact;
use App\Models\Parameter;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WelcomeController extends Controller
{
    // Page d'accueil
    public function index()
    {
        $setting = Setting::find(1);
        $articles = Article::with([
            'rubric',
            'audience',
            'categories',
        ])
        ->orderByRaw('rank asc, created_at desc')
        ->whereDate('published_at', '<=', Carbon::now())
        ->whereEnable(1)
        ->whereIn('rubric_id', [125, 18, 21, 22, 23, 177])
        ->get();

        $categories = Parameter::with([
            'childrens',
            'products' => function($q){
                $q->with([
                    'rubric',
                    'audience',
                    'categories',
                ])
                ->orderByRaw('rank asc, created_at desc')
                ->whereDate('published_at', '<=', Carbon::now())
                ->whereEnable(1);
            },
        ])
        ->where([
            'type_parameter_id' => 17,
            'parent_id' => null,
        ])
        ->withCount([
            'products' =>function ($q){
                $q->whereDate('published_at', '<=', Carbon::now())
                ->whereEnable(1);
            }
        ])
        ->orderBy('products_count', 'desc')
        ->orderByRaw('ISNULL(rank) asc, created_at desc')
        ->get();
        //dd($categories->toArray());
        $products = $articles->filter(function($article){
            return $article->rubric_id == 125;
        });
        $carousels = $articles->filter(function($article){
            return $article->rubric_id == 18;
        });
        $propos = $articles->filter(function($article){
            return $article->rubric_id == 21;
        });
        $coordonnees = $articles->filter(function($article){
            return $article->rubric_id == 22;
        });
        $sociaux = $articles->filter(function($article){
            return $article->rubric_id == 23;
        });
        $ads = $articles->filter(function($article){
            return $article->rubric_id == 177;
        });
        //dd($products->toArray());
        journalisation('home');
        return view('welcome')->with([
            'setting' => $setting,
            'carousels' => $carousels,
            'products' => $products,
            'propos' => $propos,
            'coordonnees' => $coordonnees,
            'sociaux' => $sociaux,
            'ads' => $ads,

            'categories' =>$categories,
        ]);
    }

    // Page de contact
    public function contact()
    {
        $setting = Setting::find(1);
        journalisation('contact');
        return view('contact')->with([
            'setting' => $setting,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'=> 'required',
            'email'=> 'required',
            'sujet'=> 'required',
            'message'=> 'required',
        ]);

        $user_id = (auth()->user()) ? auth()->user()->id : null;

       $visiteur = Contact::create([
            'nom'=>$request->nom,
            'prenoms'=>$request->prenoms,
            'phone'=>$request->phone,
            'email'=>$request->email,
            'sujet'=>$request->sujet,
            'message'=>$request->message,
            'user_created' => $user_id,
        ]);
        $setting = Setting::find(1);
        //Mail::to([$setting->email, 'developpeur@qenium.com'])->send(new ContactMail($visiteur));
        toast('Votre message a bien été envoyé', 'success')->autoClose(20000);
        return back()/* ->with('message' , 'Votre message a été envoyé avec succès') */;
        //return back()->with('success' , 'Votre message a été envoyé avec succès');
    }

    public function signal()
    {
        toast('Veuillez choisir le produit à signaler', 'success')->autoClose(25000);
        return redirect()->route('products');
    }
}
