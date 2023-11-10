<div>
    @push('style')
    @endpush
    @include('layouts.header')

    <div class="container db-social">
        <div class="jumbotron jumbotron-fluid" style=" background-image: url('{{$users->getMedia('image')->first()->getUrl()}}');"></div>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-11">
                    <div class="widget1 head-profile has-shadow">
                        <div class="widget-body pb-0">
                            <div class="row d-flex align-items-center">
                                <div class="col-xl-4 col-md-4 d-flex justify-content-lg-start justify-content-md-start justify-content-center">
                                    <ul>
                                        <li>
                                            <div class="counter">{{ $users->articles->count('article_id') }}</div>
                                            <div class="heading">Produits</div>
                                        </li>
                                        <li>
                                            <div class="counter">{{ $users->invoices->count() }}</div>
                                            <div class="heading">Produits vendus</div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-xl-4 col-md-4 d-flex justify-content-center">
                                    <div class="image-default">
                                        <img style="width: 100px; height: 100px;" class="rounded-circle" src="{{ $users->getMedia('image')->first()->getUrl() }}" alt="{{$users->name}}">
                                    </div>
                                    <div class="infos">
                                        <h2>{{ $users->store }}</h2>
                                        <div class="location">{{ $users->address }}</div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-4 d-flex justify-content-lg-end justify-content-md-end justify-content-center">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main_content">
        <div class="pb-0 section small_pt">
            <div class="container">
                {{-- <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="heading_s1">
                            <h2 class="text-warning">Tous les produits</h2>
                        </div>
                    </div>
                </div> --}}
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
