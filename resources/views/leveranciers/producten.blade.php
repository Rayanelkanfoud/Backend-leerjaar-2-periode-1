<x-jamin-layout title="Geleverde producten"
    :refresh-url="count($producten) === 0 ? route('leveranciers.index') : null"
    :refresh-seconds="3">
    <dl class="details">
        <dt>Naam leverancier:</dt><dd>{{ $leverancier->Naam }}</dd>
        <dt>Contactpersoon:</dt><dd>{{ $leverancier->ContactPersoon }}</dd>
        <dt>Leverancier nr:</dt><dd>{{ $leverancier->LeverancierNummer }}</dd>
        <dt>Mobiel:</dt><dd>{{ $leverancier->Mobiel }}</dd>
    </dl>
    <div class="table-scroll">
        <table>
            <thead>
                <tr>
                    <th scope="col">Naam product</th>
                    <th scope="col">Aantal in magazijn</th>
                    <th scope="col">Verpakkingseenheid</th>
                    <th scope="col">Laatste levering</th>
                    <th scope="col">Nieuwe levering</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($producten as $product)
                    <tr>
                        <td>{{ $product->Naam }}</td>
                        <td>{{ $product->AantalAanwezig ?? 0 }}</td>
                        <td>{{ str_replace('.', ',', $product->VerpakkingsEenheid) }} kg</td>
                        <td>{{ date('d-m-Y', strtotime($product->LaatsteLevering)) }}</td>
                        <td class="action">
                            <a class="icon" href="{{ route('leveringen.create', [$leverancier->Id, $product->Id]) }}" aria-label="Nieuwe levering van {{ $product->Naam }}" title="Nieuwe levering">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true">
                                    <path d="M12 4v16 M4 12h16" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="message" colspan="5" role="status">Dit bedrijf heeft tot nu toe geen producten geleverd aan Jamin</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="buttons">
        <a class="button" href="{{ route('leveranciers.index') }}">Terug</a>
        <a class="button" href="{{ route('home') }}">Home</a>
    </div>
</x-jamin-layout>
