<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => function () {
                return Category::inRandomOrder()->first()?->id ?? Category::factory()->create()->id;
            },
            'supplier_id' => function () {
                return Supplier::inRandomOrder()->first()?->id ?? Supplier::factory()->create()->id;
            },
            'name' => $this->faker->randomElement(['Beef', 'Chicken', 'Fish', 'Veggie', 'Cheese'])
                . ' '
                . $this->faker->randomElement(['Burger', 'Pizza', 'Pasta', 'Rice Bowl', 'Sandwich', 'Wrap', 'Salad']),
            'sku' => 'P-' . strtoupper(Str::random(3)),
            'price' => $this->faker->numberBetween(10000, 100000),
            'stock' => $this->faker->numberBetween(1, 100),
            'min_stock' => $this->faker->numberBetween(0, 5),
            'image_path' => $this->faker->imageUrl(640, 480, 'products', true),
            'is_active' => 0
        ];
    }
}
