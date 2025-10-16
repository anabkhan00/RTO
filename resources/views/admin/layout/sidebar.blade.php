    <aside id="sidebar"
        class="fixed top-0 left-0 h-full w-64 bg-gold text-white flex flex-col justify-between transition-all duration-300 z-50">
        <div>
            <div class="p-6 text-2xl font-bold flex justify-center  border-white/20">
                <img src="{{ asset('assets/images/whitelogo.svg') }}" class="w-32">
            </div>
        <nav class="mt-6 space-y-1 px-6">
    <a href="{{ route('admin.pages.dashboard') }}"
       class="flex items-center px-6 py-2 font-normal text-base transition {{ request()->routeIs('admin.pages.dashboard') ? 'bg-brand rounded-lg' : '' }}">
        Dashboard <span class="text-xs"> (Overview)</span>
    </a>

    <a href="{{ route('admin.pages.add_rto') }}"
       class="flex items-center px-6 py-2 font-normal text-base transition {{ request()->routeIs('admin.pages.add_rto') ? 'bg-brand rounded-lg' : '' }}">
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
    <a href="#"
       class="flex items-center px-6 py-2 font-normal text-base hover:bg-brand/20 transition">
        Settings
    </a>
</nav>

        </div>
        <button class="m-6 py-2 border border-brand text-brand rounded-md hover:bg-brand hover:text-white transition">
            Logout
        </button>
    </aside>