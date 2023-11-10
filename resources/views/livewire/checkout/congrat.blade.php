<div>
    @include('layouts.header')
    <div class="container pb-5 mb-sm-4">
        <div class="pt-5">
            <div class="py-3 card mt-sm-3">
                <div class="text-center card-body">
                    <h2 class="pb-3 h4">Nous vous remercions de votre achat!</h2>
                    <p class="mb-2 font-size-sm">Votre achat a été passé avec succès</p>
                    <p class="font-size-sm">
                        Vous recevrez sous peu un e-mail avec la confirmation de votre commande.
                        Vous pouvez maintenant: <a href="{{ route('welcome') }}">Revenir aux achats</a>
                    </p>
                    <a class="mt-3 mr-3 btn btn-secondary" href="{{ route('welcome') }}">Revenir aux achats</a>
                    <a class="mt-3 btn btn-warning" href="{{ route('profil.index') }}">
                        <i class="czi-location"></i>&nbsp;Suivre la commande
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            window.livewire.on('formClose', () => {
                $('#clear, #delete').modal('hide');
            });
            window.addEventListener('closeModal', event => {
                $("#delete_confirm").modal('hide');
            })
        </script>
    @endpush
</div>
