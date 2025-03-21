@extends('base')

@section('title', 'Login')

@if (Auth::check())

    <script>window.location.href = "{{ route('home') }}";</script>

@endif
@section("content")

    <!-- Name and Logo -->
    <div class="absolute w-full flex flex-col items-center h-full p-10 gap-3 sm:gap-5 -z-50">
        <img src="{{ asset('OdraPlace_Logo.png') }}" alt="OdraPlace Logo" class="w-16 h-16 sm:w-32 sm:h-32">
        <h1 class="text-5xl sm:text-6xl font-bold text-blue-500">Odra<span class="text-black">Place</span></h1>
    </div>
    
    <!-- Login Form -->
    <div class="flex flex-col items-center gap-4 min-h-screen justify-center">
        <h1 class="text-4xl font-bold text-blue-500">Se connecter</h1>

        <div class="w-full max-w-xs">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="{{ route('auth.login') }}" method="post">
                <!-- Add @csrf for security. -->
                @csrf
                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email:</label>
                    <input class="w-full py-2 px-3 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" id="email" name="email" placeholder="Email" value="{{ old('email') }}">
                    @error('email')
                        {{ $message }}
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6 relative flex-1 col-span-4" x-data="{ show: true }">
                    <label class="block text-gray-700 text-sm font-bold mb-1" for="password">Mot de passe :</label>
                    <input  class="w-full py-2 px-3 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            id="password"
                            :type="show ? 'password' : 'text'"
                            name="password"
                            placeholder="**********"
                            autocomplete="new-password" />
            
                    <button type="button" class="flex absolute top-1/2 right-0 items-center pr-3" @click="show = !show" :class="{'hidden': !show, 'block': show }">
                        <!-- Heroicon name: eye -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                    <button type="button" class="flex absolute top-1/2 right-0 items-center pr-3" @click="show = !show" :class="{'block': !show, 'hidden': show }">
                        <!-- Heroicon name: eye-slash -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                    @error('password')
                        {{ $message }}
                    @enderror
                </div>

                <!-- Submit Button and Signup -->
                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-700 text-red font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"  id="submitBtn">Connexion</button>
                    <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('auth.signup') }}">
                        S'inscrire
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection