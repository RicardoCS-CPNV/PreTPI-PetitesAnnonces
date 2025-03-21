<!DOCTYPE html>
<html lang="en" x-data="{ dark: localStorage.getItem('darkMode') === 'enabled' }" x-bind:class="{ 'dark': dark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/js/bootstrap.js')
    @livewireStyles
    
    <title>@yield('title')</title>
</head>
<body class="flex flex-col h-screen dark:bg-gray-900">
    @if (!request()->routeIs('auth.login') && !request()->routeIs('auth.signup'))
        <header class="h-16">
            <!-- Navbar -->
            <nav class="bg-white border-gray-200 px-4 lg:px-6 py-2.5 dark:bg-gray-800">
                <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl" x-data="{ open: false }" x-data="{ open: localStorage.getItem('open') === 'enabled' }">
                    <!-- Name and Logo -->
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ asset('OdraPlace_Logo.png') }}" class="mr-3 h-6 sm:h-9" alt="OdraPlace Logo" />
                        <span class="hidden sm:block self-center text-xl font-semibold whitespace-nowrap text-blue-500" id="sitename">Odra<span class="text-black dark:text-white">Place</span></span>
                    </a>

                    <!-- Mobile menu button -->
                    <div class="flex items-center lg:order-2" >
                        @if (Auth::check())
                            <div class="flex items-center gap-2">
                                <a href="{{ route('auth.update') }}" class="flex col-md-6 gap-2 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-600 cursor-pointer px-2 py-1 rounded-full">
                                    <p class="dark:text-white">{{ Auth::user()->name }}</p>
                                    <img src="{{ asset('avatars/' . auth()->user()->image) }}" class="w-6 h-6 rounded-full object-cover">
                                </a>
                                <form action="{{ route('auth.logout') }}" method="post" class="flex">
                                    @method("delete")
                                    @csrf
                                    <button class="hover:text-blue-950 transition-all"><svg class="h-5 w-5 text-red-500 mr-2"  xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />  <polyline points="16 17 21 12 16 7" />  <line x1="21" y1="12" x2="9" y2="12" /></svg></button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('auth.login') }}" class="text-gray-800 dark:text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">Se connecter</a>
                            <a href="{{ route('auth.signup') }}" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">S'inscrire</a>
                        @endif

                        <button @click="dark = !dark; localStorage.setItem('darkMode', dark ? 'enabled' : 'disabled')" class="inline-block p-1 dark:hover:bg-blue-800 hover:bg-blue-200 dark:hover:text-white rounded-full">
                            <svg x-show="dark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="text-white h-7" fill="currentColor"><path d="M12 21.9967C6.47715 21.9967 2 17.5196 2 11.9967C2 6.47386 6.47715 1.9967 12 1.9967C17.5228 1.9967 22 6.47386 22 11.9967C22 17.5196 17.5228 21.9967 12 21.9967ZM12 19.9967C16.4183 19.9967 20 16.415 20 11.9967C20 7.57843 16.4183 3.9967 12 3.9967C7.58172 3.9967 4 7.57843 4 11.9967C4 16.415 7.58172 19.9967 12 19.9967ZM7.00035 15.316C9.07995 15.1646 11.117 14.2939 12.7071 12.7038C14.2972 11.1137 15.1679 9.07666 15.3193 6.99706C15.6454 7.21408 15.955 7.46642 16.2426 7.75406C18.5858 10.0972 18.5858 13.8962 16.2426 16.2393C13.8995 18.5825 10.1005 18.5825 7.75736 16.2393C7.46971 15.9517 7.21738 15.6421 7.00035 15.316Z"></path></svg>
                            <svg x-show="!dark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-7" fill="currentColor"><path d="M12 21.9967C6.47715 21.9967 2 17.5196 2 11.9967C2 6.47386 6.47715 1.9967 12 1.9967C17.5228 1.9967 22 6.47386 22 11.9967C22 17.5196 17.5228 21.9967 12 21.9967ZM5.32889 16.422C6.76378 18.5675 9.20868 19.9803 11.9836 19.9803C16.4018 19.9803 19.9836 16.3985 19.9836 11.9803C19.9836 9.2053 18.5707 6.76034 16.4251 5.32547C17.2705 8.35324 16.5025 11.7369 14.1213 14.1181C11.7401 16.4993 8.3566 17.2672 5.32889 16.422Z"></path></svg>
                        </button>

                        <button @click="open = !open"
                                class="sm:inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                aria-controls="mobile-menu-2"
                                :aria-expanded="open.toString()">
                            <span class="sr-only">Open main menu</span>
                            <svg x-show="!open" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                            <svg x-show="open" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>

                    <!-- Mobile menu -->
                    <div :class="open ? 'inline-block' : 'hidden'" class="absolute z-50 lg:relative lg:top-0 lg:right-0 top-12 right-5 bg-white dark:bg-gray-800 border-border-gray-100 dark:border-white z-10 justify-between items-center w-100 lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
                        <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                            <li>
                                <a href="{{ route('home') }}"
                                class="block py-2 pr-4 pl-3 rounded {{ Request::is('/') ? 'bg-primary-700 text-white lg:dark:text-blue-700 font-bold lg:bg-transparent lg:text-primary-700' : 'text-gray-700 hover:bg-gray-50 dark:hover:bg-blue-900 lg:hover:bg-transparent dark:lg:hover:bg-transparent lg:hover:text-primary-700' }} dark:text-white"
                                aria-current="{{ Request::is('/') ? 'page' : 'false' }}">
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('posts.index') }}"
                                class="block py-2 pr-4 pl-3 rounded {{ Request::is('posts*') ? 'bg-primary-700 text-white lg:dark:text-blue-700 font-bold lg:bg-transparent lg:text-primary-700' : 'text-gray-700 hover:bg-gray-50 dark:hover:bg-blue-900 lg:hover:bg-transparent dark:lg:hover:bg-transparent lg:hover:text-primary-700' }} dark:text-white"
                                aria-current="{{ Request::is('posts*') ? 'page' : 'false' }}">
                                    Annonces
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('auth.update') }}"
                                class="block py-2 pr-4 pl-3 rounded {{ Request::is('profile') ? 'bg-primary-700 text-white lg:dark:text-blue-700 font-bold lg:bg-transparent lg:text-primary-700' : 'text-gray-700 hover:bg-gray-50 dark:hover:bg-blue-900 lg:hover:bg-transparent dark:lg:hover:bg-transparent lg:hover:text-primary-700' }} dark:text-white"
                                aria-current="{{ Request::is('profile') ? 'page' : 'false' }}">
                                    Mon profil
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('home') }}"
                                class="block py-2 pr-4 pl-3 rounded {{ Request::is('team') ? 'bg-primary-700 text-white lg:dark:text-blue-700 font-bold lg:bg-transparent lg:text-primary-700' : 'text-gray-700 hover:bg-gray-50 dark:hover:bg-blue-900 lg:hover:bg-transparent dark:lg:hover:bg-transparent lg:hover:text-primary-700' }} dark:text-white"
                                aria-current="{{ Request::is('team') ? 'page' : 'false' }}">
                                    Team
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('home') }}"
                                class="block py-2 pr-4 pl-3 rounded {{ Request::is('contact') ? 'bg-primary-700 text-white lg:dark:text-blue-700 font-bold lg:bg-transparent lg:text-primary-700' : 'text-gray-700 hover:bg-gray-50 dark:hover:bg-blue-900 lg:hover:bg-transparent dark:lg:hover:bg-transparent lg:hover:text-primary-700' }} dark:text-white"
                                aria-current="{{ Request::is('contact') ? 'page' : 'false' }}">
                                    Contact
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
    @endif
    @yield('content')
    @livewireScripts
</body>
<style>
    @media screen and (max-width: 405px) {
        #sitename {
            display: none;
        }   
    }
</style>
</html>