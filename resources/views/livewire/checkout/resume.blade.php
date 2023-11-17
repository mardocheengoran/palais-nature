<x-slot name="title">Résumé</x-slot>
<div>
    @include('composant.header.header-1')
    <div class="page-title-overlap bg-primary">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-5">
            <div class="order-lg-2 mb-lg-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start px-3">
                        <li class="breadcrumb-item">
                            <a class="text-white" href="{{ route('welcome') }}">
                                <i class="czi-home"></i>Accueil
                            </a>
                        </li>
                        <li class="breadcrumb-item text-nowrap active" aria-current="page">Résumé</li>
                    </ol>
                </nav>
            </div>
            <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
                {{-- <h1 class="h3 text-light mb-0">Votre panier ({{ Cart::instance('shopping')->count() }})</h1> --}}
            </div>
        </div>
    </div>
    <!-- Page Content-->

    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
            <section class="col-lg-8">
                <div class="steps steps-light pt-2 pb-3 mb-5 mt--100">
                    <a class="step-item active" href="{{ route('checkout.cart') }}">
                        <div class="step-progress">
                            <span class="step-count">1</span>
                        </div>
                        <div class="step-label">
                            <i class="czi-cart"></i>Panier
                        </div>
                    </a>

                    <a class="step-item active" href="{{ route('checkout.address') }}">
                        <div class="step-progress">
                            <span class="step-count">2</span>
                        </div>
                        <div class="step-label">
                            <i class="icofont-google-map"></i>Livraison
                        </div>
                    </a>

                    <span class="step-item active" href="#">
                        <div class="step-progress">
                            <span class="step-count">3</span>
                        </div>
                        <div class="step-label">
                            <i class="czi-card"></i>Paiement
                        </div>
                    </span>
                    <span class="step-item active current" href="#">
                        <div class="step-progress">
                            <span class="step-count">4</span>
                        </div>
                        <div class="step-label">
                            <i class="czi-check-circle"></i>Résumé
                        </div>
                    </span>
                </div>
                <div class="table-responsive">
                    <table class="table table-cards align-items-center" id="simpletable">
                        <thead>
                            <tr>
                                <th>Article</th>
                                <th>Prix</th>
                                <th>Quantité</th>
                                <th>Sous-total</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @php($totaux = 0)
                            {{-- @php(dd($cart)) --}}
                            @foreach ($cart as $key => $item)
                                @php($item = (object)$item)
                                @php($article = detailPanier($item->id))
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <a href="{{ route('article.show', $article->slug) }}">
                                                @if(!empty($article->getMedia('image')->first()))
                                                    <img width="80" src="{{ url($article->getMedia('image')->first()->getUrl('thumb')) }}" alt="{{ $item->name }}">
                                                @endif
                                            </a>
                                            <div class="media-body pl-3">
                                                <div class="lh-100">
                                                    <span class="text-dark font-weight-bold mb-0">
                                                        <a href="{{ route('article.show', $article->slug) }}">
                                                            {{ $item->name }}
                                                        </a>
                                                    </span>
                                                </div>
                                                @if ($item->options['size'])
                                                    <p>
                                                        @foreach ($item->options['size'] as $value)
                                                            <span class="btn btn-outline-warning rounded-circle btn-icon-only btn-sm">
                                                                <span class="btn-inner--icon text-dark">
                                                                    {{ $value }}
                                                                </span>
                                                            </span>
                                                        @endforeach
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </th>
                                    <td class="price">
                                        {{-- {{ devise($article->price_new) }} --}}
                                        {{ devise($item->price) }}
                                    </td>
                                    <td class="text-center">
                                        {{ $item->qty }}
                                    </td>
                                    <td class="total">
                                        {{ devise($item->price * $item->qty) }}
                                        @php($totaux += $item->price * $item->qty)
                                    </td>
                                </tr>
                                <tr class="table-divider"></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
            <aside class="col-lg-4 pt-4 pt-lg-0 mt-3">
                <div data-toggle="sticky" data-sticky-offset="30" class="" style="">
                    <div class="card" id="card-summary">
                        <div class="card-body pt-0">
                            <!-- Subtotal -->
                            <div class="row py-3 mt-0 border-top">
                                <div class="col-5 text-right">
                                    <div class="media align-items-center">
                                        <i class="icofont-tags"></i>
                                        <div class="media-body">
                                            <div class="text-limit lh-100">
                                                <small class="font-weight-bold mb-0">
                                                    Sous total
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-7 text-right">
                                    <span class="text-sm font-weight-bold">
                                        {{ devise(Cart::instance('shopping')->subtotal()) }}
                                    </span>
                                </div>
                            </div>
                            <!-- Shipping -->
                            <div class="row py-3 border-top">
                                <div class="col-5 text-right">
                                    <div class="media align-items-center">
                                        <i class="fas fa-shipping-fast"></i>
                                        <div class="media-body">
                                            <div class="text-limit lh-100">
                                                <small class="font-weight-bold mb-0">Livraison</small>
                                            </div>
                                            <!--<small class="text-muted">Fast Delivery</small>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-7 text-right">
                                    <span class="text-sm font-weight-bold">
                                        {{ devise($price_delivery) }}
                                    </span>
                                </div>
                            </div>
                            @isset ($invoice->deliveryMode->title)
                                <div class="row py-3 border-top">
                                    <div class="col-5 text-right">
                                        <div class="media align-items-center">
                                            <i class="icofont-compass"></i>
                                            <div class="media-body text-xs">
                                                Mode livraison
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <span class="badge badge-pill badge-soft-success">
                                            {{ $invoice->deliveryMode->title }}
                                        </span>
                                        <a href="{{ route('checkout.mode') }}" class="position-absolute right-0">
                                            <i class="icofont-pencil"></i>
                                        </a>
                                    </div>
                                </div>
                            @endisset
                            @isset ($invoice->address->title)
                                <div class="row py-3 border-top">
                                    <div class="col-5 text-right">
                                        <div class="media align-items-center">
                                            <i class="icofont-google-map"></i>
                                            <div class="media-body text-xs">
                                                Adresse
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <span class="badge badge-pill badge-soft-success">
                                            {{ $invoice->address->title }}
                                        </span>
                                        <a href="{{ route('checkout.address') }}" class="position-absolute right-0">
                                            <i class="icofont-pencil"></i>
                                        </a>
                                    </div>
                                </div>
                            @endisset
                            @isset ($invoice->relay->title)
                                <div class="row py-3 border-top">
                                    <div class="col-5 text-right">
                                        <div class="media align-items-center">
                                            <i class="icofont-food-cart"></i>
                                            <div class="media-body text-xs">
                                                Point de retrait
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <span class="badge badge-pill badge-soft-success">
                                            {{ $invoice->relay->title }}
                                        </span>
                                        <a href="{{ route('checkout.relay') }}" class="position-absolute right-0">
                                            <i class="icofont-pencil"></i>
                                        </a>
                                    </div>
                                </div>
                            @endisset
                            @isset ($invoice->planned_at)
                                <div class="row py-3 border-top">
                                    <div class="col-5 text-right">
                                        <div class="media align-items-center">
                                            <i class="icofont-ui-calendar"></i>
                                            <div class="media-body text-xs">
                                                Date livraison
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <span class="badge badge-pill badge-soft-success">
                                            {{ $invoice->planned_at->isoFormat('dddd D MMMM YYYY') }}
                                        </span>
                                        <a href="{{ route('checkout.date') }}" class="position-absolute right-0">
                                            <i class="icofont-pencil"></i>
                                        </a>
                                    </div>
                                </div>
                            @endisset
                            @isset ($invoice->paymentMethod->title)
                                <div class="row py-3 border-top">
                                    <div class="col-5 text-right">
                                        <div class="media align-items-center">
                                            <i class="icofont-credit-card"></i>
                                            <div class="media-body text-xs">
                                                Moyen de paiement
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-7 text-right">
                                        <span class="badge badge-pill badge-soft-success">
                                            {{ $invoice->paymentMethod->title }}
                                        </span>
                                        <a href="{{ route('checkout.payment') }}" class="position-absolute right-0">
                                            <i class="icofont-pencil"></i>
                                        </a>
                                    </div>
                                </div>
                            @endisset

                            <!-- Total -->
                            <div class="row mt-3 pt-3 border-top h4">
                                <div class="col-4 text-right">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <div class="text-limit">
                                                <span class="text-uppercase font-weight-bold">Total</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8 text-right">
                                    <span class="font-weight-bold">
                                        {{ devise(Cart::instance('shopping')->total() + $price_delivery) }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-center border-top">
                                <a wire:click='next' wire:loading.class="bg-dark" wire:loading.attr="disabled" class="btn btn-warning btn-shadow btn-block mt-4 text-uppercase" href="#">
                                    <i class="icofont-paper-plane font-size-lg mr-2"></i> Valider
                                    <div wire:loading wire:target="next">
                                        <span class="spinner-border spinner-border-sm"></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    @include('composant.footer.footer-ecommerce')
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
