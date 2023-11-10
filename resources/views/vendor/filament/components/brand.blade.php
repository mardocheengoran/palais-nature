@if (filled($brand = config('filament.brand')))
    <div @class([
        'filament-brand text-xl font-bold tracking-tight',
        'dark:text-white' => config('filament.dark_mode'),
    ])>
        {{-- {!! $brand !!} --}}
        {{ $brand }}
        {{-- <img src="{{ asset('img/icon.png') }}" alt="" class="max-w-full" width="100"> --}}
    </div>
@endif
