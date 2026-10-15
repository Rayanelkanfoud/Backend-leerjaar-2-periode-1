<x-layouts::app :title="__('Geleverde producten')">
    @if (count($producten) === 0)
        @push('head')
            <meta http-equiv="refresh" content="3;url={{ route('leveranciers.index') }}">
        @endpush
    @endif

    <div class="p-6">
        <h1 class="mb-6 text-2xl font-bold">Geleverde producten</h1>

        <dl class="mb-6 grid grid-cols-[max-content_1fr] gap-x-6 gap-y-2">
            <dt class="font-bold">Naam leverancier:</dt><dd>{{ $leverancier->Naam }}</dd>
            <dt class="font-bold">Contactpersoon:</dt><dd>{{ $leverancier->ContactPersoon }}</dd>
            <dt class="font-bold">Leverancier nr:</dt><dd>{{ $leverancier->LeverancierNummer }}</dd>
            <dt class="font-bold">Mobiel:</dt><dd>{{ $leverancier->Mobiel }}</dd>
        </dl>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="bg-zinc-100 dark:bg-zinc-800">
                    <tr>
                        <th scope="col" class="border border-zinc-400 px-3 py-2 text-left">Naam product</th>
                        <th scope="col" class="border border-zinc-400 px-3 py-2 text-left">Aantal in magazijn</th>
                        <th scope="col" class="border border-zinc-400 px-3 py-2 text-left">Verpakkingseenheid</th>
                        <th scope="col" class="border border-zinc-400 px-3 py-2 text-left">Laatste levering</th>
                        <th scope="col" class="border border-zinc-400 px-3 py-2 text-left">Nieuwe levering</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($producten as $product)
                        <tr>
                            <td class="border border-zinc-400 px-3 py-2">{{ $product->Naam }}</td>
                            <td class="border border-zinc-400 px-3 py-2">{{ $product->AantalAanwezig ?? 0 }}</td>
                            <td class="border border-zinc-400 px-3 py-2">{{ str_replace('.', ',', $product->VerpakkingsEenheid) }} kg</td>
                            <td class="border border-zinc-400 px-3 py-2">{{ date('d-m-Y', strtotime($product->LaatsteLevering)) }}</td>
                            <td class="border border-zinc-400 px-3 py-2 text-center">
                                <a class="inline-flex items-center justify-center text-blue-600 dark:text-blue-400" href="{{ route('leveringen.create', [$leverancier->Id, $product->Id]) }}" aria-label="Nieuwe levering van {{ $product->Naam }}" title="Nieuwe levering">
                                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true">
                                        <path d="M12 4v16 M4 12h16" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="border border-zinc-400 px-3 py-4 text-center" colspan="5" role="status">Dit bedrijf heeft tot nu toe geen producten geleverd aan Jamin</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6 flex justify-end gap-4">
            <a class="border border-zinc-400 px-5 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-700" href="{{ route('leveranciers.index') }}">Terug</a>
            <a class="border border-zinc-400 px-5 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-700" href="{{ route('dashboard') }}">Home</a>
        </div>
    </div>
</x-layouts::app>
