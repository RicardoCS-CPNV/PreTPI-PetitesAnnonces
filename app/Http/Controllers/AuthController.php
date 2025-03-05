<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function store(SignUpRequest $request)
    {
        // Les données sont validées automatiquement grâce à SignUpRequest
        $validated = $request->validated();

        if($request->has('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('avatars'), $filename);
            $validated['image'] = $filename;
        }else{
            $validated['image'] = "defaultAvatar.jpg";
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'image' => $validated['image'],
        ]);

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

        // Cela permet à isDirty() et save() de fonctionner, sans cela, ils ne fonctionneraient pas.
        /**
        * @var \App\Models\User $user
        */
        $user = Auth::user();

        if($request->has('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $validated['image'] = $filename;
            $user->image = $validated['image'];
        }
        
        // Mise à jour uniquement si le nom est modifié
        if ($request->input('name') !== $user->name) {
            $user->name = $validated['name'];
        }
        
        // Mise à jour uniquement si l'email est modifié
        if ($request->input('email') !== $user->email) {
            $user->email = $validated['email'];
        }
        
        // Vérifier si des changements ont été faits avant de sauvegarder
        if (!$user->isDirty()) {
            return back()->with('success', 'Aucune modification détectée.');
        }
        
        // Sauvegarder les modifications
        $user->save();
        $file->move(public_path('avatars'), $filename);
        
        return back()->with('success', 'Profile updated successfully.');
    }

    public function logout()
    {
        Auth::logout();
        return to_route('auth.login');
    }
}
