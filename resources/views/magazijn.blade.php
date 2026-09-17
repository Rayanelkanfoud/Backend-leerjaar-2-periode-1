<x-layouts::app :title="__('Overzicht Magazijn Jamin')">
    <div class="w-full max-w-6xl">
        <h1 class="mb-6 border-b border-zinc-300 pb-2 text-2xl font-semibold text-zinc-900 dark:text-white">
            Overzicht Magazijn Jamin
        </h1>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-zinc-400 bg-white text-sm text-zinc-900 dark:bg-zinc-900 dark:text-white">
                <thead>
                    <tr>
                        <th class="border border-zinc-400 px-3 py-2 text-left">Barcode</th>
                        <th class="border border-zinc-400 px-3 py-2 text-left">Naam</th>
                        <th class="border border-zinc-400 px-3 py-2 text-left">Verpakkingseenheid</th>
                        <th class="border border-zinc-400 px-3 py-2 text-left">Aantal aanwezig</th>
                        <th class="border border-zinc-400 px-3 py-2 text-center">Allergenen Info</th>
                        <th class="border border-zinc-400 px-3 py-2 text-center">Leverantie Info</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($producten as $product)
                        <tr>
                            <td class="border border-zinc-400 px-3 py-2">{{ $product->Barcode }}</td>
                            <td class="border border-zinc-400 px-3 py-2">{{ $product->Naam }}</td>
                            <td class="border border-zinc-400 px-3 py-2">
                                {{ str_replace('.', ',', $product->VerpakkingsEenheid) }} kg
                            </td>
                            <td class="border border-zinc-400 px-3 py-2">
                                {{ $product->AantalAanwezig ?? 'Geen voorraad' }}
                            </td>
                            <td class="border border-zinc-400 px-3 py-2 text-center">
                                <a
                                    href="{{ route('magazijn.allergenen', $product->Id) }}"
                                    class="text-2xl font-bold text-red-600"
                                    aria-label="Allergenen informatie voor {{ $product->Naam }}"
                                    wire:navigate
                                >
                                    X
                                </a>
                            </td>
                            <td class="border border-zinc-400 px-3 py-2 text-center">
                                <a
                                    href="{{ route('magazijn.levering', $product->Id) }}"
                                    class="text-2xl font-bold text-blue-600"
                                    aria-label="Leverantie informatie voor {{ $product->Naam }}"
                                    wire:navigate
                                >
                                    ?
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts::app>
