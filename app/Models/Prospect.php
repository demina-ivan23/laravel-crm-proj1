<?php

namespace App\Models;

use App\Models\ProspectState;
use App\Services\ProspectService;
use PhpParser\Builder\FunctionLike;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prospect extends Model
{
  use HasFactory, SoftDeletes;

  protected $guarded = [];

  public function getCreatedAtHumanizedAttribute()
  {
    return date('F d, Y', strtotime($this->created_at));
  }
  public function orders()
  {
    return $this->hasMany(Order::class, 'customer_id');
  }

  public function states()
  {
    return $this->belongsToMany(ProspectState::class, 'prospect_state_transition', 'prospect_id', 'prospect_state_id')
    ->withPivot('explanation')
    ->withTimestamps();
  }
  public function messages()
  {
    return $this->morphMany(Message::class, 'messagable');
  }
  public function scopeFilter($query)
  {
    if (request('search')) {

      $query
        ->where('name', 'like', '%' . request('search') . '%')
        ->orWhere('email', 'like', '%' . request('search') . '%')
        ->orWhere('state_id', 'like', '%' . request('search') . '%')
        ->orWhere('phone_number', 'like', '%' . request('search') . '%')
        ->orWhere('facebook_account', 'like', '%' . request('search') . '%')
        ->orWhere('instagram_account', 'like', '%' . request('search') . '%')
        ->orWhere('address', 'like', '%' . request('search') . '%');
    }
    if (request('filter_state')) {
      if (request('filter_state') === 'all') {
        $query
          ->where('name', 'like', '%' . '' . '%');
      } else {
        $query
          ->where('state_id', 'like', request('filter_state'));
      }
    }
  }
  public function getLatestStateAttribute(){
    return $this->states()->latest()->first();
  }
}
