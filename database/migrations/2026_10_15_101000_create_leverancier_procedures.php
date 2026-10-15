<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        foreach (['sp_get_leveranciers', 'sp_get_leverancier', 'sp_get_geleverde_producten'] as $procedure) {
            DB::unprepared("DROP PROCEDURE IF EXISTS $procedure");
            DB::unprepared(file_get_contents(database_path("procedures/$procedure.sql")));
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        foreach (['sp_get_leveranciers', 'sp_get_leverancier', 'sp_get_geleverde_producten'] as $procedure) {
            DB::unprepared("DROP PROCEDURE IF EXISTS $procedure");
        }
    }
};
