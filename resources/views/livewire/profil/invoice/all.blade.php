
    @include('layouts.header')
<div class="container py-4">
    <div class="card p-5 mt-3 mx-auto py-4">
        <H2>Toutes mes commandes</H2>

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

