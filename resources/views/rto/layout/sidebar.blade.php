<aside id="sidebar"
    class="fixed top-0 left-0 h-full w-64 bg-gold text-white flex flex-col justify-between transition-all duration-300 z-50">
    <div>
        <div class="p-6 text-2xl font-bold flex justify-center border-white/20">
            <img src="{{ asset('assets/images/whitelogo.svg') }}" class="w-32">
        </div>
        <nav class="mt-6 space-y-1 px-6">
            <a href="{{ route('rto.dashboard') }}"
                class="flex items-center px-6 py-2 font-normal text-base transition {{ request()->routeIs('rto.dashboard') ? 'bg-brand rounded-lg' : '' }}">
                Dashboard <span class="text-xs"> (Overview)</span>
            </a>

            <a href="{{ route('rto.students') }}"
                class="flex items-center px-6 py-2 font-normal text-base transition {{ request()->routeIs('rto.students*') ? 'bg-brand rounded-lg' : '' }}">
                Students
            </a>

            <a href="/profile"
                class="flex items-center px-6 py-2 font-normal text-base transition {{ request()->is('profile') ? 'bg-brand rounded-lg' : '' }}">
                Profile
            </a>

            {{-- <a href="#"
                class="flex items-center px-6 py-2 font-normal text-base hover:bg-brand/20 transition">
                Settings
            </a> --}}
        </nav>
    </div>
</aside>
