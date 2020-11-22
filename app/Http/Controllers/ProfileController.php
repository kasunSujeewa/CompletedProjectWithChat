<?php

namespace App\Http\Controllers;

use App\User;
use App\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index($slug)
    {
        $user = User::where('slug', $slug)->first();
        return view('Profile.Profile')->with('user', $user);
    }
    public function show($slug)
    {
        $user = User::with('profile')->where('slug', $slug)->first();
        $profile = Profile::with('user')->Where('user_id', $user->id)->first();
        return response()->json(['profile' => $profile, 'user' => $user]);
    }
    public function update(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $profile->update($request->all());
        $profile->save();
        return Profile::find($id);
    }
}
