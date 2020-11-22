<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'to', 'from', 'sessionData', 'bodyText'
    ];
    public function chat()
    {
        return $this->belongsTo('App\ChatList', 'sessionData');
    }
}
