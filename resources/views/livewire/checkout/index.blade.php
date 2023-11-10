<div>
    @include('layouts.header')
    @include('livewire.checkout.address.create')
    @include('livewire.checkout.address.delete')
    <div class="container pb-5 mb-2 mb-md-4 mt-3">
        <div class="row">
            <section class="col-lg-8">
                @include('livewire.checkout.process.mode')

                @if ($invoice->delivery_mode_id == 174)
                    @include('livewire.checkout.process.relay')
                @else
                    @include('livewire.checkout.process.address')
                @endif

                @include('livewire.checkout.process.payment')
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
