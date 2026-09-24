<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use PDO;

class MagazijnModel
{
    public function getProducten(): array
    {
        // verbinding met databse
        $pdo = DB::connection()->getPdo();

        $sql = "
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
        ";

        $statement = $pdo->prepare($sql);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function getProduct(int $productId): object|false
    {
        // product ophalen
        $pdo = DB::connection()->getPdo();

        $sql = "
            SELECT
                p.Id,
                p.Naam,
                p.Barcode,
                m.AantalAanwezig
            FROM Product AS p
            INNER JOIN Magazijn AS m
                ON p.Id = m.ProductId
            WHERE p.Id = :productId
        ";

        $statement = $pdo->prepare($sql);

        $statement->execute([
            'productId' => $productId,
        ]);

        return $statement->fetch(PDO::FETCH_OBJ);
    }

    public function getLeverancier(int $productId): object|false
    {
        // leverancier van product ophalen
        $pdo = DB::connection()->getPdo();

        $sql = "
            SELECT
                l.Naam AS LeverancierNaam,
                l.ContactPersoon,
                l.LeverancierNummer,
                l.Mobiel
            FROM Leverancier AS l
            INNER JOIN ProductPerLeverancier AS pl
                ON l.Id = pl.LeverancierId
            WHERE pl.ProductId = :productId
            ORDER BY pl.DatumLevering ASC
            LIMIT 1
        ";

        $statement = $pdo->prepare($sql);

        $statement->execute([
            'productId' => $productId,
        ]);

        return $statement->fetch(PDO::FETCH_OBJ);
    }

    public function getLeveringen(int $productId): array
    {
        // leveringen ophalen
        $pdo = DB::connection()->getPdo();

        $sql = "
            SELECT
                pl.DatumLevering,
                pl.Aantal,
                pl.DatumEerstVolgendeLevering
            FROM ProductPerLeverancier AS pl
            WHERE pl.ProductId = :productId
            ORDER BY pl.DatumLevering ASC
        ";

        $statement = $pdo->prepare($sql);

        $statement->execute([
            'productId' => $productId,
        ]);

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function getAllergenen(int $productId): array
    {
        // allergenen van product ophalen
        $pdo = DB::connection()->getPdo();

        $sql = "
            SELECT
                a.Naam,
                a.Omschrijving
            FROM Allergeen AS a
            INNER JOIN ProductPerAllergeen AS pa
                ON a.Id = pa.AllergeenId
            WHERE pa.ProductId = :productId
            ORDER BY a.Naam ASC
        ";

        $statement = $pdo->prepare($sql);

        $statement->execute([
            'productId' => $productId,
        ]);

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }
}