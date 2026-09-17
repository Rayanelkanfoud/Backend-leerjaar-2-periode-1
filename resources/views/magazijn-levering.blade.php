<x-layouts::app :title="__('Levering Informatie')">
    @if ($product->AantalAanwezig === null)
        <meta http-equiv="refresh" content="4;url={{ route('magazijn') }}">
    @endif

    <div class="w-full max-w-6xl">
        <h1 class="mb-6 border-b border-zinc-300 pb-2 text-2xl font-semibold text-zinc-900 dark:text-white">
            Levering Informatie
        </h1>

        @if ($product->AantalAanwezig !== null)
            <div class="mb-6 space-y-2 text-zinc-900 dark:text-white">
                <p>Naam leverancier: {{ $product->LeverancierNaam }}</p>
                <p>Contactpersoon leverancier: {{ $product->ContactPersoon }}</p>
                <p>Leveranciernummer: {{ $product->LeverancierNummer }}</p>
                <p>Mobiel: {{ $product->Mobiel }}</p>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-zinc-400 bg-white text-sm text-zinc-900 dark:bg-zinc-900 dark:text-white">
                <thead>
                    <tr>
                        <th class="border border-zinc-400 px-3 py-2 text-left">Naam Product</th>
                        <th class="border border-zinc-400 px-3 py-2 text-left">Datum laatste levering</th>
                        <th class="border border-zinc-400 px-3 py-2 text-left">Aantal</th>
                        <th class="border border-zinc-400 px-3 py-2 text-left">Eerstvolgende levering</th>
                    </tr>
                </thead>

                <tbody>
                    @if ($product->AantalAanwezig === null)
                        <tr>
                            <td colspan="4" class="border border-zinc-400 px-3 py-4">
                                Er is van dit product op dit moment geen voorraad aanwezig, de verwachte eerstvolgende levering is: 30-04-2023
                            </td>
                        </tr>
                    @else
                        @foreach ($leveringen as $levering)
                            <tr>
                                <td class="border border-zinc-400 px-3 py-2">{{ $levering->ProductNaam }}</td>
                                <td class="border border-zinc-400 px-3 py-2">{{ $levering->DatumLaatsteLevering }}</td>
                                <td class="border border-zinc-400 px-3 py-2">{{ $levering->Aantal }}</td>
                                <td class="border border-zinc-400 px-3 py-2">{{ $levering->DatumEerstVolgendeLevering ?? '-' }}</td>
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
