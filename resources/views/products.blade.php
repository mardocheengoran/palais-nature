<div>
    @push('style')
    @endpush

    @include('layouts.header')

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
                    <div class="row">
                        <div class="col-lg-8 mb-2"></div>
                        <div class="col-lg-4 mb-2 col-sm-12">
                            <div class="form-floating">
                                <select wire:model='filter' class="form-select" id="floatingSelect" aria-label="Trier les produits">
                                    <option value="tous">Tous les produits</option>
                                    <option value="recent">Plus recent</option>
                                    <option value="croissant">Prix croissant</option>
                                    <option value="decroissant">Prix décroissant</option>
                                </select>
                                <label for="floatingSelect">Trier par</label>
                              </div>
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
    {{-- <div class="container py-2 bg-white rounded shadow-lg" ></div> --}}
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
