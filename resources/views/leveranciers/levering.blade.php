<x-layouts::app :title="__('Levering product')">
    @if ($nietMeerGeproduceerd)
        @push('head')
            <meta http-equiv="refresh" content="4;url={{ route('leveranciers.producten', $leverancierId) }}">
        @endpush
    @endif

    <div class="p-6">
        <h1 class="mb-6 text-2xl font-bold">Levering product</h1>

        <dl class="mb-6 grid grid-cols-[max-content_1fr] gap-x-6 gap-y-2">
            <dt class="font-bold">Product:</dt><dd>{{ $product->ProductNaam }}</dd>
            <dt class="font-bold">Leverancier:</dt><dd>{{ $product->LeverancierNaam }}</dd>
            <dt class="font-bold">Contactpersoon:</dt><dd>{{ $product->ContactPersoon }}</dd>
            <dt class="font-bold">Mobiel:</dt><dd>{{ $product->Mobiel }}</dd>
        </dl>

        @if ($nietMeerGeproduceerd)
            <p role="alert">Het product {{ $product->ProductNaam }} van de leverancier {{ $product->LeverancierNaam }} wordt niet meer geproduceerd</p>
            <div class="mt-6 flex justify-end gap-4">
                <a class="border border-zinc-400 px-5 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-700" href="{{ route('leveranciers.producten', $leverancierId) }}">Terug</a>
                <a class="border border-zinc-400 px-5 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-700" href="{{ route('dashboard') }}">Home</a>
            </div>
        @else
            <form method="POST" action="{{ route('leveringen.store', [$leverancierId, $product->Id]) }}">
                @csrf
                <div class="mt-8 mb-6 grid max-w-2xl grid-cols-1 items-center gap-x-6 gap-y-4 sm:grid-cols-[max-content_1fr]">
                    <label for="aantal">Aantal producteenheden</label>
                    <div>
                        <input class="w-full rounded border border-zinc-400 bg-white px-3 py-2 text-zinc-900 dark:bg-zinc-900 dark:text-white" id="aantal" name="aantal" type="number" min="1" max="65535" step="1" value="{{ old('aantal') }}" required @error('aantal') aria-invalid="true" aria-describedby="aantal-error" @enderror>
                        @error('aantal')<p id="aantal-error" class="mt-2 text-sm text-red-600 dark:text-red-400" role="alert">{{ $message }}</p>@enderror
                    </div>
                    <label for="volgende-levering">Datum eerstvolgende levering</label>
                    <div>
                        <input class="w-full rounded border border-zinc-400 bg-white px-3 py-2 text-zinc-900 dark:bg-zinc-900 dark:text-white" id="volgende-levering" name="volgende_levering" type="date" value="{{ old('volgende_levering') }}" required @error('volgende_levering') aria-invalid="true" aria-describedby="datum-error" @enderror>
                        @error('volgende_levering')<p id="datum-error" class="mt-2 text-sm text-red-600 dark:text-red-400" role="alert">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="mt-6 flex max-w-2xl flex-wrap justify-between gap-4">
                    <button class="border border-zinc-400 px-5 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-700" type="submit">Sla op</button>
                    <div class="flex gap-4">
                        <a class="border border-zinc-400 px-5 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-700" href="{{ route('leveranciers.producten', $leverancierId) }}">Terug</a>
                        <a class="border border-zinc-400 px-5 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-700" href="{{ route('dashboard') }}">Home</a>
                    </div>
                </div>
            </form>
        @endif
    </div>
</x-layouts::app>
