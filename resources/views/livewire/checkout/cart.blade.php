<div>
    @include('livewire.checkout.delete')
    @include('layouts.header')
    @include('livewire.checkout.clear')

    {{-- <div class="modal fade" id="clean-{{ $item->id }}" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content h-100">
                <div class="modal-header">
                    <h4 class="modal-title">Retirer du panier</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-center font-size-sm alert alert-danger">
                        Êtes-vous sûr de vouloir supprimer <strong>"{{ $item->name }}"</strong> de votre panier
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Non</button>
                    <a href="{{ url('panier?rowId='.$item->rowId) }}" class="btn btn-danger btn-shadow btn-sm">
                        <i class="icofont-trash"></i> Oui
                    </a>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="page-title-overlap bg-light">
        <div class="container py-2 d-lg-flex justify-content-between py-lg-5">
            <div class="order-lg-2 mb-lg-0">
                <nav aria-label="breadcrumb">
                    <ol class="px-3 breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                        <li class="breadcrumb-item">
                            <a class="" href="{{ route('welcome') }}">
                                <i class="czi-home"></i>Accueil
                            </a>
                        </li>
                        <li class="breadcrumb-item text-nowrap active" aria-current="page">Panier</li>
                    </ol>
                </nav>
            </div>
            <div class="text-center order-lg-1 pr-lg-4 text-lg-left">
                <h1 class="mb-0 h3">Votre panier ({{ Cart::instance('shopping')->count() }})</h1>
            </div>
        </div>
    </div>

    @if (count(Cart::instance('shopping')->content()))
        <div class="container pb-5 mb-2 mb-md-4">
            <div class="row">
                <section class="col-lg-8">

                    {{-- <div class="pt-3 pb-2 mt-1 d-flex justify-content-between align-items-center pb-sm-5">
                        <a class="pl-2 btn btn-danger btn-sm" href="#clear" data-toggle="modal">
                            <i class="mr-2 icofont-trash"></i>Vider le panier
                        </a>
                        <a class="pl-2 btn btn-primary btn-sm" href="{{ route('welcome') }}">
                            <i class="mr-2 czi-arrow-left"></i>Poursuivre vos achats
                        </a>
                    </div> --}}
                    <div class="table-responsive shop_cart_table">
                        <table class="table table-cards align-items-center" id="simpletable">
                            {{-- <thead>
                                <tr>
                                    <th>Article</th>
                                    <th>Prix</th>
                                    <th>Quantité</th>
                                    <th>Sous-total</th>
                                    <th></th>
                                </tr>
                            </thead> --}}
                            <tbody class="list">
                                @php($totaux = 0)
                                {{-- @php(dd($cart)) --}}
                                @foreach ($cart as $key => $item)
                                    @php($item = (object)$item)
                                    {{-- @php(dd($item)) --}}
                                    {{-- @php(dd((object)$item)) --}}
                                    @php($article = detailPanier($item->id))
                                    <tr style="border-style: hidden; border-top: 0px;">
                                        <td class="product-thumbnail">
                                            <a href="{{ route('article.show', $article->slug) }}">
                                                @if(!empty($article->getMedia('image')->first()))
                                                    <img width="80" src="{{ url($article->getMedia('image')->first()->getUrl('thumb')) }}" alt="{{ $item->name }}">
                                                @endif
                                            </a>
                                        </td>
                                        <td class="product-name" data-title="Product">
                                            <a href="{{ route('article.show', $article->slug) }}">
                                                {{ $item->name }}
                                            </a>
                                            <div>
                                                {{ devise($item->price) }}
                                            </div>
                                            {{-- <div class="product_size_switch">
                                                <span>
                                                    {{ $item->options->size }}
                                                </span>
                                            </div> --}}
                                            <div>
                                                Vendeur : {{ $article->supplier->store }}
                                            </div>
                                            <div class="text-muted">
                                                @if ($item->options->size)
                                                    Taille : {{ $item->options->size }}
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-end fw-bolder fs-5" data-title="Price">
                                            {{ devise($item->price * $item->qty) }}
                                            @php($totaux += $item->price * $item->qty)
                                            <div>
                                                @if ($flash = new_price($article->id))
                                                    <del class="text-muted fw-light fs-6">
                                                        {{ devise($article->price_new * $item->qty) }}
                                                    </del>
                                                    <div class="on_sale">
                                                        <span>
                                                            -{{ number_format($flash->price_discount, 1, ',', ' ') }}%
                                                        </span>
                                                    </div>
                                                @else
                                                    @if ($article->price_old)
                                                        <del class="text-muted fw-light fs-6">
                                                            {{ devise($article->price_old * $item->qty) }}
                                                        </del>
                                                        <div class="on_sale">
                                                            <span>
                                                                -{{ number_format(100-($article->price_new*100)/$article->price_old, 1, '.', ' ') }}%
                                                            </span>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                        {{-- <td>$45.00</td>
                                        <td class="product-quantity" data-title="Quantity">
                                            <div class="quantity">
                                                <input type="button" value="-" class="minus">
                                                <input type="text" name="quantity" value="2" title="Qty" class="qty" size="4">
                                                <input type="button" value="+" class="plus">
                                            </div>
                                        </td>
                                        <td class="product-subtotal" data-title="Total">$90.00</td>
                                        <td class="product-remove" data-title="Remove"><a href="#"><i class="ti-close"></i></a></td> --}}
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <a wire:click='openModal("{{ $item->rowId }}", "{{ $item->name }}")' class="mr-2 action-item text-warning" href="#" data-bs-toggle="modal" data-bs-target="#delete">
                                                <i class="icofont-trash"></i> Supprimer
                                            </a>
                                        </td>
                                        <td class="roduct-quantity">
                                            <div class="quantity">
                                                <button type="button" wire:loading.attr="disabled" wire:click.prevent='plus("{{ $item->rowId }}", -1)' id="minus-{{ $item->rowId }}" class="minus">
                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                    <div wire:loading wire:target='plus("{{ $item->rowId }}", -1)'>
                                                        <span class="spinner-border spinner-border-sm"></span>
                                                    </div>
                                                </button>
                                                <input step="1" class="qty" min="1" wire:model="cart.{{ $key }}.qty" name="quantity-{{ $item->rowId }}" id="quantity-{{ $item->rowId }}" value="{{ $item->qty }}" type="number" readonly>
                                                <button type="button" wire:loading.attr="disabled" wire:click.prevent='plus("{{ $item->rowId }}", 1)' id="plus-{{ $item->rowId }}" class="plus">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                    <div wire:loading wire:target='plus("{{ $item->rowId }}", 1)'>
                                                        <span class="spinner-border spinner-border-sm"></span>
                                                    </div>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
                <div class="pt-4 mt-3 col-lg-4 pt-lg-0">
                    <div class="shadow card">
                        <div class="pt-0 card-body">
                            <h2 class="mt-3">Résumé</h2>
                            <!-- Subtotal -->
                            <div class="pt-3 row">
                                <div class="col-6 text-end">
                                    <small class="">Sous total</small>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="text-sm fw-bold">
                                        {{ devise(Cart::instance('shopping')->subtotal()) }}
                                    </span>
                                </div>
                            </div>
                            {{-- <!-- Shipping -->
                            <div class="pt-3 mt-3 row border-top">
                                <div class="col-6 text-end">
                                    <i class="fas fa-shipping-fast"></i>
                                    <span class="mb-0">Livraison</span>
                                </div>
                                <div class="col-6 text-end fw-bold">
                                    {{ devise($price_delivery) }}
                                </div>
                            </div> --}}
                            <!-- Total -->
                            <div class="pt-3 mt-3 row border-top h4">
                                <div class="col-4 text-end">
                                    <span class="text-uppercase fw-bold">Total</span>
                                </div>
                                <div class="col-8 text-end">
                                    <span class="fw-bolder text-warning">
                                        {{ devise(Cart::instance('shopping')->total()) }}
                                    </span>
                                </div>
                            </div>

                            <div class="text-center border-top">
                                @auth
                                    <button wire:loading.class="bg-dark" wire:loading.attr="disabled" wire:click='next' class="mt-4 btn btn-warning btn-shadow btn-block text-uppercase">
                                        <i class="mr-2 czi-card font-size-lg"></i> Valider ma commander
                                        <div wire:loading wire:target="next">
                                            <span class="spinner-border spinner-border-sm"></span>
                                        </div>
                                    </button>
                                    {{-- @can('user commercial')
                                        <button wire:loading.class="bg-dark" wire:loading.attr="disabled" class="mt-4 btn btn-warning btn-shadow btn-block" href="{{ route('checkout.sale') }}">
                                            <i class="mr-2 icofont-badge font-size-lg"></i> Commande commercial
                                        </button>
                                    @endcan --}}
                                @else
                                    <button wire:loading.class="bg-dark" wire:loading.attr="disabled" wire:click='next' class="mt-4 btn btn-warning btn-shadow btn-block">
                                        <i class="mr-2 czi-card font-size-lg"></i> Valider ma commander
                                        <div wire:loading wire:target="next">
                                            <span class="spinner-border spinner-border-sm"></span>
                                        </div>
                                    </button>
                                @endauth
                            </div>

                            <div class="pt-3 mt-3 text-center row border-top fs-4">
                                <div class="col-12">
                                    Commander par appel
                                    <div class="fs-3 fw-bolder">
                                        +225 07 03 33 46 24
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="mb-4 main-content">
            <section class="slice slice-xl mh-100vh d-flex align-items-center" data-offset-top="#header-main">
                <!-- SVG background -->
                <div class="bg-absolute-cover bg-size--contain d-flex align-items-center">
                    <figure class="px-4 w-100">
                        <img alt="Image placeholder" src="{{ asset('img/svg/backgrounds/bg-3.svg') }}" class="svg-inject" />
                    </figure>
                </div>
                <div class="container pt-6 position-relative zindex-100">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="text-center">
                                <!-- SVG illustration -->
                                <div class="mb-5 row justify-content-center">
                                    <div class="col-md-5">
                                        <img alt="Image placeholder" src="{{ asset('img/cart-2.png') }}" class="svg-inject img-fluid" />
                                    </div>
                                </div>
                                <!-- Empty cart container -->
                                <h6 class="my-4 h4">Votre panier est vide.</h6>
                                <p class="px-md-5">
                                    Votre panier est actuellement vide. Retournez dans notre boutique et consultez les dernières offres. Nous avons de superbes articles qui vous attendent.
                                </p>
                                <a href="{{ route('welcome') }}" class="mt-5 btn btn-sm btn-warning btn-icon rounded-pill">
                                    <span class="btn-inner--icon"><i class="fas fa-angle-left"></i></span>
                                    <span class="btn-inner--text">Retourner à la boutique</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        {{-- <div class="mt-2 col-md-12">
            <div class="p-2 pt-4 m-auto text-center text-white border bg-warning" style="border-radius: 100%; border: solid 3px; width: 150px; height:140px;">
                <i class="icofont-shopping-cart fa-5x"></i>
            </div>
            <h3 class="text-center  fw-bold">Panier vide</h3>
            <p class="text-center">
                <a class="pl-2 btn btn-warning btn-sm" href="{{ route('welcome') }}">
                    <i class="mr-2 czi-arrow-left"></i>Poursuivre vos achats
                </a>
            </p>
        </div> --}}
    @endif

    @push('script')
        <script src="https://cdn.qenium.com/asset/libs/sticky-kit/dist/sticky-kit.min.js"></script>

        {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script> --}}

        <script>
            window.livewire.on('formClose', () => {
                $('#clear, #delete').modal('hide');
            });
            window.addEventListener('closeModal', event => {
                $("#delete_confirm").modal('hide');
            })
        </script>
    @endpush
</div>
