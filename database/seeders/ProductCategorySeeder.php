<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductCategory::create([
            'id' => 1, 'title' => 'lorem ipsum'
        ]);
        ProductCategory::create([
            'id' => 2, 'title' => 'dolorem ipsum'
        ]);
        ProductCategory::create([
            'id' => 3, 'title' => 'lorem ipsumem'
        ]);
    }
}
