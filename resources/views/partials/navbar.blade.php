<nav class="bg-blue-600 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-xl font-bold">Sistem Indekos</a>
        <div class="flex items-center space-x-4">
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="hover:underline">Dashboard Admin</a>
                @else
                    <a href="{{ route('user.dashboard') }}" class="hover:underline">Dashboard Saya</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="hover:underline">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hover:underline">Login</a>
                <a href="{{ route('register') }}" class="hover:underline">Register</a>
            @endauth
        </div>
    </div>
</nav>