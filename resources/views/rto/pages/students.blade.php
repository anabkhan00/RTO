@extends('rto.master_layout.index')
@section('page-title', 'Students')
@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Manage Students{{ isset($rto) ? ' - ' . $rto->name : '' }}</h1>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('rto.students.create') }}"
                    class="bg-emerald-600 text-white flex items-center font-medium text-xs px-3 py-1.5 rounded-md hover:bg-emerald-700 transition-colors">
                    <i class="bi bi-person-plus mr-2 text-sm"></i>
                    Add Student
                </a>
                <button
                    class="bg-green-600 text-white flex items-center font-medium text-xs px-3 py-1.5 rounded-md hover:bg-green-700 transition-colors"
                    id="openUploadBtn">
                    <i class="bi bi-upload mr-2 text-sm"></i> Upload CSV
                </button>
                <a href="/rto/students/csv-format"
                    class="bg-gray-600 text-white flex items-center font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gray-700 transition-colors">
                    <i class="bi bi-download mr-2 text-sm"></i> Download Format
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="p-4 border-b border-gray-200">
            <button id="toggleFilters" class="flex items-center justify-between w-full text-left">
                <h3 class="text-lg font-semibold text-gray-800">Filters</h3>
                <i id="filterIcon" class="bi bi-chevron-down text-gray-500 transition-transform"></i>
            </button>
        </div>
        <div id="filterContent" class="hidden p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Search by Name/Email</label>
                    <input type="text" id="searchFilter" placeholder="Search students..."
                        class="w-full h-9 px-2 text-xs border border-gray-300 rounded-md bg-white leading-none focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Location</label>
                    <input type="text" id="locationFilter" placeholder="Search location..."
                        class="w-full h-9 px-2 text-xs border border-gray-300 rounded-md bg-white leading-none focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Priority</label>
                    <select id="priorityFilter"
                        class="w-full h-9 px-2 text-xs border border-gray-300 rounded-md bg-white leading-none focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand">
                        <option value="">All Priorities</option>
                        <option value="high_priority">High Priority</option>
                        <option value="medium Priority">Medium Priority</option>
                        <option value="low_priority">Low Priority</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Course</label>
                    <select id="courseFilter"
                        class="w-full h-9 px-2 text-xs border border-gray-300 rounded-md bg-white leading-none focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand">
                        <option value="">All Courses</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Progress Status</label>
                    <select id="progressFilter"
                        class="w-full h-9 px-2 text-xs border border-gray-300 rounded-md bg-white leading-none focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand">
                        <option value="">All Status</option>
                        <option value="completed_placements">Completed Placements</option>
                        <option value="active_placements">Active Placements</option>
                        <option value="booked_placements">Booked Placements</option>
                        <option value="awaiting_placements">Awaiting Placements</option>
                        <option value="flagged_placements">Flagged Placements</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">From Date</label>
                    <input type="date" id="fromDate"
                        class="w-full h-9 px-2 text-xs border border-gray-300 rounded-md bg-white leading-none focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">To Date</label>
                    <input type="date" id="toDate"
                        class="w-full h-9 px-2 text-xs border border-gray-300 rounded-md bg-white leading-none focus:outline-none focus:ring-2 focus:ring-brand/30 focus:border-brand">
                </div>
                <div class="flex gap-2 justify-center">
                    <button id="applyFilters"
                        class="h-9 px-3 text-[11px] font-medium rounded-md bg-green-600 text-white hover:bg-green-700 transition-colors">
                        Apply
                    </button>
                    <button id="resetFilters"
                        class="h-9 px-3 text-[11px] font-medium rounded-md bg-red-600 text-white hover:bg-red-700 transition-colors">
                        Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Students Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        @if (auth()->user()->hasRole('placement_coordinator'))
            <div class="p-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                    </div>
                    <button id="bulkAssignBtn"
                        class="bg-brand text-white text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors font-medium"
                        disabled>
                        <i class="bi bi-person-plus mr-1"></i>Assign Selected to Sourcing Coordinator
                    </button>
                </div>
            </div>
        @endif
        <div>
            <table id="studentsTable" class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        @if (auth()->user()->hasRole('placement_coordinator'))
                            <th
                                class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                                <input type="checkbox" id="headerSelectAll" class="rounded border-gray-300">
                            </th>
                        @endif
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Name</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Industry</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Course</th>
                        {{-- <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Days Left</th> --}}
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Progress</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Status</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Coordinator</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Address</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Created At</th>
                        <th
                            class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- DataTables will populate this via AJAX -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add/Edit Student Modal -->
    <div id="studentModal" class="fixed inset-0 bg-black/50 flex justify-center items-center hidden z-50">
        <div class="bg-white w-full max-w-2xl rounded-xl shadow-2xl overflow-hidden relative">
            <!-- Modal Header with Gradient -->
            <div class="bg-gradient-to-r from-brand to-gold px-6 py-4">
                <h2 id="modalTitle" class="text-xl font-semibold text-white">Add Student</h2>
                <button id="closeModalBtn" class="absolute top-4 right-4 text-white hover:text-gray-200 text-2xl">
                    &times;
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">

                <form id="studentForm" method="POST" action="/rto/students" class="space-y-5">
                    @csrf
                    <input type="hidden" id="studentId" name="_method" value="">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="bi bi-person mr-1"></i> Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="studentName" placeholder="Enter Student Name"
                                required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="bi bi-envelope mr-1"></i> Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" id="studentEmail" placeholder="Enter Email" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="bi bi-flag mr-1"></i> Priority
                            </label>
                            <select name="priority" id="studentPriority"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all bg-white">
                                <option value="">Select Priority</option>
                                <option value="high_priority">High Priority</option>
                                <option value="medium_priority">Medium Priority</option>
                                <option value="low_priority">Low Priority</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="bi bi-phone mr-1"></i> Phone
                            </label>
                            <input type="text" name="phone" id="studentPhone" placeholder="+92-xxx-xxxxxxx"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="bi bi-book mr-1"></i> Course
                            </label>
                            <select name="course_id" id="studentCourse"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all bg-white">
                                <option value="">Select Course</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="bi bi-briefcase mr-1"></i> Industry
                            </label>
                            <input type="text" name="industry" id="studentIndustry" placeholder="Enter Industry"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="bi bi-clipboard-check mr-1"></i> Progress Status
                            </label>
                            <select name="progress_status" id="studentProgressStatus"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all bg-white">
                                <option value="awaiting_placements">Awaiting</option>
                                <option value="booked_placements">Booked</option>
                                <option value="active_placements">Active</option>
                                <option value="completed_placements">Completed</option>
                                <option value="flagged_placements">Flagged</option>
                            </select>
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="bi bi-geo-alt mr-1"></i> Address <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="address" id="studentAddress" placeholder="Enter Student Address"
                                required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all" />
                        </div>
                    </div>

                    <div class="flex gap-3 pt-4 border-t">
                        <button type="submit"
                            class="bg-brand text-white text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors font-medium">
                            Save Student
                        </button>
                        <button type="button" id="cancelBtn"
                            class="bg-gray-500 text-white text-xs px-3 py-1.5 rounded-md hover:bg-gray-600 transition-colors font-medium">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- CSV Upload Modal -->
    <div id="uploadModal" class="fixed inset-0 bg-black/50 flex justify-center items-center hidden z-50">
        <div class="bg-white w-full max-w-lg rounded-xl shadow-2xl overflow-hidden relative">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <i class="bi bi-upload mr-2"></i> Upload Students CSV
                </h2>
                <button id="closeUploadBtn" class="absolute top-4 right-4 text-white hover:text-gray-200 text-2xl">
                    &times;
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form method="POST" action="/rto/students/upload" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="bi bi-file-earmark-spreadsheet mr-1"></i> Select CSV File
                        </label>
                        <input type="file" name="csv_file" accept=".csv" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all" />
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="font-medium text-blue-800 mb-2 flex items-center">
                            <i class="bi bi-info-circle mr-1"></i> CSV Format:
                        </p>
                        {{-- <p class="text-blue-700 font-mono text-sm">
                            name,email,phone,address,course_code,rto,priority,industry</p>
                        <p class="text-blue-600 text-xs mt-2">First row should contain headers</p> --}}
                    </div>

                    <div class="flex gap-3 pt-4 border-t">
                        <button type="submit"
                            class="bg-green-600 text-white text-xs px-3 py-1.5 rounded-md hover:bg-green-700 transition-colors font-medium">
                            <i class="bi bi-upload mr-1"></i> Upload CSV
                        </button>
                        <button type="button" id="cancelUploadBtn"
                            class="bg-gray-500 text-white text-xs px-3 py-1.5 rounded-md hover:bg-gray-600 transition-colors font-medium">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Assign Coordinator Modal -->
    <div id="coordinatorModal" class="fixed inset-0 bg-black/50 flex justify-center items-center hidden z-50">
        <div class="bg-white w-full max-w-md rounded-xl shadow-2xl p-6 relative">
            <button onclick="closeCoordinatorModal()"
                class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">
                &times;
            </button>
            <h3 class="text-xl font-semibold mb-4" style="color: #d4af37;">Assign Coordinator</h3>
            <form id="coordinatorForm">
                <input type="hidden" id="selectedStudentId">

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Coordinator</label>
                    <select id="coordinatorSelect" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                        <option value="">Unassign Coordinator</option>
                    </select>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="px-4 py-2 rounded-lg text-white text-sm"
                        style="background-color: #d4af37;" onmouseover="this.style.backgroundColor='#c19b2e'"
                        onmouseout="this.style.backgroundColor='#d4af37'">
                        Assign
                    </button>
                    <button type="button" onclick="closeCoordinatorModal()"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg text-sm hover:bg-gray-600">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Assign Sourcing Coordinator Modal -->
    <div id="sourcingCoordinatorModal" class="fixed inset-0 bg-black/50 flex justify-center items-center hidden z-50">
        <div class="bg-white w-full max-w-md rounded-xl shadow-2xl p-6 relative">
            <button onclick="closeSourcingCoordinatorModal()"
                class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">
                &times;
            </button>
            <h3 class="text-xl font-semibold mb-4" style="color: #d4af37;">Assign to Sourcing Coordinator</h3>
            <form id="sourcingCoordinatorForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Sourcing Coordinator</label>
                    <select id="sourcingCoordinatorSelect" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                        <option value="">Select Coordinator</option>
                    </select>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="px-4 py-2 rounded-lg text-white text-sm"
                        style="background-color: #d4af37;" onmouseover="this.style.backgroundColor='#c19b2e'"
                        onmouseout="this.style.backgroundColor='#d4af37'">
                        Assign Students
                    </button>
                    <button type="button" onclick="closeSourcingCoordinatorModal()"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg text-sm hover:bg-gray-600">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/rto/students.css') }}">
    @endpush

    @push('scripts')
        <script>
            window.studentsPageConfig = {
                dataUrl: @json(route('rto.students.data')),
                rtoId: @json(isset($rtoId) ? $rtoId : null),
                hasPlacementCoordinatorRole: @json(auth()->user()->hasRole('placement_coordinator')),
                isAdmin: @json(false),
                csrf: @json(csrf_token())
            };
        </script>
        <script src="{{ asset('assets/js/rto/students.js') }}"></script>
    @endpush
@endsection
