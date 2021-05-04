<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = \Faker\Factory::create();
        \Bezhanov\Faker\ProviderCollectionHelper::addAllProvidersTo($faker);
        $name = $faker->unique()->productName;

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $faker->text(),
            'abstract' => $faker->text(50),
            'price' => $faker->numberBetween(300, 1000),
            'discount' => $faker->numberBetween(0, 80) / 100,
        ];
    }
}
