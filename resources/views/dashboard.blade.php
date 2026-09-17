<x-layouts::app :title="__('Homepage')">
    <div class="w-full max-w-4xl">
        <h1 class="mb-6 border-b border-zinc-300 pb-2 text-2xl font-semibold text-zinc-900 dark:text-white">
            Homepage Jamin
        </h1>

        <p class="mb-6 text-zinc-900 dark:text-white">
            Welkom bij het magazijn systeem van Jamin.
        </p>

        <a href="{{ route('magazijn') }}" class="text-blue-600 underline" wire:navigate>
            Overzicht Magazijn Jamin
        </a>
    </div>
</x-layouts::app>
