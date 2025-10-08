<header class="bg-blue-600 text-white flex items-center justify-between px-4 py-3">
    <div class="flex items-center">
        {{-- Tombol toggle sidebar --}}
        <button id="sidebarToggle" class="mr-3">
            ☰
        </button>
    </div>

    <div class="relative" x-data="{ open: false }">
        {{-- Trigger dropdown --}}
        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
            <img src="https://i.pravatar.cc/40" alt="User" class="rounded-full w-8 h-8">
            <span>{{ Auth::user()->name ?? 'User' }}</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        {{-- Dropdown menu --}}
        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-40 bg-white text-black rounded shadow-lg z-10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-red-500 hover:text-white rounded">
                    Logout
                </button>
            </form>
        </div>
    </div>
</header>