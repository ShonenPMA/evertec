<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected const REGISTER_ENDPOINT = 'register';

    /**
     * @return void
     */
    public function test_muestra_los_inputs_en_la_vista_login()
    {
        $this->get(self::REGISTER_ENDPOINT)
        ->assertSee('Correo')
        ->assertSee('Clave')
        ->assertSee('Confirmación de la clave')
        ->assertSee('Nombre')
        ->assertSee('Celular')
        ->assertSee('Registrarme')
        ->assertStatus(Response::HTTP_OK);
    }

    public function test_redirecciona_si_estas_autenticado()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
        ->get(self::REGISTER_ENDPOINT)
        ->assertStatus(Response::HTTP_FOUND);
    }

    public function test_puede_registrar_usuarios()
    {
        $data = [
            'email' => $this->faker->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
            'name' => $this->faker->name,
            'phone' => $this->faker->e164PhoneNumber,
        ];

        $this->json('POST', self::REGISTER_ENDPOINT, $data)
        ->assertStatus(Response::HTTP_OK);
    }
}
