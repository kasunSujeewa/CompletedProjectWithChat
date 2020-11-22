<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function show()
    {

        return  User::all();
    }
    public function index()
    {
        return view('Chat');
    }
}
