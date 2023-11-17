<div class="card shadow mb-3">
    <div class="card-header">
        @if ($invoice->address_id)
            <div class="position-absolute end-0">
                <button wire:loading.attr="disabled" type="button" class="text-warning btn btn-sm" wire:click='addressDelete'>
                    <i class="icofont-pencil"></i>
                    Modifier
                    <div wire:loading wire:target='addressDelete'>
                        <span class="spinner-border spinner-border-sm"></span>
                    </div>
                </button>
            </div>
        @endif
        <i class="icofont-check-circled {{ ($invoice->address_id) ? 'bg-success text-white rounded-circle' : '' }}"></i>
        2. Adresse de livraison
    </div>
    @if ($invoice->delivery_mode_id and !$invoice->address_id)
        <div class="card-body">
            <form class="row">
                @foreach ($addresses as $item)
                    <div class="col-md-12 mb-3">
                        <div class="card">
                            <div class="card-body p-2">
                                <button type="button" wire:click='addressEdit({{ $item->id }})' data-bs-toggle="modal" data-bs-target="#address" class="btn btn-sm p-0 text-warning float-end">
                                    Changer
                                </button>
                                <div class="custom-control custom-radio">
                                    <input wire:model='address' value="{{ $item->id }}" type="radio" class="custom-control-input" id="address-{{ $item->id }}" />
                                    <label class="custom-control-label text-dark font-weight-bold" for="address-{{ $item->id }}">
                                        <span class="d-inline-block ms-4">
                                            {{ $item->title }} |
                                            @if ($item->city_id == 270)
                                                {{ $item->location }}
                                            @else
                                                @if ($item->country_id == 110)
                                                    {{ isset($item->city->title) ? $item->city->title : '' }} |
                                                @else
                                                    {{ isset($item->country->title) ? $item->country->title : '' }} |
                                                @endif
                                            @endif
                                            <i class="text-muted" style="font-size: 12px;">({{ $item->subtitle }})</i>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-12">
                    @error('address')
                        <div class="text-danger mb-3" style="margin-top: -10px;">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                    <a wire:click='openModal' class="btn btn-outline-warning btn-sm w-50" href="#" data-bs-toggle="modal" data-bs-target="#address">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        Ajouter une nouvelle adresse de livraison
                    </a>
                </div>
                @if (count($addresses))
                    <div class="col-12 text-end mt-2">
                        <button type="button" wire:loading.class="bg-dark text-white" wire:loading.attr="disabled" wire:click='addressNext' class="btn btn-warning text-uppercase">
                            <i class="icofont-double-right"></i>
                            Continuer
                            <div wire:loading wire:target='addressNext'>
                                <span class="spinner-border spinner-border-sm"></span>
                            </div>
                        </button>
                    </div>
                @endif
            </form>
        </div>
    @else
        @if ($invoice->address_id)
            <div class="card-body">
                {{ $invoice->address->title }} |
                @if (! empty( $invoice->address->city->title))
                    {{ $invoice->address->city->title }}
                @else
                    {{ $invoice->address->location }}
                @endif |
                <i class="text-muted" style="font-size: 12px;">{{ $invoice->address->subtitle }}</i>

                @if ($invoice->planned_at)
                    <div>
                        Livraison le <strong class="text-warning">{{ $invoice->planned_at->isoFormat('dddd D MMMM YYYY') }}</strong>
                    </div>
                @endif
            </div>
        @endif
    @endif
</div>
