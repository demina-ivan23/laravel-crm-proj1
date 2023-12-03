<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Prospect;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'products_id' => 'array'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
  
}
