    <aside id="sidebar"
        class="fixed top-0 left-0 h-full w-64 bg-gold text-brand flex flex-col justify-between transition-all duration-300 z-50">
        <div>
            <div class="p-6 text-2xl font-bold flex justify-center  border-white/20">
                <img src="{{ asset('assets/images/whitelogo.svg') }}" class="w-32">
            </div>
            <nav class="mt-2 space-y-1 px-6">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('admin.dashboard') ? 'bg-brand rounded-lg text-white' : '' }}">
                    Dashboard <span class="text-xs"> (Overview)</span>
                </a>

                <a href="{{ route('admin.add_rto') }}"
                    class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('admin.add_rto') ? 'bg-brand rounded-lg text-white' : '' }}">
                    RTO
                </a>

                <a href="{{ route('admin.students') }}"
                    class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('admin.students*') || request()->routeIs('admin.student-documents*')
            ? 'bg-brand rounded-lg text-white'
            : '' }}">
                    Students
                </a>
                <a href="{{ route('admin.courses') }}"
                    class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('admin.courses*') ? 'bg-brand rounded-lg text-white' : '' }}">
                    Courses
                </a>
                <a href="{{ route('admin.Industries') }}"
                    class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('admin.Industries*') ? 'bg-brand rounded-lg text-white' : '' }}">
                    Industries
                </a>
                <a href="{{ route('admin.Coordinator') }}"
                    class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('admin.Coordinator*') ? 'bg-brand rounded-lg text-white' : '' }}">
                    Coordinator
                </a>

                <!-- Create Users -->
                {{-- <a href="{{ route('admin.create-users') }}"
                    class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('admin.create-users*') ? 'bg-brand rounded-lg text-white' : '' }}">
                    Create Users
                </a> --}}

                <!-- Role & Permission Management -->
                <a href="{{ route('admin.roles') }}"
                    class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('admin.roles*') ? 'bg-brand rounded-lg text-white' : '' }}">
                    Roles
                </a>
                <a href="{{ route('admin.permissions') }}"
                    class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('admin.permissions*') ? 'bg-brand rounded-lg text-white' : '' }}">
                    Permissions
                </a>
                <a href="{{ route('admin.assign-permissions') }}"
                    class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('admin.assign-permissions*') ? 'bg-brand rounded-lg text-white' : '' }}">
                    Assign Permissions
                </a>

                <a href="{{ route('admin.document-checklist') }}"
                    class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('admin.document-checklist*') ? 'bg-brand rounded-lg text-white' : '' }}">
                    Document Checklist
                </a>

                <a href="{{ route('admin.contracts') }}"
                    class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('admin.contracts*') ? 'bg-brand rounded-lg text-white' : '' }}">
                    Contracts
                </a>

                <a href="/profile"
                    class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->is('profile') ? 'bg-brand rounded-lg text-white' : '' }}">
                    Profile
                </a>

                {{-- <a href="#"
                    class="flex items-center px-6 py-2 font-medium text-sm hover:bg-brand/20 transition">
                    Settings
                </a> --}}
            </nav>

        </div>
        <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>

        <button onclick="event.preventDefault(); document.getElementById('logoutForm').submit();"
            class="m-6 py-2 border border-brand text-brand rounded-md hover:bg-brand hover:text-white transition">
            Logout
        </button>

    </aside>
