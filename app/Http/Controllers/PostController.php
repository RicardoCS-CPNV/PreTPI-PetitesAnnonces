<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Carbon\Traits\Timestamp;
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
        // if(!Auth::check()){
        //     return redirect()->route('auth.login');
        // }

        $post = new Post();
        return view('posts.create', [
            'post' => $post,
            'categories' => Category::all(),
            'tags' => Tag::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        // Validate Data
        $validatedData = $request->validated();

        // Create the post
        $post = Post::create([
            'user_id' => Auth::user()->id,
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'category_id' => $validatedData['category_id'],
            'price' => $validatedData['price'],
            'slug' => Str::slug($validatedData['title']),
        ]);
    
        // Associate if tags exist
        if ($request->has('tags')) {
            $tags = explode(',', $request->input('tags')); // Transformer la chaîne en tableau
            $post->tags()->sync($tags); // Associer les tags avec `sync()`
        }
    
        // Redirect to the post's page
        return redirect()->route('posts.show', $post->id)->with('success', "L'annonce a bien été créée.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post )
    {
        return view('posts.create', [
            'post' => $post->load('tags', 'category'),
            'categories' => Category::all(),
            'tags' => Tag::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        // Validation des données
        $validatedData = $request->validated();
    
        // Mise à jour des informations du post
        $post->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'category_id' => $validatedData['category_id'],
            'price' => $validatedData['price'],
            'slug' => Str::slug($validatedData['title']),
        ]);
    
        // Vérifier si des tags ont été envoyés
        if ($request->has('tags')) {
            $newTags = explode(',', $request->input('tags'));
            $currentTags = $post->tags()->pluck('tags.id')->toArray(); // Get the current tags from the post

            // Mettre à jour uniquement si les tags ont changé
            if ($newTags !== $currentTags) {
                $post->tags()->sync($newTags);
            }
        }
    
        return redirect()->route('posts.show', $post->id)->with('success', "L'annonce a bien été mise à jour.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
