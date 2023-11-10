<div class="card shadow mb-3">
    <div class="card-header">
        <div class="position-absolute end-0">
            @if ($invoice->payment_method_id)
                <button wire:loading.attr="disabled" type="button" class="text-warning btn btn-sm" wire:click='paymentDelete'>
                    <i class="icofont-pencil"></i>
                    Modifier
                    <div wire:loading wire:target='paymentDelete'>
                        <span class="spinner-border spinner-border-sm"></span>
                    </div>
                </button>
            @endif
        </div>
        <i class="icofont-check-circled {{ $invoice->payment_method_id ? 'bg-success text-white rounded-circle' : '' }}"></i>
        3. Mode de paiement
    </div>
    @if(($invoice->address_id or $invoice->relay_id) and $invoice->delivery_mode_id and !$invoice->payment_method_id)
        <div class="card-body">
            <form class="row">
                @foreach ($payments as $item)
                    <div class="col-md-12 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="custom-control custom-radio">
                                    <input wire:model='payment' value="{{ $item->id }}" type="radio" class="custom-control-input" id="payment-{{ $item->id }}" />
                                    <label class="custom-control-label text-dark font-weight-bold" for="payment-{{ $item->id }}">
                                        <p class="text-muted text-sm mt-3 mb-0">
                                            @if(!empty($item->getMedia('image')->first()))
                                                <img class="float-start mr-2" width="80" src="{{ url($item->getMedia('image')->first()->getUrl('thumb')) }}" alt="{{ $item->title }}">
                                            @endif
                                            <span class="d-inline-block ms-4">
                                                {{ $item->title }}
                                            </span>
                                            {!! $item->content !!}
                                        </p>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-12 text-end">
                    <button type="button" wire:loading.class="bg-dark text-white" wire:loading.attr="disabled" wire:click='paymentNext' class="btn btn-warning text-uppercase">
                        <i class="icofont-double-right"></i>
                        Continuer
                        <div wire:loading wire:target='paymentNext'>
                            <span class="spinner-border spinner-border-sm"></span>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    @endif
    @if ($invoice->payment_method_id)
        <div class="card-body">
            {{ isset($invoice->paymentMethod->title) ? $invoice->paymentMethod->title : '' }}
        </div>
    @endif
</div>
