<x-dashboard-layout>

    <div class="container mx-auto max-w-7xl px-4 py-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div class="mb-4 sm:mb-0">
                <h2 class="text-2xl font-semibold"> Selamat datang di Dashboard <span
                        class="underline font-extrabold">{{ Auth::user()->Username }}!</span></h2>
                <p class="mt-1"> {{ Carbon\Carbon::now()->format('d M Y, H:i') }} </p>
            </div>
        </div>

        <div class="grid grid-cols-2 ">
            <div class="rounded-lg bg-zinc-700 text-white  p-8 mx-2">
                <div class="relative">
                    <div class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-7">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <span class="mx-2 font-bold text-lg">{{ $Fadly_user->count() }}</span>
                    </div>

                    <p class="text-sm pt-2">
                        user terverifikasi
                    </p>
                </div>
            </div>
            <div class="rounded-lg bg-zinc-700 text-white  p-8 mx-2">
                <div class="relative">
                    <div class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-7">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>

                        <span class="mx-2 font-bold text-lg">
                            {{ $Fadly_buku->count() }}
                        </span>

                    </div>

                    <p class="text-sm pt-2">
                        buku tersedia
                    </p>
                </div>
            </div>

        </div>

    </div>

</x-dashboard-layout>
