<?php

namespace Tests\Feature;

use App\Models\MagazijnModel;
use App\Models\User;
use Tests\JaminMysqlTestCase;

class MagazijnTest extends JaminMysqlTestCase
{
    public function test_opdracht_1_blijft_beschikbaar_met_de_database_van_opdracht_2(): void
    {
        $this->actingAs(User::factory()->create());

        // ook een product dat niet meer gemaakt wordt heeft nog leveringsinformatie
        $this->assertCount(13, (new MagazijnModel)->getProducten());
        $this->get('/magazijn')->assertOk()->assertSee('Winegums');
        $this->get('/magazijn/1/leverantie')->assertOk()->assertSee('Venco')->assertSee('Mintnopjes');
        $this->get('/magazijn/10/leverantie')->assertOk()
            ->assertSee('Er is van dit product op dit moment geen voorraad aanwezig')
            ->assertSee('content="4;url='.route('magazijn').'"', false);
        $this->get('/magazijn/13/allergenen')->assertOk()->assertSee('Gluten')->assertSee('Lactose')->assertSee('Soja');
        $this->get('/magazijn/5/allergenen')->assertOk()
            ->assertSee('In dit product zitten geen stoffen die een allergische reactie kunnen veroorzaken');
    }
}
