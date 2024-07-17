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
    $search = request('prospects-search');
    if ($search) {
      $query
        ->where('name', 'like', '%' . $search . '%')
        ->orWhere('email', 'like', '%' . $search . '%')
        ->orWhere('phone_number', 'like', '%' . $search . '%')
        ->orWhere('facebook_account', 'like', '%' . $search . '%')
        ->orWhere('instagram_account', 'like', '%' . $search . '%')
        ->orWhere('address', 'like', '%' . $search . '%')
        ->orWhereHas('states', function ($subQuery) use ($search) {
          $subQuery->latest()->take(1)->where('title', 'like', '%' . $search . '%');
        });
    }
    $filterState = request('filter_state');
    if ($filterState && $filterState !== 'all'){
        $query->whereHas('states', function ($subQuery) use ($filterState) {
          $subQuery->latest()->take(1)->where('prospect_state_id', $filterState);
        });
      }
    return $query;
  }
  public function getLatestStateAttribute(){
    return $this->states()->latest()->first();
  }
}
