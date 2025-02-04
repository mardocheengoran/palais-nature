<div>
    @push('style')
    @endpush
    @include('layouts.header')

    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="tns-carousel tns-nav-enabled tns-nav-inside">
                        <div class="tns-carousel-inner data-carousel-options='{mode: carousel, speed: 1000, autoplayTimeout: 5000, autoplay: true}'">
                            @foreach (specific_article($articles, 18) as $article)
                                @if($article->getMedia('image')->first())
                                    <div>
                                        {{-- <a href="{{ $article->link ? url($article->link) : '#' }}"> --}}
                                            <img src="{{ $article->getMedia('image')->first()->getUrl() }}" alt="{{ setting()->title }}">
                                        {{-- </a> --}}
                                        <div class="text-center text-lg-left text-lg-nowrap position-relative" style="top: -100px; z-index: 10;">
                                            <a class="btn btn-primary" href="https://www.palaisdelanature.com/category/produits-rondeurs">
                                                Produits fessiers <i class="ml-2 czi-arrow-right mr-n1"></i>
                                            </a>
                                            <a class="btn btn-primary" href="https://www.palaisdelanature.com/category/cosmetiques">
                                                Produits cosmétiques <i class="ml-2 czi-arrow-right mr-n1"></i>
                                            </a>
                                        </div>
                                    </div>
                                    {{-- <div class="" style="">
                                        <div class="d-lg-flex justify-content-between align-items-center">
                                            <img class="d-block" src="{{ $article->getMedia('image')->first()->getUrl() }}" alt="{{ setting()->title }}">
                                            <div class="py-5 mx-auto" style="z-index: 10;">
                                                <div class="text-center text-lg-left text-lg-nowrap">
                                                    <a class="btn btn-primary delay-4" href="https://www.palaisdelanature.com/category/produits-rondeurs">
                                                        Produits fessiers <i class="ml-2 czi-arrow-right mr-n1"></i>
                                                    </a>
                                                    <a class="btn btn-primary delay-4" href="https://www.palaisdelanature.com/category/cosmetiques">
                                                        Produits cosmétiques <i class="ml-2 czi-arrow-right mr-n1"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-5" style="background-color: #e2b900;">
        <div class="container">
            <div class="pb-3 row">
                @foreach (specific_article($articles, 267) as $article)
                    <div class="mb-4 col-md-3 col-sm-6">
                        <div class="d-flex">
                            <i class="{{ $article->icon }} text-primary" style="font-size: 2.25rem;"></i>
                            <div class="ps-3">
                                <h2 class="mb-1 fs-base text-light">
                                    {{ $article->title }}
                                </h2>
                                <p class="mb-0 opacity-50 fs-ms text-light">
                                    {{ $article->subtitle }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- <section class="container pt-3 pb-5 position-relative pt-lg-0" style="z-index: 10;">
        <div class="row">
            <div class="col-lg-12">
                <div class="border-0 shadow-lg card">
                    <div class="px-3 pb-0 card-body pt-grid-gutter">
                        <div class="row g-0 ps-1">
                            @foreach (specific_article($articles, 125)->where('active_size', 1)->take(4) as $article)
                                @if($article->getMedia('image')->first())
                                    <div class="px-2 col-md-3 mb-grid-gutter">
                                        <a class="text-center d-block text-decoration-none me-1" href="{{ route('article.show', $article->slug) }}">
                                            <div class="box-img">
                                                <img class="mb-3 rounded d-block" src="{{ $article->getMedia('image')->first()->getUrl('thumb') }}" alt="{{ $article->title }}">
                                            </div>
                                            <h3 class="pt-1 mb-0 fs-base">
                                                {{ $article->title }}
                                            </h3>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <section class="container py-4 mb-2 py-lg-5">
        <div class="mb-2 align-items-center justify-content-between mb-sm-3 section-header">
            <h2 class="mb-0 h3">Nos gammes de produits</h2>
        </div>
        <!-- Product carousel-->
        <div class="px-0 tns-carousel tns-controls-static tns-controls-outside mx-xl-n4 mx-n2 px-xl-4">
            <div class="mx-0 tns-carousel-inner row gx-xl-0 gx-3" data-carousel-options="{&quot;items&quot;: 2, &quot;autoHeight&quot;: false, &quot;nav&quot;: true, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1,&quot;controls&quot;: false, &quot;gutter&quot;: 0},&quot;500&quot;:{&quot;items&quot;:2},&quot;768&quot;:{&quot;items&quot;:3}, &quot;1100&quot;:{&quot;items&quot;:4}, &quot;1278&quot;:{&quot;controls&quot;: true, &quot;nav&quot;: false, &quot;gutter&quot;: 30}}}">
                @foreach (specific_article($articles, 125)->where('active_size', 1)->take(4) as $article)
                    @if($article->getMedia('image')->first())
                        <!-- Product item-->
                        <div class="py-3 col">
                            <article class="border-0 shadow card product-card h-100">
                                <div class="overflow-hidden card-img-top position-relative">
                                    <a class="d-block" href="{{ route('article.show', $article->slug) }}">
                                        <img src="{{ $article->getMedia('image')->first()->getUrl() }}" alt="{{ $article->title }}">
                                    </a>
                                    {{-- <!-- Countdown timer-->
                                    <div class="top-0 m-3 badge bg-dark fs-sm position-absolute start-0 zindex-5">
                                        <i class="ci-time me-1"></i>
                                        <div class="countdown d-inline" data-countdown="12/31/2023 12:00:00 PM">
                                            <span class="mb-0 countdown-hours me-0">
                                                <span class="countdown-value">0</span>
                                                <span class="countdown-label fs-lg">:</span>
                                            </span>
                                            <span class="mb-0 countdown-minutes me-0">
                                                <span class="countdown-value">0</span>
                                                <span class="countdown-label fs-lg">:</span>
                                            </span>
                                            <span class="mb-0 countdown-seconds me-0">
                                                <span class="countdown-value">0</span>
                                            </span>
                                        </div>
                                    </div>
                                    <!-- Wishlist button-->
                                    <button class="top-0 btn-wishlist btn-sm position-absolute end-0" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Favorites" style="margin: 12px;"><i class="ci-heart"></i></button> --}}
                                </div>
                                <div class="card-body">
                                    <h3 class="mb-2 product-title fs-base">
                                        <a class="d-block text-truncate" href="{{ route('article.show', $article->slug) }}">
                                            {{ $article->title }}
                                        </a>
                                    </h3>
                                    <div class="flex-wrap d-flex align-items-center">
                                        <h1 class="mt-1 mb-0 fs-base text-darker">
                                            {{ devise($article->price_new) }}
                                        </h1>
                                    </div>
                                </div>
                                <div class="card-body{{--  card-body-hidden --}}">
                                    <a href="{{ route('article.show', $article->slug) }}" class="mb-2 btn btn-primary btn-sm d-block w-100">
                                        <i class="ci-cart fs-sm me-1"></i> Découvrez
                                    </a>
                                </div>
                            </article>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>


    @foreach ($categoriesHome as $category)
        @if (count($category->products))
            <section class="pt-3 pt-md-4">
                <div class="container">
                    <div class="row">
                        <div class="flex-wrap mb-2 d-flex align-items-center justify-content-between mb-sm-3 section-header">
                            <h2 class="pt-3 mb-0 h3 me-3">
                                {{ $category->title }}
                            </h2>
                            <div class="pt-3">
                                <a class="btn btn-primary btn-sm" href="{{ route('article.index', $category->slug) }}">
                                    Voir tous les produits
                                    <i class="ci-arrow-right ms-1 me-n1"></i>
                                </a>
                            </div>
                        </div>
                        {{-- <div class="pt-2 tns-carousel tns-controls-static tns-controls-outside tns-nav-enabled">
                            <div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 2, &quot;gutter&quot;: 16, &quot;controls&quot;: true, &quot;autoHeight&quot;: true, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1}, &quot;480&quot;:{&quot;items&quot;:2}, &quot;720&quot;:{&quot;items&quot;:3}, &quot;991&quot;:{&quot;items&quot;:2}, &quot;1140&quot;:{&quot;items&quot;:3}, &quot;1300&quot;:{&quot;items&quot;:4}, &quot;1500&quot;:{&quot;items&quot;:5}}}"> --}}
                                @foreach ($category->products->take(8) as $article)
                                    @include('item-shop', [
                                        'articles' => $article,
                                        'column' => 'col-lg-3 col-6 col-sm-4',
                                        'thumb' => 'normal',
                                    ])
                                @endforeach
                            {{-- </div>
                        </div> --}}
                        <div class="col-lg-12"><hr></div>
                    </div>
                </div>
            </section>
        @endif
    @endforeach



    @push('script')
    @endpush
</div>
