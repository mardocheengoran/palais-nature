<x-filament::page>
    <div class="grid grid-cols-2 gap-6 filament-breezy-grid-section mx-auto">
        <form wire:submit.prevent="updateProfile" class="col-span-2 sm:col-span-1 mt-5 md:mt-0">
            <x-filament::card>
                <div class="py-3">
                    @if (auth()->user()->status)
                        <div class="text-success">
                            <i class="heroicon-o-badge-check"></i>
                        </div>
                    @else
                        <div class="text-orange-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Votre compte n'est pas encore vérifier
                        </div>
                    @endif
                </div>
                {{ $this->updateProfileForm }}
                <x-slot name="footer">
                    <div class="text-right">
                        <x-filament::button type="submit">
                            {{ __('filament-breezy::default.profile.personal_info.submit.label') }}
                        </x-filament::button>
                    </div>
                </x-slot>
            </x-filament::card>
        </form>
    </div>
</x-filament::page>
