<div wire:ignore.self class="modal fade subscribe_popup" id="delete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Vider panier</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-2">
                <p class="font-size-sm alert alert-warning text-center">
                    Voulez-vous vraiment supprimer cet article <span class="text-warning font-weight-bold">"{{ $name }}"</span> ?
                </p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal" aria-label="Close">Fermer</button>
                <button  wire:loading.class="bg-dark" wire:loading.attr="disabled" wire:click='destroy' class="btn btn-primary btn-shadow btn-sm">
                    <i class="icofont-trash"></i> Supprimer
                    <div wire:loading wire:target="destroy">
                        <span class="spinner-border spinner-border-sm"></span>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>
