<?php

namespace App\Models;

use App\Models\Prospect;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProspectState extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function prospects()
    {
        return $this->hasMany(Prospect::class);
    }
} 
