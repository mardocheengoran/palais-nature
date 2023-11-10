<div class="card shadow mb-3">
    <div class="card-header">
        @if ($invoice->delivery_mode_id)
            <div class="position-absolute end-0">
                <button wire:loading.attr="disabled" type="button" class="text-warning btn btn-sm" wire:click='modeDelete'>
                    <i class="icofont-pencil"></i>
                    Modifier
                    <div wire:loading wire:target='modeDelete'>
                        <span class="spinner-border spinner-border-sm"></span>
                    </div>
                </button>
            </div>
        @endif
        <i class="icofont-check-circled {{ $invoice->delivery_mode_id ? 'bg-success text-white rounded-circle' : '' }}"></i>
        1. Mode de livraison
    </div>
    <div class="card-body">
        @if(!$invoice->delivery_mode_id)
            <form class="row">
                @foreach ($modes as $item)
                    <div class="col-md-12 mb-3">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="row align-items-center">
                                    <div class="col-7">
                                        <div class="custom-control custom-radio">
                                            <input wire:model='mode' value="{{ $item->id }}" type="radio" class="custom-control-input" id="shipping-{{ $item->id }}" />
                                            <label class="custom-control-label text-dark font-weight-bold" for="shipping-{{ $item->id }}">
                                                <span class="d-inline-block ms-4">
                                                    {{ $item->title }}
                                                    <i class="text-muted" style="font-size: 12px;">({{ $item->subtitle }})</i>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-12 text-end">
                    <button type="button" wire:loading.class="bg-dark text-white" wire:loading.attr="disabled" wire:click='modeNext' class="btn btn-warning text-uppercase">
                        <i class="icofont-double-right"></i>
                        Continuer
                        <div wire:loading wire:target='modeNext'>
                            <span class="spinner-border spinner-border-sm"></span>
                        </div>
                    </button>
                </div>
            </form>
        @else
            {{ $invoice->deliveryMode->title }}
        @endif
    </div>
</div>
