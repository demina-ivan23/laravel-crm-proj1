<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Order;
use App\Models\Product;
use App\Models\Prospect;
use App\Models\TimeTakenForOrder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GeneralTest extends TestCase
{
    protected $timeTakenForOrderArray = [];
   public function test_prospects_creation()
   {
    $prospects = Prospect::factory()->times(30)->create();
    foreach ($prospects as $prospect)
    {
        $this->assertDatabaseHas('prospects', [
            'id' => $prospect->id,
        ]);
        
    }
   }
   public function test_product_creation()
   {
    $products = Product::factory()->times(30)->create();
    foreach ($products as $product)
    {
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
        ]);
    }
   }
   public function test_order_creation()
   {
       
       $prospects = Prospect::all();
       $products = Product::all();
    $arrayToPass = [];
       foreach ($prospects as $prospect){
    $startTime = microtime(true);
   $order = Order::create(
        [
            'customer_id' => $prospect->id,
            'customer_name' => $prospect->name,
            'customer_email' => $prospect->email,
        ]
    );
    $randProducts = $products->shuffle()->take(2)->values();

    $order->products()->attach([$randProducts[0]->id, $randProducts[1]->id]);

    $endTime = microtime(true);
    $timeTaken = ($endTime - $startTime) * 1000;
    
     TimeTakenForOrder::create([
      'order_id' => $order->id,
      'time_taken' => $timeTaken
    ]);
    $arrayToPass[$order->id] = $timeTaken;

    
    $this->assertTrue(true);
} 
  dd($arrayToPass);


 }



}