<div>
    @push('style')
    @endpush

    @include('layouts.header')

    <div class="breadcrumb_section page-title-mini bg-category" style="background-image: url({{ !empty($rubric->getMedia('cover')->first()) ? url($rubric->getMedia('cover')->first()->getUrl()) : url($rubric->getMedia('image')->first()->getUrl()) }})">
        <div class="mask">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-title">
                            <h1 class="text-center text-white">{{ $title }}</h1>
                        </div>
                    </div>
                    {{-- <div class="col-md-6">
                        <ol class="breadcrumb justify-content-md-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item active">Shop List</li>
                        </ol>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="main_content">
        @if (count($rubric->childrens))
            <div class="py-4">
                <div class="container">
                    <div class="p-3 shadow-lg card" style="margin-top: -100px;">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="heading_s1">
                                    <h2 class="text-warning">Sous catégories</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="product_slider carousel_slider owl-carousel owl-theme nav_style1" data-loop="false" data-dots="false" data-nav="true" data-margin="5" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "6"}, "1199":{"items": "5"}}'>
                                    @foreach ($rubric->childrens as $item)
                                        <div class="item">
                                            <div class="product">
                                                <a href="{{ route('article.index', $item->slug) }}">
                                                    <div class="product_img">
                                                        @if(!empty($item->getMedia('image')->first()))
                                                            <img src="{{ url($item->getMedia('image')->first()->getUrl('thumb')) }}" alt="{{ $item->title }}">
                                                        @endif
                                                    </div>
                                                </a>
                                                <div class="product_info">
                                                    <h6 class="product_title">
                                                        <a href="{{ route('article.index', $item->slug) }}">
                                                            {{ $item->title }}
                                                        </a>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        @if (count($rubric->products))
            <div class="pb-0 section small_pt">
                <div class="container">
                    <div class="p-3 card">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="p-3 pb-5 mb-3 heading_s2">
                                            <div class="pb-2 h3 position-absolute text-danger">Les plus demandés</div>
                                            {{-- <div class="end-0 position-absolute me-2">
                                                <a href="#" class="text-white">Découvrez +</a>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="product_slider carousel_slider owl-carousel owl-theme dot_style1" data-loop="true" data-margin="20" data-responsive='{"0":{"items": "2"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "6"}}'>
                                            @foreach ($rubric->products->take(12) as $article)
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
            </div>
        @endif


        <div class="pb-0 section small_pt">
            <div class="container">
                <div class="card p-3">
                    <div class="row">
                        <div class="col-12">
                            <header class="section-header my-4">
                                <h3>{{ $title }}</h3>
                            </header>
                        </div>
                    </div>
                    <div class="infinite-scroll">
                        <div class="row">
                            @foreach ($products as $article)
                                @include('item-shop', [
                                    'articles' => $article,
                                    'column' => 'col-md-2 col-6',
                                    'thumb' => 'thumb',
                                ])
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                {{ $products->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>
        <script type="text/javascript">
            $('ul.pagination').hide();
            $(function() {
                $('.infinite-scroll').jscroll({
                    autoTrigger: true,
                    loadingHtml: '<div class="m-auto text-center"><img class="text-center w-25" src="/img/loading.gif" alt="Chargement..." /></div>',
                    padding: 0,
                    nextSelector: '.pagination li.active + li a',
                    contentSelector: 'div.infinite-scroll',
                    callback: function() {
                        $('ul.pagination').remove();
                    }
                });
            });
        </script>
    @endpush
</div>
