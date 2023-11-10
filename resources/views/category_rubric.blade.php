<div>
    @push('style')
    @endpush

    @include('layouts.header')

    <div class="breadcrumb_section page-title-mini bg-category" style="background-image: url({{ !empty($rubric->getMedia('image')->first()) ? url($rubric->getMedia('image')->first()->getUrl()) : '' }})">
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
        <div class="pb-0 section small_pt">
            <div class="container">
                <div class="p-3 card">
                    <div class="row">
                        @foreach ($rubric->products as $article)
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

    </div>


    {{-- <div class="container py-2 bg-white rounded shadow-lg" ></div> --}}
    @push('script')
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>
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
        </script> --}}
    @endpush
</div>
