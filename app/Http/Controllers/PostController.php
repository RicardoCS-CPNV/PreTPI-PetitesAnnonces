<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\Tag;
use Carbon\Traits\Timestamp;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::paginate(30);
    
        return view('posts.index', [
            'posts' => $posts,
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
            'published_at' => now(),
        ]);
    
        // Associate if tags exist
        if ($request->has('tags')) {
            $tags = explode(',', $request->input('tags')); // Transformer la chaîne en tableau
            $post->tags()->sync($tags); // Associer les tags avec `sync()`
        }

        if ($request->hasFile('image')) {
            $files = $request->file('image');
            foreach ($files as $file) {
                $timestamp = Carbon::now()->format('Ymd_His_u');
                $filename = $post->id . '_' . $timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                $post->images()->create([
                    'url_image' => $filename,
                    'post_id' => $post->id
                ]);

                $file->storeAs('posts', $filename, 'public');
            }
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
            'post' => $post,
            'price' => $post->getFormattedPriceAttribute(),
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
            'updated_at' => now(),
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

        if ($request->hasFile('image')) {
            $files = $request->file('image');
            foreach ($files as $file) {
                $timestamp = Carbon::now()->format('Ymd_His_u');
                $filename = $post->id . '_' . $timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                $post->images()->create([
                    'url_image' => $filename,
                    'post_id' => $post->id
                ]);

                $file->storeAs('posts', $filename, 'public');
            }
        }

    
        return redirect()->route('posts.show', $post->id)->with('success', "L'annonce a bien été mise à jour.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            return back()->with('error', "Vous n'avez pas l'autorisation de supprimer cette annonce.");
        }
    
        // Supprimer les images associées (si tu en as)
        // foreach ($post->images as $image) {
        //     Storage::disk('public')->delete($image->image_path);
        // }
    
        // Supprimer l'annonce
        $post->delete();

        return redirect()->route('posts.index')->with('success', "L'annonce a été supprimée.");
    }
}
