<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    // Stores a new user in the database
    public function store(SignUpRequest $request)
    {
        // Validate the request
        $validated = $request->validated();

        // Create the user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'image' => "defaultAvatar.jpg",
        ]);

        // Upload the avatar
        if($request->has('image')) {
            $file = $request->file('image');
            $filename = $user->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('avatars'), $filename);

            $user->update(['image' => $filename]);
        }

        // Login the user
        Auth::login($user);

        // Redirect to the home page
        return redirect()->intended(route('home'));
    }
    
    // Displays the login form
    public function login()
    {
        return view('auth.login');
    }

    // Handles the login request
    public function doLogin(LoginRequest $request)
    {
        // Validate the request
        $credentials = $request->validated();

        // Attempt to authenticate the user
        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }else{
            return to_route('auth.login')->withErrors([
                'email' => 'Email invalide'
            ])->onlyInput('email');
        }
    }

    // Displays the update form
    public function edit(User $user)
    {
        // Compact the user variable and send it to the view
        return view('auth.update', compact('user'));
    }

    // Handles the update request
    public function update(UpdateUserRequest $request)
    {
        // Validate the request
        $validated = $request->validated();
        $modified = false; // Variable to check if the user has been modified

        // For isDirty() and save()
        /**
        * @var \App\Models\User $user
        */

        // Get the authenticated user
        $user = Auth::user();

        // Upload the avatar
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Auth::id() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('avatars');
        
            // Check if the user already has an image
            if ($user && $user->image && file_exists($destinationPath . '/' . $user->image) && $user->image !== 'defaultAvatar.jpg') {
                // Delete the old image
                unlink($destinationPath . '/' . $user->image);
            }
        
            // Move the uploaded file to the destination
            $file->move($destinationPath, $filename);

            // Update the user's image
            $user->update(['image' => $filename]);
        
            $modified = true;
        }
        
        // Upload the user name only if it has changed
        if ($request->input('name') !== $user->name) {
            $user->name = $validated['name'];
            $modified = true;
        }
        
        // Upload the user email only if it has changed
        if ($request->input('email') !== $user->email) {
            $user->email = $validated['email'];
            $modified = true;
        }

        // Check if the user has been modified
        if (!$modified && !$user->isDirty()) {
            return back()->with('success', 'Aucune modification détectée.');
        }

        // Save the user
        $user->save();

        return back()->with('success', 'Votre profil a été mis à jour avec succès.');
    }

    // Logs the user out
    public function logout()
    {
        // Logout the user
        Auth::logout();
        return to_route('auth.login');
    }

    // Deletes the user
    public function delete(User $user)
    {
        // Check if the user has an avatar and not the default avatar
        if(asset('avatars/' . $user->image) !== asset('avatars/defaultAvatar.jpg')) {
            // Delete the avatar
            Storage::delete('avatars/' . $user->image);
        }
        
        // Delete all posts
        $user->posts()->each(function ($post) {
            // Delete linked images
            foreach ($post->images as $image) {
                Storage::delete('posts/' . $image->url_image);
            }
            $post->delete(); // Delete the post
        });
        
        // Delete the user
        $user->delete();
        
        // Logout the user
        Auth::logout();

        return to_route('auth.login');
    }
}
