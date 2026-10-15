<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use PDO;

class LeverancierModel
{
    /** @return array<int, object> */
    public function getLeveranciers(): array
    {
        $statement = DB::connection()->getPdo()->prepare('CALL sp_get_leveranciers()');
        $statement->execute();
        $leveranciers = $statement->fetchAll(PDO::FETCH_OBJ);
        // resultaat afsluiten zodat de volgende query ook uitgevoerd kan worden
        $statement->closeCursor();

        return $leveranciers;
    }

    public function getLeverancier(int $leverancierId): object|false
    {
        $statement = DB::connection()->getPdo()->prepare('CALL sp_get_leverancier(:leverancierId)');
        $statement->execute(['leverancierId' => $leverancierId]);
        $leverancier = $statement->fetch(PDO::FETCH_OBJ);
        $statement->closeCursor();

        return $leverancier;
    }

    /** @return array<int, object> */
    public function getProducten(int $leverancierId): array
    {
        $statement = DB::connection()->getPdo()->prepare('CALL sp_get_geleverde_producten(:leverancierId)');
        $statement->execute(['leverancierId' => $leverancierId]);
        $producten = $statement->fetchAll(PDO::FETCH_OBJ);
        $statement->closeCursor();

        return $producten;
    }
}
