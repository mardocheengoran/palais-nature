<div>
    <div class="container mt-6 mb-5">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-lg-8">

                {{-- @foreach ($errors->all() as $error)
                    <p class="text-center text-danger">{{ $error }}</p>
                @endforeach --}}
                <h6 class="my-3 text-center h3 text-uppercase">Finaliser votre inscription</h6>
                <span class="clearfix"></span>
                <form method="POST" {{-- action="{{ route('register') }}" --}} class="form-box">
                    @csrf
                    <div class="shadow card">
                        <div class="card-body">
                            <img src="{{ asset('img/grille.jpg') }}" alt="" class="img-fluid">
                            <div class="my-2">
                                <div class="custom-control custom-checkbox">
                                    <input wire:model='status' type="checkbox" class="custom-control-input" id="status" />
                                    <label class="custom-control-label" for="status">
                                        <span class="ms-4">
                                            J'accepte les conditions de vente et la politique de confidentialité
                                        </span>
                                    </label>
                                </div>
                                @error('status')
                                    <span class="text-center text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="button" wire:loading.class="text-white bg-dark" wire:loading.attr="disabled" wire:click='next' class="btn btn-warning btn-icon rounded-pill btn-lg btn-block">
                            <span class="btn-inner--text">Continuer</span>
                            <span class="btn-inner--icon"><i class="fas fa-long-arrow-alt-right"></i></span>
                            <div wire:loading wire:target='next'>
                                <span class="spinner-border spinner-border-sm"></span>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal modal-fluid fade" id="modal_1" tabindex="-1" role="dialog" aria-labelledby="modal_1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Termes et conditions
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="ion-ios-close-empty"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris ac pretium ex. Nam porttitor maximus ligula, quis malesuada eros suscipit commodo. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Mauris at erat in dolor imperdiet venenatis in ac tortor. Integer non mauris id dolor hendrerit convallis. Sed odio quam, consequat at dolor eget, venenatis ultricies metus. Praesent eleifend, dolor eu feugiat pulvinar, arcu magna pulvinar massa, vitae fermentum est urna faucibus justo. Donec ac porttitor arcu. Nulla pretium non dolor sit amet sodales. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Etiam accumsan feugiat rhoncus. Quisque tempor justo nulla, quis condimentum arcu consequat in. Quisque in ultrices purus, quis auctor purus. Etiam elementum, purus luctus dictum suscipit, arcu ligula euismod nisi, et gravida leo purus a leo.
                        </p>
                        <p>
                            Vivamus ultrices ultrices diam quis eleifend. Vivamus molestie eleifend enim convallis placerat. Curabitur eu enim vulputate, condimentum sapien nec, venenatis ipsum. Nullam sed condimentum ante. Curabitur venenatis lectus eu gravida ornare. Nullam placerat arcu at mi ullamcorper, ac molestie mauris pulvinar. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script src="https://cdn.qenium.com/asset/libs/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
    @endpush
</div>
