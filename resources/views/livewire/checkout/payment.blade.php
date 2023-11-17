<x-slot name="title">Moyen de paiement</x-slot>
<div>
    @include('composant.header.header-1')

    <div class="page-title-overlap bg-primary pt-4">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
            <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start px-3">
                        <li class="breadcrumb-item">
                            <a class="text-white" href="{{ route('welcome') }}">
                                <i class="czi-home"></i>Accueil
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="text-white" href="{{ route('checkout.cart') }}">
                                <i class="czi-home"></i>Panier
                            </a>
                        </li>
                        <li class="breadcrumb-item text-nowrap active" aria-current="page">Mode de livraison</li>
                    </ol>
                </nav>
            </div>
            <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
                {{-- <h1 class="h3 text-light mb-0">Mes adresses de livraison</h1> --}}
            </div>
        </div>
    </div>
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 mt-3">
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

                    <span class="step-item active current" href="#">
                        <div class="step-progress">
                            <span class="step-count">3</span>
                        </div>
                        <div class="step-label">
                            <i class="czi-card"></i>Paiement
                        </div>
                    </span>
                    <span class="step-item" href="#">
                        <div class="step-progress">
                            <span class="step-count">4</span>
                        </div>
                        <div class="step-label">
                            <i class="czi-check-circle"></i>Résumé
                        </div>
                    </span>
                </div>

                <form class="row">
                    @foreach ($payments as $item)
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body p-2">
                                    <div class="row align-items-center">
                                        <div class="col-7">
                                            <div class="custom-control custom-radio">
                                                <input wire:model='payment' value="{{ $item->id }}" type="radio" class="custom-control-input" id="shipping-{{ $item->id }}" />
                                                <label class="custom-control-label text-dark font-weight-bold" for="shipping-{{ $item->id }}">
                                                    {{ $item->title }}
                                                </label>
                                            </div>
                                        </div>
                                        {{-- <div class="col-5 text-right text-xs text-muted" style="font-size: 11px;">
                                            <span>{{ $item->subtitle }}</span>
                                        </div> --}}
                                    </div>
                                    <p class="text-muted text-sm mt-3 mb-0">
                                        @if(!empty($item->getMedia('image')->first()))
                                            <img class="float-left mr-2" width="80" src="{{ url($item->getMedia('image')->first()->getUrl('thumb')) }}" alt="{{ $item->title }}">
                                        @endif
                                        {!! $item->content !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-12 text-center">
                        <a wire:click='next' wire:loading.class="bg-dark" wire:loading.attr="disabled" class="btn btn-warning text-uppercase">
                            <i class="icofont-double-right"></i>
                            Continuer
                            <div wire:loading wire:target='next'>
                                <span class="spinner-border spinner-border-sm"></span>
                            </div>
                        </a>
                    </div>
                </form>
            </section>
            @include('livewire.checkout.summary')
        </div>
    </div>

    @include('composant.footer.footer-ecommerce')
    @push('script')
        <script src="https://cdn.qenium.com/asset/libs/sticky-kit/dist/sticky-kit.min.js"></script>
        <script>
            window.livewire.on('formClose', () => {
                $('#clear, #delete, #address').modal('hide');
            });
        </script>
    @endpush
</div>
