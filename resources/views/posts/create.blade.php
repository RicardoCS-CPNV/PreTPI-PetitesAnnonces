@extends('base')

@section('title', 'Post')

@section('content')



    <h1 class="text-center text-4xl font-bold mb-6 dark:text-white mt-4">Ajouter une annonce</h1>
    <div class="sm:p-6 p-2 flex justify-center w-full">
        <form action="{{ route('posts.create') }}" method="POST" enctype="multipart/form-data" class="flex justify-center w-full">
            @csrf
            <div class="mb-6 flex flex-col gap-5 w-96">
                <div class="w-full">
                    <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selectionner une categorie</label>
                    <select id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @foreach ($categories as $category)
                            <option value="">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Titre</label>
                    <input type="text" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Titre de l'annonce">
                    @error('title')
                        {{ $message }}
                    @enderror
                </div>

                <div>
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                    <textarea id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Insérer une description..."></textarea>
                    @error('description')
                        {{ $message }}
                    @enderror
                </div>

                <div>
                    <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prix (CHF)</label>
                    <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Prix de l'annonce en CHF">
                    @error('price')
                        {{ $message }}
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="user_avatar">Upload file</label>
                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="user_avatar" type="file">
                    @error('image')
                        {{ $message }}
                    @enderror
                </div>

                <div>
                    <fieldset>
                        <div class="flex items-center mb-4">
                            <input id="country-option-1" type="radio" name="countries" value="USA" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600" checked>
                            <label for="country-option-1" class="block ms-2  text-sm font-medium text-gray-900 dark:text-gray-300">
                            United States
                            </label>
                        </div>
                    </fieldset>
                </div>
            </div>
        </form>
    </div>
@endsection