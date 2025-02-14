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

        if($request->has('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('avatars'), $filename);
            $validated['image'] = $filename;
        }

        $user = User::where('id', Auth::user()->id)->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            // 'image' => $validated['image']
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function logout()
    {
        Auth::logout();
        return to_route('auth.login');
    }
}
