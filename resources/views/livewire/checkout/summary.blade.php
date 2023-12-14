@if (Cart::instance('shopping')->count() > 0)
    <aside class="pt-4 col-lg-4 pt-lg-0">
        <div data-toggle="sticky" data-sticky-offset="30" class="" style="">
            <div class="card" id="card-summary">
                <div class="py-2 card-header">
                    <div class="position-absolute end-0 me-2" style="font-size: 12px">
                        <a  href="{{ route('checkout.cart') }}" class="text-warning">
                            <i class="icofont-pen-alt-2"></i>
                            Modifier panier
                        </a>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-12">
                            <span class="h6">
                                Récapitulatif
                                <span class="translate-middle badge rounded-pill bg-success ms-2">
                                    {{ count(Cart::instance('shopping')->content()) }}
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @php($i = 0)
                    @foreach (Cart::instance('shopping')->content() as $item)
                        @php($i++)
                        @php($article = detailPanier($item->id))
                        <div class="py-2 row border-bottom">
                            <div class="col-8">
                                <div class="media align-items-center">
                                    @if(!empty($article->getMedia('image')->first()))
                                        <img style="width: 42px;" class="mr-2 float-start" src="{{ url($article->getMedia('image')->first()->getUrl('thumb')) }}" alt="{{ $item->name }}">
                                    @endif
                                    <div class="media-body d-inline-block">
                                        <div class="text-limit lh-100">
                                            <small class="mb-0 font-weight-bold">
                                                {{ $item->name }}
                                            </small>
                                        </div>
                                        <small class="text-muted">
                                            {{ $item->qty }} x {{ devise($item->price) }}
                                        </small>
                                        {{-- <div>
                                            Vendeur : {{ $article->supplier->store }}
                                        </div> --}}
                                        <div class="text-muted">
                                            @if ($item->options->size)
                                                Taille : {{ $item->options->size }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right col-4 lh-100">
                                <small class="text-dark">
                                    {{ devise($item->price * $item->qty) }}
                                </small>
                            </div>
                        </div>
                    @endforeach

                    <div class="pt-3 row">
                        <div class="col-4 text-end">
                            <span class="">Sous total</span>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-sm fw-bold">
                                {{ devise(Cart::instance('shopping')->subtotal()) }}
                            </span>
                        </div>
                    </div>
                    @if ($invoice->price_delivery)
                        <!-- Shipping -->
                        <div class="pt-3 mt-3 row border-top">
                            <div class="col-4 text-end ps-0">
                                <span class="mb-0">Frais livraison</span>
                            </div>
                            <div class="col-8 text-end fw-bold">
                                {{ devise($invoice->price_delivery) }}
                            </div>
                        </div>

                    @endif
                    <!-- Total -->
                    <div class="pt-3 mt-3 row border-top h4">
                        <div class="col-4 text-end">
                            <span class="text-uppercase fw-bold">Total</span>
                        </div>
                        <div class="col-8 text-end">
                            <span class="fw-bolder text-warning">
                                {{ devise(Cart::instance('shopping')->total() + $invoice->price_delivery) }}
                            </span>
                        </div>
                    </div>
                    @isset ($invoice->planned_at)
                        <div class="py-3 row border-top">
                            <div class="text-right col-5">
                                <span class="">
                                    Date livraison
                                </span>
                            </div>
                            <div class="col-7 text-end">
                                <span class="fw-bolder badge bg-warning">
                                    {{ $invoice->planned_at->isoFormat('dddd D MMMM YYYY') }}
                                </span>
                            </div>
                        </div>
                    @endisset
                </div>
                {{-- @if (($invoice->address_id or $invoice->relay_id) and $invoice->delivery_mode_id and $invoice->payment_method_id)
                    <div class="text-center card-footer">
                        <button type="button" wire:loading.class="text-white bg-dark" wire:loading.attr="disabled" wire:click='confirmer' class="btn btn-success btn-block">
                            <i class="icofont-paper-plane"></i>
                            Confirmer la commande
                            <div wire:loading wire:target='confirmer'>
                                <span class="spinner-border spinner-border-sm"></span>
                            </div>
                        </button>
                    </div>
                @endif --}}
            </div>
        </div>
    </aside>
@endif
