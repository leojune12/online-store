<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $default_categories = [
            'Women Clothes',
           ' Men Clothes',
            'Beauty',
            'Health',
            'Fashion Accessories',
            'Home Appliances',
            'Men Shoes',
            'Mobile & Gadgets',
            'Travel & Luggage',
            'Women Bags',
            'Women Shoes',
            'Men Bags',
            'Watches',
            'Audio',
            'Food & Beverage',
            'Pets',
            'Mom & Baby',
            'Baby & Kids Fashion',
            'Gaming & Consoles',
            'Cameras & Drones',
            'Home & Living',
            'Sports & Outdoors',
            'Stationery',
            'Hobbies & Collections',
            'Automobiles',
            'Motorcycles',
            'Books & Magazines',
            'Computers & Accessories',
            'Gardening',
        ];

        foreach ($default_categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category)
            ]);
        }
    }
}
