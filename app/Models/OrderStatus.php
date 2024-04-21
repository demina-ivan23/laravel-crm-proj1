<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_status_transition', 'order_status_id', 'order_id')
            ->withPivot('explanation')
            ->withTimestamps();
    }
}
