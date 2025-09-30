<header class="bg-blue-600 text-white flex items-center justify-between px-4 py-3">
    <div class="flex items-center">
        {{-- Tombol toggle sidebar --}}
        <button id="sidebarToggle" class="mr-3">
            ☰
        </button>
    </div>

    <div class="flex items-center space-x-2">
        <img src="https://i.pravatar.cc/40" alt="User" class="rounded-full w-8 h-8">
        <span>{{ Auth::user()->name ?? 'User' }}</span>
    </div>
</header>
