<?php

namespace App\Http\Controllers;

use App\User;


use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function notificationGet($id)
    {
        $users = User::with(['unreadNotifications'])->find($id);
        return response()->json($users);
    }
    public function notificationmarkAsRead($id)
    {
        $user = User::find($id);
        $user->unreadNotifications->markAsRead();
    }
}
