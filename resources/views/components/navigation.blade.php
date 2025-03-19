<nav x-data="{ open: false }" class="bg-gray-900 border-2  text-white shadow-lg">
    <div class=" mx-auto max-w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="text-2xl  font-bold text-white hover:text-gray-300 transition">
                    soundcore
                </a>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:ml-10 sm:flex">
                    <a href="{{ route('dashboard') }}" class="hover:text-gray-400 transition">Dashboard</a>
                    <a href="{{ route('sounds.index') }}" class="hover:text-gray-400 transition">Sounds</a>
                    <a href="{{ route('sounds.create') }}" class="hover:text-gray-400 transition">Upload</a>
                </div>
            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:flex sm:items-center">
                @auth
                    <div class="relative">
                        <button @click="open = !open" class="flex items-center space-x-2 text-white focus:outline-none">
                            <span class="font-medium">{{ Auth::user()->name }}</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open" class="absolute right-0 mt-2 w-48 bg-white text-gray-800 shadow-md rounded-md py-2 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="bg-blue-600 px-4 py-2 rounded hover:bg-blue-700 transition">Login</a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <button @click="open = ! open" class="sm:hidden text-white focus:outline-none">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" class="sm:hidden bg-gray-800">
        <a href="{{ route('dashboard') }}" class="block py-2 px-4 text-gray-300 hover:bg-gray-700">Dashboard</a>
        <a href="{{ route('sounds.index') }}" class="block py-2 px-4 text-gray-300 hover:bg-gray-700">Sounds</a>
        <a href="{{ route('sounds.create') }}" class="block py-2 px-4 text-gray-300 hover:bg-gray-700">Upload</a>
        
        @auth
            <a href="{{ route('profile.edit') }}" class="block py-2 px-4 text-gray-300 hover:bg-gray-700">Profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left py-2 px-4 text-gray-300 hover:bg-gray-700">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="block py-2 px-4 text-gray-300 hover:bg-gray-700">Login</a>
        @endauth
    </div>
</nav>
