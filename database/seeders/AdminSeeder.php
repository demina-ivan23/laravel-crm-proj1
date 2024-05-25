<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use function PHPSTORM_META\map;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('iamadmin1234'),
            'api_key' => Str::uuid(),
            'role_id' => 1
        ]);
    }
}
