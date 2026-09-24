<x-layouts::app :title="__('Levering Informatie')">

    @if ($geenVoorraad)
        <meta http-equiv="refresh" content="4;url={{ route('magazijn') }}">
    @endif

    <div class="p-6">

        <h1 class="mb-6 text-2xl font-bold">
            Levering Informatie
        </h1>

        @if ($geenVoorraad)

            <table class="w-full border-collapse">

                <tbody>

                    <tr>
                        <td class="border border-zinc-400 px-3 py-4">
                            Er is van dit product op dit moment geen voorraad aanwezig, de verwachte eerstvolgende levering is: 30-04-2023
                        </td>
                    </tr>

                </tbody>

            </table>

        @else

            <div class="mb-6 space-y-2">

                <p>
                    <strong>Naam leverancier:</strong>
                    {{ $leverancier->LeverancierNaam }}
                </p>

                <p>
                    <strong>Contactpersoon leverancier:</strong>
                    {{ $leverancier->ContactPersoon }}
                </p>

                <p>
                    <strong>Leveranciernummer:</strong>
                    {{ $leverancier->LeverancierNummer }}
                </p>

                <p>
                    <strong>Mobiel:</strong>
                    {{ $leverancier->Mobiel }}
                </p>

            </div>

            <table class="w-full border-collapse">

                <thead>

                    <tr class="bg-zinc-100 dark:bg-zinc-800">

                        <th class="border border-zinc-400 px-3 py-2 text-left">
                            Naam Product
                        </th>

                        <th class="border border-zinc-400 px-3 py-2 text-left">
                            Datum laatste levering
                        </th>

                        <th class="border border-zinc-400 px-3 py-2 text-left">
                            Aantal
                        </th>

                        <th class="border border-zinc-400 px-3 py-2 text-left">
                            Eerstvolgende levering
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach ($leveringen as $levering)

                        <tr>

                            <td class="border border-zinc-400 px-3 py-2">
                                {{ $product->Naam }}
                            </td>

                            <td class="border border-zinc-400 px-3 py-2">
                                {{ date('d-m-Y', strtotime($levering->DatumLevering)) }}
                            </td>

                            <td class="border border-zinc-400 px-3 py-2">
                                {{ $levering->Aantal }}
                            </td>

                            <td class="border border-zinc-400 px-3 py-2">
                                @if ($levering->DatumEerstVolgendeLevering)
                                    {{ date('d-m-Y', strtotime($levering->DatumEerstVolgendeLevering)) }}
                                @else
                                    Geen datum bekend
                                @endif
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @endif

        <div class="mt-6">

            <a
                href="{{ route('magazijn') }}"
                class="underline"
            >
                Terug naar magazijn
            </a>

        </div>

    </div>

</x-layouts::app>