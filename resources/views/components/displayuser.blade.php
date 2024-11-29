@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 shadow rounded-lg p-4 ' . $class]) }}>
    @auth
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
            Welcome, {{ auth()->user()->name }}!
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
            It's great to see you again.
        </p>
    @else
        <p class="text-lg text-gray-600 dark:text-gray-300">
            Welcome, Guest!
        </p>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
            Please <a href="{{ route('login') }}" class="text-blue-600 hover:underline dark:text-blue-400">log in</a> to see personalized content.
        </p>
    @endauth
</div>
