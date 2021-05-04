<?php

namespace Tests\Feature\Http\Controllers\Web;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_mostrar_vista_de_listado_de_productos()
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);
        $this->actingAs($user)
        ->get('/product')
        ->assertSee('Listado de productos')
        ->assertStatus(Response::HTTP_OK);
    }

    public function test_mostrar_vinculo_parar_crear_productos()
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);
        $this->actingAs($user)
        ->get('/product')
        ->assertSee('Nuevo producto')
        ->assertStatus(Response::HTTP_OK);
    }

    public function test_mostrar_mensaje_cuando_no_hay_productos_registrados()
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);
        $this->actingAs($user)
        ->get('/product')
        ->assertSee('No hay productos registrados')
        ->assertStatus(Response::HTTP_OK);
    }

    public function test_mostrar_tabla_cuando_hay_productos_registrados()
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);
        Product::factory(10)->create();

        $this->actingAs($user)
        ->get('/product')
        ->assertSee('Producto')
        ->assertSee('Precio')
        ->assertSee('Descuento')
        ->assertSee('Total de visitas')
        ->assertSee('Total de ordenes')
        ->assertSee('Eliminar')
        ->assertStatus(Response::HTTP_OK);
    }
}
