<?php

namespace Tests\Feature\Http\Controllers\Web;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_mostrar_vista_de_generar_orden()
    {
        $product = Product::factory()->create();
        $this
            ->get('/order/'.$product->slug)
            ->assertStatus(Response::HTTP_OK)
            ->assertSee('Nombre')
            ->assertSee('Correo')
            ->assertSee('Celular')
            ->assertSee('Generar orden');
    }

    public function test_genera_orden_de_compra()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'phone' => $this->faker->e164PhoneNumber,
        ];

        $requestId = $this->faker->randomNumber(4);
        Http::fake([
            config('checkout.URL') => Http::response([
                'requestId' => $requestId,
                'processUrl' => $this->faker->url,
            ]),
        ]);

        $product = Product::factory()->create();

        $this->json('POST', "/order/{$product->slug}", $data)
        ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('orders', [
            'customer_name' => $data['name'],
            'customer_email' => $data['email'],
            'customer_mobile' => $data['phone'],
            'product_name' => $product->name,
            'total' => $product->raw_price,
            'request_id' => $requestId,
        ]);
    }

    public function test_muestra_datos_de_la_orden()
    {
        $order = Order::factory()->create();

        $this->json('GET', "/order/check/{$order->code}")
        ->assertStatus(Response::HTTP_OK)
        ->assertSee('Estado de la orden de compra')
        ->assertSee('Código de rastreo')
        ->assertSee('Producto')
        ->assertSee('Total')
        ->assertSee('Nombre del comprador')
        ->assertSee('Correo del comprador')
        ->assertSee('Celular del comprador');
    }

    public function test_actualiza_el_estado_a_PAYED_cuando_se_aprobo_el_pago_de_la_orden()
    {
        $order = Order::factory()->create();
        Http::fake([
            config('checkout.URL')."/{$order->request_id}" => Http::response([
                'requestId' => $order->request_id,
                'status' => [
                    'status' => 'APPROVED',
                ],
            ]),
        ]);
        $this->json('GET', "/order/check/{$order->code}")
        ->assertStatus(Response::HTTP_OK)
        ->assertSee('Estado de la orden de compra')
        ->assertSee('Código de rastreo')
        ->assertSee('Producto')
        ->assertSee('Total')
        ->assertSee('Nombre del comprador')
        ->assertSee('Correo del comprador')
        ->assertSee('Celular del comprador')
        ->assertSee('PAGADO');
    }

    public function test_actualiza_el_estado_a_REJECTED_cuando_se_rechazo_el_pago_de_la_orden()
    {
        $order = Order::factory()->create();
        Http::fake([
            config('checkout.URL')."/{$order->request_id}" => Http::response([
                'requestId' => $order->request_id,
                'status' => [
                    'status' => 'REJECTED',
                ],
            ]),
        ]);
        $this->json('GET', "/order/check/{$order->code}")
        ->assertStatus(Response::HTTP_OK)
        ->assertSee('Estado de la orden de compra')
        ->assertSee('Código de rastreo')
        ->assertSee('Producto')
        ->assertSee('Total')
        ->assertSee('Nombre del comprador')
        ->assertSee('Correo del comprador')
        ->assertSee('Celular del comprador')
        ->assertSee('RECHAZADO');
    }
}
