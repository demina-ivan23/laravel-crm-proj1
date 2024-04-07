<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProspectStateTransitionTracking extends Model
{
    use HasFactory;
    
    const UPDATED_AT = null;

    protected $guarded = ['id'];

    public function prospect(){
        return $this->belongsTo(Prospect::class);
    }
}
