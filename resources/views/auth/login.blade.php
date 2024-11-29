<x-app-layout>

    <div class="flex items-center justify-center bg-gray-100 min-h-[50rem]">
        <div class="w-full max-w-xl p-8 space-y-8 border border-black rounded-lg shadow-sm">
            <div>
                <h2 class="mt-6 text-3xl font-extrabold text-center text-gray-900">
                    {{ __('Login ke Akunmu') }}
                </h2>
            </div>

            @if (session('status'))
                <div class="mb-4 text-sm font-medium text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="-space-y-px rounded-md shadow-sm">
                    <div>
                        <label for="email" class="sr-only">{{ __('Email') }}</label>
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-black focus:border-black focus:z-10 sm:text-sm @error('email') border-red-500 @enderror"
                            placeholder="{{ __('Email') }}" value="{{ old('email') }}">
                    </div>
                    <div>
                        <label for="password" class="sr-only">{{ __('Password') }}</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-black focus:border-black focus:z-10 sm:text-sm @error('password') border-red-500 @enderror"
                            placeholder="{{ __('Password') }}">
                    </div>
                </div>

                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <div>
                    <button type="submit"
                        class="relative flex justify-center w-full px-4 py-2 text-sm font-medium text-black  border border-black rounded-md group ">
                        {{ __('Sign in') }}
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    {{ __("Don't have an account?") }}
                    <a href="{{ route('register') }}" class="font-medium text-black hover:text-indigo-500">
                        {{ __('Sign up') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
