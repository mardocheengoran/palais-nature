<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Parameter;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        $setting = Setting::find(1);
        $rubric = Parameter::whereSlug($slug)->firstOrFail();
        $articles = Article::with([
            'city',
            'rubric',
            'audience',
            'property',
            'offer',
            'brand',
            'jobs',
            'equipments',
            'categories',
        ])
        ->orderByRaw('rank asc, created_at desc')
        ->whereDate('published_at', '<=', Carbon::now())
        ->whereEnable(1)
        ->whereRubric_id($rubric->id)
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
        //dd($articles->toArray());
        if (!isset($category)) {
            $category = (object)array();
        }

        return view('category')->with([
            'rubric' => $rubric,
            'articles' => $articles,
            'setting' => $setting,

            'category' => $category,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $article = Article::with([
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
        ->whereDate('published_at', '<=', Carbon::now())
        ->whereEnable(1)
        ->whereSlug($slug)
        ->firstOrFail();

        $similaries = Article::with([
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
        ->whereRubric_id($article->rubric_id)
        ->whereNotIn('id', [$article->id])
        ->orderBy('id', 'desc')
        ->limit(10)
        ->get();
        //dd($post->toArray());

        $setting = Setting::find(1);
        return view('show')->with([
            'article' => $article,
            'similaries' =>$similaries,
            'setting' => $setting,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
    }
}
