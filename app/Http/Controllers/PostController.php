<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            $imagename = $request->image->getClientOriginalName();
            $request->image->storeAs('public', $imagename);
            $post = new Post;
            $post->postName = $request->post_name;
            $post->description = $request->description;
            $post->image = $imagename;
            $post->user_id = Auth::user()->id;
            $post->save();
        } else {
            $post = new Post;
            $post->postName = $request->post_name;
            $post->description = $request->description;

            $post->user_id = Auth::user()->id;
            $post->save();
        }
        return Post::all();
    }
    public function index()
    {
        if ((Auth::user()->friends->count()) > 0) {
            $collection = collect(Auth::user()->friends->pluck('friend_id'));
            $collection->push(Auth::user()->id);

            $post = Post::with(['likes', 'dislikes', 'user', 'comment'])->whereIn('user_id', $collection)->orderBy('created_at', 'desc')->get();
            return response()->json(['post' => $post]);
        } else {
            $post = Post::with(['likes', 'dislikes', 'user', 'comment'])->where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
            return response()->json(['post' => $post]);
        }
    }
    public function Userindex($id)
    {
        $ownPost = Post::with(['likes', 'dislikes', 'user', 'comment'])->orderBy('created_at', 'desc')->where('user_id', $id)->get();

        return response()->json(['ownPost' => $ownPost]);
    }
    public function Update(Request $request, $id)
    {
        if ($request->hasFile('image')) {
            $post = Post::find($id);
            $imagename = $request->image->getClientOriginalName();
            $request->image->storeAs('public', $imagename);

            $post->postName = $request->post_name;
            $post->description = $request->description;
            $post->image = $imagename;
            $post->user_id = Auth::user()->id;
            $post->save();
        } else {
            $post = Post::find($id);
            $post->postName = $request->post_name;
            $post->description = $request->description;

            $post->user_id = Auth::user()->id;
            $post->save();
        }
    }
    public function remove($id)
    {
        $post = Post::find($id);
        $post->comment()->forceDelete();
        $post->likes()->forceDelete();
        $post->dislikes()->forceDelete();
        $post->delete();
    }
    public function show($id)
    {
        $post = Post::find($id);
        return view('SinglePost')->with('post', $post);
    }
}
