@extends('base')

@section('title', 'Update')

@section("content")
    <div class="flex flex-col items-center gap-4 min-h-screen justify-center">
        <h1 class="text-4xl font-bold text-blue-500">Edit Profile</h1>

        <div class="w-full max-w-xs">
            <form method="POST" action="{{ route('auth.update') }}" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf

                @if (session('success'))
                    <div class="alert alert-success" role="alert" class="text-danger">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-4" >
                    <div class="mb-3 col-md-6">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name: </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" id="name" name="name" value="{{ auth()->user()->name }}" autofocus="" >
                        @error('name')
                            <span role="alert" class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

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
                <div class="mb-4">
                    <h2 class="block text-gray-700 text-sm font-bold mb-2">Profile picture:</h2>

                    <div class="mb-3 col-md-6 flex justify-around items-center">
                        <img src="avatars/{{ auth()->user()->image }}" class="w-20 h-20 rounded-full">
                        <input class="hidden" type="file" id="image" name="image" value="{{ auth()->user()->image }}" autofocus="" value="{{ old('file') }}">
                        <label for="image" class="h-10 bg-blue-500 hover:bg-blue-700 text-red font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Choose a file</label>
                    </div>
                    @error('image')
                        {{ $message }}
                    @enderror
                </div>
                <div class="mb-4">
                    <div class="mb-3 col-md-6">
                        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password: </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="password" id="password" name="password" autofocus="" >
                        @error('password')
                            <span role="alert" class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="confirm_password" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password: </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="password" id="confirm_password" name="confirm_password" autofocus="" >
                        @error('confirm_password')
                            <span role="alert" class="text-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div>
                    <div class="col-md-12 offset-md-5">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-red font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            {{ __('Upload Profile') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection