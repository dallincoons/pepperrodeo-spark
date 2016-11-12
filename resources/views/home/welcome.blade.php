@extends('layouts.app')

@section('content')
    @if(!Auth::check())
        <h1>Welcome Page</h1>
    @else
        @include('home.includes.user-home')
    @endif
@endsection
