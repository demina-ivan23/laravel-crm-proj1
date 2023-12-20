<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prospect>
 */
class ProspectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'email' => $this->faker->email,
            'profile_image' => null,
            'phone_number' => $this->faker->phoneNumber,
            'facebook_account' => $this->faker->userName,
            'instagram_account' => $this->faker->userName,
            'address'=> $this->faker->address,
            'personal_info' => $this->faker->paragraph(2)
        ];
    }
}
