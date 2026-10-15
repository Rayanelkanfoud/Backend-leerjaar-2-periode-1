<?php

namespace Tests\Feature;

use App\Models\LeverancierModel;
use App\Models\User;
use Tests\JaminMysqlTestCase;

class LeverancierTest extends JaminMysqlTestCase
{
    public function test_bezoeker_moet_eerst_inloggen(): void
    {
        $this->get('/leveranciers')->assertRedirect('/login');
        $this->get('/leveranciers/1/producten')->assertRedirect('/login');
    }

    public function test_leveranciers_tellen_verschillende_producten_en_sorteren_aflopend(): void
    {
        $model = new LeverancierModel;
        $leveranciers = $model->getLeveranciers();
        $this->assertCount(6, $leveranciers);
        $this->assertSame([3, 3, 3, 3, 1, 0], array_map(fn ($l) => (int) $l->AantalVerschillendeProducten, $leveranciers));
        $this->assertSame('Quality Street', $leveranciers[5]->Naam);

        $this->actingAs(User::factory()->create())->get('/leveranciers')
            ->assertOk()->assertSee('Overzicht leveranciers')->assertSee('Quality Street')
            ->assertSee('data-flux-sidebar', false)->assertSee(route('dashboard'));
    }

    public function test_producten_bevatten_geen_dubbele_leveringen_en_juiste_sortering(): void
    {
        $producten = (new LeverancierModel)->getProducten(1);
        $this->assertCount(3, $producten);
        $this->assertSame(['Mintnopjes', 'Schoolkrijt', 'Honingdrop'], array_column($producten, 'Naam'));
        $this->assertSame('2024-11-18', $producten[0]->LaatsteLevering);

        $this->actingAs(User::factory()->create())->get('/leveranciers/1/producten')
            ->assertOk()->assertSee('Bert van Linge')->assertSee('18-11-2024');
    }

    public function test_lege_leverancier_toont_melding_en_keert_na_drie_seconden_terug(): void
    {
        $this->actingAs(User::factory()->create())->get('/leveranciers/6/producten')
            ->assertOk()
            ->assertSee('Dit bedrijf heeft tot nu toe geen producten geleverd aan Jamin')
            ->assertSee('content="3;url='.route('leveranciers.index').'"', false);

        $this->get('/leveranciers/999/producten')->assertNotFound();
    }
}
