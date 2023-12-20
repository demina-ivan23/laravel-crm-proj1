<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimeTakenForOrder extends Model
{
    
    use HasFactory;
    protected $guarded = [];

    public function order()
    {
        $this->belongsTo(Order::class);
    }
}
