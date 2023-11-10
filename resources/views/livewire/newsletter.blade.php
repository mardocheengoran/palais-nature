<div>
    <form>
        <div class="input-group">
            <input class="input form-control" type="email" id="email" wire:model="email" name="email" autocomplete="off" placeholder="Entrez l'adresse email" required>
            <button wire:click="send(6)" {{-- wire:loading.class="text-white bg-dark" --}} wire:loading.attr="disabled" type="button" class="btn btn-secondary">
                HOMME
                <div wire:loading wire:target="send(6)">
                    <span class="spinner-border spinner-border-sm"></span>
                </div>
            </button>
            <button wire:click="send(5)" type="button" class="btn btn-secondary">
                FEMME
                <div wire:loading wire:target="send(5)">
                    <span class="spinner-border spinner-border-sm"></span>
                </div>
            </button>
        </div>
        @error('email')
            <div class="text-center text-danger mt-1">
                <strong>{{ $message }}</strong>
            </div>
        @enderror
    </form>
</div>
