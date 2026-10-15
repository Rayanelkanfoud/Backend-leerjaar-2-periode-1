<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $this->installProcedure(false);
    }

    public function down(): void
    {
        $this->installProcedure(true);
    }

    private function installProcedure(bool $oldOrder): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        $sql = file_get_contents(database_path('procedures/sp_get_leveranciers.sql'));
        if ($sql === false) {
            throw new RuntimeException('De procedure voor het leveranciersoverzicht kon niet worden gelezen.');
        }

        if ($oldOrder) {
            $sql = str_replace('AantalVerschillendeProducten DESC, l.Id ASC', 'AantalVerschillendeProducten DESC, l.Naam ASC', $sql);
        }

        DB::unprepared('DROP PROCEDURE IF EXISTS sp_get_leveranciers');
        DB::connection()->getPdo()->exec($sql);
    }
};
