<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_name' => $this->faker->name,
            'customer_email' => $this->faker->safeEmail,
            'customer_mobile' => $this->faker->e164PhoneNumber,
            'product_name' => $this->faker->name,
            'total' => $this->faker->randomNumber(3),
            'request_id' => $this->faker->randomNumber(4),
            'code' => uniqid('EVERTEC')
        ];
    }
}
