<?php

namespace App\Http\Controllers;

use App\Events\DemoEvent;
use App\FriendRequest;
use App\Friends;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class FriendsController extends Controller
{
    public function removefr(Request $req)
    {
        $frRQ1 = FriendRequest::where('user_id', $req->friend_id)->where('friend_id', Auth::user()->id)->first();
        $frRQ2 = FriendRequest::where('friend_id', $req->friend_id)->where('user_id', Auth::user()->id)->first();
        if ($frRQ1) {
            $frRQ1->delete();
        } else {
            $frRQ2->delete();
        }
        $fr1 = Friends::where('friend_id', $req->friend_id)->where('user_id', Auth::user()->id)->first();

        $fr1->delete();
        $fr2 = Friends::where('user_id', $req->friend_id)->where('friend_id', Auth::user()->id)->first();
        $fr2->delete();

        $request = "deleted";
        broadcast(new DemoEvent($request));
    }
}
