<x-filament::page>
    <form wire:submit.prevent="submit">
        {{ $this->form }}
        <br/>
        <button type="submit" class="inline-flex
        items-center justify-center font-medium tracking-tight space-y-2 rounded-lg border
        transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset
        filament-button dark:focus:ring-offset-0 h-9 px-4 text-white shadow focus:ring-white
        border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700
        focus:ring-offset-primary-700 filament-page-button-action"
        wire:loading.attr="disabled"
        wire:loading.class="opacity-70 cursor-wait"
        >
            save
        </button>
    </form>
</x-filament::page>
