<?php

namespace App;

use Illuminate\Support\Facades\Cache;


use Illuminate\Support\Facades\Auth;



use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'gender', 'slug', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function profile()
    {
        return $this->hasOne('App\Profile');
    }
    public function post()
    {
        return $this->hasMany('App\Post');
    }
    public function likes()
    {
        return $this->hasMany('App\Like')->where('status', true);
    }
    public function dislikes()
    {
        return $this->hasMany('App\Like')->where('status', false);
    }
    public function comment()
    {
        return $this->hasMany('App\Comment');
    }
    public function friendRequestsSend()
    {
        return $this->hasMany('App\FriendRequest', 'user_id')->where('status', false);
    }
    public function friendRequestsReceive()
    {
        return $this->hasMany('App\FriendRequest', 'friend_id')->where('status', false);
    }
    public function friends()
    {
        return $this->hasMany('App\Friends', 'user_id');
    }
    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }
    public function chats()
    {
        return $this->hasMany('App\ChatList');
    }
}
