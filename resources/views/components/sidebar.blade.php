<aside class="flex min-h-screen ">
    <div class="fixed top-0 bottom-0 left-0 z-40 w-[18rem] ">
        <div class="pb-4 text-center pt-[2rem] pr-6 dark:border-gray-700">
            <h1 class="text-xl font-bold text-gray-800 dark:text-white"> StudyStacks </h1>
        </div>
        <nav class="p-4 text-lg px-28">
            <ul class="space-y-3">
                <x-link-dash :active="request()->routeIs('dashboard')" href="{{ route('dashboard') }}">
                    Dashboard
                </x-link-dash>
                <x-link-dash :active="request()->routeIs('kategori.index')" href="{{ route('kategori.index') }}">
                    Kategori
                </x-link-dash>
                <x-link-dash :active="request()->routeIs('buku.index')" href="{{ route('buku.index') }}">
                    Buku
                </x-link-dash>
                <x-link-dash :active="request()->routeIs('denda.index')" href="{{ route('denda.index') }}">
                    Denda
                </x-link-dash>
                @if (auth()->user()->isAdmin())
                    <x-link-dash :active="request()->routeIs('user.index')" href="{{ route('user.index') }}">
                        User
                    </x-link-dash>
                @endif
                <x-link-dash :active="request()->routeIs('activity.index')" href="{{ route('activity.index') }}">
                    Activity
                </x-link-dash>
                <x-link-dash :active="request()->routeIs('laporan.index')" href="{{ route('laporan.index') }}">
                    Laporan
                </x-link-dash>
                <x-link-dash :active="request()->routeIs('peminjaman.index')" href="{{ route('peminjaman.index') }}">
                    Peminjaman
                </x-link-dash>
            </ul>
        </nav>
    </div>

    <div class="flex-1 ml-72">
        <header class="">
            <div class="flex items-center justify-end px-6 pt-7">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center text-gray-600 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-200">
                            <span class="text-sm font-medium">{{ Auth::user()->Username }}</span>
                            <svg class="w-4 h-4 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left">
                                <x-dropdown-link>
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </button>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </header>

        <main class="p-6">
            @if (isset($header))
                <div class="mb-6">
                    {{ $header }}
                </div>
            @endif
            {{ $slot }}
        </main>
    </div>
</aside>
