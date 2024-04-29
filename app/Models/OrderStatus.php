<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_status_transition', 'order_status_id', 'order_id')
            ->withPivot('explanation')
            ->withTimestamps();
    }
    public function statuses()
    {
        return $this->belongsToMany(OrderStatus::class, 'order_status_order_status', 'order_status_id_1', 'order_status_id_2');
    }
}
