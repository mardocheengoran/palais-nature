<div>
    @include('layouts.header')
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4 mt-3">
        <div class="row">
            <section class="col-lg-8">
                <form class="row">
                    @foreach ($modes as $item)
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body p-2">
                                    <div class="row align-items-center">
                                        <div class="col-7">
                                            <div class="custom-control custom-radio">
                                                <input wire:model='mode' value="{{ $item->id }}" type="radio" class="custom-control-input" id="shipping-{{ $item->id }}" />
                                                <label class="custom-control-label text-dark font-weight-bold" for="shipping-{{ $item->id }}">
                                                    {{ $item->title }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-5 text-right text-xs text-muted" style="font-size: 11px;">
                                            <span>{{ $item->subtitle }}</span>
                                        </div>
                                    </div>
                                    <p class="text-muted text-sm mt-3 mb-0">
                                        {!! $item->content !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-12 text-center">
                        <button wire:loading.class="bg-dark" wire:loading.attr="disabled" wire:click='next' class="btn btn-warning text-uppercase">
                            <i class="icofont-double-right"></i>
                            Continuer
                            <div wire:loading wire:target='next'>
                                <span class="spinner-border spinner-border-sm"></span>
                            </div>
                        </button>
                    </div>
                </form>
            </section>
            @include('livewire.checkout.summary')
        </div>
    </div>

    @push('script')
        <script>
            window.livewire.on('formClose', () => {
                $('#clear, #delete, #address').modal('hide');
            });
        </script>
    @endpush
</div>
