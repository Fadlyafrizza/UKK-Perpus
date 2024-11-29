<nav class="bg-white border-b border-gray-200 shadow-sm dark:bg-gray-800 dark:border-gray-700">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <a href="{{ url('/') }}" class="flex items-center">
                        <span class="ml-2 text-xl font-semibold text-gray-800 dark:text-white">
                            StudyStacks
                        </span>
                    </a>
                </div>

                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        Home
                    </x-nav-link>
                    <x-nav-link :href="route('list.index')" :active="request()->routeIs('list.index')">
                        Peminjaman
                    </x-nav-link>
                    <x-nav-link :href="route('koleksi.index')" :active="request()->routeIs('koleksi.index')">
                        Koleksi Buku
                    </x-nav-link>
                </div>
            </div>
            <div class="flex items-center">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center text-sm font-medium text-gray-700 transition duration-150 ease-in-out dark:text-gray-300 hover:text-gray-900 dark:hover:text-white focus:outline-none">
                                <span>{{ auth()->user()->Username }}</span>
                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">

                            @if (auth()->user()->hasRole())
                                <x-dropdown-link href="{{ url('/dashboard') }}">
                                    Dashboard
                                </x-dropdown-link>
                            @endif


                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    this.closest('form').submit();">
                                    Logout
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center space-x-4">
                        <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                            Login
                        </x-nav-link>
                        @if (Route::has('register'))
                            <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                                Register
                            </x-nav-link>
                        @endif
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
