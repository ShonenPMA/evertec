<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Requests\Authentication;

use App\Http\Requests\Authentication\LoginRequest;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginRequestTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    private $validator;
    private $rules;

    public function setUp() : void
    {
        parent::setUp();
        $this->rules = (new LoginRequest())->rules();
        $this->validator = app()->get('validator');
    }

    public function requestProvider() : array
    {
        $faker = Factory::create(Factory::DEFAULT_LOCALE);
        $data = [
            'email' =>  $faker->safeEmail,
            'password' => $faker->password(8),
        ];

        return [
            'la petición debe fallar cuando falta el email' => [
                 'shouldPass' => false,
                 'data' => array_merge($data, ['email' => '']),
            ],
            'la petición debe fallar cuando falta el correo' => [
                 'shouldPass' => false,
                 'data' => array_merge($data, ['password' => '']),

            ],
            'la petición debe fallar cuando el correo no tiene el formato correcto' => [
                 'shouldPass' => false,
                 'data' => array_merge($data, ['email' => $faker->text]),

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
