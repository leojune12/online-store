<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
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
        $productSuffixes = [
            'Sweater',
            'Pants',
            'Shirt',
            'Glasses',
            'Hat',
            'Socks',
            'Bag',
            'Shoes',
            'Watch',
            'Soap'
        ];

        $name = $this->faker->company . ' ' . Arr::random($productSuffixes);

        $categories = Category::all();

        return [
            'name' => $name,
            'shop_id' => rand(3, 102),
            'category_id' => $categories->random(1)->pluck('id')->toArray()[0],
            'slug' => Str::slug($name),
            'description' => $this->faker->realText(320),
            'price' => $this->faker->numberBetween(100, 10000),
            'stock' => $this->faker->numberBetween(5, 100),
            'condition' => $this->faker->numberBetween(0, 1),
            'publish' => $this->faker->numberBetween(0, 1),
            'view_count' => $this->faker->numberBetween(0, 500),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (Product $product) {
            //
        })->afterCreating(function (Product $product) {

            $url = 'https://picsum.photos/200';

            $product
            ->addMediaFromUrl($url)
            ->toMediaCollection('product_cover_image');

            $product->cover_image_url = $product->getFirstMediaUrl('product_cover_image');

            $product->save();

            $url = 'https://picsum.photos/200';

            $product
            ->addMediaFromUrl($url)
            ->toMediaCollection('product_images');

            $url = 'https://picsum.photos/200';

            $product
            ->addMediaFromUrl($url)
            ->toMediaCollection('product_images');

            $url = 'https://picsum.photos/200';

            $product
            ->addMediaFromUrl($url)
            ->toMediaCollection('product_images');
        });
    }
}
