<div>
    @include('layouts.header')
    @include('livewire.profil.invoice.show')

    <!-- Page Title-->
    <div class="page-title-overlap bg-primary pt-4">
        <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
            <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                        <li class="breadcrumb-item">
                            <a class="text-nowrap" href="{{ route('welcome') }}"><i class="ci-home"></i>Accueil</a>
                        </li>
                        <li class="breadcrumb-item text-nowrap"><a href="{{ route('profil.index') }}">Compte</a></li>
                        <li class="breadcrumb-item text-nowrap active" aria-current="page">Liste des commandes</li>
                    </ol>
                </nav>
            </div>
            <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
                <h1 class="h3 text-light mb-0">Liste des commandes</h1>
            </div>
        </div>
    </div>
    <div class="container pb-5 mb-2 mb-md-3 mt-3">
        <div class="row">
            @include('livewire.profil.account')
            <!-- Content  -->
            <div class="mt-5 col-lg-9 order-lg-1 order-0">
                <table class="table table-cards align-items-center" id="simpletable">
                    <thead>
                        <tr>
                            <th class="text-center" >Date de commande</th>
                            <th class="text-center" >Commande #</th>
                            {{-- <th>Etat</th> --}}
                            <th class="text-center">Nbr produits</th>
                            <th class="text-center" >Total</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->invoices_check as $item)
                        <tr>
                            <td class="py-3 text-center">
                                <span type="button" data-bs-container="body" data-toggle="popover" data-bs-placement="top" data-bs-trigger="hover" data-content="{{ $item->created_at->format('d-m-Y H:i') }}">
                                    {{ $item->created_at->diffForHumans() }}
                                </span>
                            </td>
                            <td class="py-3 text-center">
                                <a class="text-sm nav-link-style font-weight-medium" href="{{ route('invoice.all.details',  $item->code) }}" data-toggle="modal" wire:click="invoice_show({{ $item->code }})">
                                    {{ $item->code }}
                                </a>
                            </td>
                            {{-- <td class="py-3">
                                <span class="badge badge-soft-{{ $item->state->subtitle }}">
                                    <i class="{{ $item->state->icon }} m-0"></i>
                                    {{ $item->state->title }}
                                </span>
                            </td> --}}
                            <td class="py-3 text-center">
                                <span class="m-0 badge bg-success">{{ count($item->articles) }}</span>
                            </td>
                            <td class="py-3 text-center">{{ devise($item->price_final) }}</td>
                            {{-- <td>
                                <a class="btn btn-success" href="{{ route('commande-repasser', $item)}}" data-container="body" data-toggle="popover" data-placement="top" data-trigger="hover" data-content="Repasser la commande">
                                    <i class="icofont-retweet"></i>
                                    Recommander
                                </a>
                            </td> --}}
                        </tr>
                        <tr class="table-divider"></tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

