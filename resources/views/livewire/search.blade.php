<div class="product_search_form rounded_input">
    <form action="{{ route('products') }}" method="get">
        <div class="input-group">
            {{-- <div class="input-group-prepend">
                <div class="custom_select">
                    <select class="first_null">
                        <option value="">All Category</option>
                        <option value="Dresses">Dresses</option>
                        <option value="Shirt-Tops">Shirt & Tops</option>
                        <option value="T-Shirt">T-Shirt</option>
                        <option value="Pents">Pents</option>
                        <option value="Jeans">Jeans</option>
                    </select>
                </div>
            </div> --}}
            <input class="form-control" placeholder="Rechercher un Produit..." required type="text" name="search" wire:model="search" wire:keyup="searchResult">
            <button wire:click='research' type="submit" class="search_btn2"><i class="fa fa-search"></i></button>
        </div>
            <!-- Search result list -->
        @if($showdiv)
            <ul class="list-unstyled position-absolute bg-white w-100 p-3 shadow">
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
</div>
