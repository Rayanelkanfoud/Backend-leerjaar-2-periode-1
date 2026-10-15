<x-jamin-layout title="Levering product"
    :refresh-url="$nietMeerGeproduceerd ? route('leveranciers.producten', $leverancierId) : null"
    :refresh-seconds="4">
    <dl class="details">
        <dt>Product:</dt><dd>{{ $product->ProductNaam }}</dd>
        <dt>Leverancier:</dt><dd>{{ $product->LeverancierNaam }}</dd>
        <dt>Contactpersoon:</dt><dd>{{ $product->ContactPersoon }}</dd>
        <dt>Mobiel:</dt><dd>{{ $product->Mobiel }}</dd>
    </dl>

    @if ($nietMeerGeproduceerd)
        <p role="alert">Het product {{ $product->ProductNaam }} van de leverancier {{ $product->LeverancierNaam }} wordt niet meer geproduceerd</p>
        <div class="buttons">
            <a class="button" href="{{ route('leveranciers.producten', $leverancierId) }}">Terug</a>
            <a class="button" href="{{ route('home') }}">Home</a>
        </div>
    @else
        <form method="POST" action="{{ route('leveringen.store', [$leverancierId, $product->Id]) }}">
            @csrf
            <div class="fields">
                <label for="aantal">Aantal producteenheden</label>
                <div>
                    <input id="aantal" name="aantal" type="number" min="1" max="65535" step="1" value="{{ old('aantal') }}" required @error('aantal') aria-invalid="true" aria-describedby="aantal-error" @enderror>
                    @error('aantal')<p id="aantal-error" class="error" role="alert">{{ $message }}</p>@enderror
                </div>
                <label for="volgende-levering">Datum eerstvolgende levering</label>
                <div>
                    <input id="volgende-levering" name="volgende_levering" type="date" value="{{ old('volgende_levering') }}" required @error('volgende_levering') aria-invalid="true" aria-describedby="datum-error" @enderror>
                    @error('volgende_levering')<p id="datum-error" class="error" role="alert">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="buttons form-buttons">
                <button class="button" type="submit">Sla op</button>
                <div>
                    <a class="button" href="{{ route('leveranciers.producten', $leverancierId) }}">Terug</a>
                    <a class="button" href="{{ route('home') }}">Home</a>
                </div>
            </div>
        </form>
    @endif
</x-jamin-layout>
