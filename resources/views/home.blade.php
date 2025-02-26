@extends('base')

@section('title', 'Home')

@section('content')
    <h1 class="text-4xl font-bold">Home</h1>

    @if (Auth::check())
        <a href="{{ route('auth.update') }}" class="hover:text-blue-600">Edit Profile</a>
    @else
        <p>You are not logged in.</p>
        <div class="flex flex-col mt-4">
            <a href="{{ route('auth.login') }}">Login</a>
            <a href="{{ route('auth.signup') }}">Sign Up</a>
        </div>
    @endif
@endsection