<div class="flex p-2 bg-black text-gray-300">
    <a href="{{ route('home') }}" class="hover:bg-gray-900 p-3 block">Home</a>

    @if (!Auth::check())
        <a href="{{ route('login') }}" class="hover:bg-gray-900 p-3 block">Login</a>
        <a href="{{ route('register') }}" class="hover:bg-gray-900 p-3 block">Register</a>
    @endif

    {{-- #FIXME need to be removed --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                            this.closest('form').submit();">
            {{ __('Log Out') }}
        </x-responsive-nav-link>

    </form>
</div>
