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


    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    public function customer()
    {
        return $this->belongsTo(Prospect::class);
    }
    public function scopeFilter($query)
    {
        if (request('search')) {
            $search = request('search');
            $query->where('id', 'like', '%' . $search . '%')
                ->orWhereHas('customer', function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                })
                ->orWhereHas('products', function ($subQuery) use ($search) {
                    $subQuery->where('title', 'like', '%' . $search . '%');
                })
                ->orWhere('customer_id', 'like', '%' . $search . '%');
        }
        return $query;
    }
}
