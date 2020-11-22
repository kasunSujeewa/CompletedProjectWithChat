<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatList extends Model
{
    protected $fillable = [
        'user_id', 'user2_id', 'sessionKey',
    ];
    public function user()
    {
        return $this->belongsTo('App\User', 'user2_id');
    }
    public function message()
    {
        return $this->hasMany('App\message', 'sessionKey');
    }
}
