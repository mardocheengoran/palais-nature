<div>
    @push('style')
    @endpush
    @include('layouts.header')
    {{-- <div class="py-5 breadcrumb_section bg_gray page-title-mini">
        <!-- STRART CONTAINER -->
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1 class="text-warning">
                            {{ $article->title }}
                        </h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item">
                            <a href="{{ route('welcome') }}">Accueil</a>
                        </li>
                        @if(in_array('product', $article->rubric->field))
                            @isset ($article->categories->last()->title)
                                <li class="breadcrumb-item">
                                    <a href="{{ route('article.index', $article->rubric->slug).'?category='.$article->categories->last()->slug }}">
                                        {{ $article->categories->last()->title }}
                                    </a>
                                </li>
                            @endisset
                        @else
                            @if ($article->rubric)
                                <li class="breadcrumb-item">
                                    <a href="{{ route('article.index', $article->rubric->slug) }}">
                                        {{ $article->rubric->title }}
                                    </a>
                                </li>
                            @endif
                        @endif
                        <li class="breadcrumb-item active">
                            {{ $article->title }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- END CONTAINER-->
    </div> --}}

    <div class="mt-2">
        <div class="container">
            <div class="row">
                <div class="col-9">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-links px-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('welcome') }}">Accueil</a>
                            </li>
                            @if(in_array('product', $article->rubric->field))
                                @if ($category)
                                    <li class="breadcrumb-item">
                                        <a href="{{ url('category/'.$category->slug) }}">
                                            {{ $category->title }}
                                        </a>
                                    </li>
                                @endif
                            @else
                                @if ($article->rubric)
                                    <li class="breadcrumb-item">
                                        <a href="{{ url('category/'.$article->rubric->slug) }}">
                                            {{ $article->rubric->title }}
                                        </a>
                                    </li>
                                @endif
                            @endif
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $article->title }}
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-3 text-xs text-right pt-2">
                    <span class="" title="{{ $article->created_at->isoFormat('LLLL') }}" data-toggle="tooltip" data-placement="top" title="{{ $article->created_at->isoFormat('LLLL') }}">
                        <i class="icofont-ui-calendar"></i>
                        Publié {{ $article->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>
        </div>
        <div class="slice bg-section-secondary py-3">
            <div class="container container-lg">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <header class="section-header my-4">
                            <h3>{{ $article->title }}</h3>
                            @if ($article->subtitle)
                                {{ $article->subtitle }}
                            @endif
                        </header>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                @if(isset($article->city->title) or isset($article->address))
                                    <span class="city d-block text-dark">
                                        <i class="icofont-location-pin text-danger"></i>
                                        {{ isset($article->city->title) ? $article->city->title : '' }} {{ isset($article->address) ? $article->address : '' }}
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-7">
                                @isset($article->price_new)
                                    <div class="price mb-2 text-danger text-xl font-weight-bold">
                                        <span class="">
                                            {{ devise($article->price_new) }}{{ (isset($article->periodicite) and $article->periodicite != 'Unique') ? '/'.$article->periodicite : '' }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-1 text-right">
                                @isset($article->property->title)
                                    <span class="badge badge-soft-success" style="">
                                        {{ isset($article->offer->title) ? $article->offer->title : '' }}
                                    </span>
                                @endisset
                            </div>
                        </div>

                        @if ($article->link_video)
                            {!! iframe_video($article->link_video) !!}
                        @else
                            @if ($article->getMedia('image')->first())
                                @if (count($article->getMedia('image')) > 1)
                                    @include('component.purpose.detail.item-carousel')
                                @else
                                    <a href="{{ url($article->getMedia('image')->first()->getUrl()) }}" class="img-fluid" data-fancybox="gallery" data-caption="{{ $article->title }}">
                                        <img src="{{ url($article->getMedia('image')->first()->getUrl('normal')) }}" class="img-fluid w-100">
                                    </a>
                                @endif
                            @endif
                        @endif

                        <div class="mt-2">
                            <ul class="list-inline mb-0 text-muted text-sm">
                                @if ($article->number_piece)
                                    <li class="list-inline-item pr-2 p-2 shadow hover-shadow">
                                        <i class="icofont-bed"></i> Pièces: {{ $article->number_piece }}
                                    </li>
                                @endif
                                @if ($article->surface)
                                    <li class="list-inline-item pr-2 p-2 shadow hover-shadow">
                                        <i class="icofont-ui-map"></i> {{ $article->surface }} m<sup>2</sup>
                                    </li>
                                @endif
                                @if ($article->bathroom)
                                    <li class="list-inline-item pr-2 p-2 shadow hover-shadow">
                                        <i class="icofont-bathtub"></i> Salle de bain: {{ $article->bathroom }}
                                    </li>
                                @endif
                                @if ($article->parking)
                                    <li class="list-inline-item pr-2 p-2 shadow hover-shadow">
                                        <i class="icofont-car-alt-1"></i>Voiture dans le parking: {{ $article->parking }}
                                    </li>
                                @endif
                                @isset ($article->stage)
                                    <li class="list-inline-item pr-2 p-2 shadow hover-shadow">
                                        <i class="icofont-building"></i> Situé au {{ $article->stage }}
                                    </li>
                                @endisset
                                @if ($article->number_place)
                                    <li class="list-inline-item pr-2 p-2 shadow hover-shadow">
                                        <i class="icofont-users-alt-2"></i> {{ $article->number_place }}
                                    </li>
                                @endif
                                @if ($article->fuel_id)
                                    <li class="list-inline-item pr-2 p-2 shadow hover-shadow">
                                        <i class="fas fa-gas-pump"></i> {{ $article->fuel->title }}
                                    </li>
                                @endif
                                @if ($article->transmission_id)
                                    <li class="list-inline-item pr-2 p-2 shadow hover-shadow">
                                        <i class="icofont-game-console"></i> {{ $article->transmission->title }}
                                    </li>
                                @endif
                                @if ($article->end_at)
                                    <li class="list-inline-item pr-2 p-2 shadow hover-shadow" data-toggle="tooltip" data-placement="top" title="{{ $article->end_at->format('d-m-Y H:i') }}">
                                        <i class="icofont-ui-calendar"></i> Expire {{ $article->end_at->diffForHumans() }}
                                    </li>
                                @endif
                                @isset ($article->contract->title)
                                    <li class="list-inline-item pr-2 p-2 shadow hover-shadow">
                                        <i class="icofont-card"></i> {{ $article->contract->title }}
                                    </li>
                                @endisset
                                @isset ($article->level)
                                    <li class="list-inline-item pr-2 p-2 shadow hover-shadow">
                                        <i class="icofont-graduate"></i> {{ $article->level }}
                                    </li>
                                @endisset
                                @isset ($article->experience)
                                    <li class="list-inline-item pr-2 p-2 shadow hover-shadow">
                                        <i class="icofont-compass-alt"></i> {{ $article->experience }}
                                    </li>
                                @endisset
                                @isset ($article->number_job)
                                    <li class="list-inline-item pr-2 p-2 shadow hover-shadow">
                                        <i class="icofont-users-alt-2"></i> Poste: {{ $article->number_job }}
                                    </li>
                                @endisset
                            </ul>
                        </div>

                        @if(in_array('job', $article->rubric->field))
                            <div class="mt-3 font-weight-bold">
                                Métiers :
                                @foreach ($article->jobs as $key => $item)
                                    {{ $item->title }}{{ count($article->jobs) > $key+1 ? ',' : '' }}
                                @endforeach
                            </div>
                        @endif
                        @if(in_array('property', $article->rubric->field))
                            <div class="mt-3 font-weight-bold">
                                Equipements :
                                @foreach ($article->equipments as $key => $item)
                                    {{ $item->title }}{{ count($article->equipments) > $key+1 ? ',' : '' }}
                                @endforeach
                            </div>
                        @endif
                        <div class="mt-3">
                            {!! $article->content !!}
                            <p>
                                <a href="{{ $article->link }}">
                                    {{ $article->link }}
                                </a>
                            </p>
                        </div>

                        @if ($article->link_video)
                            @if ($article->getMedia('image')->first())
                                @if (count($article->getMedia('image')) > 1)
                                    @include('composant.detail.item-carousel')
                                @else
                                    <a href="{{ url($article->getMedia('image')->first()->getUrl()) }}" class="img-fluid" data-fancybox="gallery" data-caption="{{ $article->title }}">
                                        <img src="{{ url($article->getMedia('image')->first()->getUrl('normal')) }}" class="img-fluid w-100">
                                    </a>
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
