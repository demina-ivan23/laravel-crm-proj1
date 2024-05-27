<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_key',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_key',
        'role_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function messages()
    {
        return $this->morphMany(Message::class, 'messagable');
    }
    public function role(){
        return $this->belongsTo(Role::class);
    }
    public function scopeFilter($query){
        return $query;
    }
    public function getLastSeenOnlineAttribute()
    {
        if($this->last_activity_at > Carbon::now()->subSeconds(10)){
            return 'online';
        } elseif($this->last_activity_at > Carbon::now()->subMinute()) {
            return 'Last seen just now';
        } elseif($this->last_activity_at > Carbon::now()->subHours(24)) {
           return 'Last seen at ' . date('D h:m',  strtotime($this->last_activity_at)); 
        } elseif($this->last_activity_at > Carbon::now()->subDays(2)) {
            return 'Last seen today';
        } elseif ($this->last_activity_at > Carbon::now()->subDays(30)){
            return 'Last seen ' . date('M d, h:m',  strtotime($this->last_activity_at));
        } else {
            return 'Last seen longer than 30 days ago';
        }
    }
}
