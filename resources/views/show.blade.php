<div>
    @push('style')
    @endpush
    @include('layouts.header')
    @include('signal')
    <div class="py-3 breadcrumb_section bg_gray page-title-mini">
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
                        {{-- {{ dd($article->rubric->field) }} --}}
                        @if(in_array('product', $article->rubric->field))
                            @isset ($article->category1->title)
                                <li class="breadcrumb-item">
                                    <a href="{{ route('article.index', $article->caregory1->slug) }}">
                                        {{ $article->category1->title }}
                                    </a>
                                </li>
                            @endisset
                            @isset ($article->category2->title)
                                <li class="breadcrumb-item">
                                    <a href="{{ route('article.index', $article->category2->slug) }}">
                                        {{ $article->category2->title }}
                                    </a>
                                </li>
                            @endisset
                            @isset ($article->category3->title)
                                <li class="breadcrumb-item">
                                    <a href="{{ route('article.index', $article->category3->slug) }}">
                                        {{ $article->category3->title }}
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
    </div>

    <div class="mt-2 main_content">
        <div class="container py-3">
            <div class="row">
                <div class="col-md-9">
                    <div class="p-3 card">
                        <div class="row">
                            <div class="mb-4 col-md-5 mb-md-0">
                                <div class="product-image">
                                    <div class="product_img_box">
                                        @if(!empty($article->getMedia('image')->first()))
                                            <img id="product_img" src="{{ url($article->getMedia('image')->first()->getUrl('normal')) }}" data-zoom-image="{{ url($article->getMedia('image')->first()->getUrl()) }}" alt="{{ $article->title }}">
                                        @endif
                                        <a href="#" class="product_img_zoom" title="Zoom">
                                            <span class="linearicons-zoom-in"></span>
                                        </a>
                                    </div>
                                    <div id="pr_item_gallery" class="product_gallery_item slick_slider slick-initialized slick-slider" data-slides-to-show="4" data-slides-to-scroll="1" data-infinite="false">
                                        <div aria-live="polite" class="slick-list draggable">
                                            <div class="slick-track" role="listbox" style="opacity: 1; width: 556px; left: 0px;">
                                                @foreach ($article->getMedia('image') as $key => $item)
                                                    <div class="item slick-slide {{ $loop->first ? 'slick-current' : '' }} slick-active" data-slick-index="0" aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide{{ $key }}" style="width: 129px;">
                                                        <a href="#" class="product_gallery_item active" data-image="{{ url($item->getUrl()) }}" data-zoom-image="{{ url($item->getUrl()) }}" tabindex="0">
                                                            <img src="{{ url($item->getUrl('normal')) }}" alt="{{ $article->title }}" />
                                                        </a>
                                                    </div>
                                                @endforeach
                                                {{-- <div class="item slick-slide slick-active" data-slick-index="1" aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide01" style="width: 129px;">
                                                    <a href="#" class="product_gallery_item" data-image="assets/images/product_img1-2.jpg" data-zoom-image="assets/images/product_zoom_img2.jpg" tabindex="0">
                                                        <img src="assets/images/product_small_img2.jpg" alt="product_small_img2" />
                                                    </a>
                                                </div>
                                                <div class="item slick-slide slick-active" data-slick-index="2" aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide02" style="width: 129px;">
                                                    <a href="#" class="product_gallery_item" data-image="assets/images/product_img1-3.jpg" data-zoom-image="assets/images/product_zoom_img3.jpg" tabindex="0">
                                                        <img src="assets/images/product_small_img3.jpg" alt="product_small_img3" />
                                                    </a>
                                                </div>
                                                <div class="item slick-slide slick-active" data-slick-index="3" aria-hidden="false" tabindex="-1" role="option" aria-describedby="slick-slide03" style="width: 129px;">
                                                    <a href="#" class="product_gallery_item" data-image="assets/images/product_img1-4.jpg" data-zoom-image="assets/images/product_zoom_img4.jpg" tabindex="0">
                                                        <img src="assets/images/product_small_img4.jpg" alt="product_small_img4" />
                                                    </a>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="pr_detail">
                                    <div class="product_description">
                                        <h4 class="product_title">
                                            {{ $article->title }}
                                        </h4>
                                        {{-- <div>
                                            <div class="float-none mt-4 mb-3 rating_wrap">
                                                <div class="rating">
                                                    <div class="product_rate" style="width:80%"></div>
                                                </div>
                                                <span class="rating_num">(5 avis vérifiés)</span>
                                                <hr class="my-1">
                                            </div>
                                        </div> --}}

                                        <div class="float-none mb-1 product_price">
                                            @if ($flash = new_price($article->id))
                                                <span class="price">
                                                    {{ devise($flash->price_new) }}
                                                </span>
                                            @else
                                                <span class="price">
                                                    {{ devise($article->price_new) }}
                                                </span>
                                            @endif


                                            @if ($flash = new_price($article->id))
                                                <del>
                                                    {{ devise($article->price_new) }}
                                                </del>
                                                <div class="on_sale">
                                                    <span>
                                                        -{{ number_format($flash->price_discount, 1, ',', ' ') }}%
                                                    </span>
                                                </div>
                                            @else
                                                @if ($article->price_old)
                                                    <del>
                                                        {{ devise($article->price_old) }}
                                                    </del>
                                                    <div class="on_sale">
                                                        <span>
                                                            -{{ number_format(100-($article->price_new*100)/$article->price_old, 1, '.', ' ') }}%
                                                        </span>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                        @isset($article->brand)
                                            <div class="brand_name">
                                                <a href="{{ route('article.index', $article->brand->slug) }}">
                                                    {{ $article->brand->title }}
                                                </a>
                                            </div>
                                        @endisset
                                        <div>
                                            @if ($article->quantity <= 10)
                                                <span class="text-danger fs-5 fw-bold small">
                                                    Quantité restante : {{ $article->quantity }}
                                                </span>
                                            @else
                                                <span class="text-warning small">
                                                    Quantité restante : {{ $article->quantity }}
                                                </span>
                                            @endif
                                        </div>
                                        {{-- <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width: 80%;"></div>
                                            </div>
                                            <span class="rating_num">(21)</span>
                                        </div> --}}
                                        <div class="pr_desc">
                                            <p>
                                                {!! $article->resume !!}
                                            </p>
                                        </div>
                                        {{-- <div class="product_sort_info">
                                            <ul>
                                                <li><i class="linearicons-shield-check"></i> 1 Year AL Jazeera Brand Warranty</li>
                                                <li><i class="linearicons-sync"></i> 30 Day Return Policy</li>
                                                <li><i class="linearicons-bag-dollar"></i> Cash on Delivery available</li>
                                            </ul>
                                        </div> --}}
                                        {{-- <div>
                                            <div class="pr_switch_wrap">
                                                <span class="switch_lable">Couleur</span>
                                                <div class="product_color_switch">

                                                    <span class="active" data-color="#87554B" style="background-color: rgb(135, 85, 75);"></span>
                                                    <span data-color="#333333" style="background-color: rgb(51, 51, 51);"></span>
                                                    <span data-color="#DA323F" style="background-color: rgb(218, 50, 63);"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pr_switch_wrap">
                                            <span class="switch_lable">Size</span>
                                            <div class="product_size_switch">
                                                <span>xs</span>
                                                <span>s</span>
                                                <span>m</span>
                                                <span>l</span>
                                                <span>xl</span>
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <form>
                                                @csrf
                                                {{-- <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                    @foreach ($article->sizes as $item)
                                                        <label class="mr-1 btn btn-outline-info btn-icon-only">
                                                            <input value="{{ $item->title }}" type="checkbox" id="size" wire:model="size" name="size[]"> {{ $item->title }}
                                                        </label>
                                                    @endforeach
                                                </div> --}}
                                                <div class="form-group">
                                                    @if ($article->active_size)
                                                        @foreach ($article->sizes as $item)
                                                            {{-- @php(dd(check_cart($cartId, $item->title))) --}}
                                                            <div class="mb-2 custom-control custom-option custom-control-inline">
                                                                <input value="{{ $item->title }}" type="radio" class="custom-control-input" id="size-{{ $item->id }}" wire:model="size" name="size[]">
                                                                <label for="size-{{ $item->id }}" class="custom-option-label">
                                                                    {{ $item->title }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                        @error('size')
                                                            <div class="text-center text-danger">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                        @enderror
                                                    @endif
                                                    <select style="height: 37px; width: {{ $article->active_size ? '60px' : '50%' }} ;" class="py-0 form-control-sm form-control d-inline-block" name="quantity" id="quantity" wire:model="quantity">
                                                        @for($i = 1; $i <= 10; $i++)
                                                            <option value="{{ $i }}">{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                {{-- <div class="mt-3 btn-group btn-group-toggle d-block" data-toggle="buttons">
                                                    @foreach ($article->couleurs as $item)
                                                        <label class="mr-1 btn btn-outline-dark btn-icon-only rounded-circle" style="background-color: {{ $item->sous_titre }};">
                                                            <input required value="{{ $item->sous_titre }}" type="radio" id="couleur" name="couleur[]">
                                                        </label>
                                                    @endforeach
                                                </div> --}}
                                                <div class="cart_extra">
                                                    {{-- <div class="cart-product-quantity">
                                                        <div class="quantity">
                                                            <input type="button" value="-" class="minus">
                                                            <input type="text" wire:model="quantity" name="quantity" value="1" title="Qty" class="qty" size="4">
                                                            <input type="button" value="+" class="plus">
                                                        </div>
                                                    </div> --}}
                                                    <div class="cart_btn">
                                                        <button wire:loading.class="bg-dark"  wire:loading.attr="disabled" wire:click.prevent="addCart" class="btn btn-fill-out btn-addtocart" type="button">
                                                            <i class="icon-basket-loaded"></i>Ajouter au panier
                                                            <div wire:loading wire:target="addCart">
                                                                <span class="spinner-border spinner-border-sm"></span>
                                                            </div>
                                                        </button>

                                                        <button type="button" wire:loading.class="text-warning"  wire:loading.attr="disabled" wire:click="wishlist" class="p-0 add_wishlist btn" href="#">
                                                            <i class="icon-heart"></i>
                                                            <div wire:loading wire:target="wishlist">
                                                                <span class="spinner-border spinner-border-sm"></span>
                                                            </div>
                                                        </button>
                                                    </div>
                                                    @error('quantity')
                                                        <div class="text-center text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    {{-- <div class="cart_extra">
                                        <div class="cart-product-quantity">
                                            <div class="quantity">
                                                <input type="button" value="-" class="minus" />
                                                <input type="text" name="quantity" value="1" title="Qty" class="qty" size="4" />
                                                <input type="button" value="+" class="plus" />
                                            </div>
                                        </div>
                                        <div class="cart_btn">
                                            <button class="btn btn-fill-out btn-addtocart" type="button"><i class="icon-basket-loaded"></i>Ajouter au panier</button>
                                            <a class="add_compare" href="#"><i class="icon-shuffle"></i></a>
                                            <a class="add_wishlist" href="#"><i class="icon-heart"></i></a>
                                        </div>
                                    </div> --}}
                                    <hr />
                                    {{-- <ul class="product-meta">
                                        <li>Category: <a href="#">Clothing</a></li>
                                    </ul> --}}
                                </div>
                            </div>
                        </div>

                        <a href="#" class="text-primary small text-end d-block" data-bs-toggle="modal" data-bs-target="#signal">
                            Signaler ce produit
                        </a>
                    </div>

                    <div class="p-3 mt-2 card">
                        <div class="row">
                            <div class="col-12">
                                <div class="tab-style3">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="Description-tab" data-bs-toggle="tab" href="#Description" role="tab" aria-controls="Description" aria-selected="true">Détails</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="Additional-info-tab" data-bs-toggle="tab" href="#Additional-info" role="tab" aria-controls="Additional-info" aria-selected="false">Fiche technique</a>
                                        </li>
                                        {{-- <li class="nav-item">
                                            <a class="nav-link" id="Reviews-tab" data-bs-toggle="tab" href="#Reviews" role="tab" aria-controls="Reviews" aria-selected="false">Reviews (2)</a>
                                        </li> --}}
                                    </ul>
                                    <div class="tab-content shop_info_tab">
                                        <div class="tab-pane fade show active" id="Description" role="tabpanel" aria-labelledby="Description-tab">
                                            {!! $article->content !!}
                                        </div>
                                        <div class="tab-pane fade" id="Additional-info" role="tabpanel" aria-labelledby="Additional-info-tab">
                                            {{-- json_decode($project->locality->location)->lat --}}
                                            <div class="row">
                                                @if ($article->other)
                                                    @foreach ($article->other as $item)
                                                        <div class="mb-2 col-md-6">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    {{ $item['titre'] }}
                                                                </div>
                                                                <div class="card-body">
                                                                    {!! $item['contenu'] !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                        {{-- <div class="tab-pane fade" id="Reviews" role="tabpanel" aria-labelledby="Reviews-tab">
                                            <div class="comments">
                                                <h5 class="product_tab_title">2 Review For <span>Blue Dress For Woman</span></h5>
                                                <ul class="mt-4 list_none comment_list">
                                                    <li>
                                                        <div class="comment_img">
                                                            <img src="assets/images/user1.jpg" alt="user1" />
                                                        </div>
                                                        <div class="comment_block">
                                                            <div class="rating_wrap">
                                                                <div class="rating">
                                                                    <div class="product_rate" style="width: 80%;"></div>
                                                                </div>
                                                            </div>
                                                            <p class="customer_meta">
                                                                <span class="review_author">Alea Brooks</span>
                                                                <span class="comment-date">March 5, 2018</span>
                                                            </p>
                                                            <div class="description">
                                                                <p>
                                                                    Lorem Ipsumin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh
                                                                    vulputate
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="comment_img">
                                                            <img src="assets/images/user2.jpg" alt="user2" />
                                                        </div>
                                                        <div class="comment_block">
                                                            <div class="rating_wrap">
                                                                <div class="rating">
                                                                    <div class="product_rate" style="width: 60%;"></div>
                                                                </div>
                                                            </div>
                                                            <p class="customer_meta">
                                                                <span class="review_author">Grace Wong</span>
                                                                <span class="comment-date">June 17, 2018</span>
                                                            </p>
                                                            <div class="description">
                                                                <p>
                                                                    It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less
                                                                    normal distribution of letters
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="review_form field_form">
                                                <h5>Add a review</h5>
                                                <form class="mt-3 row">
                                                    <div class="mb-3 form-group col-12">
                                                        <div class="star_rating">
                                                            <span data-value="1"><i class="far fa-star"></i></span>
                                                            <span data-value="2"><i class="far fa-star"></i></span>
                                                            <span data-value="3"><i class="far fa-star"></i></span>
                                                            <span data-value="4"><i class="far fa-star"></i></span>
                                                            <span data-value="5"><i class="far fa-star"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 form-group col-12">
                                                        <textarea required="required" placeholder="Your review *" class="form-control" name="message" rows="4"></textarea>
                                                    </div>
                                                    <div class="mb-3 form-group col-md-6">
                                                        <input required="required" placeholder="Enter Name *" class="form-control" name="name" type="text" />
                                                    </div>
                                                    <div class="mb-3 form-group col-md-6">
                                                        <input required="required" placeholder="Enter Email *" class="form-control" name="email" type="email" />
                                                    </div>

                                                    <div class="mb-3 form-group col-12">
                                                        <button type="submit" class="btn btn-fill-out" name="submit" value="Submit">Submit Review</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-3">
                    <div class="p-3 card">
                        <div class="h5 fw-bolder">Livraison & expédition</div>
                        <div class="small">
                            <i class="icofont-check-alt"></i>
                            Expédition en 48h soit le {{ \Carbon\Carbon::now()->addDays(2)->isoFormat('dddd DD MMMM YYYY') }}
                        </div>
                        <div class="mt-2 small">
                            <i class="icofont-check-alt"></i>
                            Livraison en 24h soit le {{ \Carbon\Carbon::now()->addDays(1)->isoFormat('dddd DD MMMM YYYY') }}
                        </div>

                        <div class="mt-4 h5 fw-bolder">Retour</div>
                        <div class="small">
                            Retours gratuits sur 3  jours à Abidjan et 5 jours à l’intérieur.
                        </div>

                        <div class="mt-4 h5 fw-bolder">Garantie</div>
                        <div class="small">
                            24 mois
                        </div>
                    </div>
                    <div class="card mt-3">
                        <a class="" href="{{ route('boutique.show', $article->supplier->id) }}">
                            <div class="card-header">
                                <i class="icofont-simple-right position-absolute end-0"></i>
                                <div class="text-muted">Vendeur</div>
                            </div>
                        </a>
                        <div class="card-body">
                            <div class="card-title">
                                <i class="icofont-building"></i>
                                {{ $article->supplier->store }}
                            </div>
                            <p class="card-text"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <div class="card bg-light">
                        <div class="product_slider carousel_slider owl-carousel owl-theme dot_style1" data-nav="true" data-loop="true" data-margin="20" data-responsive='{"0":{"items": "2"}, "481":{"items": "2"}, "768":{"items": "3"}, "991":{"items": "4"}}'>
                            @foreach ($similaries as $article)
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

@push('script')
        <script>
            window.livewire.on('formClose', () => {
                $('#signal').modal('hide');
            });
        </script>
    @endpush
