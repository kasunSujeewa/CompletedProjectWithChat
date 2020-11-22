<?php

namespace App\Http\Controllers;

use App\Events\DemoEvent;



use App\FriendRequest;
use App\Friends;
use App\Notifications\FriendRequestNotification;
use Illuminate\Support\Facades\Auth;

use App\User;


use Illuminate\Http\Request;

class FriendRequestController extends Controller
{
    public function Store(Request $req)
    {
        $request = new FriendRequest;
        $request->user_id = Auth::user()->id;
        $request->friend_id = $req->friend_id;

        $request->save();
        $user = User::find($req->friend_id);

        $user->notify(new FriendRequestNotification($request));
        broadcast(new DemoEvent($request));
    }
    public function index()
    {
        $friendRequestSend = FriendRequest::with(['user'])->where('status', false)->where('user_id', Auth::user()->id)->get();
        $friendRequestReceive = FriendRequest::with(['user'])->where('status', false)->where('friend_id', Auth::user()->id)->get();
        $requestedID = collect(Auth::user()->friendRequestsSend->pluck('friend_id'));
        $requestResID = collect(Auth::user()->friendRequestsReceive->pluck('user_id'));
        $friends = Friends::with('user')->where('friend_id', Auth::user()->id)->get();
        $friendID = collect(Friends::with('user')->where('friend_id', Auth::user()->id)->pluck('user_id'));

        $user = User::with(['friendRequestsSend', 'friendRequestsReceive', 'friends'])->where('id', '!=', Auth::user()->id)->get();
        return response()->json(['friendRequestSend' => $friendRequestSend, 'friendRequestReceive' => $friendRequestReceive, 'friends' => $friends, 'users' => $user, 'requestedID' => $requestedID, 'requestResID' => $requestResID, 'friendsID' => $friendID]);
    }
    public function destroy($id)
    {
        $request1 = Auth::user()->friendRequestsSend->where('friend_id', $id)->first();


        $request1->delete();
        $request = "deleted";
        broadcast(new DemoEvent($request));
    }
    public function confirm(Request $req)
    {
        $request1 = FriendRequest::where('user_id', $req->friend_id)->where('friend_id', Auth::user()->id)->first();

        $request1->status = true;

        $request1->save();
        Friends::create([
            'user_id' => $req->friend_id,
            'friend_id' => Auth::user()->id,

        ]);
        Friends::create([
            'friend_id' => $req->friend_id,
            'user_id' => Auth::user()->id,

        ]);

        $request = "added";
        broadcast(new DemoEvent($request));
    }
    public function remove($id)
    {
        $request1 = FriendRequest::find($id);


        $request1->delete();
        $request = "deleted";
        broadcast(new DemoEvent($request));
    }
}
