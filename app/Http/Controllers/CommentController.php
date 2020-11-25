<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Events\DemoEvent;
use App\Events\NotificationDemo;


use App\Notifications\commentNotification;
use App\User;
use Illuminate\Support\Facades\Auth;



use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index($id)
    {
        $comment = Comment::with(['user', 'post'])->orderBy('id', 'desc')->where('post_id', $id)->latest()->take(3)->get();
        return response()->json(['comment' => $comment]);
    }
    public function store(Request $request, $id)
    {
        $comment = new Comment;
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $id;
        $comment->comment = $request->comment;


        $comment->save();
        $user2 = User::find($comment->post->user_id);
        $user2->notify(new commentNotification($comment));
        broadcast(new NotificationDemo($comment));
        $request = "deleted";
        broadcast(new DemoEvent($request));

        return response()->json(['comment' => $comment, 'message' => 'seccesfuly commented']);
    }
    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);
        $comment->update($request->all());
        return response()->json(['message' => 'seccesfuly commented']);
    }
    public function remove($id)
    {
        $comment = Comment::find($id);
        $comment->delete();
        $request = "deleted";
        broadcast(new DemoEvent($request));
        return response()->json(['message' => 'seccesfuly deleted']);
    }
}
