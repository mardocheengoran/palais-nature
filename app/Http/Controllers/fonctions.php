<?php

use App\Models\Address;
use App\Models\Article;
use App\Models\ArticleFlash;
use App\Models\Delivery;
use App\Models\Flash;
use App\Models\Invoice;
use App\Models\Parameter;
use App\Models\Setting;
use App\Models\TypeParameter;
use App\Models\User;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

// Durée d'une session
function duree_session()
{
    return strtotime(Carbon::now()->subMinutes(5));
}

// Menu type parametre
function menu_parametre()
{
    return TypeParameter::orderBy('created_at', 'asc')->get();
}

// Menu type article
function menu_type_article()
{
    return Parameter::where('type_parameter_id', 7)
    ->orderBy('created_at', 'asc')->get();
}

// Menu type article
function parameters($type_parameter, $order = "ISNULL(rank) asc, created_at desc", $limit = null)
{
    return Parameter::with([
        'childrens',
    ])
    ->where('type_parameter_id', $type_parameter)
    ->orderByRaw($order)
    ->limit($limit)
    ->get();
}

// Article par rubrique
function articles($rubric, $order = "ISNULL(rank) asc, created_at desc", $limit = null)
{
    return Article::with([
        'rubric',
    ])
    ->when(is_array($rubric), function($q) use($rubric){
        $q->whereIn('id', $rubric);
    }, function($q) use($rubric){
        $q->whereRubric_id($rubric);
    })
    ->where('status',1)
    ->whereDate('published_at', '<=', Carbon::now())
    ->whereEnable(1)
    ->orderByRaw($order)
    ->limit($limit)
    ->get();
}

// find article
function find_article($id)
{
    return Article::find($id);
}

// Menu role user
function menu_role()
{
    $roles = Role::orderBy('name', 'asc')
    ->get();
    return $roles;
}

// Get articles specific
function specific_article($articles, $rubric)
{
    return $articles->filter(function($article) use($rubric) {
        return $article->rubric_id == $rubric;
    });
}

// Activity log
function journalisation($libelle, $model = null)
{
    if ($model) {
        activity()
        ->performedOn($model)
        ->log($libelle);
    }
    else {
        activity()
        ->log($libelle);
    }
}

// Name of file
function generate_file_name($slug, $input_name = 'image')
{
    $name = $slug;
    $extension = null;
    if (request($input_name)) {
        $extension = request($input_name)->getClientOriginalExtension();
        return $name = $name.'.'.$extension;
    }
    else {
        return null;
    }
}

function devise($montant)
{
    return number_format($montant, 0, '.', ' ').' Fcfa';
}

function millier($montant)
{
    return number_format($montant, 0, '.', ' ');
}

// Trouver un user
function find_user($id)
{
    return $user = User::find($id);
}

// get id day of date
function day($value)
{
    $day = Carbon::parse($value)->format('w');
    switch ($day) {
        case 0:
            $jour_id = 36;
            break;
        case 1:
            $jour_id = 30;
            break;
        case 2:
            $jour_id = 31;
            break;
        case 3:
            $jour_id = 32;
            break;
        case 4:
            $jour_id = 33;
            break;
        case 5:
            $jour_id = 34;
            break;
        case 6:
            $jour_id = 35;
            break;

        default:
            # code...
            break;
    }
    return $jour_id;
}


// Verifie si un user a prié une intension
function check_pray($user_id, $prieurs)
{
    $prieurs = $prieurs->where('id', $user_id);
    $ma_priere = $prieurs->where('id', $user_id)->first();
    return (object) [
        'count_prieres' => $prieurs->count(),
        'prieres' => $prieurs,
        'ma_priere' => $ma_priere,
    ];
    //dd($prieurs, $prieurs->count());
}

function connect()
{
    return User::find(auth()->user()->id);
}

function pluriel($count, $plural, $singular)
{
    return $count > 1 ? $plural : $singular;
}

// Salution actuelle
function salutation()
{
    $hour = date('G');
    if ($hour >= 0 and $hour <= 12) {
        return 'Bonjour';
    }
    elseif ($hour >= 13 and $hour <= 17) {
        return 'Bon après-midi';
    }
    else {
        return 'Bonsoir';
    }
}


// Setting
function setting()
{
    return Setting::find(1);
}

function post_data($rubric_id = null, $post_id = null, $champATrier = 'id desc', $limit = 3, $restriction = [])
{
    if ($post_id) {
        $posts = Article::with([
            'rubric',
        ])
        ->whereDate('published_at', '<=', Carbon::now())
        ->where([
            'articles.id' => $post_id,
        ])
        ->first();
        return $posts;
    }
    else {
        if (request('trier')) {
            switch (request('trier')) {
                case 365: // Populaire
                    $champATrier = 'rang asc, id desc';
                    break;
                case 366: // Prix croissant
                    $champATrier = 'prix_nouveau asc';
                    break;
                case 367: // Prix décroissant
                    $champATrier = 'prix_nouveau desc';
                    break;
                case 368: // Nouveauté
                    $champATrier = 'id desc';
                    break;

                default:
                    # code...
                    break;
            }
        }
        $posts = Article::with([
            'rubric',
        ])
        ->whereRubric_id($rubric_id)
        ->whereDate('published_at', '<=', Carbon::now())
        ->whereNotIn('id', $restriction)
        ->when(request('search'), function($q){
            return $q->where('libelle', 'like', '%'.request('search').'%');
        })
        ->when(request('price_min'), function($q){
            $min = request('price_min');
            $max = request('price_max');
            return $q->whereBetween('price_new', [$min, $max]);
        })
        ->orderByRaw("$champATrier");
        $postsSansPaginate = $posts;
        $postsSansPaginate = $postsSansPaginate->get();
        $posts = $posts->paginate($limit);
        return $posts;
    }
}


// Mettre la une classe active
function active($i, $class)
{
    return ($i == 0) ? $class : null ;
}


function iframe_video($video)
{
    if (Str::contains($video, 'facebook')) {
        return '<iframe src="https://www.facebook.com/plugins/video.php?href='.$video.'&show_text=false&width=800&height=500&t=0" width="100%" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share" allowFullScreen="true"></iframe>';
    }
    elseif (Str::contains($video, 'youtube')) {
        $video = Str::substr(Str::after($video, '?v='), 0, 11);
        //return $video;
        return '<iframe src="https://www.youtube.com/embed/'.$video.'?rel=0" title="YouTube video" width="100%" height="500" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';
    }
    elseif (Str::contains($video, 'vimeo')) {
        $video = Str::substr(Str::after($video, '.com/'), 0, 9);
        return '<iframe src="https://player.vimeo.com/video/'.$video.'?h=16bd5fe54c&color=ffffff&title=0&byline=0&portrait=0" width="100%" height="500" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';
    }
    elseif (Str::contains($video, 'tiktok')) {
        return '<blockquote class="tiktok-embed" cite="'.$video.'" data-video-id="7138461977990483206" style="max-width: 605px;min-width: 325px;" > <section> <a target="_blank" title="@harmonie_prestations" href="https://www.tiktok.com/@harmonie_prestations?refer=embed">@harmonie_prestations</a> <a title="appartement" target="_blank" href="https://www.tiktok.com/tag/appartement?refer=embed">#Appartement</a> <a target="_blank" title="♬ son original - harmonie_prestations" href="https://www.tiktok.com/music/son-original-7138461986438073094?refer=embed">♬ son original - harmonie_prestations</a> </section> </blockquote> <script async src="https://www.tiktok.com/embed.js"></script>';
    }
}


// Détails produit dans panier
function detailPanier($code)
{
    $article = Article::with([
        'categories' => function ($q){
            $q->with([
                'parent' => function($q){
                    $q->with([
                        'parent'
                    ]);
                }
            ]);
        },
        'available'
    ])
    ->whereCode($code)
    ->first();
    return $article;
}

// Trouver le cout de livraison
function coutLivraison($total)
{
    if ($total < 25000) {
        return 1000;
    }
    else {
        return 0;
    }
}


// Get User
function user_cart($id)
{
    $user = User::with([
        'cart' => function ($q) {
            $q->with([
                'articles',
                'deliveryMode',
                'address',
                'relay',
                'paymentMethod',
                'customer',
            ]);
        },
    ])
    ->find($id);
    return $user;
}

// Mise à jour de commande
function invoice_create()
{
    $quantity = count(Cart::instance('shopping')->content());
    $price_ht = Cart::instance('shopping')->subtotal();
    $price_delivery = coutLivraison($price_ht);
    $price_final = $price_ht + $price_delivery;
    $invoice = Invoice::create([
        'type' => 'product',
        'quantity' => $quantity,
        'price_ht' => $price_ht,
        'price_delivery' => $price_delivery,
        'price_final' => $price_final,
        'customer_id' => auth()->user()->id,
        //'state_id' => 47,
        'ip' => request()->ip(),
        'user_created' => auth()->user()->id,
        //'benefit' => $benefit,
    ]);
    $invoice->states()->attach(47, [
        'user_created' => auth()->user()->id,
        'status' => 1,
    ]);
    pivot_invoice_MAJ($invoice);
    return $invoice;
}

// Mise à jour de commande
function invoice_MAJ($invoice)
{
    $quantity = count(Cart::instance('shopping')->content());
    $price_ht = Cart::instance('shopping')->subtotal();
    $price_delivery = coutLivraison($price_ht);
    $price_final = $price_ht + $price_delivery;
    // Si on déjà une commande en cours. On fait une mise à jour et on continue
    $invoice->update([
        'type' => 'product',
        'quantity' => $quantity,
        'price_ht' => $price_ht,
        'price_delivery' => $price_delivery,
        'price_final' => $price_final,
        'customer_id' => auth()->user()->id,
        'state_id' => 47,
        'ip' => request()->ip(),
        'user_updated' => auth()->user()->id
    ]);
    $invoice->states()->sync(47, [
        'user_created' => auth()->user()->id,
        'status' => 1,
    ]);
    pivot_invoice_MAJ($invoice);
    return $invoice;
}

// Mise à jour des produits d'une commande
function pivot_invoice_MAJ($invoice)
{
    $invoice->articles()->detach();
    $board = 0;
    foreach (Cart::instance('shopping')->content() as $item){
        $article = detailPanier($item->id);
        //dd($article->disponibilite);
        if ($article and $article->available_id == 54) {
            $board += $article->board * $item->price * $item->qty / 100;
            $invoice->articles()->attach($article->id, [
                'price' => $item->price,
                'price_total' => $item->price * $item->qty,
                'quantity' => $item->qty,
                'user_id' => auth()->user()->id,
                'board' => $article->board,
                'benefit' => $article->board * $item->price * $item->qty/ 100,
                'options' => json_encode($item->options), //pas gérer
            ]);
        }
        else {
            Cart::instance('shopping')->remove($item->rowId);
        }

    }

    $invoice->update([
        'benefit' =>  $board,
    ]);
}

// Calcul de date de livraison
function dateLivraison($date, $commercial_id)
{
    if($date->format('D') == 'Sun'){
        $date->addDay();
        $message = 'La date de la livraison de votre commande étant un dimanche sera reportée au <strong class="text-lg">'.$date->formatLocalized('%A %d %B %Y').'</strong>';
        //$cookie = Cookie::make('dateLivraison', $date, dureeCookie());
    }
    elseif(!$commercial_id and date('H') >= 20 and $date->subDay() <= Carbon::today()){
        $date->addDays(2);
        if($date->format('D') == 'Sun'){
            $date->addDay();
            $message = 'Votre date de livraison sera le <strong class="text-lg">'.$date->formatLocalized('%A %d %B %Y').'</strong> parce que la date de livraison que vous avez choisi est un samedi et que votre commande a été passée après 20h';
        }
        else{
            $message = 'Votre date de livraison sera le <strong class="text-lg">'.$date->formatLocalized('%A %d %B %Y').'</strong> parce que votre commande a été passée après 20h';
        }
    }
    else{
        $message = 'La date de la livraison de votre commande : <strong class="text-lg">'.$date->formatLocalized('%A %d %B %Y').'</strong>';
    }
    return $arrayName = array('date' => $date, 'message' => $message);
}

// color aléatoire
function color_random($i)
{
    $arrayName = [
        0 => 'primary',
        1 => 'warning',
        2 => 'success',
        3 => 'danger',
        4 => 'secondary',
        5 => 'dark',
        6 => 'info',
        7 => 'default',
    ];
    foreach ($arrayName as $key => $value) {
        if ($i == $key) {
            return $value;
        }
    }
}

// All menu
function all_menu()
{
    $menu = Parameter::where([
        'parent_id' => null,
        'type_parameter_id' => 24
    ])
    ->with([
        'item_type_parameter' => function ($q){
            $q->with([
                'parameters',
            ]);
        },
        'item_rubric' => function ($q){
            $q->with([
                'articles',
            ]);
        },
        'link_rubric',
        'link_article',
    ])
    ->orderByRaw('parameters.rank asc, created_at desc')
    ->get();
    return $menu;
}

// All articles
function all_articles()
{
    $articles = Article::with([
        'rubric',
        'audience',
        'categories',
    ])
    ->whereStatus(1)
    ->orderByRaw('articles.rank asc, created_at desc')
    ->whereDate('published_at', '<=', Carbon::now())
    ->whereEnable(1)
    //->whereIn('rubric_id', [125, 18, 21, 22, 23, 177])
    ->get();
    return $articles;
}


// Déterminer le lien des articles
function find_link($link)
{
    return !$link ? '#' : $link;
}

// Déterminer si un lien doit ouvrir une nouvelle fenêtre
function find_link_window($link)
{
    return ($link and $link != '#') ? "target=_blank" : '';
}


// Detect lien menu
function detect_link_menu($item)
{
    if ($item->link) {
        return route($item->link);
    }
    elseif($item->link_rubric) {
        return route('article.index', $item->link_rubric->slug);
    }
    elseif($item->link_article) {
        return route('article.show', $item->link_article->slug);
    }
    elseif($item->submenu) {
        if ($item->item_type_parameter) {
            return $item->item_type_parameter;
        }
        elseif ($item->item_rubric) {
            return $item->item_rubric;
        }
    }
    elseif($item->ecommerce) {
        return $item->item_rubric;
    }
}


// Trouver une taille et quantité d'un produit dans le panier
function check_cart($cartId, $size)
{
    return $cartId->filter(function ($value, $key) use($size, $cartId) {
        $result = $value->options->where('size', $size);
        dd($cartId, $value->options, $size, $result);
    });
}

// Cout de la livraison
function delivery_cost($address, $supplier)
{
    $end = Address::find($address)->city_id;
    if ($end) {
        $start = User::find($supplier)->city_id;
        $delivery = Delivery::where([
            'start_id' => $start,
            'end_id' => $end,
        ])
        ->first();
        $amount = 0;
        if ($delivery) {
            $amount = $delivery->amount;
        }
        return $amount;
    }
    return null;
}

// Nouveau montant du produit dante vente flash
function new_price($article)
{
    /* $flash = Flash::whereHas('articles', function ($q) use($article) {
        $q->where('article_id', $article);
    })
    ->with([
        'articles' => function ($q) use($article) {
            $q->where('article_id', $article);
        },
    ])
    ->whereDate('limit_at', '>=', Carbon::now())
    ->first();
    return $flash->articles->first()->pivot;
    //dd($flash->toArray()); */

    $pivot = ArticleFlash::whereHas('flash', function ($q) {
        $q->whereDate('limit_at', '>=', Carbon::now());
    })
    ->where([
        'article_id' => $article,
    ])
    ->first();
    //dd($pivot->toArray());
    return $pivot;

}
