<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'title' => 'role 1',
            'description' => 'a first placeholder role'
        ]);
        Role::create([
            'title' => 'role 2',
            'description' => 'a second placeholder role'
        ]);
        Role::create([
            'title' => 'role 3',
            'description' => 'a third placeholder role'
        ]);
    }
}
