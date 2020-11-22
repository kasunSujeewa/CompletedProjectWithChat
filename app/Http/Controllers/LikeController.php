<?php

namespace App\Http\Controllers;

use App\Events\DemoEvent;


use Illuminate\Database\Eloquent\Collection;
use App\Post;
use App\Like;
use Illuminate\Support\Facades\Auth;



use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request, $id)
    {
        $like1 = new Like;
        $like1->post_id = $id;
        $like1->user_id = Auth::user()->id;
        $like1->status = $request->status;
        $like1->save();
        $post = Post::find($id);
        $like = collect($post->likes->pluck('user_id'));
        $dislike = collect($post->dislikes->pluck('user_id'));
        $request = "deleted";
        broadcast(new DemoEvent($request));
        return response()->json(['like' => $like, 'dislike' => $dislike, 'message' => "succesful reacted"]);
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
