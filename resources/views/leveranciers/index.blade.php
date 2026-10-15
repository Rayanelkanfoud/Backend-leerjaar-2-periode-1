<x-layouts::app :title="__('Overzicht leveranciers')">

    <div class="p-6">
        <h1 class="mb-6 text-2xl font-bold">Overzicht leveranciers</h1>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="bg-zinc-100 dark:bg-zinc-800">
                    <tr>
                        <th scope="col" class="border border-zinc-400 px-3 py-2 text-left">Naam</th>
                        <th scope="col" class="border border-zinc-400 px-3 py-2 text-left">Contactpersoon</th>
                        <th scope="col" class="border border-zinc-400 px-3 py-2 text-left">Leveranciernummer</th>
                        <th scope="col" class="border border-zinc-400 px-3 py-2 text-left">Mobiel</th>
                        <th scope="col" class="border border-zinc-400 px-3 py-2 text-left">Aantal verschillende producten</th>
                        <th scope="col" class="border border-zinc-400 px-3 py-2 text-left">Toon producten</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leveranciers as $leverancier)
                        <tr>
                            <td class="border border-zinc-400 px-3 py-2">{{ $leverancier->Naam }}</td>
                            <td class="border border-zinc-400 px-3 py-2">{{ $leverancier->ContactPersoon }}</td>
                            <td class="border border-zinc-400 px-3 py-2">{{ $leverancier->LeverancierNummer }}</td>
                            <td class="border border-zinc-400 px-3 py-2">{{ $leverancier->Mobiel }}</td>
                            <td class="border border-zinc-400 px-3 py-2 text-center">{{ $leverancier->AantalVerschillendeProducten }}</td>
                            <td class="border border-zinc-400 px-3 py-2 text-center">
                                <a class="inline-flex items-center justify-center text-blue-600 dark:text-blue-400" href="{{ route('leveranciers.producten', $leverancier->Id) }}" aria-label="Toon producten van {{ $leverancier->Naam }}" title="Toon producten">
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                        <path d="m12 3 9 5v8l-9 5-9-5V8z M3 8l9 5 9-5 M12 13v8 M7.5 5.5l9 5v8" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6 flex justify-end gap-4">
            <a class="border border-zinc-400 px-5 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-700" href="{{ route('dashboard') }}">Home</a>
        </div>
    </div>
</x-layouts::app>
