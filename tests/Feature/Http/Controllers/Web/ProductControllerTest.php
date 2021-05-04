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
    protected const PRODUCT_INDEX_ENDPOINT = 'product';
    protected const PRODUCT_CREATE_ENDPOINT = 'product/create';
    protected const PRODUCT_STORE_ENDPOINT = 'product';

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
        ->get(self::PRODUCT_INDEX_ENDPOINT)
        ->assertSee('Listado de productos')
        ->assertStatus(Response::HTTP_OK);
    }

    public function test_mostrar_vinculo_parar_crear_productos()
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);
        $this->actingAs($user)
        ->get(self::PRODUCT_INDEX_ENDPOINT)
        ->assertSee('Nuevo producto')
        ->assertStatus(Response::HTTP_OK);
    }

    public function test_mostrar_mensaje_cuando_no_hay_productos_registrados()
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);
        $this->actingAs($user)
        ->get(self::PRODUCT_INDEX_ENDPOINT)
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
        ->get(self::PRODUCT_INDEX_ENDPOINT)
        ->assertSee('Producto')
        ->assertSee('Precio')
        ->assertSee('Descuento')
        ->assertSee('Total de visitas')
        ->assertSee('Total de ordenes')
        ->assertSee('Eliminar')
        ->assertStatus(Response::HTTP_OK);
    }

    public function test_mostrar_formulario_de_creacion_de_productos()
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);
        Product::factory(10)->create();

        $this->actingAs($user)
        ->get(self::PRODUCT_CREATE_ENDPOINT)
        ->assertSee('Nuevo producto')
        ->assertSee('Nombre')
        ->assertSee('Precio')
        ->assertSee('Descuento')
        ->assertSee('Resumen')
        ->assertSee('Descripción')
        ->assertSee('Crear producto')

        ->assertStatus(Response::HTTP_OK);
    }
}
