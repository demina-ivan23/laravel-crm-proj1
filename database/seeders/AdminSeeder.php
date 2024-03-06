<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('iamadmin')
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jane@doe.com',
            'password' => bcrypt('password')
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Registered User',
            'email' => 'test@test.com',
            'password' => bcrypt('12345678')
        ]);
   }
}
