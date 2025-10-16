    <aside id="sidebar"
        class="fixed top-0 left-0 h-full w-64 bg-gold text-white flex flex-col justify-between transition-all duration-300 z-50">
        <div>
            <div class="p-6 text-2xl font-bold flex justify-center  border-white/20">
                <img src="{{ asset('assets/images/whitelogo.svg') }}" class="w-32">
            </div>
            <nav class="mt-6 space-y-1 px-6">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-6 py-2 font-normal text-base transition {{ request()->routeIs('admin.dashboard') ? 'bg-brand rounded-lg' : '' }}">
                    Dashboard <span class="text-xs"> (Overview)</span>
                </a>

                <a href="{{ route('admin.add_rto') }}"
                    class="flex items-center px-6 py-2 font-normal text-base transition {{ request()->routeIs('admin.add_rto') ? 'bg-brand rounded-lg' : '' }}">
                    RTO
                </a>

                <a href="{{ route('admin.students') }}"
                    class="flex items-center px-6 py-2 font-normal text-base transition {{ request()->routeIs('admin.students*') ? 'bg-brand rounded-lg' : '' }}">
                    Students
                </a>
                <a href="{{ route('admin.courses') }}"
                    class="flex items-center px-6 py-2 font-normal text-base transition {{ request()->routeIs('admin.courses*') ? 'bg-brand rounded-lg' : '' }}">
                    Courses
                </a>
                <a href="{{ route('admin.Industries') }}"
                    class="flex items-center px-6 py-2 font-normal text-base transition {{ request()->routeIs('admin.Industries*') ? 'bg-brand rounded-lg' : '' }}">
                    Industries
                </a>
                <a href="{{ route('admin.Coordinator') }}"
                    class="flex items-center px-6 py-2 font-normal text-base transition {{ request()->routeIs('admin.Coordinator*') ? 'bg-brand rounded-lg' : '' }}">
                    Coordinator
                </a>

                <!-- Create Users -->
                <a href="{{ route('admin.create-users') }}"
                    class="flex items-center px-6 py-2 font-normal text-base transition {{ request()->routeIs('admin.create-users*') ? 'bg-brand rounded-lg' : '' }}">
                    Create Users
                </a>

                <!-- Role & Permission Management -->
                <a href="{{ route('admin.roles') }}"
                    class="flex items-center px-6 py-2 font-normal text-base transition {{ request()->routeIs('admin.roles*') ? 'bg-brand rounded-lg' : '' }}">
                    Roles
                </a>
                <a href="{{ route('admin.permissions') }}"
                    class="flex items-center px-6 py-2 font-normal text-base transition {{ request()->routeIs('admin.permissions*') ? 'bg-brand rounded-lg' : '' }}">
                    Permissions
                </a>
                <a href="{{ route('admin.assign-permissions') }}"
                    class="flex items-center px-6 py-2 font-normal text-base transition {{ request()->routeIs('admin.assign-permissions*') ? 'bg-brand rounded-lg' : '' }}">
                    Assign Permissions
                </a>

                <a href="#"
                    class="flex items-center px-6 py-2 font-normal text-base hover:bg-brand/20 transition">
                    Settings
                </a>
            </nav>

        </div>
        {{-- <button class="m-6 py-2 border border-brand text-brand rounded-md hover:bg-brand hover:text-white transition">
            Logout
        </button> --}}
    </aside>
