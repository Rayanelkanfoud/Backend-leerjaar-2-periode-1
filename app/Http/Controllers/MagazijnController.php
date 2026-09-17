<?php

namespace App\Http\Controllers;

use App\Models\MagazijnModel;

class MagazijnController extends Controller
{
    public function index(MagazijnModel $magazijnModel)
    {
        // producten ophalen uit databse
        $producten = $magazijnModel->getProducten();

        return view('magazijn', [
            'producten' => $producten,
        ]);
    }

    public function levering(int $productId, MagazijnModel $magazijnModel)
    {
        // leveringen ophalen uit databse
        $leveringen = $magazijnModel->getLeveringen($productId);

        abort_if(count($leveringen) === 0, 404);

        return view('magazijn-levering', [
            'product' => $leveringen[0],
            'leveringen' => $leveringen,
        ]);
    }

    public function allergenen(int $productId, MagazijnModel $magazijnModel)
    {
        // allergenen ophalen uit databse
        $allergenen = $magazijnModel->getAllergenen($productId);

        abort_if(count($allergenen) === 0, 404);

        return view('magazijn-allergenen', [
            'product' => $allergenen[0],
            'allergenen' => $allergenen,
        ]);
    }
}
