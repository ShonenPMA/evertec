<?php

namespace Tests\Feature\Http\Controllers\Web;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Mews\Purifier\Facades\Purifier;
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

    public function test_registar_producto()
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $name = $this->faker->name;

        $data = [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->text(),
            'abstract' => $this->faker->text(50),
            'price' => $this->faker->numberBetween(300, 1000),
            'discount' => $this->faker->numberBetween(0, 80),
        ];

        $this->actingAs($user)
            ->json('POST', self::PRODUCT_STORE_ENDPOINT, $data)
            ->assertJsonFragment([
                'name' => $data['name'],
                'slug' => $data['slug'],
                'description' => Purifier::clean($data['description']),
                'abstract' => Purifier::clean($data['abstract']),
                'price' => $data['price'],
                'discount' => $data['discount'] / 100,
            ]);

        $this->assertDatabaseHas('products', [
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => Purifier::clean($data['description']),
            'abstract' => Purifier::clean($data['abstract']),
            'price' => $data['price'],
            'discount' => $data['discount'] / 100,
        ]);
    }
}
