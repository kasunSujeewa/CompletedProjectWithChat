@extends('layouts.app')
@section('content')

<chat :user="{{Auth::user()}}"></chat>



@endsection
