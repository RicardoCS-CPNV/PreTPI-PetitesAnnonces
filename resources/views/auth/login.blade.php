@extends('base')

@section('title', 'Login')

@section("content")

    <div class="flex flex-col items-center gap-4 min-h-screen justify-center">
        <h1 class="text-4xl font-bold text-blue-500">Se connecter</h1>

        <div class="w-full max-w-xs">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="{{ route('auth.login') }}" method="post">
                <!-- Add @csrf for security. -->
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email:</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="email" name="email" placeholder="Email" value="{{ old('email') }}">
                    @error('email')
                        {{ $message }}
                    @enderror
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password:</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="password" id="password" name="password" placeholder="**********">
                    @error('password')
                            {{ $message }}
                    @enderror
                </div>
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