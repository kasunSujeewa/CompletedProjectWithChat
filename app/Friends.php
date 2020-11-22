<?php

namespace App;

use Illuminate\Support\Facades\Cache;


use Illuminate\Database\Eloquent\Model;

class Friends extends Model
{
    protected $fillable = [
        'user_id', 'friend_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->user_id);
    }
}
