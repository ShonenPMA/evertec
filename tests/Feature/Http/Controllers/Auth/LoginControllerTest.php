<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected const LOGIN_ENDPOINT = 'login';

    /**
     * @return void
     */
    public function test_muestra_los_inputs_en_la_vista_login()
    {
        $this->get(self::LOGIN_ENDPOINT)
        ->assertSee('Correo')
        ->assertSee('Clave')
        ->assertSee('Ingresar')
        ->assertStatus(Response::HTTP_OK);
    }

    public function test_redirecciona_si_estas_autenticado()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
        ->get(self::LOGIN_ENDPOINT)
        ->assertStatus(Response::HTTP_FOUND);
    }

    public function test_puede_iniciar_sesion()
    {
        $user = User::factory()->create();
        $data = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $this->json('POST', self::LOGIN_ENDPOINT, $data)
        ->assertStatus(Response::HTTP_OK);
    }
}
