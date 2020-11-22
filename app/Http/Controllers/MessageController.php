<?php

namespace App\Http\Controllers;

use App\Events\Chatting;
use Illuminate\Support\Facades\Auth;


use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function getMessage($sessionKey)
    {
        $message = Message::with(['chat'])->where('sessionData', $sessionKey)->get();
        return response()->json($message);
    }
    public function saveMessage(Request $request)
    {
        $message = new Message;
        $message->sessionData = $request->specificKey;
        $message->to = $request->user;
        $keyValue = $request->specificKey;
        $message->from = Auth::user()->id;
        $message->bodyText = $request->text;
        $message->save();
        broadcast(new Chatting($message));
        return response()->json($message);
    }
}
