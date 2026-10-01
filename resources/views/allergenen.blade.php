<x-layouts::app :title="__('Overzicht Allergenen')">

    @if (count($allergenen) === 0)
        <meta http-equiv="refresh" content="4;url={{ route('magazijn') }}">
    @endif

    <div class="p-6">

        <h1 class="mb-6 text-2xl font-bold">
            Overzicht Allergenen
        </h1>

        <div class="mb-6 space-y-2">

            <p>
                <strong>Naam Product:</strong>
                {{ $product->Naam }}
            </p>

            <p>
                <strong>Barcode:</strong>
                {{ $product->Barcode }}
            </p>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full border-collapse">

                <thead>

                    <tr class="bg-zinc-100 dark:bg-zinc-800">

                        <th class="border border-zinc-400 px-3 py-2 text-left">
                            Naam
                        </th>

                        <th class="border border-zinc-400 px-3 py-2 text-left">
                            Omschrijving
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @if (count($allergenen) === 0)

                        <tr>

                            <td
                                colspan="2"
                                class="border border-zinc-400 px-3 py-4 text-center"
                            >
                                In dit product zitten geen stoffen die een allergische reactie kunnen veroorzaken
                            </td>

                        </tr>

                    @else

                        @foreach ($allergenen as $allergeen)

                            <tr>

                                <td class="border border-zinc-400 px-3 py-2">
                                    {{ $allergeen->Naam }}
                                </td>

                                <td class="border border-zinc-400 px-3 py-2">
                                    {{ $allergeen->Omschrijving }}
                                </td>

                            </tr>

                        @endforeach

                    @endif

                </tbody>

            </table>

        </div>

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