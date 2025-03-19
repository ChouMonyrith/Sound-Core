<nav class="bg-gray-900 text-white py-4 shadow-md">
    <div class="container mx-auto px-6 flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="text-2xl font-bold text-white">SoundCore</a>

        <!-- Navigation Links -->
        <div class="hidden md:flex space-x-6">
            <a href="{{ route('sounds.index') }}" class="hover:text-gray-400">Sounds</a>
            <a href="{{ route('sounds.create') }}" class="hover:text-gray-400">Upload</a>
            <a href="{{ route('about') }}" class="hover:text-gray-400">About</a>
        </div>

        <!-- Authentication Links -->
        <div>
            @auth
                <span class="text-gray-300 mr-4">Welcome, {{ Auth::user()->name }}</span>
                <a href="{{ route('logout') }}" 
                   class="bg-red-500 px-4 py-2 rounded hover:bg-red-600 transition"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                   Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            @else
                <a href="{{ route('login') }}" class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600 transition">Login</a>
            @endauth
        </div>

        <!-- Mobile Menu Button -->
        <button id="mobile-menu-btn" class="md:hidden text-white focus:outline-none">
            <i class="fa-solid fa-bars text-2xl"></i>
        </button>
    </div>
</nav>
