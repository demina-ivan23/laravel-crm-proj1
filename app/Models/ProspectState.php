<?php

namespace App\Models;

use App\Models\Prospect;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProspectState extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;

    public function prospects()
    {
        return $this->belongsToMany(Prospect::class, 'prospect_state_transition', 'prospect_state_id', 'prospect_id')
            ->withPivot('explanation')
            ->withTimestamps();
    }

    public function states()
    {
        return $this->belongsToMany(ProspectState::class, 'prospect_state_prospect_state', 'prospect_state_id_1', 'prospect_state_id_2');
    }
}
