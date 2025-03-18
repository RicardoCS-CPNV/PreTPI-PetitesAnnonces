<h1 class="text-center text-4xl font-bold mb-6 dark:text-white mt-4">
    @if ($post->id)
            Modifier votre annonce
        @else
            Ajouter une annonce
    @endif
</h1>
<div class="sm:p-4 p-2 flex flex-col justify-center w-full">
    <!-- Post Form -->
    <form action="
        @if ($post->id)
            {{ route('posts.update', ['post' => $post->id]) }}
        @else
            {{ route('posts.create') }}
        @endif
        " method="POST" enctype="multipart/form-data" class="flex justify-center w-full">
        @csrf
        <div class="flex flex-col gap-5 w-[700px]">
            <!-- Category -->
            <div class="w-full">
                <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selectionner une categorie</label>
                <select id="category" name="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="" disabled {{ empty(old('category_id', $post->category_id ?? '')) ? 'selected' : '' }}>
                        Sélectionner une catégorie
                    </option>

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id ?? '') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Title -->
            <div>
                <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Titre</label>
                <input type="text" id="title" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ old('title', $post->title) }}" placeholder="Titre de l'annonce">
                @error('title')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                <textarea id="description" rows="4" name="description" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Insérer une description...">{{ old('description', $post->description) }}</textarea>
                @error('description')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price -->
            <div>
                <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prix (CHF)</label>
                <input type="text" name="price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ old('price', $post->price) }}" placeholder="Prix de l'annonce en CHF">
                @error('price')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="image">Ajouter des images</label>
                <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" name="image[]" multiple aria-describedby="image_help" id="image" type="file">
                @error('image')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tags -->
            <div>
                <label for="tags" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ajouter des tags</label>
                <div x-data="{ 
                        selectedTags: {{ $post->tags->pluck('id')->toJson() }}, 
                        search: '', 
                        showAll: false, 
                        tags: {{ $tags->map(fn($tag) => ['id' => $tag->id, 'name' => $tag->name])->toJson() }} 
                    }">
                    
                    <input type="text"
                        placeholder="Rechercher un tag..."
                        x-model="search"
                        class="w-full px-4 py-2 mb-4 border border-gray-300 rounded-lg dark:bg-gray-800 dark:text-white dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >

                    <div class="flex flex-wrap gap-2">
                        <template x-for="(tag, index) in tags.filter(tag => tag.name.toLowerCase().includes(search.toLowerCase())).slice(0, showAll ? tags.length : 10)" :key="tag.id">
                            <button type="button"
                                    @click="selectedTags.includes(tag.id) ? selectedTags = selectedTags.filter(id => id !== tag.id) : selectedTags.push(tag.id)"
                                    class="px-4 py-2 rounded-full border border-gray-300 text-gray-700 dark:hover:bg-violet-600 hover:bg-violet-200 shadow-md dark:text-white dark:border-gray-600 dark:bg-gray-800 transition-all duration-300"
                                    :class="selectedTags.includes(tag.id) ? 'border-black bg-violet-200 font-bold dark:bg-violet-700' : ''">
                                <span x-text="tag.name"></span>
                            </button>
                        </template>
                    </div>

                    <div class="text-center mt-2" x-show="tags.length > 10">
                        <button type="button" @click="showAll = !showAll" class="text-blue-500 hover:underline">
                            <span x-text="showAll ? 'Voir moins' : 'Voir plus'"></span>
                        </button>
                    </div>

                    <input type="hidden" name="tags" :value="selectedTags.join(',')">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex flex-wrap justify-end">

                <button class="z-10 w-full sm:w-fit text-white bg-blue-500 hover:bg-blue-700 font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline"  id="submitBtn">
                    @if ($post->id)
                            Modifier l'annonce
                        @else
                            Créer l'annonce
                    @endif
                </button>
            </div>
        </div>
    </form>

    <!-- Delete Button -->
    @if ($post->id)
        <div class="flex justify-center">
            <form class="flex mt-4 sm:-mt-10 w-[700px]" action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette annonce ? Cette action est irréversible.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full sm:w-fit text-white bg-red-500 hover:bg-red-700 font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline">
                    Supprimer l'annonce
                </button>
            </form>
        </div>
    @endif
</div>