<?php

namespace Tests;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

abstract class JaminMysqlTestCase extends TestCase
{
    private ?string $testDatabase = null;

    protected function setUp(): void
    {
        parent::setUp();

        if (getenv('JAMIN_MYSQL_TESTS') !== '1') {
            $this->markTestSkipped('Zet JAMIN_MYSQL_TESTS=1 om de stored procedures in een tijdelijke MySQL database te testen.');
        }

        // eigen lege testdatabse, nooit de voorraad van de echte applicatie aanpassen
        config(['database.default' => 'mysql', 'database.connections.mysql.database' => 'mysql']);
        DB::purge('mysql');
        $this->testDatabase = 'jamin_test_'.bin2hex(random_bytes(6));
        DB::statement("CREATE DATABASE `{$this->testDatabase}`");
        config(['database.connections.mysql.database' => $this->testDatabase]);
        DB::purge('mysql');
        Artisan::call('migrate', ['--force' => true]);
    }

    protected function tearDown(): void
    {
        if ($this->testDatabase !== null) {
            DB::statement("DROP DATABASE `{$this->testDatabase}`");
            DB::purge('mysql');
        }

        parent::tearDown();
    }
}
