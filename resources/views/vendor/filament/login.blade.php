<form wire:submit.prevent="authenticate" class="space-y-8">
    {{ $this->form }}

    <x-filament::button type="submit" form="authenticate" class="w-full">
        {{ __('filament::login.buttons.submit.label') }}
    </x-filament::button>

    <div class="mt-4 text-center">
        Vous n'avez pas de compte fournisseur ? <br>
        <a href="{{ route('register') }}?supplier=fournisseur" class="text-gray-600 underline hover:text-gray-900">
            Inscrivez-vous ici
        </a>
    </div>
</form>
