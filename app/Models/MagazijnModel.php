<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use PDO;

class MagazijnModel
{
    public function getProducten(): array
    {
        // verbinding ophalen via pdo
        $pdo = DB::connection()->getPdo();

        // producten uit de databse ophalen
        $sql = '
            SELECT
                p.Id,
                p.Naam,
                p.Barcode,
                m.VerpakkingsEenheid,
                m.AantalAanwezig
            FROM Product AS p
            INNER JOIN Magazijn AS m
                ON p.Id = m.ProductId
            WHERE p.IsActief = 1
                AND m.IsActief = 1
            ORDER BY p.Barcode ASC
        ';

        $statement = $pdo->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function getLeveringen(int $productId): array
    {
        // verbinding ophalen via pdo
        $pdo = DB::connection()->getPdo();

        // leveringen ophalen uit databse
        $sql = "
            SELECT
                p.Id AS ProductId,
                p.Naam AS ProductNaam,
                m.AantalAanwezig,
                l.Naam AS LeverancierNaam,
                l.ContactPersoon,
                l.LeverancierNummer,
                l.Mobiel,
                DATE_FORMAT(ppl.DatumLevering, '%d-%m-%Y') AS DatumLaatsteLevering,
                ppl.Aantal,
                DATE_FORMAT(ppl.DatumEerstVolgendeLevering, '%d-%m-%Y') AS DatumEerstVolgendeLevering
            FROM Product AS p
            INNER JOIN Magazijn AS m
                ON p.Id = m.ProductId
            INNER JOIN ProductPerLeverancier AS ppl
                ON p.Id = ppl.ProductId
            INNER JOIN Leverancier AS l
                ON ppl.LeverancierId = l.Id
            WHERE p.Id = :productId
                AND p.IsActief = 1
                AND m.IsActief = 1
                AND ppl.IsActief = 1
                AND l.IsActief = 1
            ORDER BY ppl.DatumLevering ASC
        ";

        $statement = $pdo->prepare($sql);
        $statement->bindValue(':productId', $productId, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function getAllergenen(int $productId): array
    {
        // verbinding ophalen via pdo
        $pdo = DB::connection()->getPdo();

        // allergenen ophalen uit databse
        $sql = '
            SELECT
                p.Id AS ProductId,
                p.Naam AS ProductNaam,
                p.Barcode,
                a.Naam AS AllergeenNaam,
                a.Omschrijving
            FROM Product AS p
            LEFT JOIN ProductPerAllergeen AS ppa
                ON p.Id = ppa.ProductId
                AND ppa.IsActief = 1
            LEFT JOIN Allergeen AS a
                ON ppa.AllergeenId = a.Id
                AND a.IsActief = 1
            WHERE p.Id = :productId
                AND p.IsActief = 1
            ORDER BY a.Naam ASC
        ';

        $statement = $pdo->prepare($sql);
        $statement->bindValue(':productId', $productId, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }
}
