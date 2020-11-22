@extends('layouts.app')
@section('content')
<single-post :user="{{Auth::user()}}" :post="{{$post}}"></single-post>
@endsection
