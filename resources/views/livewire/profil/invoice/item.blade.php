<table class="table table-cards align-items-center" id="simpletable">
    <thead>
        <tr>
            <th>Date de commande</th>
            <th>Commande #</th>
            {{-- <th>Etat</th> --}}
            <th>Nbr produits</th>
            <th>Total</th>
            {{-- <th>Action</th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach ($user->invoices_check as $item)
            <tr>
                <td class="py-3">
                    <a href="#" type="button" data-bs-container="body" data-toggle="popover" data-bs-placement="top" data-bs-trigger="hover" data-bs-content="{{ $item->created_at->format('d-m-Y H:i') }}">
                        {{ $item->created_at->diffForHumans() }}
                    </a>
                </td>
                <td class="py-3">
                    <a class="text-sm nav-link-style font-weight-medium" href="#" data-bs-toggle="modal" data-bs-toggle="modal" data-bs-target="#invoice" wire:click="invoice_show({{ $item->id }})">
                        {{ $item->code }}
                    </a>
                </td>
                {{-- <td class="py-3">
                    <span class="badge badge-soft-{{ $item->state->subtitle }}">
                        <i class="{{ $item->state->icon }} m-0"></i>
                        {{ $item->state->title }}
                    </span>
                </td> --}}
                <td class="py-3">
                    <span class="m-0 badge bg-success">{{ count($item->articles) }}</span>
                </td>
                <td class="py-3">{{ devise($item->price_final) }}</td>
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
