<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prospect extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getDateForHumansAttribute()
    {
      return date('F d, Y', strtotime($this->created_at)); 
    }
}
