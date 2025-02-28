@extends('base')

@section('title', 'Posts')

@php
    $image = true;
@endphp

@section('content')
    <h1 class="text-center text-4xl font-bold mb-6 dark:text-white mt-4">Annonces</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 my-5 mx-2 sm:mx-5">
        @foreach($posts as $post)
            <div class="relative flex md:flex-row w-full gap-2 bg-slate-50 dark:bg-slate-800 p-4 shadow-md dark:shadow-gray-950 rounded-xl">
                @if ($image)
                    <div class="min-w-32  w-32 h-32 bg-black flex items-center justify-center object-cover overflow-hidden">
                        <img src="avatars/1740487941.webp" alt="">
                    </div>
                @endif
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $post->title }}</h2>
                    <p class="text-gray-700 dark:text-gray-400">
                        {{ $post->description }}
                    </p>
                </div>
                <div class="absolute bottom-2 right-0  flex flex-row gap-2">
                    <p class=" bg-cyan-300 dark:bg-cyan-800 dark:text-white text-sm font-semibold dark:font-medium mr-2 px-2.5 py-0.5 rounded-full">{{ $post->price }}</p>
                </div>
            </div>
        @endforeach

    </div>

@endsection