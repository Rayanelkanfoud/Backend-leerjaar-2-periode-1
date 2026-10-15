<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        // bij een nieuwe installatie eerst de zes jamin tabellen maken
        $tables = ['Product', 'Allergeen', 'Leverancier', 'Magazijn', 'ProductPerAllergeen', 'ProductPerLeverancier'];
        $existing = array_filter($tables, fn (string $table): bool => Schema::hasTable($table));

        if (count($existing) === 0) {
            $sql = file_get_contents(database_path('create_script.sql'));
            $sql = preg_replace('/^(CREATE DATABASE[^;]*;|USE[^;]*;)\s*$/mi', '', $sql);
            DB::unprepared($sql);
        } elseif (count($existing) !== count($tables)) {
            throw new RuntimeException('De Jamin database is onvolledig. Controleer eerst de zes tabellen.');
        }

        // bestaande gegevens behouden, alleen de wijzigingen van opdracht 2 toepassen
        foreach ($tables as $table) {
            DB::statement("ALTER TABLE `$table` MODIFY Opmerking VARCHAR(255) NULL");
        }

        DB::statement("INSERT INTO Leverancier
            (Naam, ContactPersoon, LeverancierNummer, Mobiel, IsActief, DatumAangemaakt, DatumGewijzigd)
            SELECT 'Quality Street', 'Johan Nooij', 'L1029234586', '06-23458456', 1, NOW(6), NOW(6)
            WHERE NOT EXISTS (SELECT 1 FROM Leverancier WHERE LeverancierNummer = 'L1029234586')");

        DB::statement("UPDATE Product SET IsActief = 0, DatumGewijzigd = NOW(6) WHERE Barcode = '8719587327527'");
        DB::statement("UPDATE ProductPerLeverancier
            SET DatumLevering = DATE_ADD(DatumLevering, INTERVAL 1 MONTH),
                DatumEerstVolgendeLevering = DATE_ADD(DatumEerstVolgendeLevering, INTERVAL 1 MONTH),
                DatumGewijzigd = NOW(6)
            WHERE DatumLevering BETWEEN '2024-10-01' AND '2024-10-31'");
    }

    public function down(): void
    {
        // voorraad en leveringen blijven bewaard bij een rollback
    }
};
