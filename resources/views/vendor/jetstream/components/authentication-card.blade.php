<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-8 col-lg-5 my-2">
            {{-- @include('flash::message') --}}
            <div>
                {{ $logo }}
            </div>

            <div class="card shadow-sm px-1 mx-2">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
