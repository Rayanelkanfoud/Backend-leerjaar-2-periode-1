<?php

namespace Tests\Feature;

use App\Models\LeverancierModel;
use App\Models\LeveringModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\JaminMysqlTestCase;

class LeveringTest extends JaminMysqlTestCase
{
    private function leveringUrl(int $leverancier = 1, int $product = 1): string
    {
        return "/leveranciers/$leverancier/producten/$product/levering";
    }

    public function test_formulier_is_beveiligd_en_toont_het_juiste_product(): void
    {
        $this->get($this->leveringUrl())->assertRedirect('/login');
        $this->post($this->leveringUrl())->assertRedirect('/login');
        $this->actingAs(User::factory()->create())->get($this->leveringUrl())
            ->assertOk()->assertSee('Mintnopjes')->assertSee('Venco')->assertSee('Aantal producteenheden');
        $this->get($this->leveringUrl(2, 1))->assertNotFound();
        $this->post($this->leveringUrl(2, 1), ['aantal' => 25, 'volgende_levering' => '2024-05-29'])->assertNotFound();
    }

    public function test_25_mintnopjes_verhoogt_voorraad_en_maakt_een_nieuwe_levering(): void
    {
        $voorraad = DB::table('Magazijn')->where('ProductId', 1)->first();
        $this->actingAs(User::factory()->create())->post($this->leveringUrl(), [
            'aantal' => 25, 'volgende_levering' => '2024-05-29',
        ])->assertRedirect(route('leveranciers.producten', 1));

        $this->assertDatabaseHas('Magazijn', ['ProductId' => 1, 'AantalAanwezig' => 478]);
        $nieuw = DB::table('Magazijn')->where('ProductId', 1)->first();
        $this->assertSame($voorraad->DatumAangemaakt, $nieuw->DatumAangemaakt);
        $this->assertNotSame($voorraad->DatumGewijzigd, $nieuw->DatumGewijzigd);
        $this->assertDatabaseHas('ProductPerLeverancier', [
            'ProductId' => 1, 'LeverancierId' => 1, 'Aantal' => 25,
            'DatumLevering' => DB::selectOne('SELECT CURRENT_DATE() AS datum')->datum,
            'DatumEerstVolgendeLevering' => '2024-05-29',
        ]);
        $this->assertCount(3, (new LeverancierModel)->getProducten(1));
        $this->assertSame(3, (int) (new LeverancierModel)->getLeveranciers()[3]->AantalVerschillendeProducten);
    }

    public function test_winegums_wordt_geweigerd_zonder_iets_op_te_slaan(): void
    {
        $voorraad = DB::table('Magazijn')->where('ProductId', 10)->first();
        $leveringen = DB::table('ProductPerLeverancier')->count();
        $this->actingAs(User::factory()->create())->get($this->leveringUrl(4, 10))->assertOk()->assertSee('Winegums');
        $this->post($this->leveringUrl(4, 10), [
            'aantal' => 30, 'volgende_levering' => now()->format('Y-m-d'),
        ])->assertOk()
            ->assertSee('Het product Winegums van de leverancier Basset wordt niet meer geproduceerd')
            ->assertSee('content="4;url='.route('leveranciers.producten', 4).'"', false);

        $this->assertEquals($voorraad, DB::table('Magazijn')->where('ProductId', 10)->first());
        $this->assertSame($leveringen, DB::table('ProductPerLeverancier')->count());
    }

    public function test_ongeldige_invoer_slaat_niets_op(): void
    {
        $this->actingAs(User::factory()->create());
        foreach ([0, -1, '1.5', 'abc', 65536] as $aantal) {
            $this->from($this->leveringUrl())->post($this->leveringUrl(), [
                'aantal' => $aantal, 'volgende_levering' => '2024-05-29',
            ])->assertSessionHasErrors('aantal');
        }
        $this->post($this->leveringUrl(), ['aantal' => 25, 'volgende_levering' => '2026-02-30'])
            ->assertSessionHasErrors('volgende_levering');
        $this->post($this->leveringUrl(), [])->assertSessionHasErrors(['aantal', 'volgende_levering']);
        $this->assertDatabaseHas('Magazijn', ['ProductId' => 1, 'AantalAanwezig' => 453]);
        $this->assertDatabaseCount('ProductPerLeverancier', 17);
    }

    public function test_te_grote_voorraad_en_een_databasefout_laten_geen_halve_levering_achter(): void
    {
        $model = new LeveringModel;
        $this->assertSame('voorraad_te_hoog', $model->toevoegen(1, 1, 65535, '2024-05-29'));
        $this->actingAs(User::factory()->create())->post($this->leveringUrl(), [
            'aantal' => 65535, 'volgende_levering' => '2024-05-29',
        ])->assertSessionHasErrors('aantal');

        DB::unprepared("CREATE TRIGGER test_weiger_levering BEFORE INSERT ON ProductPerLeverancier
            FOR EACH ROW SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'test fout bij opslaan'");
        try {
            $model->toevoegen(1, 1, 25, '2024-05-29');
            $this->fail('De trigger hoort de insert te weigeren.');
        } catch (\PDOException $exception) {
            $this->assertStringContainsString('test fout bij opslaan', $exception->getMessage());
        }

        $this->assertDatabaseHas('Magazijn', ['ProductId' => 1, 'AantalAanwezig' => 453]);
        $this->assertDatabaseCount('ProductPerLeverancier', 17);
    }

    public function test_null_voorraad_wordt_bij_een_actief_product_als_nul_geteld(): void
    {
        DB::statement('UPDATE Product SET IsActief = 1 WHERE Id = 10');
        $this->assertSame('opgeslagen', (new LeveringModel)->toevoegen(4, 10, 30, '2024-05-29'));
        $this->assertDatabaseHas('Magazijn', ['ProductId' => 10, 'AantalAanwezig' => 30]);
    }
}
