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
                        <li class="breadcrumb-item text-nowrap active" aria-current="page">Liste d'envie</li>
                    </ol>
                </nav>
            </div>
            <div class="text-center order-lg-1 pr-lg-4 text-lg-left">
                <h1 class="mb-0 h3">Votre liste d'envie ({{ Cart::instance('wishlist')->count() }})</h1>
            </div>
        </div>
    </div>
    <!-- Page Content-->

    @if (count(Cart::instance('wishlist')->content()))
        <div class="container pb-5 mb-2 mb-md-4 mt-4">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive wishlist_table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="product-thumbnail">Image</th>
                                    <th class="product-name">Article</th>
                                    <th class="product-price">Cout</th>
                                    <th class="product-add-to-cart"></th>
                                    <th class="product-remove"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart as $key => $item)
                                    @php($item = (object)$item)
                                    @php($article = detailPanier($item->id))
                                    <tr>
                                        <td class="product-thumbnail">
                                            <a href="{{ route('article.show', $article->slug) }}">
                                                @if(!empty($article->getMedia('image')->first()))
                                                    <img width="80" src="{{ url($article->getMedia('image')->first()->getUrl('thumb')) }}" alt="{{ $item->name }}">
                                                @endif
                                            </a>
                                        </td>
                                        <td class="product-name" data-title="{{ $item->name }}">
                                            <a href="{{ route('article.show', $article->slug) }}">
                                                {{ $item->name }}
                                            </a>
                                        </td>
                                        <td class="product-price" data-title="{{ devise($item->price) }}">
                                            {{ devise($item->price) }}
                                        </td>
                                        <td class="product-add-to-cart">
                                            <a href="{{ route('article.show', $article->slug) }}" class="btn btn-fill-out">
                                                <i class="icon-basket-loaded"></i>Ajouter au panier
                                            </a>
                                        </td>
                                        <td class="product-remove" data-title="Supprimer">
                                            <a wire:click='openModal("{{ $item->rowId }}", "{{ $item->name }}")' href="#" data-bs-toggle="modal" data-bs-target="#delete">
                                                <i class="ti-close"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                        <img alt="Bezo" src="{{ asset('img/svg/backgrounds/bg-3.svg') }}" class="svg-inject" />
                    </figure>
                </div>
                <div class="container pt-6 position-relative zindex-100">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="text-center">
                                <!-- SVG illustration -->
                                <div class="mb-5 row justify-content-center">
                                    <div class="col-md-5">
                                        <img alt="Bezo" src="{{ asset('img/cart-2.png') }}" class="svg-inject img-fluid" />
                                    </div>
                                </div>
                                <!-- Empty cart container -->
                                <h6 class="my-4 h4">Vous n'avez pas encore de liste d'envie.</h6>
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
                <i class="icofont-wishlist-cart fa-5x"></i>
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
