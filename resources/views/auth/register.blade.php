<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-100 to-indigo-300 px-4">
        <div class="max-w-5xl w-full bg-white shadow-2xl rounded-2xl overflow-hidden flex flex-col md:flex-row">
            
            <!-- Bagian Kiri: Logo + ilustrasi / welcome -->
            <div class="md:w-1/2 bg-indigo-600 text-white p-8 flex flex-col justify-center items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Sikosan" class="w-56 mb-6">
                <h2 class="text-3xl font-bold mb-4 text-center">Daftar Akun Baru</h2>
                <p class="text-indigo-100 text-center text-lg">
                    Kelola bisnis indekos Anda dengan mudah. Sistem terintegrasi untuk manajemen kamar, penghuni, dan keuangan.
                </p>
            </div>

            <!-- Bagian Kanan: Form registrasi -->
            <div class="md:w-1/2 p-8">
                <h3 class="text-2xl font-semibold text-gray-700 mb-6 text-center">Isi data Anda untuk mendaftar</h3>

                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-center">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-center">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-gray-600 font-medium mb-1">Nama Lengkap</label>
                        <input type="text" name="name" id="name" 
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-200 focus:ring-2 focus:border-indigo-500 p-3 @error('name') border-red-500 @enderror"
                               value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-600 font-medium mb-1">Email</label>
                        <input type="email" name="email" id="email" 
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-200 focus:ring-2 focus:border-indigo-500 p-3 @error('email') border-red-500 @enderror"
                               value="{{ old('email') }}" placeholder="contoh@email.com" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="no_telepon" class="block text-gray-600 font-medium mb-1">Nomor Telepon</label>
                        <input type="text" name="no_telepon" id="no_telepon" 
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-200 focus:ring-2 focus:border-indigo-500 p-3 @error('no_telepon') border-red-500 @enderror"
                               value="{{ old('no_telepon') }}" placeholder="08xxxxxxxxxx" required>
                        @error('no_telepon')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="alamat" class="block text-gray-600 font-medium mb-1">Alamat</label>
                        <textarea name="alamat" id="alamat" rows="3" 
                                  class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-200 focus:ring-2 focus:border-indigo-500 p-3 @error('alamat') border-red-500 @enderror"
                                  placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-gray-600 font-medium mb-1">Kata Sandi</label>
                        <input type="password" name="password" id="password" 
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-200 focus:ring-2 focus:border-indigo-500 p-3 @error('password') border-red-500 @enderror"
                               placeholder="Minimal 8 karakter" required>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-gray-600 font-medium mb-1">Konfirmasi Kata Sandi</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-200 focus:ring-2 focus:border-indigo-500 p-3"
                               placeholder="Ulangi kata sandi" required>
                    </div>

                    <button type="submit" class="w-full py-3 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-semibold transition duration-300">
                        Daftar Sekarang
                    </button>

                    <p class="mt-4 text-center text-gray-500">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-medium underline">Masuk di sini</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
