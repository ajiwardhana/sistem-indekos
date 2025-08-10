@auth
    @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard Admin</a>
    @else
        <a href="{{ route('user.dashboard') }}" class="nav-link">Dashboard</a>
    @endif
@endauth