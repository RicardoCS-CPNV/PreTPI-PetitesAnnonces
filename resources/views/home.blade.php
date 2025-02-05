@extends('base')

@section('title', 'Home')

@section('content')
    <h1 class="text-4xl font-bold">Home</h1>

    @if (Auth::check())
        <p>Welcome {{ Auth::user()->name }}!</p>
        <form action="{{ route('auth.logout') }}" method="post" class="flex">
            @method("delete")
            @csrf
            <button class="hover:text-blue-950 transition-all"><svg class="h-8 w-8 text-red-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />  <polyline points="16 17 21 12 16 7" />  <line x1="21" y1="12" x2="9" y2="12" /></svg></button>
        </form>
    @else
        <p>You are not logged in.</p>
        <div class="flex flex-col mt-4">
            <a href="{{ route('auth.login') }}">Login</a>
            <a href="{{ route('auth.signup') }}">Sign Up</a>
        </div>
    @endif
@endsection