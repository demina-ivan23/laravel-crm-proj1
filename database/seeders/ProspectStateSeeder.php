<?php

namespace Database\Seeders;

use App\Models\ProspectState;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProspectStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prospect = ProspectState::create([
            'title' => 'prospect',
            'description' => 'A prospect that we know about very little but still want to keep record of them'
        ]);
        $lead = ProspectState::create([
            'title' => 'lead',
            'description' => 'A prospect who is potentially a customer but haven\'t bought anything yet'
        ]);
        $customer = ProspectState::create([
            'title' => 'customer',
            'description' => 'well... a customer, I suppose'
        ]);
        $faker = ProspectState::create([
            'title' => 'faker',
            'description' => 'A person who is trolling our co-workers should be kept in the database, too...'
        ]);
        $prospect->states()->attach($lead);
        $prospect->states()->attach($customer);
        $prospect->states()->attach($faker);

        $lead->states()->attach($customer);
        $lead->states()->attach($faker);

        $faker->states()->attach($lead);
        $faker->states()->attach($customer);
        //You can add more states if you want
    }
}
