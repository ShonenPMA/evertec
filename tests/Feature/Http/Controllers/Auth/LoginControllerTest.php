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
    /**
     *
     * @return void
     */
    public function test_muestra_los_inputs_en_la_vista_login()
    {
        $this->get('/login')
        ->assertSee('Correo')
        ->assertSee('Clave')
        ->assertSee('Ingresar')
        ->assertStatus(Response::HTTP_OK);
    }


    public function test_redirecciona_si_estas_autenticado()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
        ->get('login')
        ->assertStatus(Response::HTTP_FOUND);
    }
}
