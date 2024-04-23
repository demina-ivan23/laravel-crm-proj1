<?php

namespace Database\Factories;

use App\Models\Prospect;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customerId = $this->faker->numberBetween(Prospect::min('id'), Prospect::max('id'));
        $customer = Prospect::find($customerId);
        return [
            'customer_id' => $customerId
        ];
    }
}
