<div class="flex p-2 bg-black text-gray-300 justify-between">
    <a href="{{ route('home') }}" class="hover:bg-gray-900 p-3 block">Home</a>
    <div class="flex space-x-4">
        @if (!Auth::check())
            <a href="{{ route('login') }}" class="hover:bg-gray-900 p-3 block">Login</a>
            <a href="{{ route('register') }}" class="hover:bg-gray-900 p-3 block">Register</a>

        @else
            {{-- #FIXME need to be removed --}}
            @if (Auth::user()->role === 'instructor')
                <a href="{{ route('dashboard') }}" class="hover:bg-gray-900 p-3 block">Dashboard</a>
            @else
                <form method="POST" action="{{ route('be.in') }}">
                    @csrf
                    <a href="{{ route('be.in') }}" class="hover:bg-gray-900 p-3 block" onclick="event.preventDefault();
                this.closest('form').submit();" class="hover:bg-gray-900 p-3 block">Be Instructor</a>

                </form>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                    this.closest('form').submit();" class="hover:bg-gray-900 p-3 block">Log Out</a>

            </form>
        @endif
    </div>


</div>
