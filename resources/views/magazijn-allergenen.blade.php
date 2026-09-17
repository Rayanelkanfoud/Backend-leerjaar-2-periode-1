<x-layouts::app :title="__('Overzicht Allergenen')">
    @if ($product->AllergeenNaam === null)
        <meta http-equiv="refresh" content="4;url={{ route('magazijn') }}">
    @endif

    <div class="w-full max-w-4xl">
        <h1 class="mb-6 border-b border-zinc-300 pb-2 text-2xl font-semibold text-zinc-900 dark:text-white">
            Overzicht Allergenen
        </h1>

        <div class="mb-6 space-y-2 text-zinc-900 dark:text-white">
            <p>Naam: {{ $product->ProductNaam }}</p>
            <p>Barcode: {{ $product->Barcode }}</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-zinc-400 bg-white text-sm text-zinc-900 dark:bg-zinc-900 dark:text-white">
                <thead>
                    <tr>
                        <th class="border border-zinc-400 px-3 py-2 text-left">Naam</th>
                        <th class="border border-zinc-400 px-3 py-2 text-left">Omschrijving</th>
                    </tr>
                </thead>

                <tbody>
                    @if ($product->AllergeenNaam === null)
                        <tr>
                            <td colspan="2" class="border border-zinc-400 px-3 py-4">
                                In dit product zitten geen stoffen die een allergische reactie kunnen veroorzaken
                            </td>
                        </tr>
                    @else
                        @foreach ($allergenen as $allergeen)
                            <tr>
                                <td class="border border-zinc-400 px-3 py-2">{{ $allergeen->AllergeenNaam }}</td>
                                <td class="border border-zinc-400 px-3 py-2">{{ $allergeen->Omschrijving }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <a href="{{ route('magazijn') }}" class="mt-6 inline-block text-blue-600 underline" wire:navigate>
            Terug naar Overzicht Magazijn Jamin
        </a>
    </div>
</x-layouts::app>
