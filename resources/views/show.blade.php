<div>
    @push('style')
    @endpush
    @include('layouts.header')
    @include('signal')

    <!-- Custom page title-->
    <section class="pt-4 page-title-overlap bg-primary">
        <div class="container py-2 d-lg-flex justify-content-between py-lg-3">
            <div class="mb-3 order-lg-2 mb-lg-0 pt-lg-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                        <li class="breadcrumb-item">
                            <a class="text-nowrap" href="{{ route('welcome') }}">
                                <i class="ci-home"></i>
                                Accueil
                            </a>
                        </li>
                        <li class="breadcrumb-item text-nowrap">
                            <a href="{{ route('article.index', $article->rubric->slug) }}">{{ $article->rubric->title }}</a>
                        </li>
                        <li class="breadcrumb-item text-nowrap active" aria-current="page">
                            {{ $article->title }}
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="text-center order-lg-1 pe-lg-4 text-lg-start">
                <h1 class="mb-2 h3 text-light">
                    {{ $article->title }}
                </h1>
            </div>
        </div>
    </section>
    <section class="container">
        <div class="p-3 shadow-lg bg-light rounded-3">
            <div class="row">
                <!-- Product gallery-->
                <div class="col-lg-5 pe-lg-0">
                    <div class="product-gallery">
                        <div class="product-gallery-preview order-sm-2">
                            @foreach ($article->getMedia('image') as $item)
                                <div class="product-gallery-preview-item {{ $loop->first ? 'active' : '' }}" id="{{ $item->id }}">
                                    <img class="image-zoom" src="{{ url($item->getUrl()) }}" data-zoom="{{ url($item->getUrl()) }}" alt="{{ $article->title }}">
                                    <div class="image-zoom-pane"></div>
                                </div>
                            @endforeach
                        </div>
                        <div class="product-gallery-thumblist order-sm-1">
                            @foreach ($article->getMedia('image') as $item)
                                <a class="product-gallery-thumblist-item {{ $loop->first ? 'active' : '' }}" href="#{{ $item->id }}">
                                    <img src="{{ url($item->getUrl()) }}" alt="{{ $article->title }}">
                                </a>
                            @endforeach
                            {{-- <a class="product-gallery-thumblist-item video-item" href="https://www.youtube.com/watch?v=nrQevwouWn0">
                                <div class="product-gallery-thumblist-item-text"><i class="ci-video"></i>Video</div>
                            </a> --}}
                        </div>
                    </div>
                </div>
                <!-- Product details-->
                <div class="pt-4 col-lg-7 pt-lg-0">
                    <div class="pb-3 product-details ms-auto">
                        <div class="mb-2 text-end">

                            <button type="button" data-bs-toggle="tooltip" aria-label="Ajouter à la liste d'envie" data-bs-original-title="Ajouter à la liste d'envie" wire:loading.class="text-warning"  wire:loading.attr="disabled" wire:click="wishlist" class="btn-wishlist me-0 me-lg-n3" href="#">
                                <i class="ci-heart"></i>
                                <div wire:loading wire:target="wishlist">
                                    <span class="spinner-border spinner-border-sm"></span>
                                </div>
                            </button>
                        </div>
                        <div class="mb-3">
                            <span class="mr-1 h3 font-weight-normal text-primary">
                                {{ devise($article->price_new) }}
                            </span>
                            @if ($article->price_old)
                                <del class="text-muted fs-lg me-3">
                                    {{ devise($article->price_old) }}
                                </del>

                                <span class="align-middle badge bg-primary badge-shadow mt-n2">
                                    @php($solde = 100-($article->price_new*100)/$article->price_old)
                                    {{ '-'.number_format($solde, 2, '.', ' ').'%' }}
                                </span>
                            @endif
                        </div>
                        <form class="pt-2 pb-4 d-flex align-items-center">
                            <select class="form-select me-3" style="width: 5rem;" name="quantity" id="quantity" wire:model="quantity">
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <button wire:loading.class="bg-dark"  wire:loading.attr="disabled" wire:click.prevent="addCart" class="btn btn-primary btn-shadow d-block w-100" type="button">
                                <i class="ci-cart fs-lg me-2"></i>
                                Ajouter au panier
                                <div wire:loading wire:target="addCart">
                                    <span class="spinner-border spinner-border-sm"></span>
                                </div>
                            </button>
                        </form>
                        {!! $article->content !!}
                        <!-- Sharing-->
                        {{-- <label class="my-2 align-middle form-label d-inline-block me-3">Share:</label>
                        <a class="my-2 btn-share btn-twitter me-2" href="#"><i class="ci-twitter"></i>Twitter</a>
                        <a class="my-2 btn-share btn-instagram me-2" href="#"><i class="ci-instagram"></i>Instagram</a>
                        <a class="my-2 btn-share btn-facebook" href="#"><i class="ci-facebook"></i>Facebook</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="container pb-5 pt-lg-2 mb-md-3" wire:ignore>
        <div class="section-header">
            <h2 class="pb-4 text-center h3">
                Produits similaires
            </h2>
        </div>
        <div class="tns-carousel tns-controls-static tns-controls-outside">
            <div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 2, &quot;controls&quot;: true, &quot;nav&quot;: false, &quot;responsive&quot;: {&quot;0&quot;:{&quot;items&quot;:1},&quot;500&quot;:{&quot;items&quot;:2, &quot;gutter&quot;: 18},&quot;768&quot;:{&quot;items&quot;:3, &quot;gutter&quot;: 20}, &quot;1100&quot;:{&quot;items&quot;:4, &quot;gutter&quot;: 30}}}" style="min-height: 430px;">
                <!-- Product-->
                @foreach ($similaries as $article)
                    @include('item-shop', [
                        'articles' => $article,
                        'column' => 'col-md-3 col-6',
                        'thumb' => 'thumb',
                    ])
                @endforeach
            </div>
        </div>
    </section>


</div>

@push('script')
<script>
    window.livewire.on('formClose', () => {
        $('#signal').modal('hide');
    });

</script>
@endpush
