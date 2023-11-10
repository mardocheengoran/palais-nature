<x-slot name="title">Adresse de livraison</x-slot>
<div>
    @include('composant.header.header-1')
    @include('livewire.checkout.address.create')
    @include('livewire.checkout.address.delete')

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
                        <li class="breadcrumb-item text-nowrap active" aria-current="page">Adresse de livraison</li>
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
                <div class="text-right mb-3">
                    <a class="btn btn-warning btn-sm" href="#address" data-toggle="modal">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        Ajouter une nouvelle adresse de livraison
                    </a>
                </div>
                {{-- @foreach ($addresses as $item)
                    <div class="card" id="card-summary">
                        <div class="card-body">
                        </div>
                    </div>
                @endforeach --}}

                <div class="row">
                    @forelse ($addresses as $item)
                        <div class="col-lg-4 col-sm-6 mb-grid-gutter">
                            <div class="card bg-gradient-dark box-shadow">
                                <div class="card-body p-3 pt-1">
                                    <a href="#address" wire:click='edit({{ $item->id }})' data-toggle="modal" class="float-right text-warning">
                                        <i class="icofont-pen-alt-2" aria-hidden="true"></i> Editer
                                    </a>
                                    <a href="#delete" wire:click='edit({{ $item->id }})' data-toggle="modal" class="float-right text-warning">
                                        <i class="icofont-trash" aria-hidden="true"></i>
                                    </a>
                                    <ul class="list-unstyled mb-0">
                                        <li class="media pb-3 border-bottom">
                                            <i class="icofont-google-map font-size-lg mt-2 mb-0 text-warning"></i>
                                            <div class="media-body pl-3">
                                                <span class="text-xs text-muted">Commune</span>
                                                <a class="d-block text-heading text-sm text-warning" href="#">
                                                    @if (! empty( $item->city->title))
                                                        {{ $item->city->title }}
                                                    @else
                                                        {{ $item->location }}
                                                    @endif
                                                </a>
                                            </div>
                                        </li>
                                        <li class="media pt-2 pb-3 border-bottom">
                                            <i class="icofont-iphone font-size-lg mt-2 mb-0 text-warning"></i>
                                            <div class="media-body pl-3">
                                                <span class="text-xs text-muted">Téléphone</span>
                                                <a class="d-block text-heading text-sm text-warning" href="#">
                                                    {{ $item->subtitle }}
                                                </a>
                                            </div>
                                        </li>
                                        <li class="media pt-2">
                                            <i class="icofont-map font-size-lg mt-2 mb-0 text-warning"></i>
                                            <div class="media-body pl-3">
                                                <span class="text-xs text-muted">Lieu exact de livraison</span>
                                                <a class="d-block text-heading text-sm text-warning" href="">
                                                    {{ $item->title }}
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-footer p-0">
                                    <button wire:loading.class="bg-dark" wire:loading.attr="disabled" class="btn btn-warning btn-shadow btn-block" href="#" wire:click='choice({{ $item->id }})'>
                                        <i class="icofont-check-circled font-size-lg mr-2"></i> Choisissez
                                        <div wire:loading wire:target='choice({{ $item->id }})'>
                                            <span class="spinner-border spinner-border-sm"></span>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-lg-12 mb-grid-gutter">
                            <div class="alert alert-danger text-center">
                                <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                Ajouter au moins une adresse de livraison
                            </div>
                        </div>
                    @endforelse
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
