@extends('base')

@section('title', 'Home')

@section('content')
<h1 class="dark:text-white text-4xl font-bold text-center">Home</h1>
@if (auth()->check())
    <h2 class="dark:text-white text-2xl font-bold mx-2 sm:mx-5">Bienvenue {{ auth()->user()->name }}</h2>
@endif
<div class="m-2 sm:m-5 flex flex-col gap-5">
        <a href="{{ route('posts.index') }}" class="w-full sm:w-fit text-white bg-blue-500 dark:bg-blue-700 dark:text-white hover:bg-blue-700 dark:hover:bg-blue-500 font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline">Voir les annonces disponibles</a>
        @if (auth()->check())
            <a href="{{ route('auth.update') }}" class="w-full sm:w-fit text-white bg-blue-500 dark:bg-blue-700 dark:text-white hover:bg-blue-700 dark:hover:bg-blue-500 font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline">Votre profil</a>
        @endif
    </div>


@endsection