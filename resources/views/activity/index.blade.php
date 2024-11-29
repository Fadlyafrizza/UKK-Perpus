<x-dashboard-layout>
    <div class="container mx-auto max-w-7xl px-4 py-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div class="mb-4 sm:mb-0">
                <h2 class="text-2xl font-semibold">
                    Aktivitas Petugas
                </h2>
                <p class="text-sm mt-1">
                    Menampilkan <span id="activityCount">{{ $Fadly_logAktifitas->flatten()->count() }}</span> aktivitas
                </p>
            </div>

            <div class="relative w-full sm:w-64">
                <input type="text" id="searchInput" name="search" placeholder="Cari aktivitas..."
                    class="w-full px-4 py-2 pl-10 border rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300" />
                <svg class="absolute w-5 h-5 left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                    </path>
                </svg>
            </div>
        </div>

        @foreach ($Fadly_logAktifitas as $aksi => $activities)
            <div class="mb-8 activity-group" data-aksi="{{ $aksi }}">
                <h3 class="text-xl font-semibold mb-4">{{ ucfirst($aksi) }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($activities as $Fadly_activity)
                        <div class="activity-card border rounded-lg shadow-sm transition-all duration-200 hover:shadow-md bg-white"
                            id="activity-{{ $Fadly_activity->id }}" data-aksi="{{ $aksi }}">
                            <div class="p-4 border-b">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <span class="text-sm font-extrabold">
                                            {{ $loop->parent->iteration }}.{{ $loop->iteration }}
                                        </span>
                                        <span class="font-medium text-sm text-slate-600">
                                            {{ $Fadly_activity->user->Username ?? 'User Dihapus' }}
                                        </span>
                                    </div>
                                    <div class="flex flex-col items-end space-y-1">
                                        <span class="text-xs text-slate-500">
                                            {{ $Fadly_activity->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4">
                                <div class="activity-details mt-4 space-y-3">
                                    @foreach ($Fadly_activity->detail as $key => $value)
                                        @if (!in_array($key, ['image', 'Login', 'Logout']))
                                            <div class="flex flex-col justify-between sm:flex-row sm:items-center pb-2">
                                                <span class="text-sm font-medium min-w-[120px]">
                                                    {{ ucfirst($key) }}
                                                </span>
                                                <span class="text-sm mt-1 sm:mt-0">
                                                    {{ Str::limit($value, 20) }}
                                                </span>
                                            </div>
                                        @endif
                                    @endforeach
                                    @if (array_intersect(['Login', 'Logout'], array_keys($Fadly_activity->detail)))
                                        <div class="flex flex-col justify-between sm:flex-row sm:items-center pb-2">
                                            @if (!empty($Fadly_activity->detail['Login']))
                                                <span class="text-sm font-medium min-w-[120px]">
                                                    Login
                                                </span>
                                                <span class="text-sm mt-1 sm:mt-0">
                                                    {{ \Carbon\Carbon::parse($Fadly_activity->detail['Login'])->diffForHumans() }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex flex-col justify-between sm:flex-row sm:items-center pb-2">
                                            @if (!empty($Fadly_activity->detail['Logout']))
                                                <span class="text-sm font-medium min-w-[120px]">
                                                    Logout
                                                </span>
                                                <span class="text-sm mt-1 sm:mt-0">
                                                    {{ \Carbon\Carbon::parse($Fadly_activity->detail['Logout'])->diffForHumans() }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif

                                    @if (!empty($Fadly_activity->detail['image']))
                                        <div class="flex items-center justify-between pb-2">
                                            <span class="text-sm font-medium min-w-[120px]">Image</span>
                                            <img src="{{ asset('images/' . $Fadly_activity->detail['image']) }}"
                                                alt="Book Image" class="w-16 h-16 object-cover rounded">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</x-dashboard-layout>
