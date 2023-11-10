<div class="card-group flex-column flex-lg-row">
    <div class="card {{ $mt }}">
        <div class="card-body border rounded bg-dark">
            <div class="mb-3">
                <form class="row" action="{{ route('article.index', $rubric->slug) }}" method="get">
                    @if (in_array('offer', $rubric->field))
                        <div class="col-md-3 ">
                            <label for="" class="form-label text-white">OFFRES</label>
                            <select name="offer" class="custom-select border rounded">
                                <option value="">--------Tous-------</option>
                                @foreach ($offres as $item)
                                    <option {{ request('offer') == $item->slug ? 'selected' : '' }} value="{{ $item->slug }}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    @if (in_array('property', $rubric->field))
                        <div class="col-md-3">
                            <label for="" class="form-label text-white">QUE CHERCHEZ-VOUS ?</label>
                            <select name="type" class="custom-select  border rounded">
                                <option value="">--------Tous-------</option>
                                @foreach ($types as $item)
                                    <option {{ request('type') == $item->slug ? 'selected' : '' }} value="{{ $item->slug }}">{{ $item->title }}</option>
                                @endforeach
                                @if (request()->routeIs('welcome'))
                                    @foreach ($categories as $item)
                                        <option {{ request('type') == $item->slug ? 'selected' : '' }} value="{{ $item->slug }}">{{ $item->title }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    @endif

                    @if (in_array('city', $rubric->field))
                        <div class="col-md-3 ">
                            <label for="" class="form-label text-white">ZONES</label>
                            <select name="commune" class="custom-select border rounded">
                                <option value="">--------Tous-------</option>
                                @foreach ($communes as $item)
                                    <option {{ request('commune') == $item->slug ? 'selected' : '' }} value="{{ $item->slug }}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    @if (in_array('job', $rubric->field))
                        <div class="col-md-3 ">
                            <label for="" class="form-label text-white">Catégorie emploi</label>
                            <select name="job" class="custom-select border rounded">
                                <option value="">--------Tous-------</option>
                                @foreach (parameters(15) as $item)
                                    <option {{ request('job') == $item->slug ? 'selected' : '' }} value="{{ $item->slug }}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    @if (in_array('job', $rubric->field))
                        <div class="col-md-3">
                            <label for="" class="form-label text-white">Type Contrat</label>
                            <select name="contract" class="custom-select border rounded">
                                <option value="">--------Tous-------</option>
                                @foreach (parameters(12) as $item)
                                    <option {{ request('contract') == $item->slug ? 'selected' : '' }} value="{{ $item->slug }}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    @if (in_array('brand', $rubric->field))
                        <div class="col-md-3">
                            <label for="" class="form-label text-white">Constructeur</label>
                            <select name="brand" class="custom-select border rounded">
                                <option value="">--------Tous-------</option>
                                @foreach (parameters(16) as $item)
                                    <option {{ request('brand') == $item->slug ? 'selected' : '' }} value="{{ $item->slug }}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    @if (in_array('category', $rubric->field))
                        <div class="col-md-3">
                            <label for="" class="form-label text-white">Catégorie</label>
                            <select name="category" class="custom-select border rounded">
                                <option value="">--------Tous-------</option>
                                @foreach (parameters(17) as $item)
                                    <option {{ request('category') == $item->slug ? 'selected' : '' }} value="{{ $item->slug }}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="col-md-3 search-buttons" style="margin-top: 30px">
                        <div class="search-button">
                            <button type="submit" class="btn-danger btn-block btn-lg" style="padding: 0.65rem 1.875rem;">
                                <i class="icofont-search-property"></i> Rechercher
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
