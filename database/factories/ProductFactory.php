<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $productSuffixes = ['Sweater', 'Pants', 'Shirt', 'Glasses', 'Hat', 'Socks', 'Bag', 'Shoes', 'Watch', 'Soap'];

        $name = $this->faker->company . ' ' . Arr::random($productSuffixes);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->realText(320),
            'price' => $this->faker->numberBetween(100, 10000)
        ];
    }
}
