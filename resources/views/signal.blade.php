<div wire:ignore.self class="modal fade" id="signal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Signaler produit</h4>
                <button type="button" class="btn p-0" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ion-ios-close-empty"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="message">
                        Commentaire
                        <span class="text-danger">*</span>
                    </label>
                    <textarea wire:model.defer="content" name="content" required placeholder="Indiquez le problème" class="form-control" id="message" rows="3"></textarea>
                    @error('content')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal">Fermer</button>
                <button type="button" wire:loading.class="bg-dark" wire:loading.attr="disabled" wire:click='signal' class="btn btn-danger btn-shadow btn-sm">
                    <i class="icofont-paper-plane"></i> Envoyer
                    <div wire:loading wire:target="signal">
                        <span class="spinner-border spinner-border-sm"></span>
                    </div>
                </button>
            </div>
        </form>
    </div>
</div>
