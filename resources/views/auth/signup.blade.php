@extends("base")

@section('title', 'Sign Up')

@section("content")

    <div class="flex flex-col items-center gap-4 min-h-screen justify-center">
        <h1 class="text-4xl font-bold text-blue-500">S'inscrire</h1>
    
        <div class="w-full max-w-xs">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="{{ route('auth.signup') }}" method="post">
                <!-- Add @csrf for security. -->
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name:</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="name" name="name" placeholder="Type your name" value="{{ old('name') }}">
                    @error('name')
                        {{ $message }}
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email:</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="email" name="email" placeholder="Type your email">
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
                    <button class="bg-blue-500 hover:bg-blue-700 text-red font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" id="submitBtn">Créer</button>
                    <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('auth.login') }}">
                        Se connecter
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection