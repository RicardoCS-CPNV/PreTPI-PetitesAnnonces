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
    public function store(SignUpRequest $request)
    {
        // Les données sont validées automatiquement grâce à SignUpRequest
        $validated = $request->validated();


        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'image' => "defaultAvatar.jpg",
        ]);

        if($request->has('image')) {
            $file = $request->file('image');
            $filename = $user->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('avatars'), $filename);

            $user->update(['image' => $filename]);
        }

        Auth::login($user);

        return redirect()->intended(route('home'));
    }
    
    public function login()
    {
        return view('auth.login');
    }

    public function doLogin(LoginRequest $request)
    {
        $credentials = $request->validated();

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }else{
            return to_route('auth.login')->withErrors([
                'email' => 'Email invalide'
            ])->onlyInput('email');
        }
    }

    public function edit(User $user)
    {
        return view('auth.update', compact('user'));
    }

    public function update(UpdateUserRequest $request)
    {
        $validated = $request->validated();
        $modified = false;

        // Cela permet à isDirty() et save() de fonctionner, sans cela, ils ne fonctionneraient pas.
        /**
        * @var \App\Models\User $user
        */
        $user = Auth::user();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Auth::id() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('avatars');
        
            // 🔥 Vérifier si l'utilisateur a déjà une image avant de la supprimer
            if ($user && $user->image && file_exists($destinationPath . '/' . $user->image) && $user->image !== 'defaultAvatar.jpg') {
                unlink($destinationPath . '/' . $user->image);
            }
        
            // 🔥 Déplacer la nouvelle image uniquement si l’upload est valide
            $file->move($destinationPath, $filename);
            $user->update(['image' => $filename]);
        
            $modified = true;
        }
        
        // Mise à jour uniquement si le nom est modifié
        if ($request->input('name') !== $user->name) {
            $user->name = $validated['name'];
            $modified = true;
        }
        
        // Mise à jour uniquement si l'email est modifié
        if ($request->input('email') !== $user->email) {
            $user->email = $validated['email'];
            $modified = true;
        }

        // Vérifier si des changements ont été faits avant de sauvegarder
        if (!$modified && !$user->isDirty()) {
            return back()->with('success', 'Aucune modification détectée.');
        }

        // Sauvegarder les modifications
        $user->save();
        return back()->with('success', 'Votre profil a été mis à jour avec succès.');
    }

    public function logout()
    {
        Auth::logout();
        return to_route('auth.login');
    }

    public function delete(User $user)
    {
        if(asset('avatars/' . $user->image) !== asset('avatars/defaultAvatar.jpg')) {
            Storage::delete('avatars/' . $user->image);
        }
        
        // Delete all posts
        $user->posts()->each(function ($post) {
            // Supprime les images des posts
            foreach ($post->images as $image) {
                Storage::delete('posts/' . $image->url_image);
            }
            $post->delete(); // Supprime le post après ses images
        });
        
        // Delete the user
        $user->delete();
        
        Auth::logout();

        return to_route('auth.login');
    }
}
