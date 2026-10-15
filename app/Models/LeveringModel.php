<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use PDO;

class LeveringModel
{
    public function getProduct(int $leverancierId, int $productId): object|false
    {
        $statement = DB::connection()->getPdo()->prepare('CALL sp_get_levering_product(:leverancierId, :productId)');
        $statement->execute(['leverancierId' => $leverancierId, 'productId' => $productId]);
        $product = $statement->fetch(PDO::FETCH_OBJ);
        $statement->closeCursor();

        return $product;
    }

    public function toevoegen(int $leverancierId, int $productId, int $aantal, string $volgendeLevering): string
    {
        $statement = DB::connection()->getPdo()->prepare(
            'CALL sp_toevoegen_levering(:leverancierId, :productId, :aantal, :volgendeLevering)'
        );
        $statement->execute([
            'leverancierId' => $leverancierId,
            'productId' => $productId,
            'aantal' => $aantal,
            'volgendeLevering' => $volgendeLevering,
        ]);
        $status = $statement->fetchColumn();
        $statement->closeCursor();

        return (string) $status;
    }
}
