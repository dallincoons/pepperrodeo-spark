@extends('layouts.app')

@section('content')
    @if(!Auth::check())
    @else
        @include('home.includes.user-home')
    @endif
@endsection
