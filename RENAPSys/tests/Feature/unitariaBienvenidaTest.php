<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class unitariaBienvenidaTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUnitariaBienvenida()
    {

        /*
            Prueba unitaria para la verificacion del estado de pagina
            inicial y de mensaje Bienvenida del Sitio
        */
        
        $response = $this->get('/');

        $response->assertStatus(200);
        
        $response->assertSeeText('RENAPSys 2019 prueba de etiquetas');

    }
}
