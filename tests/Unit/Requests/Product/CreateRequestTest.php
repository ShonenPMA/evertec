<?php

namespace Tests\Unit\Requests\Product;

use App\Http\Requests\Product\CreateRequest;
use App\Models\Product;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class CreateRequestTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    private $validator;
    private $rules;

    public function setUp() : void
    {
        parent::setUp();
        $this->rules = (new CreateRequest())->rules();
        $this->validator = app()->get('validator');
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
        $this->assertEquals(
            $shouldPass,
            $this->validate($data)
        );
    }

    protected function validate($data)
    {
        return $this->validator
            ->make($data, $this->rules)
            ->passes();
    }

    public function test_validar_que_el_producto_sea_unico()
    {
        $product = Product::factory()->create();

        $faker = Factory::create(Factory::DEFAULT_LOCALE);


        $name = $faker->name;
        $data = [
            'name' => $name,
            'slug' => Str::slug($product->slug),
            'description' => $faker->text(),
            'abstract' => $faker->text(50),
            'price' => $faker->numberBetween(300, 1000),
            'discount' => $faker->numberBetween(0, 80) / 100,
        ];

        $this->assertEquals(false, $this->validate($data));
    }
}
