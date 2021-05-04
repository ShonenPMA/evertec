<?php

namespace Tests\Unit\Requests\Product;

use App\Http\Requests\Product\UpdateRequest;
use App\Models\Product;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\Validator;
use Tests\TestCase;

class UpdateRequestTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp() : void
    {
        parent::setUp();
    }

    public function requestProvider() : array
    {
        $faker = Factory::create(Factory::DEFAULT_LOCALE);

        $name = $faker->unique()->name;
        $data = [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $faker->text(),
            'abstract' => $faker->text(50),
            'price' => $faker->numberBetween(300, 1000),
            'discount' => $faker->numberBetween(0, 80) / 100,
        ];

        return [
            'la petición debe fallar cuando falta el nombre' => [
                 'shouldPass' => false,
                 'data' => array_merge($data, ['name' => '']),
            ],
            'la petición debe fallar cuando falta el precio' => [
                 'shouldPass' => false,
                 'data' => array_merge($data, ['price' => '']),
            ],
            'la petición debe fallar cuando el precio no es un número' => [
                 'shouldPass' => false,
                 'data' => array_merge($data, ['price' => $faker->text]),
            ],
            'la petición debe fallar cuando falta el resumen' => [
                 'shouldPass' => false,
                 'data' => array_merge($data, ['abstract' => '']),
            ],
            'la petición debe fallar cuando el resumen excede a los 50 caracteres' => [
                 'shouldPass' => false,
                 'data' => array_merge($data, ['abstract' => $faker->lexify(str_repeat('?', 51))]),
            ],
            'la petición debe fallar cuando falta la descripcion' => [
                 'shouldPass' => false,
                 'data' => array_merge($data, ['description' => '']),
            ],
            'la petición debe fallar cuando el descuento no es un número' => [
                 'shouldPass' => false,
                 'data' => array_merge($data, ['discount' => $faker->text]),
            ],
             'la petición debe fallar cuando el descuento es mayor a 100' => [
                 'shouldPass' => false,
                 'data' => array_merge($data, ['discount' => '101']),
            ],
            'la petición debe ser exitosa en el resto de los casos' => [
                 'shouldPass' => true,
                 'data' => $data,

            ],
        ];
    }

    /**
     * @dataProvider requestProvider
     */
    public function test_validacion_funciona_como_se_espera($shouldPass, $data)
    {
        $user = User::factory()->create(['role' => 'admin']);
        $product = Product::factory()->create();

        $response = $this
                        ->actingAs($user)
                        ->json('PUT', "product/{$product->slug}", $data);
        if ($shouldPass) {
            $response->assertStatus(Response::HTTP_OK);
        } else {
            $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function test_validar_que_el_producto_sea_unico()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $product = Product::factory()->create();
        $old_product = Product::factory()->create();
        $faker = Factory::create(Factory::DEFAULT_LOCALE);

        $data = [
            'name' => $old_product->name,
            'description' => $faker->text(),
            'abstract' => $faker->text(50),
            'price' => $faker->numberBetween(300, 1000),
            'discount' => $faker->numberBetween(0, 80) / 100,
        ];

        $this
            ->actingAs($user)
            ->json('PUT', "product/{$product->slug}", $data)
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
