<?php

namespace Tests\Feature\Http\Requests\Authentication;

use App\Http\Requests\Authentication\RegisterRequest;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterRequestTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    private $validator;
    private $rules;

    public function setUp() : void
    {
        parent::setUp();
        $this->rules = (new RegisterRequest())->rules();
        $this->validator = app()->get('validator');
    }

    public function requestProvider() : array
    {
        $faker = Factory::create(Factory::DEFAULT_LOCALE);
        $password = $faker->password(8);
        $data = [
            'email' =>  $faker->safeEmail,
            'password' => $password,
            'password_confirmation' => $password,
            'name' => $faker->name,
            'phone' => $faker->e164PhoneNumber,
        ];

        return [
            'la petición debe fallar cuando falta el email' => [
                 'shouldPass' => false,
                 'data' => array_merge($data, ['email' => '']),
            ],
            'la petición debe fallar cuando el correo no tiene el formato correcto' => [
                'shouldPass' => false,
                'data' => array_merge($data, ['email' => $faker->text]),

           ],
            'la petición debe fallar cuando falta la clave' => [
                 'shouldPass' => false,
                 'data' => array_merge($data, ['password' => '']),
            ],
            'la petición debe fallar cuando la clave tiene menos de 8 caracteres' => [
                 'shouldPass' => false,
                 'data' => array_merge($data, ['password' => $faker->password(7)]),
            ],

            'la petición debe fallar cuando falta el celular' => [
                'shouldPass' => false,
                'data' => array_merge($data, ['phone' => '']),

           ],
            'la petición debe fallar cuando falta el nombre' => [
                'shouldPass' => false,
                'data' => array_merge($data, ['name' => '']),

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
