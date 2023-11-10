<div wire:ignore.self class="modal fade" id="delete" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Supprimer adresse de livraison</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="font-size-sm alert alert-danger text-center">
                    Voulez-vous vraiment supprimer cette adresse <span class="text-warning font-weight-bold">"{{ isset($valeur->title) ? $valeur->title : '' }}"</span> ?
                </p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Annuler</button>
                <button wire:loading.class="bg-dark" wire:loading.attr="disabled" wire:click='destroy' href="#" class="btn btn-danger btn-shadow btn-sm">
                    <i class="icofont-trash"></i> Supprimer
                    <div wire:loading wire:target='destroy'>
                        <span class="spinner-border spinner-border-sm"></span>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>
