<x-slot name="title">Mode de livraison</x-slot>
<div>
    @include('composant.header.header-1')

    <div class="page-title-overlap bg-dark pt-4">
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

                    <a class="step-item active current" href="#">
                        <div class="step-progress">
                            <span class="step-count">2</span>
                        </div>
                        <div class="step-label">
                            <i class="icofont-google-map"></i>Livraison
                        </div>
                    </a>

                    <span class="step-item" href="#">
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
                <div class="my-4">
                    <header class="section-header my-4">
                        <h3 class="">Quand souhaitez-vous être livré ?</h3>
                        {{-- <p class="">Découvrez les articles à la mode</p>
                        <a href="#" class="btn btn-warning btn-sm">
                            <i class="icofont-stylish-right"></i>
                            Voir plus
                        </a> --}}
                    </header>
                    <button wire:loading.class="bg-dark" wire:loading.attr="disabled" class="btn btn-warning btn-block" wire:click='choice(0)'>
                        Livrer demain
                        <div wire:loading wire:target='choice(0)'>
                            <span class="spinner-border spinner-border-sm"></span>
                        </div>
                    </button>
                    <div class="text-center my-4">
                        Ou choisissez votre date de livraison
                    </div>
                    <div class="input-group mb-3">
                        <input wire:model='date' type="text" class="form-control" placeholder="Date de livraison" data-toggle="date">
                        <div class="input-group-append">
                            <button wire:loading.class="bg-dark" wire:loading.attr="disabled" wire:click='choice(1)' class="btn btn-outline-warning" type="button">
                                Continuer
                                <div wire:loading wire:target='choice(1)'>
                                    <span class="spinner-border spinner-border-sm"></span>
                                </div>
                            </button>
                        </div>
                    </div>
                    <div>
                        @error('date')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
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
