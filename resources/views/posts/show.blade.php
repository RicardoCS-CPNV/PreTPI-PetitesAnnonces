@extends('base')

@section('title', 'Post')

@section('content')

<div class="flex flex-col w-full items-center px-2 sm:px-5 my-1 sm:mt-4 sm:my-0">
    @if(session('success'))
    <div class="flex items-center w-full sm:w-fit p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
        </svg>
        <div>
            {{ session('success') }}
        </div>
    </div>
    @endif

    <div class="max-w-5xl w-full">
        <a href="{{ route('posts.index') }}" class="flex justify-center items-center bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-800 hover:bg-gray-200 text-gray-800 p-2 w-fit rounded-full border-gray-400 shadow">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-gray-800 dark:text-white">
                <path d="M15.75 19.5a.75.75 0 01-1.06 0L6.47 11.28a1 1 0 010-1.41l8.22-8.22a.75.75 0 011.06 1.06L7.94 10.5l7.81 7.81a.75.75 0 010 1.06z" />
            </svg>
        </a>
    </div>
</div>

<div class="p-1 sm:p-5 w-full flex flex-col items-center">

    <div class="relative flex flex-col max-w-5xl w-full gap-2 bg-slate-50 dark:bg-slate-800 p-5 shadow-md dark:shadow-gray-950 rounded-xl">
        <div class="mb-3 flex flex-col gap-1">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $post->title }}</h1>
            <h2 class="w-fit bg-cyan-300 dark:bg-cyan-800 dark:text-white text-md font-semibold dark:font-medium mr-2 px-2.5 py-0.5 rounded-full">{{ $price }}</h2>
            <h3 class="text-gray-700 dark:text-gray-400">{{ $post->category->name }}</h3>
            <h3 class="text-gray-700 dark:text-gray-400">Publié le {{ $post->created_at->format('d.m.Y') . " à " . $post->created_at->format('H:i') . ' par ' . $post->user->name}}</h3>
        </div>
        <div class="flex sm:flex-row gap-5 flex-col mb-3">
            @if ($post->images->count() > 0)
                <div class="flex flex-col">

                    <div id="controls-carousel" class="relative w-full max-w-md mx-auto" data-carousel="static">
                        <!-- Carousel wrapper -->
                        <div class="relative min-w-32 w-full h-80 sm:min-w-64 sm:w-64 sm:min-h-64 sm:h-64  overflow-hidden rounded-lg">
                            @foreach ($post->images as $index => $image)
                                <div class="duration-700 ease-in-out" data-carousel-item="{{ $loop->first ? 'active' : '' }}">
                                    <img src="{{ asset('storage/posts/' . $image->url_image) }}" 
                                        class="absolute block w-full h-full object-cover -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                        alt="Image {{ $index + 1 }}">
                                </div>
                            @endforeach
                        </div>

                        @if ($post->images->count() > 1)
                            <div class="h-full absolute top-0 start-0 flex items-center justify-center">
                                <button type="button" class="z-30 flex items-center justify-center h-fit px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-300/50 group-hover:bg-white/50 dark:group-hover:bg-gray-600/60 group-focus:ring-4 group-focus:ring-gray-300 dark:group-focus:ring-gray-600/70 group-focus:outline-none">
                                        <svg class="w-4 h-4 text-black rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                                        </svg>
                                        <span class="sr-only">Previous</span>
                                    </span>
                                </button>
                            </div>

                            <div class="h-full absolute top-0 end-0 flex items-center justify-center">
                                <button type="button" class="z-30 flex items-center justify-center h-fit px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-300/50 group-hover:bg-white/50 dark:group-hover:bg-gray-600/60 group-focus:ring-4 group-focus:ring-gray-300 dark:group-focus:ring-gray-600/70 group-focus:outline-none">
                                        <svg class="w-4 h-4 text-black rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                        </svg>
                                        <span class="sr-only">Next</span>
                                    </span>
                                </button>
                            </div>
                        @endif

                    </div>

                    @if ($post->tags->isNotEmpty())
                        <div class="mt-2">
                            <ul class="flex flex-wrap gap-2">
                                @foreach ($post->tags as $tag)
                                    <li class="text-sm text-slate-700 dark:text-slate-200 bg-slate-200 dark:bg-slate-700 w-fit rounded-full px-2 py-0.5">{{ $tag->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                </div>
            @endif
            <p class="text-black dark:text-gray-300 text-justify">
                {{ $post->description }} <br><br>
            </p>
        </div>
        @if ($post->images->count() <= 0 && $post->tags->isNotEmpty())
            <div>
                <ul class="flex flex-wrap gap-2">
                    @foreach ($post->tags as $tag)
                    <li class="text-sm text-slate-700 dark:text-slate-200 bg-slate-200 dark:bg-slate-700 w-fit rounded-full px-2 py-0.5">{{ $tag->name }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (Auth::user() == $post->user)
            <div class="flex justify-end">
                <a href="{{ route('posts.edit', parameters: [$post->id]) }}" class=" w-fit bg-blue-500 hover:bg-blue-700 font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline" id="submitBtn">Modifier l'annonce</a>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const carouselItems = document.querySelectorAll('[data-carousel-item]');
        let activeIndex = 0;

        function showSlide(index) {
            carouselItems.forEach((item, i) => {
                item.classList.toggle('hidden', i !== index);
            });
        }

        document.querySelector('[data-carousel-prev]').addEventListener('click', function() {
            activeIndex = (activeIndex === 0) ? carouselItems.length - 1 : activeIndex - 1;
            showSlide(activeIndex);
        });

        document.querySelector('[data-carousel-next]').addEventListener('click', function() {
            activeIndex = (activeIndex + 1) % carouselItems.length;
            showSlide(activeIndex);
        });

        showSlide(activeIndex);
    });
</script>

@endsection