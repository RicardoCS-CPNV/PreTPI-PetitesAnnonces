@extends('base')

@section('title', 'Posts')

@section('content')
    <!-- Success message -->
    @if(session('success'))
        <div class="flex justify-center sm:mx-5 mx-2 sm:mt-3 mt-2">
            <div class="flex items-center p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 w-[700px]" role="alert">
                <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 1 1 1v4h1a1 1 0 1 1 0 2Z"/>
                </svg>
                <div>
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif

    <h1 class="text-center text-4xl font-bold mb-6 dark:text-white mt-4">Annonces</h1>

    <!-- Search form -->
    <div class="mx-2 sm:mx-5 mb-5 w-full sm:w-fit">
        <form action="{{ route('posts.index') }}" method="GET" class="w-full sm:w-96">
            <label for="search" class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">Rechercher une annonce</label>
            <div class="relative">
                <input type="text" id="search" name="search" value="{{ request('search') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pr-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Ex : iPhone 13, Appartement Paris...">
                <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 dark:text-gray-400">
                    🔍
                </button>
            </div>
        </form>
    </div>

    <!-- Create post button -->
    <div class="mx-2 sm:mx-5 mb-5">
        <a href="{{ route('posts.create') }}" class="w-fit text-white bg-blue-500 dark:bg-blue-700 dark:text-white hover:bg-blue-700 dark:hover:bg-blue-500 font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline">
            Créer une annonce
        </a>
    </div>

    <!-- Filters -->
    <div class="flex flex-col gap-5 justify-between mx-2 sm:mx-5" x-data="{ openSort: false }">
        <!-- Category filter -->
        <div x-data="{ openCategory: false }">
            <div class="w-full mt-4">
                <label for="category" class="hidden sm:block text-2xl font-bold dark:text-white">Sélectionner une catégorie</label>
                <select id="category" name="category_id" onchange="location = this.value;"
                    class="w-full sm:w-fit bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-white font-bold py-2 px-4 rounded-lg flex justify-between items-center">
                    
                    <option value="{{ route(name: 'posts.index') }}" {{ request('category') ? '' : 'selected' }}>
                        Toutes les catégories
                    </option>

                    @foreach ($categories as $category)
                        <option value="{{ route('posts.index', ['category' => $category->id]) }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Sort filter -->
        <div class="flex flex-col w-full">
            <h1 class="hidden sm:block text-2xl font-bold dark:text-white mt-2">Trier</h1>
            <div class="relative sm:hidden w-full">
                <button @click="openSort = !openSort" class="w-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-white font-bold py-2 px-4 rounded-lg flex justify-between items-center">
                    Trier par
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="openSort" @click.away="openSort = false" class="absolute mt-2 w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-lg z-10">
                    <a href="{{ route('posts.index', ['sort' => 'latest']) }}" class="block px-2 py-1 text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-600">Les plus récents</a>
                    <a href="{{ route('posts.index', ['sort' => 'oldest']) }}" class="block px-2 py-1 text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-600">Les plus anciens</a>
                    <a href="{{ route('posts.index', ['sort' => 'price_asc']) }}" class="block px-2 py-1 text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-600">Prix croissant</a>
                    <a href="{{ route('posts.index', ['sort' => 'price_desc']) }}" class="block px-2 py-1 text-gray-700 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-600">Prix décroissant</a>
                </div>
            </div>
    
            <div class="hidden sm:flex space-x-4">
                <a href="{{ route('posts.index', ['sort' => 'latest']) }}" class="px-2 py-1 rounded-lg border {{ $sort === 'latest' ? 'bg-blue-500 text-white' : 'border-gray-300 dark:border-gray-700 text-gray-700 dark:text-white' }}">Les plus récents</a>
                <a href="{{ route('posts.index', ['sort' => 'oldest']) }}" class="px-2 py-1 rounded-lg border {{ $sort === 'oldest' ? 'bg-blue-500 text-white' : 'border-gray-300 dark:border-gray-700 text-gray-700 dark:text-white' }}">Les plus anciens</a>
                <a href="{{ route('posts.index', ['sort' => 'price_asc']) }}" class="px-2 py-1 rounded-lg border {{ $sort === 'price_asc' ? 'bg-blue-500 text-white' : 'border-gray-300 dark:border-gray-700 text-gray-700 dark:text-white' }}">Prix croissant</a>
                <a href="{{ route('posts.index', ['sort' => 'price_desc']) }}" class="px-2 py-1 rounded-lg border {{ $sort === 'price_desc' ? 'bg-blue-500 text-white' : 'border-gray-300 dark:border-gray-700 text-gray-700 dark:text-white' }}">Prix décroissant</a>
            </div>
        </div>
    </div>

    <!-- Posts -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 my-5 mx-2 sm:mx-5 pb-5">
        @foreach($posts as $post)
            <a href="{{ route('posts.show', ['post' => $post->id]) }}" class="relative flex md:flex-row w-full gap-2 bg-slate-50 dark:bg-slate-800 p-4 shadow-md dark:shadow-gray-950 rounded-xl">
                @if ($post->images->count() > 0)
                    <div class="min-w-32 w-32 h-32 rounded-md flex items-center justify-center object-cover overflow-hidden">
                        <img src="{{ asset('storage/posts/' . $post->images->first()->url_image) }}" class="rounded-lg" alt="">
                    </div>
                @endif
                <div class="mb-4">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $post->title }}</h2>
                    <p class="text-gray-700 dark:text-gray-400 : md:text-base text-sm">
                        {{ Str::limit($post->description, 100, '...') }}
                    </p>
                </div>
                <div class="absolute bottom-2 right-0 flex flex-row gap-2">
                    <p class="bg-cyan-300 dark:bg-cyan-800 dark:text-white text-sm font-semibold dark:font-medium mr-2 px-2.5 py-0.5 rounded-full">{{ $post->getFormattedPriceAttribute() }}</p>
                </div>
            </a>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mx-2 sm:mx-5">
        {{ $posts->links() }}
    </div>

@endsection