    <aside id="sidebar"
        class="fixed top-0 left-0 h-full w-64 bg-gold text-brand flex flex-col justify-between transition-all duration-300 z-50">
        <div>
            <div class="p-6 text-2xl font-bold flex justify-center  border-white/20">
                <img src="{{ asset('assets/images/whitelogo.svg') }}" class="w-32">
            </div>
            <nav class="mt-2 space-y-1 px-6">
                @can('dashboard.view')
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('admin.dashboard') ? 'bg-brand rounded-lg text-white' : '' }}">
                        Dashboard
                    </a>
                @endcan

                @can('rtos.view')
                    <a href="{{ route('admin.rtos') }}"
                        class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('admin.rtos*') ? 'bg-brand rounded-lg text-white' : '' }}">
                        RTOs
                    </a>
                @endcan

                @can('courses.view')
                    <a href="{{ route('admin.courses') }}"
                        class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('admin.courses*') ? 'bg-brand rounded-lg text-white' : '' }}">
                        Courses
                    </a>
                @endcan

                @can('coordinators.view')
                    <a href="{{ route('admin.coordinators') }}"
                        class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('admin.coordinators*') ? 'bg-brand rounded-lg text-white' : '' }}">
                        Coordinators
                    </a>
                @endcan

                @can('roles.view')
                    <a href="{{ route('admin.roles') }}"
                        class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('admin.roles*') ? 'bg-brand rounded-lg text-white' : '' }}">
                        Roles
                    </a>
                @endcan

                @can('permissions.view')
                    <a href="{{ route('admin.permissions') }}"
                        class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('admin.permissions*') ? 'bg-brand rounded-lg text-white' : '' }}">
                        Permissions
                    </a>
                @endcan

                @can('permissions.assign')
                    <a href="{{ route('admin.assign-permissions') }}"
                        class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('admin.assign-permissions*') ? 'bg-brand rounded-lg text-white' : '' }}">
                        Assign Permissions
                    </a>
                @endcan

                @can('documents.checklists')
                    <a href="{{ route('admin.document-checklist') }}"
                        class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('admin.document-checklist*') ? 'bg-brand rounded-lg text-white' : '' }}">
                        Document Checklist
                    </a>
                @endcan

                @can('contracts.view')
                    <a href="{{ route('admin.contracts') }}"
                        class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('admin.contracts*') ? 'bg-brand rounded-lg text-white' : '' }}">
                        Contracts
                    </a>
                @endcan

                @can('students.view')
                    <a href="{{ route('admin.students') }}"
                        class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('admin.students*') || request()->routeIs('admin.student-documents*') ? 'bg-brand rounded-lg text-white' : '' }}">
                        Students
                    </a>
                @endcan

                @can('students.assign_industry')
                    <a href="{{ route('admin.assign-students') }}"
                        class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('admin.assign-students*') ? 'bg-brand rounded-lg text-white' : '' }}">
                        Assign Students
                    </a>
                @endcan

                @can('industries.view')
                    <a href="{{ route('admin.industries') }}"
                        class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('admin.industries*') ? 'bg-brand rounded-lg text-white' : '' }}">
                        Industries
                    </a>
                @endcan

                @can('audit_history.view')
                    <a href="{{ route('admin.audits') }}"
                        class="flex items-center px-6 py-2 font-medium text-sm transition {{ request()->routeIs('admin.audits*') ? 'bg-brand rounded-lg text-white' : '' }}">
                        Audit History
                    </a>
                @endcan

            </nav>

        </div>
        <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>

    </aside>
