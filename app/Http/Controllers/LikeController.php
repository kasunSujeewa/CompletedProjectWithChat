<?php

namespace App\Http\Controllers;

use App\Events\DemoEvent;
use App\Events\ReactHandleNotification;
use Illuminate\Database\Eloquent\Collection;
use App\Post;
use App\Like;
use App\Notifications\LikeNotification;
use App\User;
use Illuminate\Support\Facades\Auth;



use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request, $id)
    {
        $like = new Like;
        $like->post_id = $id;
        $like->user_id = Auth::user()->id;
        $like->status = $request->status;
        $like->save();
        $post = Post::find($id);
        $like1 = collect($post->likes->pluck('user_id'));
        $dislike = collect($post->dislikes->pluck('user_id'));
        $request = "deleted";
        $post = Post::find($id);
        $user = User::find($post->user_id);
        $user->notify(new LikeNotification($like));
        broadcast(new ReactHandleNotification($like));
        return response()->json(['like' => $like1, 'dislike' => $dislike, 'message' => "succesful reacted"]);
    }
    public function remove($id)
    {
        $like1 = Like::where('post_id', $id)->where('user_id', Auth::user()->id)->first();
        $like1->delete();
        $post = Post::find($id);
        $like = collect($post->likes->pluck('user_id'));
        $dislike = collect($post->dislikes->pluck('user_id'));
        $request = "deleted";
        broadcast(new DemoEvent($request));
        return response()->json(['like' => $like, 'dislike' => $dislike, 'message' => "succesful reacted"]);
    }
    public function update(Request $request, $id)
    {
        $like = Like::where('post_id', $id)->where('user_id', Auth::user()->id)->first();
        $like->status = $request->status;
        $like->save();
        $request = "deleted";
        broadcast(new DemoEvent($request));
        return response()->json(['message' => "succesful reacted"]);
    }
    public function Likes($id)
    {
        $post = Post::find($id);
        $like = collect($post->likes->pluck('user_id'));
        $dislike = collect($post->dislikes->pluck('user_id'));
        return response()->json(['like' => $like, 'dislike' => $dislike]);
    }
}
