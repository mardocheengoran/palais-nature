<div wire:ignore.self class="modal fade subscribe_popup" id="invoice" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl {{-- modal-dialog-centered --}}" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    @isset($invoice)
                        Commande #{{ $invoice->code }}
                        <span class="badge badge-soft-{{ $invoice->state->subtitle }}">
                            <i class="{{ $invoice->state->icon }} m-0"></i>
                            {{ $invoice->state->title }}
                        </span>
                    @endisset
                </h4>
                {{-- <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> --}}
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ion-ios-close-empty"></i></span>
                </button>
            </div>
            <div class="modal-body p-2">
                @isset($invoice)
                    <div class="table-responsive">
                        <table class="table table-cards align-items-center">
                            <thead>
                                <tr>
                                    <th>Article</th>
                                    <th>Prix</th>
                                    <th>Quantité</th>
                                    <th>Sous-total</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @php($i = 0)
                                @foreach ($invoice->articles as $value)
                                    @php($i++)
                                    <tr>
                                        <th scope="row">
                                            <div class="media align-items-center">
                                                <a href="{{ route('article.show', $value->title) }}">
                                                    @if(!empty($value->getMedia('image')->first()))
                                                        <img class="float-left me-2" width="80" src="{{ url($value->getMedia('image')->first()->getUrl('thumb')) }}" alt="{{ $value->title }}">
                                                    @endif
                                                </a>
                                                <a href="{{ route('article.show', $value->title) }}">
                                                    {{ $value->title }}
                                                </a>
                                                <div class="media-body pl-3">
                                                    <div class="lh-100">
                                                        <span class="text-dark font-weight-bold mb-0">

                                                        </span>
                                                    </div>
                                                    @isset(json_decode($value->pivot->options)->size)
                                                        <p>
                                                            @foreach (json_decode($value->pivot->options)->size as $size)
                                                                <span class="btn btn-outline-warning rounded-circle btn-icon-only btn-sm">
                                                                    <span class="btn-inner--icon text-dark">
                                                                        {{ $size }}
                                                                    </span>
                                                                </span>
                                                            @endforeach
                                                        </p>
                                                    @endisset
                                                    @isset (json_decode($value->pivot->options)->color)
                                                        <p>
                                                            @foreach (json_decode($value->pivot->options)->color as $color)
                                                                <span class="btn btn-outline-dark btn-icon-only mr-1 rounded-circle btn-sm" style="background-color: {{ $color }};">
                                                                    <span class="btn-inner--icon text-dark">
                                                                    </span>
                                                                </span>
                                                            @endforeach
                                                        </p>
                                                    @endisset
                                                </div>
                                            </div>
                                        </th>
                                        <td class="price">
                                            {{ devise($value->pivot->price) }}
                                        </td>
                                        <td>
                                            {{ $value->pivot->quantity }}
                                        </td>
                                        <td class="total">
                                            {{ devise($value->pivot->price * $value->pivot->quantity) }}
                                        </td>
                                    </tr>
                                    <tr class="table-divider"></tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endisset
            </div>
            {{-- <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Fermer</button>
            </div> --}}
            @isset($invoice)
                <div class="modal-footer">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="text-end" width="50%">Adresse de livraison : </td>
                                <td>{{ ($invoice->address) ? $invoice->address->title : '' }}</td>
                            </tr>
                            <tr>
                                <td class="text-end">Sous total : </td>
                                <td>{{ devise($invoice->price_ht) }}</td>
                            </tr>
                            <tr>
                                <td class="text-end">Livraison : </td>
                                <td>{{ devise($invoice->price_delivery) }}</td>
                            </tr>
                            <tr>
                                <td class="text-end">Total : </td>
                                <td>
                                    <span class="h4 fw-bolder">
                                        {{ devise($invoice->price_final) }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endisset
        </div>
    </div>
</div>
