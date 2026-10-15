<?php

namespace App\Http\Controllers;

use App\Models\LeveringModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LeveringController extends Controller
{
    public function create(int $leverancierId, int $productId, LeveringModel $model): View
    {
        $product = $model->getProduct($leverancierId, $productId);
        abort_if($product === false, 404);

        return view('leveranciers.levering', [
            'product' => $product,
            'leverancierId' => $leverancierId,
            'nietMeerGeproduceerd' => false,
        ]);
    }

    public function store(Request $request, int $leverancierId, int $productId, LeveringModel $model): View|RedirectResponse
    {
        $product = $model->getProduct($leverancierId, $productId);
        abort_if($product === false, 404);

        $request->validate([
            'aantal' => ['required', 'integer', 'min:1', 'max:65535'],
            'volgende_levering' => ['required', 'date_format:Y-m-d'],
        ], [
            'aantal.required' => 'Vul het aantal producteenheden in.',
            'aantal.integer' => 'Het aantal moet een heel getal zijn.',
            'aantal.min' => 'Het aantal moet minimaal 1 zijn.',
            'aantal.max' => 'Het aantal mag maximaal 65535 zijn.',
            'volgende_levering.required' => 'Vul de datum van de eerstvolgende levering in.',
            'volgende_levering.date_format' => 'Vul een geldige datum in.',
        ]);

        // opgeslagen en voorraad aangepast worden binnen dezelfde transactie
        $status = $model->toevoegen($leverancierId, $productId, $request->integer('aantal'), $request->string('volgende_levering')->toString());

        if ($status === 'inactief') {
            return view('leveranciers.levering', [
                'product' => $product,
                'leverancierId' => $leverancierId,
                'nietMeerGeproduceerd' => true,
            ]);
        }

        abort_if($status === 'onbekend', 404);

        if ($status === 'voorraad_te_hoog') {
            throw ValidationException::withMessages(['aantal' => 'Met deze levering wordt de maximale voorraad van 65535 overschreden.']);
        }

        abort_unless($status === 'opgeslagen', 500);

        return redirect()->route('leveranciers.producten', $leverancierId);
    }
}
