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
        if (!$this->last_activity_at) {
            return 'Never seen online';
        }
        $lastActivityAt = Carbon::parse($this->last_activity_at);
        // dd(date('D H:i:s', strtotime(Carbon::now()->setTimezone(session('timezone')))));
        if($lastActivityAt > Carbon::now()->subSeconds(10)){
            return 'online';
        } elseif($lastActivityAt > Carbon::now()->subMinute()) {
            return 'Last seen just now';
        } elseif($lastActivityAt > Carbon::now()->subHours(24)) {
           return 'Last seen at ' . $lastActivityAt->setTimezone(session('timezone'))->format('D h:i'); 
        } elseif($lastActivityAt > Carbon::now()->subDays(2)) {
            return 'Last seen today';
        } elseif ($lastActivityAt > Carbon::now()->subDays(30)){
            return 'Last seen ' . $lastActivityAt->setTimezone(session('timezone'))->format('M d, h:i');
        } else {
            return 'Last seen longer than 30 days ago';
        }
    }
}
