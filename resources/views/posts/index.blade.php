@extends('base')

@section('title', 'Posts')

@php
    $image = 1;
@endphp

@section('content')
    <h1 class="text-center text-4xl font-bold mb-6 dark:text-white mt-4">Annonces</h1>
    <div class="mx-2 sm:mx-5">
        <a href="{{ route('posts.create') }}" class=" w-fit bg-blue-500 dark:bg-blue-700 dark:text-white hover:bg-blue-700 dark:hover:bg-blue-500 font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline"  id="submitBtn">
            Créer une annonce
        </a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 my-5 mx-2 sm:mx-5">
        @foreach($posts as $post)
            <a href="{{ route('posts.show', ['post' => $post->id]) }}" class="relative flex md:flex-row w-full gap-2 bg-slate-50 dark:bg-slate-800 p-4 shadow-md dark:shadow-gray-950 rounded-xl">
                @if ($image)
                    <div class="min-w-32  w-32 h-32 bg-black flex items-center justify-center object-cover overflow-hidden">
                        <img src="avatars/1740487941.webp" alt="">
                    </div>
                @endif
                <div class="mb-4">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $post->title }}</h2>
                    <p class="text-gray-700 dark:text-gray-400 : md:text-base text-sm">
                        {{ Str::limit($post->description, 100, '...') }}
                    </p>
                </div>
                <div class="absolute bottom-2 right-0  flex flex-row gap-2">
                    <p class=" bg-cyan-300 dark:bg-cyan-800 dark:text-white text-sm font-semibold dark:font-medium mr-2 px-2.5 py-0.5 rounded-full">{{ $post->price }}</p>
                </div>
            </a>
        @endforeach

    </div>

@endsection