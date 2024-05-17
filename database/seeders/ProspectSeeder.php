<?php

namespace Database\Seeders;

use App\Models\ProspectState;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProspectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prospects = \App\Models\Prospect::factory(30)->create();
        foreach($prospects as $prospect)
        {
            $prospect->states()->attach(ProspectState::inRandomOrder()->first(), ['explanation' => $prospect->addres]);
        }
    }
}
