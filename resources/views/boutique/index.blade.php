<div>
    @push('style')
    @endpush
    @include('layouts.header')

    <div class="container">
        <div class="main-body">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 gutters-sm">
                @foreach ($users as $user )
                    <div class="col mb-3">
                        <div class="card">
                            @if(!empty($user->getMedia('image')->first()))
                                <a href="{{ route('boutique.show', $user->id)}}">
                                    <img style="width: 100%; height: 100%;" class="card-img-top img-fluid" src="{{ url($user->getMedia('image')->first()->getUrl()) }}" alt="{{ $user->name }}">
                                </a>
                            @endif
                            <div class="card-body text-center">
                                @if(!empty($user->getMedia('image')->first()))
                                    <a href="{{ route('boutique.show', $user->id)}}">
                                        <img style="width: 100px; height: 100px; margin-top: -65px;" class="img-fluid img-thumbnail rounded-circle border-0 mb-3" src="{{ url($user->getMedia('image')->first()->getUrl('thumb')) }}" alt="{{ $user->name }}">
                                    </a>
                                @endif
                                <h5 class="card-title">
                                    <a href="{{ route('boutique.show', $user->id)}}" class="text-warning">
                                        {{ $user->store }}
                                    </a>
                                </h5>
                                <p class="text-secondary mb-1">{{ $user->address }}</p>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('boutique.show', $user->id)}}" class="btn btn-light btn-sm bg-white has-icon btn-block">
                                    En savoir plus
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>
    <script type="text/javascript">
        $('ul.pagination').hide();
        $(function() {
            $('.infinite-scroll').jscroll({
                autoTrigger: true,
                loadingHtml: '<div class="m-auto text-center"><img class="text-center w-25" src="/img/loading.gif" alt="Chargement..." /></div>',
                padding: 0,
                nextSelector: '.pagination li.active + li a',
                contentSelector: 'div.infinite-scroll',
                callback: function() {
                    $('ul.pagination').remove();
                }
            });
        });
    </script>
    @endpush
</div>
