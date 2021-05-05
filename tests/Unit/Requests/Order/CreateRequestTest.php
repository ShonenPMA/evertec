<?php

namespace Tests\Unit\Requests\Order;

use App\Http\Requests\Order\CreateRequest as OrderCreateRequest;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateRequestTest extends TestCase
{
    use RefreshDatabase;
    private $validator;
    private $rules;

    public function setUp() : void
    {
        parent::setUp();
        $this->rules = (new OrderCreateRequest())->rules();
        $this->validator = app()->get('validator');
    }

    public function requestProvider() : array
    {
        $faker = Factory::create(Factory::DEFAULT_LOCALE);

        $data = [
            'name' => $faker->name,
            'phone' => $faker->e164PhoneNumber,
            'email' => $faker->safeEmail,
        ];

        return [
            'la petición debe fallar cuando falta el nombre' => [
                 'shouldPass' => false,
                 'data' => array_merge($data, ['name' => '']),
            ],
            'la petición debe fallar cuando el nombre exceda de los 80 caracteres' => [
                 'shouldPass' => false,
                 'data' => array_merge($data, ['name' => $faker->lexify(str_repeat('?', 81))]),
            ],
            'la petición debe fallar cuando falta el correo' => [
                 'shouldPass' => false,
                 'data' => array_merge($data, ['email' => '']),
            ],
            'la petición debe fallar cuando el correo exceda de los 120 caracteres' => [
                 'shouldPass' => false,
                 'data' => array_merge($data, ['email' => $faker->lexify(str_repeat('?', 121))]),
            ],
            'la petición debe fallar cuando el correo no tiene el formato adecuado' => [
                 'shouldPass' => false,
                 'data' => array_merge($data, ['email' => $faker->text]),
            ],
            'la petición debe fallar cuando falta el celular' => [
                 'shouldPass' => false,
                 'data' => array_merge($data, ['phone' => '']),
            ],
            'la petición debe fallar cuando el celular exceda de los 40 caracteres' => [
                 'shouldPass' => false,
                 'data' => array_merge($data, ['phone' => $faker->lexify(str_repeat('?', 41))]),
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
}
