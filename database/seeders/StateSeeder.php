<?php

namespace Database\Seeders;

use App\Models\ProspectState;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProspectState::create([
            'id' => 1, 'title' => 'prospect'
        ]);
        ProspectState::create([
            'id' => 2, 'title' => 'lead'
        ]);
        ProspectState::create([
            'id' => 3, 'title' => 'customer'
        ]);
    }
}
