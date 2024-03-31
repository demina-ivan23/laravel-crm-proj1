<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use function PHPSTORM_META\map;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuperadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Superadmin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('iamsuperadmin1234'),
            'api_key' => Str::uuid(),
            'api_access_level' => 'FULL_ACCESS',
            'is_superadmin' => true
        ]);
    }
}
