<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $post = new Post();
        return view('posts.create', [
            'post' => $post,
            'tags' => Tag::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $post)
    {
        $post->validated();

        Post::create([
            'user_id' => Auth::user()->id,
            'title' => $post->title,
            'description' => $post->description,
            'category_id' => $post->category_id,
            'price' => $post->price,
            // 'slug' => Str::slug($post->id . '-' . $post->title),
        ]);

        dd($post->all());

        // return redirect()->route('posts.show', ['slug' => $post->slug, 'post' => $post->id])->with('success', "L'article a bien été sauvegardé");
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post ,string $slug)
    {
        if($post->slug != $slug){
            return to_route('posts.show', ['slug' => $post->slug, 'id' => $post->id]);
        }

        return view('posts.show', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
