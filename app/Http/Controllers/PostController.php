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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the sorting criterion and category from the user request
        $sort = $request->query('sort', 'latest');
        $categoryId = $request->query('category');
        $search = $request->query('search');

        // Build the request
        $query = Post::query();

        // Apply the category filter
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // Apply the search if there is one
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Apply the sort
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'oldest':
                $query->oldest();
                break;
            default:
                $query->latest();
                break;
        }

        // Apply the pagination
        $posts = $query->paginate(30);

        // Send to the view
        return view('posts.index', [
            'posts' => $posts,
            'sort' => $sort, 
            'categories' => Category::all(),
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check if the user is logged
        if(!Auth::check()){
            return redirect()->route('auth.login');
        }

        // Create the post
        $post = new Post();

        // Send to the view
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

        // Upload images if any
        if ($request->hasFile('image')) {
            $files = $request->file('image');
            foreach ($files as $file) {
                $timestamp = Carbon::now()->format('Ymd_His_u');
                $filename = $post->id . '_' . $timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // Create the image
                $post->images()->create([
                    'url_image' => $filename,
                    'post_id' => $post->id
                ]);

                // Upload the image on the storage
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
        // Check if the post belongs to the user
        if (Auth::id() !== $post->user_id) {
            if (!Auth::check()) {
                return redirect()->route('auth.login');
            }
            return redirect()->route('home')->with('error', "Vous n'avez pas l'autorisation de modifier cette annonce.");
        }
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
        // Validate Data
        $validatedData = $request->validated();
    
        // Update the post
        $post->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'category_id' => $validatedData['category_id'],
            'price' => $validatedData['price'],
            'slug' => Str::slug($validatedData['title']),
            'updated_at' => now(),
        ]);
    
        // Update if tags exist
        if ($request->has('tags')) {
            $newTags = explode(',', $request->input('tags'));
            $currentTags = $post->tags()->pluck('tags.id')->toArray(); // Get the current tags from the post

            // Check if the new tags are different from the current tags
            if ($newTags !== $currentTags) {
                $post->tags()->sync($newTags);
            }
        }

        // Delete linked images
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
        // Check if the post belongs to the user
        if (Auth::id() !== $post->user_id) {
            return back()->with('error', "Vous n'avez pas l'autorisation de supprimer cette annonce.");
        }
    
        // Delete linked images
        foreach ($post->images as $image) {
            Storage::delete('posts/' . $image->url_image);
        }
    
        // Delete Post
        $post->delete();

        return redirect()->route('posts.index')->with('success', "L'annonce a été supprimée.");
    }
}
