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
        $nm = rand(1 , 3);
        if ($nm === 1)
        {
            return [
            'name' => $this->faker->word,
            'email' => $this->faker->email,
            'profile_image' => null,
            'state_id' => 1,
            ];
        }
        if($nm === 2) {

            return [
                'name' => $this->faker->word,
                'email' => $this->faker->email,
                'profile_image' => null,
                'state_id' => 2,
                'phone_number' => $this->faker->phoneNumber,
                'facebook_account' => $this->faker->userName,
                'instagram_account' => $this->faker->userName,
                'address'=> $this->faker->address,
                'personal_info' => $this->faker->paragraph(2)
            ];
        } 
        if($nm === 3){
            $nm_2 = rand(1, 2);
            if($nm_2 === 1){
                return [
                    'name' => $this->faker->word,
                    'email' => $this->faker->email,
                    'profile_image' => null,
                    'state_id' => 3,
                ];
            } else {
                return [
                    'name' => $this->faker->word,
                    'email' => $this->faker->email,
                    'profile_image' => null,
                    'state_id' => 3,
                    'phone_number' => $this->faker->phoneNumber,
                    'facebook_account' => $this->faker->userName,
                    'instagram_account' => $this->faker->userName,
                    'address'=> $this->faker->address,
                    'personal_info' => $this->faker->paragraph(2)
                ];
            }
        }
    }
}
