<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-100 to-indigo-300 px-4">
        <div class="max-w-4xl w-full bg-white shadow-2xl rounded-2xl overflow-hidden flex flex-col md:flex-row">
            
            <!-- Bagian Kiri (Logo + Welcome) -->
            <div class="md:w-1/2 bg-indigo-600 text-white p-8 flex flex-col justify-center items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Sikosan" class="w-56 mb-6">
                <h2 class="text-3xl font-bold mb-4">Selamat Datang di Sikosan</h2>
                <p class="text-indigo-100 text-center text-lg">
                    Kelola bisnis indekos Anda dengan mudah. Sistem terintegrasi untuk manajemen kamar, penghuni, dan keuangan.
                </p>
            </div>

            <!-- Bagian Kanan (Form Login) -->
            <div class="md:w-1/2 p-8">
                <h3 class="text-2xl font-semibold text-gray-700 mb-6 text-center">Login ke Akun Anda</h3>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Email')" class="text-gray-600 font-medium" />
                        <x-text-input id="email" class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-sm" />
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Password')" class="text-gray-600 font-medium" />
                        <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between mb-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-indigo-600 hover:text-indigo-800 underline" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <x-primary-button class="w-full py-3 text-lg font-semibold rounded-lg bg-indigo-600 hover:bg-indigo-700 transition duration-300">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>
                </form>

                <p class="mt-6 text-center text-gray-500">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800 font-medium underline">Daftar Sekarang</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
