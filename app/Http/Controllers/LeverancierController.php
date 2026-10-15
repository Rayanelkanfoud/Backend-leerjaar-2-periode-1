<?php

namespace App\Http\Controllers;

use App\Models\LeverancierModel;
use Illuminate\Contracts\View\View;

class LeverancierController extends Controller
{
    public function index(LeverancierModel $model): View
    {
        return view('leveranciers.index', ['leveranciers' => $model->getLeveranciers()]);
    }

    public function producten(int $leverancierId, LeverancierModel $model): View
    {
        $leverancier = $model->getLeverancier($leverancierId);
        abort_if($leverancier === false, 404);

        return view('leveranciers.producten', [
            'leverancier' => $leverancier,
            'producten' => $model->getProducten($leverancierId),
        ]);
    }
}
