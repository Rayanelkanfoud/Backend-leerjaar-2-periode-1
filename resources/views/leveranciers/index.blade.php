<x-jamin-layout title="Overzicht leveranciers">
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th scope="col">Naam</th>
                    <th scope="col">Contactpersoon</th>
                    <th scope="col">Leveranciernummer</th>
                    <th scope="col">Mobiel</th>
                    <th scope="col">Aantal verschillende producten</th>
                    <th scope="col">Toon producten</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($leveranciers as $leverancier)
                    <tr>
                        <td>{{ $leverancier->Naam }}</td>
                        <td>{{ $leverancier->ContactPersoon }}</td>
                        <td>{{ $leverancier->LeverancierNummer }}</td>
                        <td>{{ $leverancier->Mobiel }}</td>
                        <td class="number">{{ $leverancier->AantalVerschillendeProducten }}</td>
                        <td class="action">
                            <a class="icon" href="{{ route('leveranciers.producten', $leverancier->Id) }}" aria-label="Toon producten van {{ $leverancier->Naam }}" title="Toon producten">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path d="m12 3 9 5v8l-9 5-9-5V8z M3 8l9 5 9-5 M12 13v8 M7.5 5.5l9 5v8" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="buttons">
        <a class="button" href="{{ route('home') }}">Home</a>
    </div>
</x-jamin-layout>
