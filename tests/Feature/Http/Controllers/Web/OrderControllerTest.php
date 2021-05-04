<?php

namespace Tests\Feature\Http\Controllers\Web;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_mostrar_vista_de_generar_orden()
    {
        $product = Product::factory()->create();
        $this
            ->get('/order/'.$product->slug)
            ->assertStatus(Response::HTTP_OK)
            ->assertSee('Nombre')
            ->assertSee('Correo')
            ->assertSee('Celular')
            ->assertSee('Generar orden')
            ;
    }
}
