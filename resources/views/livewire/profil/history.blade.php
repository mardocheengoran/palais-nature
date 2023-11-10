<div>
    <x-slot name="title">Espace membre</x-slot>
    @include('layouts.header')

    <div class="container pb-5 mb-2 mb-md-3">
        <div class="row">
            @include('livewire.profil.account')
            <!-- Content  -->
            <div class="mt-5 col-lg-8 order-lg-1 order-0">
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
                                'column' => 'col-md-3 col-6',
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
