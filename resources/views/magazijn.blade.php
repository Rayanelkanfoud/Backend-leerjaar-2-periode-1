<x-layouts::app :title="__('Overzicht Magazijn Jamin')">

    <div class="p-6">

        <h1 class="mb-6 text-2xl font-bold">
            Overzicht Magazijn Jamin
        </h1>

        <div class="overflow-x-auto">

            <table class="w-full border-collapse">

                <thead>
                    <tr class="bg-zinc-100 dark:bg-zinc-800">

                        <th class="border border-zinc-400 px-3 py-2 text-left">
                            Barcode
                        </th>

                        <th class="border border-zinc-400 px-3 py-2 text-left">
                            Naam
                        </th>

                        <th class="border border-zinc-400 px-3 py-2 text-left">
                            Verpakkingseenheid
                        </th>

                        <th class="border border-zinc-400 px-3 py-2 text-left">
                            Aantal aanwezig
                        </th>

                        <th class="border border-zinc-400 px-3 py-2 text-center">
                            Allergenen Info
                        </th>

                        <th class="border border-zinc-400 px-3 py-2 text-center">
                            Leverantie Info
                        </th>

                    </tr>
                </thead>

                <tbody>

                    @foreach ($producten as $product)

                        <tr>

                            <td class="border border-zinc-400 px-3 py-2">
                                {{ $product->Barcode }}
                            </td>

                            <td class="border border-zinc-400 px-3 py-2">
                                {{ $product->Naam }}
                            </td>

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
                                    title="Allergenen informatie"
                                >
                                    ✖
                                </a>

                            </td>

                            <td class="border border-zinc-400 px-3 py-2 text-center">

                                <a
                                    href="{{ route('magazijn.leverantie', $product->Id) }}"
                                    class="text-2xl font-bold text-blue-600"
                                    title="Leverantie informatie"
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