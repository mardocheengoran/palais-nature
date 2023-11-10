<div class="card shadow mb-3">
    <div class="card-header">
        <div class="position-absolute end-0">
            @if ($invoice->relay_id)
                <button wire:loading.attr="disabled" type="button" class="text-warning btn btn-sm" wire:click='relayDelete'>
                    <i class="icofont-pencil"></i>
                    Modifier
                    <div wire:loading wire:target='relayDelete'>
                        <span class="spinner-border spinner-border-sm"></span>
                    </div>
                </button>
            @endif
        </div>
        <i class="icofont-check-circled {{ $invoice->relay_id ? 'bg-success text-white rounded-circle' : '' }}"></i>
        2. {{ $invoice->deliveryMode->title }}
    </div>
    @if ($invoice->delivery_mode_id and !$invoice->relay_id)
        <div class="card-body">
            <form class="row">
                @foreach ($relays as $item)
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            @if(!empty($item->getMedia('image')->first()))
                                <img class="card-img-top" src="{{ url($item->getMedia('image')->first()->getUrl('thumb')) }}" alt="{{ $item->title }}">
                            @endif
                            <div class="card-body p-2">
                                <div class="custom-control custom-radio">
                                    <input wire:model='relay' value="{{ $item->id }}" type="radio" class="custom-control-input" id="relay-{{ $item->id }}" />
                                    <label class="custom-control-label text-dark font-weight-bold" for="relay-{{ $item->id }}">
                                        <span class="d-inline-block ms-4">
                                            {{ $item->title }}
                                        </span>
                                        {{-- {!! $item->content !!} --}}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @error('relay')
                    <div class="text-center text-danger">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
                <div class="col-12 text-end">
                    <button type="button" wire:loading.class="bg-dark text-white" wire:loading.attr="disabled" wire:click='relayNext' class="btn btn-warning text-uppercase">
                        <i class="icofont-double-right"></i>
                        Continuer
                        <div wire:loading wire:target='relayNext'>
                            <span class="spinner-border spinner-border-sm"></span>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    @else
        @if ($invoice->relay_id)
            <div class="card-body">
                {{ isset($invoice->relay->title) ? $invoice->relay->title : '' }}
            </div>
        @endif
    @endif
</div>
