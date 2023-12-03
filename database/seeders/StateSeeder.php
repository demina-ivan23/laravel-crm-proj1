<?php

namespace Database\Seeders;

use App\Models\CustomerState;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CustomerState::create([
            'id' => 1, 'title' => 'prospect'
        ]);
        CustomerState::create([
            'id' => 2, 'title' => 'lead'
        ]);
        CustomerState::create([
            'id' => 3, 'title' => 'customer'
        ]);
    }
}
