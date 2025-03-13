@extends('base')

@section('title', 'Posts')

@section('content')
    @if(session('success'))
        <div class="flex justify-center sm:mx-5 mx-2 sm:mt-3 mt-2">
            <div class="flex items-center p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 w-[700px]" role="alert">
                <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <div>
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif
    <h1 class="text-center text-4xl font-bold mb-6 dark:text-white mt-4">Annonces</h1>
    <div class="mx-2 sm:mx-5">
        <a href="{{ route('posts.create') }}" class=" w-fit text-white bg-blue-500 dark:bg-blue-700 dark:text-white hover:bg-blue-700 dark:hover:bg-blue-500 font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline"  id="submitBtn">
            Créer une annonce
        </a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 my-5 mx-2 sm:mx-5">
        @foreach($posts as $post)
            <a href="{{ route('posts.show', ['post' => $post->id]) }}" class="relative flex md:flex-row w-full gap-2 bg-slate-50 dark:bg-slate-800 p-4 shadow-md dark:shadow-gray-950 rounded-xl">
                @if ($post->images->count() > 0)
                    <div class="min-w-32  w-32 h-32 rounded-md flex items-center justify-center object-cover overflow-hidden">
                        <img src="{{ asset('storage/posts/' . $post->images->first()->url_image) }}" class="rounded-lg" alt="">
                    </div>
                @endif
                <div class="mb-4">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $post->title }}</h2>
                    <p class="text-gray-700 dark:text-gray-400 : md:text-base text-sm">
                        {{ Str::limit($post->description, 100, '...') }}
                    </p>
                </div>
                <div class="absolute bottom-2 right-0  flex flex-row gap-2">
                    <p class=" bg-cyan-300 dark:bg-cyan-800 dark:text-white text-sm font-semibold dark:font-medium mr-2 px-2.5 py-0.5 rounded-full">{{ $post->getFormattedPriceAttribute() }}</p>
                </div>
            </a>
        @endforeach
    </div>
    <div class="mx-2 sm:mx-5">
        {{ $posts->links() }}
    </div>

@endsection