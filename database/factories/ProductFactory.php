<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $name = $this->faker->word();

        // Generate product_code similar to your controller logic
        $first = strtoupper(substr($name, 0, 1));
        $last = strtoupper(substr($name, -1));

        // For factory, use a random number padded to 10 digits
        $number = str_pad($this->faker->numberBetween(1, 9999), 10, '0', STR_PAD_LEFT);

        $product_code = $first . $number . $last;

        return [
            'product_code' => $product_code,
            'name' => $name,
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'description' => $this->faker->sentence(),
        ];
    }
}
