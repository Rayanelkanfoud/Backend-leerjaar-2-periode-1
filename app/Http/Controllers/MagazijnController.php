<?php

namespace App\Http\Controllers;

use App\Models\MagazijnModel;
use Illuminate\Routing\Controllers\HasMiddleware;

class MagazijnController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        // gebruiker moet ingelogd zijn
        return ['auth'];
    }

    public function index(MagazijnModel $magazijnModel)
    {
        // producten ophalen uit databse
        $producten = $magazijnModel->getProducten();

        return view('magazijn', [
            'producten' => $producten,
        ]);
    }

    public function leverantie(int $id, MagazijnModel $magazijnModel)
    {
        // gekozen product ophalen
        $product = $magazijnModel->getProduct($id);

        abort_if(!$product, 404);

        // checken of product voorraad heeft
        if ($product->AantalAanwezig === null) {
            return view('leverantie', [
                'product' => $product,
                'geenVoorraad' => true,
                'leverancier' => null,
                'leveringen' => [],
            ]);
        }

        // leverancier en leveringen ophalen
        $leverancier = $magazijnModel->getLeverancier($id);
        $leveringen = $magazijnModel->getLeveringen($id);

        return view('leverantie', [
            'product' => $product,
            'geenVoorraad' => false,
            'leverancier' => $leverancier,
            'leveringen' => $leveringen,
        ]);
    }

    public function allergenen(int $id, MagazijnModel $magazijnModel)
    {
        // product ophalen
        $product = $magazijnModel->getProduct($id);

        abort_if(!$product, 404);

        // allergenen ophalen
        $allergenen = $magazijnModel->getAllergenen($id);

        return view('allergenen', [
            'product' => $product,
            'allergenen' => $allergenen,
        ]);
    }
}