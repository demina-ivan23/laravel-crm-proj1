<?php

namespace App\Models;

use App\Models\CustomerState;
use App\Services\ProspectService;
use PhpParser\Builder\FunctionLike;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
      $state = ProspectService::getCustomStateTitle($this->state_id);
      return $state;
    }

    public function state()
    {
      return $this->belongsTo(CustomerState::class);
    }

    public function scopeFilter($query)
    { 
      if(request('search')){
        
        $query 
        ->where('name', 'like', '%' . request('search') . '%')
        ->orWhere('email', 'like', '%' . request('search') . '%')
        ->orWhere('state_id', 'like', '%' . request('search') . '%')
        ->orWhere('phone_number', 'like', '%' . request('search') . '%')
        ->orWhere('facebook_account', 'like', '%' . request('search') . '%')
        ->orWhere('instagram_account', 'like', '%' . request('search') . '%')
        ->orWhere('address', 'like', '%' . request('search') . '%');
      }
    }
 
}
