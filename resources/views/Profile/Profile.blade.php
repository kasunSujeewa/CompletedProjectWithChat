@extends('layouts.app')
@section('content')
<div id="app">

    <div class="timeline-header">
        <div class="row justify-content-center">
        <div class="col-8">
        <profile :user="{{$user}}" :user2="{{Auth::user()}}"></profile>
    <post-add v-if='{{$user->id}}=={{Auth()->user()->id}}' :user="{{$user}}"></post-add>
    <own-posts :user="{{$user}}" :user2="{{Auth::user()}}"></own-posts>

    </div>
    </div>
    </div>
    </div>
@endsection
