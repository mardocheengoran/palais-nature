<div>
    @push('style')
    @endpush

    @include('layouts.header')

    <!-- START SECTION BANNER -->
    <div class="mt-0 staggered-animation-wrap">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 offset-lg-3">
                    <div class="banner_section shop_el_slider">
                        <div id="carouselExampleControls" class="carousel slide carousel-fade light_arrow" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($all = specific_article($articles, 18) as $article)
                                    @if($article->getMedia('image')->first())
                                        <a href="{{ $article->link ? url($article->link) : '#' }}" style="background-repeat: no-repeat; background-size:contain;" class="carousel-item {{ $loop->first ? 'active' : '' }} background_bg img-fluid" data-img-src="{{ url($article->getMedia('image')->first()->getUrl('normal')) }}">
                                            {{-- <div class="banner_slide_content banner_content_inner">
                                                <div class="col-lg-7 col-10">
                                                    <div class="overflow-hidden banner_content3">
                                                        <h5 class="mb-3 staggered-animation font-weight-light" data-animation="slideInLeft" data-animation-delay="0.5s">Plus de -30% de rduction</h5>
                                                        <h2 class="staggered-animation" data-animation="slideInLeft" data-animation-delay="1s">Montre Intelligente</h2>
                                                        <h4 class="mb-4 staggered-animation product-price" data-animation="slideInLeft" data-animation-delay="1.2s"><span class="price">20 000 Fr</span><del>45 000 Fr</del></h4>
                                                        <a class="btn btn-fill-out btn-radius staggered-animation text-uppercase" href="shop-left-sidebar.html" data-animation="slideInLeft" data-animation-delay="1.5s">Acheter maintenant</a>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </a>
                                    @endif
                                @endforeach
                                {{-- <div class="carousel-item background_bg img-fluid" data-img-src="{{ asset('img/tele.jpg') }}">
                                    <div class="banner_slide_content banner_content_inner">
                                        <div class="col-lg-8 col-10">
                                            <div class="overflow-hidden banner_content3">
                                                <h5 class="mb-3 staggered-animation font-weight-light" data-animation="slideInLeft" data-animation-delay="0.5s">Plus de -30% de rduction</h5>
                                                <h2 class="staggered-animation" data-animation="slideInLeft" data-animation-delay="1s">Télévion Samsung 12 pouces</h2>
                                                <h4 class="mb-3 staggered-animation mb-sm-4 product-price" data-animation="slideInLeft" data-animation-delay="1.2s"><span class="price">129 000 Fr</span><del>170 000 Fr</del></h4>
                                                <a class="btn btn-fill-out btn-radius staggered-animation text-uppercase" href="shop-left-sidebar.html" data-animation="slideInLeft" data-animation-delay="1.5s">Acheter maintenant</a>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- <div class="carousel-item background_bg img-fluid" data-img-src="{{ asset('img/micro.jpg') }}">
                                    <div class="banner_slide_content banner_content_inner">
                                        <div class="col-lg-8 col-10">
                                            <div class="overflow-hidden banner_content3">
                                                <h5 class="mb-3 staggered-animation font-weight-light" data-animation="slideInLeft" data-animation-delay="0.5s">Plus de -30% de rduction</h5>
                                                <h2 class="staggered-animation" data-animation="slideInLeft" data-animation-delay="1s">Ecouteur Bluetooth</h2>
                                                <h4 class="mb-4 staggered-animation product-price" data-animation="slideInLeft" data-animation-delay="1.2s"><span class="price">15 000 Fr</span><del>25 000 Fr</del></h4>
                                                <a class="btn btn-fill-out btn-radius staggered-animation text-uppercase" href="shop-left-sidebar.html" data-animation="slideInLeft" data-animation-delay="1.5s">Acheter maintenant</a>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-bs-slide="prev"><i class="ion-chevron-left"></i></a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-bs-slide="next"><i class="ion-chevron-right"></i></a>
                            <ol class="carousel-indicators indicators_style3">
                                @php($i = 0)
                                @foreach ($all as $article)
                                    <li data-bs-target="#carouselExampleControls" data-bs-slide-to="{{ $i++ }}" class="{{ $loop->first ? 'active' : '' }}"></li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 d-none d-lg-block">
                    <div class="shop_banner2 el_banner1">
                        <div class="p-2">
                            <div href="#" class="hover_effect1">
                                <div class="el_title text_white">
                                    <div class="mb-1 fw-bolder">Faites vous assister</div>
                                </div>
                                <div class="text_white w-100">
                                    <a href="{{ route('article.show', 'espace-guide') }}" class="pb-1" style="font-size: 14px;">
                                        <i class="linearicons-chevron-right"></i>Espace guide
                                    </a>
                                    <a href="#" class="pb-1" style="font-size: 14px;">
                                        <i class="linearicons-chevron-right"></i>Commander
                                    </a>
                                    <div class="my-1 text-center fs-6 fw-bolder">
                                        07 03 33 46 24
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-warning">
                            <a href="https://api.whatsapp.com/send?phone=+225 0703334624&text=Bonjour j'ai une préoccupation sur votre bezo.ci" class="p-1 text-center text-white fw-bolder" target="_blank">
                                Chatez avec un conseiller client
                            </a>
                        </div>
                    </div>

                    <div class="shop_banner2 el_banner2">
                        @foreach (specific_article($articles, 412)->take(1) as $article)
                            @if($article->getMedia('image')->first())
                                <a href="{{ $article->link ? url($article->link) : '#' }}" class="hover_effect1">
                                    <div class="el_title text_white">
                                        <h6 class="mb-0">{{ $article->title }}</h6>
                                        <span><u>Acheter maintenant</u></span>
                                    </div>
                                    <div class="el_img">
                                        <img src="{{ url($article->getMedia('image')->first()->getUrl('thumb')) }}" alt="Bezo">
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION BANNER -->

    <!-- END MAIN CONTENT -->
    <div class="main_content">
        <div class="py-3">
            <div class="container">
                <div class="p-3 card bg-light">
                    <div class="row">
                        @handheld()
                        @foreach ($categories->take(8) as $category)
                            @if(!empty($category->getMedia('image')->first()))
                                <div class="mb-2 col-4">
                                    <a href="{{ route('article.index', $category->slug) }}">
                                        <img src="{{ url($category->getMedia('image')->first()->getUrl('thumb')) }}" class="border img-fluid rounded-3 border-1">
                                        <div>
                                            {{ $category->title }}
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                        @elsehandheld()
                            @foreach ($categories as $category)
                                @if (count($category->childrens))
                                    <div class="mb-2 col-md-3">
                                        <div class="card">
                                            <div class="flex-row p-2 card-body">
                                                <div class="h6">
                                                    <a href="{{ route('article.index', $category->slug) }}" class="text-warning">
                                                        {{ $category->title }}
                                                    </a>
                                                </div>
                                                <div class="text-center">
                                                    @foreach ($category->childrens->take(3) as $item)
                                                        @if(!empty($item->getMedia('image')->first()))
                                                            <div class="me-1 d-inline-block">
                                                                <a href="{{ route('article.index', $item->slug) }}">
                                                                    <img src="{{ url($item->getMedia('image')->first()->getUrl('thumb')) }}" style="height: 70px;" class="rounded">
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                {{-- <img style="width: 100px" src="{{ asset('img/9.jpg') }}" alt="" srcset="">
                                                <img style="width: 100px" src="{{ asset('img/9.jpg') }}" alt="" srcset=""> --}}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endhandheld()
                    </div>
                    <div class="mt-3 text-center">
                        <a href="{{ route('boutique.index') }}" class="btn btn-warning text-uppercase">
                            Boutiques
                            <i class="icofont-caret-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- <div class="pb-0">
                <div class="container">
                    <div class="row">
                        @foreach (specific_article($articles, 265)->slice(0, 1) as $article)
                            @if(!empty($article->getMedia('image')->first()))
                                <div class="mt-3 col-md-12">
                                    <a href="{{ ($article->link) ? $article->link : '#' }}">
                                        <img class="img-fluid" src="{{ url($article->getMedia('image')->first()->getUrl()) }}" alt="{{ $article->title }}">
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div> --}}

            @if ($flashes)
                <div class="container mt-3">
                    <div class="p-3 border-0 card">
                        <div class="row">
                            <div class="col-xl-3 d-none d-xl-block">
                                <div class="sale-banner">
                                    @if(!empty($flashes->getMedia('image')->first()))
                                        <div class="me-1 d-inline-block">
                                            <a class="hover_effect1" href="#">
                                                <img src="{{ url($flashes->getMedia('image')->first()->getUrl('normal')) }}" alt="{{ $flashes->title }}">
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-9">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="p-3 pb-5 mb-3 text-white heading_s2 bg-danger">
                                            <div class="pb-2 h3 position-absolute">Offre flash</div>
                                            <div class="end-0 position-absolute me-2">
                                                <a href="#" class="text-white">Découvrez +</a>
                                                <div id="timer" data-endtime="{{ $flashes->limit_at }}"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="product_slider carousel_slider owl-carousel owl-theme nav_style1" data-nav="true" data-loop="true" data-margin="20" data-responsive='{"0":{"items": "2"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>
                                            @foreach ($flashes->articles as $article)
                                                @include('item-shop', [
                                                    'articles' => $article,
                                                    'thumb' => 'thumb',
                                                ])
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="pb-0">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="p-3 pb-5 mb-0 text-white heading_s2" style="background-color: #a85527;">
                            <div class="pb-2 h3 position-absolute">Les plus commandés</div>
                            <div class="end-0 position-absolute me-2">
                                <a href="#" class="text-white">Découvrez +</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3 card">
                    <div class="row">
                        @foreach (specific_article($articles, 125)->take(12) as $article)
                            @include('item-shop', [
                                'articles' => $article,
                                'column' => 'col-md-2 col-6',
                                'thumb' => 'thumb',
                            ])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>


        <div class="pb-0">
            <div class="container">
                <div class="row">
                    @foreach (specific_article($articles, 265)->slice(0, 1) as $article)
                        @if(!empty($article->getMedia('image')->first()))
                            <div class="mt-3 col-md-12">
                                <a href="{{ ($article->link) ? $article->link : '#' }}">
                                    <img class="img-fluid" src="{{ url($article->getMedia('image')->first()->getUrl()) }}" alt="{{ $article->title }}">
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>


        @php($i = 0)
        @php($j = 0)
        @foreach ($categoriesHome as $category)
            @if (count($category->products))
                @php($i++)
                <div class="pb-0 mt-3">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="p-3 pb-5 mb-0 text-white heading_s2" style="background-color: {{ $category->color }};">
                                    <div class="pb-2 h3 position-absolute">
                                        {{ ($category->subtitle) ? $category->subtitle : $category->title }}
                                    </div>
                                    <div class="end-0 position-absolute me-2">
                                        <a href="{{ route('article.index', $category->slug) }}" class="text-white">Découvrez +</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 card">
                            <div class="row">
                                @foreach ($category->products->take(12) as $article)
                                    @include('item-shop', [
                                        'articles' => $article,
                                        'column' => 'col-md-2 col-6',
                                        'thumb' => 'thumb',
                                    ])
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                @if ($i == 1)
                    @php($i = 0)
                    <div class="pb-0">
                        <div class="container">
                            <div class="row">
                                @foreach (specific_article($articles, 266)->slice($j, 2) as $article)
                                    @if(!empty($article->getMedia('image')->first()))
                                        <div class="mt-3 col-md-6 col-6">
                                            <a href="{{ ($article->link) ? $article->link : '#' }}">
                                                <img width="560" class="img-fluid" src="{{ url($article->getMedia('image')->first()->getUrl('normal')) }}" alt="{{ $article->title }}">
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @php($j += 2)
                @endif
            @endif
        @endforeach


        <div class="pb-0">
            <div class="container">
                <div class="row">
                    @foreach (specific_article($articles, 265)->slice(1, 1) as $article)
                        @if(!empty($article->getMedia('image')->first()))
                            <div class="mt-3 col-md-12">
                                <a href="{{ ($article->link) ? $article->link : '#' }}">
                                    <img class="img-fluid" src="{{ url($article->getMedia('image')->first()->getUrl()) }}" alt="{{ $article->title }}">
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <br>

    </div>
    <!-- END MAIN CONTENT -->
    @push('script')
        {{-- <script defer src="https://unpkg.com/alpinejs@3.10.5/dist/cdn.min.js"></script> --}}
        <script>
            function myTimer() {
                var ending = jQuery("#timer").attr("data-endtime"),
                endTime = new Date(ending);
                endTime = Date.parse(endTime) / 1000;

                var now = new Date();
                now = Date.parse(now) / 1000;

                var timeLeft = endTime - now;

                var days = Math.floor(timeLeft / 86400);
                var hours = Math.floor((timeLeft - days * 86400) / 3600);
                var minutes = Math.floor((timeLeft - days * 86400 - hours * 3600) / 60);
                var seconds = Math.floor(
                    timeLeft - days * 86400 - hours * 3600 - minutes * 60
                );

                if (days < 10) {
                    days = 0 + days;
                }
                if (days < 1) {
                    days = 0;
                }
                if (hours < 10) {
                    hours = 0 + hours;
                }
                if (hours < 1) {
                    hours = 0;
                }
                if (minutes < 10) {
                    minutes = 0 + minutes;
                }
                if (minutes < 1) {
                    minutes = 0;
                }
                if (seconds < 10) {
                    seconds = 0 + seconds;
                }
                if (seconds < 1) {
                    seconds = 0;
                }

                $("#timer").html(
                    "<span id='days'>" +
                    days +
                    "<span>j </span></span>" +
                    "<span id='hours'>" +
                    hours +
                    "<span>:</span></span>" +
                    "<span id='minutes'>" +
                    minutes +
                    "<span>:</span></span>" +
                    "<span id='seconds'>" +
                    seconds +
                    "<span></span></span>"
                );
            }

            setInterval(function() {
                myTimer();
            }, 1000);
        </script>
    @endpush
</div>
