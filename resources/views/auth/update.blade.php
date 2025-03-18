@extends('base')

@section('title', 'Update')

@section("content")
    <div class="flex flex-col items-center gap-4 justify-center flex-1">
        <div class="flex w-full max-w-max">
            <a href="{{ route('home') }}" class="flex items-center pr-[1px] ease-in-out transition-all hover:bg-gray-100 rounded-full">
                <svg class="text-gray-500 hover:text-blue-500 ease-in-out transition-all" xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
            </a>
            <h1 class="flex justify-center text-4xl font-bold text-blue-500 w-96 max-w-80">Edit Profile</h1>
        </div>

        <div class="w-full max-w-max">
            <!-- Update Form -->
            <form method="POST" action="{{ route('auth.update') }}" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 ">
                @csrf

                @if (session('success'))
                    <div class="alert alert-success" role="alert" class="text-danger">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-4" >
                    <!-- Name -->
                    <div class="mb-3 col-md-6">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name: </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="name" name="name" value="{{ auth()->user()->name }}" autofocus="" >
                        @error('name')
                            <span role="alert" class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3 col-md-6">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email: </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="email" name="email" value="{{ auth()->user()->email }}" autofocus="" >
                        @error('email')
                            <span role="alert" class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <!-- Image -->
                <div>
                    <h2 class="block text-gray-700 text-sm font-bold mb-2">Profile picture:</h2>

                    <div class="col-md-1 flex flex-wrap items-center justify-between gap-4">
                        <input class="hidden" type="file" id="image" name="image">
                        <label for="image" class="flex items-center gap-1 h-10 bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:shadow-outline cursor-pointer">
                            Choose a file
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/>
                                <polyline points="7 9 12 4 17 9"/>
                                <line x1="12" y1="4" x2="12" y2="16"/>
                            </svg>
                        </label>

                        <img id="preview" src="{{ asset('avatars/' . auth()->user()->image) }}" class="w-20 h-20 rounded-full object-cover border border-gray-300">
                    </div>

                    @error('image')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-between items-center">
                    <div class="col-md-12 offset-md-5">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-5 rounded focus:outline-none focus:shadow-outline">
                            {{ __('Upload Profile') }}
                        </button>
                    </div>
                </div>
            </form>

            <!-- Delete Account -->
            <form action="{{  route('auth.delete', auth()->user()->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer votre compte ? Cette action est irréversible.');">
                <div class="flex flex-wrap justify-center w-full mt-5 gap-4">
                    @csrf
                    @method('DELETE')
                    <div class="hover:text-blue-500 cursor-pointer">
                        <a href="#">Mot de passe oublié ?</a>
                    </div>
                    <div class="text-red-500 font-bold hover:text-red-900 cursor-pointer">
                        <button type="submit">Supprimer le compte</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Script for the Image Preview -->
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