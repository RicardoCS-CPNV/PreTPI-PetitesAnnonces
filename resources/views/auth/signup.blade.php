@extends("base")

@section('title', 'Sign Up')
@if (Auth::check())

    <script>window.location.href = "{{ route('home') }}";</script>

@endif
@section("content")

    <div class="flex flex-col items-center gap-4 min-h-screen justify-center">
        <h1 class="text-4xl font-bold text-blue-500">S'inscrire</h1>
    
        <div class="w-full max-w-xs">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="{{ route('auth.signup') }}" method="post" enctype="multipart/form-data">
                <!-- Add @csrf for security. -->
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-1" for="name">Name:</label>
                    <input class="w-full py-2 px-3 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" id="name" name="name" placeholder="Type your name" value="{{ old('name') }}">
                    @error('name')
                        {{ $message }}
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-1" for="email">Email:</label>
                    <input class="w-full py-2 px-3 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" id="email" name="email" placeholder="Type your email" value="{{ old('email') }}">
                    @error('email')
                        {{ $message }}
                    @enderror
                </div>

                <div class="mb-4">
                    <h2 class="block text-gray-700 text-sm font-bold mb-1">Profile picture:</h2>
                    
                    <div class="mb-3 col-md-6 flex justify-around items-center">
                        <img id="preview" src="{{ asset('avatars/defaultAvatar.jpg') }}" class="w-20 h-20 rounded-full object-cover">
                        <input class="hidden" type="file" id="image" name="image" accept="image/*">
                        <label for="image" class="h-10 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Choose a file
                        </label>

                        @error('image')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6 relative flex-1 col-span-4" x-data="{ show: true }">
                    <label class="block text-gray-700 text-sm font-bold mb-1" for="password">Password:</label>
                    <input  class="w-full py-2 px-3 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            id="password"
                            :type="show ? 'password' : 'text'"
                            name="password"
                            placeholder="**********"
                            autocomplete="new-password" />
            
                    <button type="button" class="flex absolute top-1/2 right-0 items-center pr-3" @click="show = !show" :class="{'hidden': !show, 'block': show }">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    </button>
                    <button type="button" class="flex absolute top-1/2 right-0 items-center pr-3" @click="show = !show" :class="{'block': !show, 'hidden': show }">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                    </button>
                    @error('password')
                        {{ $message }}
                    @enderror
                </div>

                <div class="mb-6 relative flex-1 col-span-4" x-data="{ show: true }">
                    <label class="block text-gray-700 text-sm font-bold mb-1" for="password_confirm">Confirm Password:</label>
                    <input  class="w-full py-2 px-3 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            id="password_confirm"
                            :type="show ? 'password' : 'text'"
                            name="password_confirm"
                            placeholder="**********" />
            
                    <button type="button" class="flex absolute top-1/2 right-0 items-center pr-3" @click="show = !show" :class="{'hidden': !show, 'block': show }">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    </button>
                    <button type="button" class="flex absolute top-1/2 right-0 items-center pr-3" @click="show = !show" :class="{'block': !show, 'hidden': show }">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                    </button>
                    @error('password_confirm')
                        {{ $message }}
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="submit"
                            id="submitBtn">
                        S'inscrire
                    </button>
                    <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('auth.login') }}">
                        Se connecter
                    </a>
                </div>

            </form>
        </div>
    </div>

    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            let file = event.target.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection