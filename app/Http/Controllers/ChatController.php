<?php

namespace App\Http\Controllers;

use App\ChatList;
use App\Friends;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;




use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {

        return view('Chat');
    }
    public function onlineUser()
    {
        $friends = Friends::where('friend_id', Auth::user()->id)->get();


        if ($friends) {
            $OnlineUser = array();
            foreach ($friends as $friend) {
                if ($friend->isOnline()) {
                    $OnlineUser[] = $friend->user;
                }
            }
            return response()->json(['onlineFR' => $OnlineUser]);
        }
    }
    public function index1(Request $request)
    {


        $chatList = ChatList::where('user_id', Auth::user()->id)->where('user2_id', $request->id)->get();
        if ($chatList->count() > 0) {
            return response()->json(['message' => 'failed']);
        } else
            $uniqid = Str::random(9);
        ChatList::create([
            'user_id' => Auth::user()->id,
            'user2_id' => $request->id,
            'sessionKey' => $uniqid,
        ]);
        ChatList::create([
            'user2_id' => Auth::user()->id,
            'user_id' => $request->id,
            'sessionKey' => $uniqid,
        ]);
    }
    public function chatCollection($id)
    {
        $chatlist = ChatList::with(['user'])->where('user_id', Auth::user()->id)->get();
        return response()->json(['convertations' => $chatlist]);
    }
}
