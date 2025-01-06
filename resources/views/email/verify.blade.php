<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Verification</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div class="min-h-screen bg-gray-50 flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white rounded-lg shadow-sm border border-gray-100">
            <div class="p-6 space-y-1 border-b border-gray-100">
                <div class="flex justify-center mb-4">
                    <div class="p-3 bg-gray-50 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="16" x="2" y="4" rx="2" />
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                        </svg>
                    </div>
                </div>
                <h2 class="text-2xl font-semibold text-center text-gray-900">{{ __('Verifikasi Email') }}</h2>
            </div>

            <div class="p-6">
                @if (session('message'))
                    <div class="mb-6 bg-gray-50 text-gray-900 px-4 py-3 rounded-lg text-sm text-center" role="alert">
                        {{ session('message') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.send') }}" class="space-y-6">
                    @csrf
                    <div class="space-y-2">
                        <label for="otp" class="text-sm font-medium text-gray-900 block">
                            {{ __('Kode Verifikasi') }}
                        </label>
                        <input id="otp" type="text" name="otp" required maxlength="4" autocomplete="off"
                            placeholder="Masukkan kode verifikasi"
                            class="w-full px-3 py-2 text-center text-lg tracking-widest border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition-colors @error('otp') border-red-500 @enderror">
                        @error('otp')
                            <span class="text-sm text-red-500" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-gray-900 text-white py-2 px-4 rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2 transition-colors">
                        {{ __('Verifikasi') }}
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <form method="POST" action="{{ route('verification.resend') }}" class="inline-block">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2 rounded-md transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                                <path d="M3 3v5h5" />
                                <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16" />
                                <path d="M16 16h5v5" />
                            </svg>
                            {{ __('Kirim ulang kode verifikasi') }}
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
