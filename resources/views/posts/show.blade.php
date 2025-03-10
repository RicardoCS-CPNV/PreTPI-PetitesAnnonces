@extends('base')

@section('title', 'Post')

@php
    $image = 0;
@endphp

@section('content')

    <div class="p-1 sm:p-5 w-full flex justify-center">
        <div class="relative flex flex-col max-w-5xl w-full gap-2 bg-slate-50 dark:bg-slate-800 p-5 shadow-md dark:shadow-gray-950 rounded-xl">
            <div class="mb-3 flex flex-col gap-1">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $post->title }}</h1>
                <h2 class="w-fit bg-cyan-300 dark:bg-cyan-800 dark:text-white text-md font-semibold dark:font-medium mr-2 px-2.5 py-0.5 rounded-full">{{ $post->price }}</h2>
                <h3 class="text-gray-700 dark:text-gray-400">{{ $post->category->name }}</h3>
                <h3 class="text-gray-700 dark:text-gray-400">Publié le {{ $post->created_at->format('d.m.Y') . " à " . $post->created_at->format('H:i') . ' par ' . $post->user->name}}</h3>
            </div>
            <div class="flex sm:flex-row gap-5 flex-col mb-3">
                @if ($image)
                <div class="flex flex-col gap-4">
                    <div class="min-w-32 w-32 h-32 sm:min-w-64 sm:w-64 sm:h-64 bg-black flex items-center justify-center object-cover overflow-hidden">
                        <img src="avatars/1740487941.webp" alt="">
                    </div>
                    @if ($post->tags->isNotEmpty())
                        <div>
                            <ul class="flex gap-2">
                                @foreach ($post->tags as $tag)
                                    <li class="text-sm text-slate-700 dark:text-slate-200 bg-slate-200 dark:bg-slate-700 w-fit rounded-full px-2 py-0.5">{{ $tag->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                @endif
                <div>
                    <p class="text-black dark:text-gray-300 text-justify">
                        {{ $post->description }} <br><br>
                        <p class="text-black dark:text-gray-300 text-justify">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Veritatis officiis ullam minus beatae qui in aut tempore modi facilis! Fugit voluptas expedita perferendis ducimus accusamus voluptatem est consequatur assumenda qui.
                        Quos sequi nulla odio voluptates animi dolorum illo voluptate itaque vero quam, soluta totam laboriosam quis nesciunt saepe quaerat eveniet eaque nam, qui, eum iste at? Nam distinctio facere fugit.
                        Optio quidem beatae aspernatur. Officiis consectetur natus fugit recusandae, doloremque veritatis omnis! Est cum fugit porro obcaecati saepe ipsa nam qui nulla aut! Repellendus saepe ad nisi itaque temporibus magni.</p>
                    </p>
                </div>
            </div>
            @if (!$image && $post->tags->isNotEmpty())
                        <div>
                            <ul class="flex gap-2">
                                @foreach ($post->tags as $tag)
                                    <li class="text-sm text-slate-700 dark:text-slate-200 bg-slate-200 dark:bg-slate-700 w-fit rounded-full px-2 py-0.5">{{ $tag->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

            @if (Auth::user() == $post->user)
            <div class="flex justify-end">
                <a href="{{ route('posts.edit', parameters: [$post->id]) }}" class=" w-fit bg-blue-500 hover:bg-blue-700 font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline"  id="submitBtn">Modifier l'annonce</a>
            </div>
            @endif
        </div>
    </div>

@endsection