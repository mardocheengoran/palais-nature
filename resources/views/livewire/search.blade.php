<form action="{{ route('products') }}" method="get" class="input-group d-none d-lg-flex mx-4">
    <input class="form-control rounded-end pe-5" placeholder="Rechercher un Produit..." required type="text" name="search" wire:model="search" wire:keyup="searchResult">
    {{-- <button wire:click='research' type="submit" class="search_btn2"> --}}
        <i class="ci-search position-absolute top-50 end-0 translate-middle-y text-muted fs-base me-3"></i>
    {{-- </button> --}}

    <!-- Search result list -->
    @if($showdiv)
        <ul class="list-unstyled position-absolute bg-white w-100 p-3 shadow mt-5">
            @if(!empty($records))
                @foreach($records as $record)
                    <li>
                        <a href="{{ route('article.show', $record->slug) }}">
                            {{ $record->title}}
                        </a>
                    </li>
                @endforeach
            @endif
        </ul>
    @endif
</form>
