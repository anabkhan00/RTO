    <aside id="sidebar"
        class="fixed top-0 left-0 h-full w-64 bg-gold text-brand flex flex-col justify-between transition-all duration-300 z-50">
        <div>
            <div class="p-6 text-2xl font-bold flex justify-center  border-white/20">
                <img src="{{ asset('assets/images/whitelogo-1.svg') }}" class="w-32">
            </div>
            <nav class="mt-2 space-y-1 px-6">
                <a href="{{ route('rto.dashboard') }}"
                    class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('rto.dashboard') ? 'bg-brand rounded-lg text-white' : '' }}">
                    Dashboard
                </a>

                <a href="{{ route('rto.students') }}"
                    class="flex items-center px-6 py-2 font-medium text-sm transition
        {{ request()->routeIs('rto.students*') || request()->routeIs('rto.student-documents*')
            ? 'bg-brand rounded-lg text-white'
            : '' }}">
                    Students
                </a>

                <a href="{{ route('rto.my-documents') }}"
                    class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('rto.my-documents*') ? 'bg-brand rounded-lg text-white' : '' }}">
                    Documents
                </a>

                <a href="{{ route('rto.contracts') }}"
                    class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('rto.contracts*') ? 'bg-brand rounded-lg text-white' : '' }}">
                    Contracts
                </a>

                <a href="/profile"
                    class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->is('profile') ? 'bg-brand rounded-lg text-white' : '' }}">
                    Settings
                </a>
            </nav>

        </div>
        {{-- <button class="m-6 py-2 border border-brand text-brand rounded-md hover:bg-brand hover:text-white transition">
            Logout
        </button> --}}
    </aside>
