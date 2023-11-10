<div wire:ignore.self class="modal fade" id="clear" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Vider panier</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ion-ios-close-empty"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <p class="font-size-sm alert alert-danger text-center">
                    Voulez-vous vraiment vider le panier
                </p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Fermer</button>
                <button wire:loading.class="bg-dark" wire:loading.attr="disabled" wire:click='clear' class="btn btn-danger btn-shadow btn-sm">
                    <i class="icofont-trash"></i> Vider
                    <div wire:loading wire:target="clear">
                        <span class="spinner-border spinner-border-sm"></span>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>
