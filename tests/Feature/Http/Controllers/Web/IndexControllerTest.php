<?php

namespace Tests\Feature\Http\Controllers\Web;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_mostrar_productos_en_vista_principal()
    {
        $this->withoutExceptionHandling();
        Product::factory(10)->create();
        $products = Product::orderBy('name', 'ASC')->get();
        $maps = $products->map(function($item,$key){
            return  $item->name;
        });

        $array = $maps->toArray();


        $this
            ->get('/')
            ->assertStatus(Response::HTTP_OK)
            ->assertSeeTextInOrder($array)
            ;
    }
}
