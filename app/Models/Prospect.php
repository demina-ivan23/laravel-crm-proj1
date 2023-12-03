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

    public function getProspectStateAttribute()
    {
      switch ($this->state_id) {
        case 1:
          return 'prospect';
          break;
        case 2:
          return 'lead';
          break;
        case 3:
          return 'customer';
          break;
        default:
          return 'undefined';
          break;
      }
    }

 
}
