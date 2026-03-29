<x-filament-panels::page>

    {{ $this->form }}

    <div style="display:flex; justify-content:flex-end; margin-top:1rem;">
        <x-filament::button wire:click="save">
            Guardar configuración
        </x-filament::button>
    </div>

</x-filament-panels::page>
