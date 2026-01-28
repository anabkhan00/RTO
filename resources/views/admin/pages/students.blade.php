@extends('admin.master_layout.index')
@section('page-title', 'Students')
<style>
    .bg-blue-100,
    .bg-purple-100,
    .bg-green-100,
    .bg-orange-100,
    .bg-pink-100,
    .bg-indigo-100,
    .bg-teal-100,
    .bg-rose-100 {
        background-color: rgba(0, 0, 0, 0.03) !important;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
</style>
@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Students Management{{ isset($rto) ? ' - ' . $rto->name : '' }}
                </h1>
                <p class="text-gray-600 mt-1">
                    {{ isset($rto) ? 'Students enrolled under this RTO' : 'Manage and track your students' }}</p>
            </div>
            @can('students.create')
            <div class="flex gap-3">
                @if (isset($rto))
                    <a href="{{ route('admin.students') }}"
                        class="bg-gray-500 text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gray-600 transition-colors">
                        <i class="bi bi-arrow-left mr-1"></i> All Students
                    </a>
                @endif
                @if (auth()->user()->role !== 'coordinator')
                    <a href="{{ route('admin.students.create') }}"
                        class="bg-brand text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors">
                        Add Student
                    </a>
                    <button
                        class="bg-green-600 text-white flex items-center font-medium text-xs px-3 py-1.5 rounded-md hover:bg-green-700 transition-colors"
                        id="openUploadBtn">
                        <i class="bi bi-upload mr-2 text-sm"></i> Upload CSV
                    </button>
                    <a href="/admin/students/csv-format"
                        class="bg-gray-600 text-white flex items-center font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gray-700 transition-colors">
                        <i class="bi bi-download mr-2 text-sm"></i> Download Format
                    </a>
                @endif
            </div>
            @endcan
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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search by Name/Email</label>
                    <input type="text" id="searchFilter" placeholder="Search students..."
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                    <input type="text" id="locationFilter" placeholder="Search location..."
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                    <select id="priorityFilter"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                        <option value="">All Priorities</option>
                        <option value="high_priority">High Priority</option>
                        <option value="medium Priority">Medium Priority</option>
                        <option value="low_priority">Low Priority</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                    <select id="courseFilter"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                        <option value="">All Courses</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Progress Status</label>
                    <select id="progressFilter"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                        <option value="">All Status</option>
                        <option value="completed_placements">Completed Placements</option>
                        <option value="active_placements">Active Placements</option>
                        <option value="booked_placements">Booked Placements</option>
                        <option value="awaiting_placements">Awaiting Placements</option>
                        <option value="flagged_placements">Flagged Placements</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                    <input type="date" id="fromDate"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                    <input type="date" id="toDate"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                </div>
                <div class="flex items-end gap-2">
                    <button id="applyFilters"
                        class="bg-brand text-white text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors font-medium">
                        Apply Filters
                    </button>
                    <button id="resetFilters"
                        class="bg-gray-500 text-white text-xs px-3 py-1.5 rounded-md hover:bg-gray-600 transition-colors font-medium">
                        Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Students Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        @if(auth()->user()->hasRole('placement_coordinator'))
        <div class="p-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                </div>
                <button id="bulkAssignBtn" class="bg-brand text-white text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors font-medium" disabled>
                    <i class="bi bi-person-plus mr-1"></i>Assign Selected to Sourcing Coordinator
                </button>
            </div>
        </div>
        @endif
        <div class="overflow-x-auto">
            <table id="studentsTable" class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        @if(auth()->user()->hasRole('placement_coordinator'))
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
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
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Days Left</th>
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
                        @if (auth()->user()->role === 'admin')
                            <th
                                class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                                Actions</th>
                        @endif
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

                <form id="studentForm" method="POST" action="/admin/students" class="space-y-5">
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
                                <i class="bi bi-building mr-1"></i> RTO
                            </label>
                            <select name="rto" id="studentRto"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all bg-white">
                                <option value="">Select RTO</option>
                                @foreach ($rtos as $rto)
                                    <option value="{{ $rto->id }}">{{ $rto->name }}</option>
                                @endforeach
                            </select>
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
                                <i class="bi bi-book mr-1"></i> Industry
                            </label>
                            <select name="course_id" id="studentIndustry"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all bg-white">
                                <option value="">Select Industry</option>
                                @foreach ($industries as $industry)
                                    <option value="{{ $industry->id }}">{{ $industry->name }}
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
                <form method="POST" action="/admin/students/upload" enctype="multipart/form-data" class="space-y-5">
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

    <script>
        // Initialize DataTables with server-side processing
        let studentsTable = $('#studentsTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('admin.students.data') }}",
                "type": "GET",
                "data": function(d) {
                    d.search = $('#searchFilter').val();
                    d.location = $('#locationFilter').val();
                    d.priority = $('#priorityFilter').val();
                    d.course = $('#courseFilter').val();
                    d.progress = $('#progressFilter').val();
                    d.from_date = $('#fromDate').val();
                    d.to_date = $('#toDate').val();
                    @if (!empty($rtoId))
                        d.rto_id = '{{ $rtoId }}';
                    @endif
                }
            },
            "columns": [
                @if(auth()->user()->hasRole('placement_coordinator'))
                {
                    "data": "checkbox",
                    "orderable": false
                },
                @endif
                {
                    "data": "name",
                    "orderable": true
                },
                {
                    "data": "industry",
                    "orderable": false
                },
                {
                    "data": "course",
                    "orderable": false
                },
                {
                    "data": "days_left",
                    "orderable": false
                },
                {
                    "data": "progress",
                    "orderable": false
                },
                {
                    "data": "status",
                    "orderable": false
                },
                {
                    "data": "coordinator",
                    "orderable": false
                },
                {
                    "data": "address",
                    "orderable": true
                },
                {
                    "data": "created_at",
                    "orderable": true
                },
                @if (auth()->user()->role === 'admin')
                    {
                        "data": "actions",
                        "orderable": false
                    }
                @endif
            ],
            "pageLength": 25,
            "searching": false,
            "ordering": true,
            "info": false,
            "lengthChange": false,
            "dom": 'rt<"flex justify-end mt-4"p>',
            "scrollX": true,
            "language": {
                "processing": "Processing..."
            },
            "createdRow": function(row, data, dataIndex) {
                $(row).addClass('hover:bg-gray-50 transition-colors cursor-pointer');

                // Prevent row click on actions column and checkbox column
                $(row).find('td:last-child, td:first-child').on('click', function(e) {
                    e.stopPropagation();
                });

                // Row click navigation
                $(row).on('click', function(e) {
                    window.location.href = data.row_url;
                });
            }
        });

        // Modal functionality
        const studentModal = document.getElementById('studentModal');
        const uploadModal = document.getElementById('uploadModal');
        // const openModalBtn = document.getElementById('openModalBtn');
        const openUploadBtn = document.getElementById('openUploadBtn');
        // const closeModalBtn = document.getElementById('closeModalBtn');
        const closeUploadBtn = document.getElementById('closeUploadBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const cancelUploadBtn = document.getElementById('cancelUploadBtn');

        // Open modals
        // openModalBtn.addEventListener('click', () => {
        //     studentModal.classList.remove('hidden');
        //     document.getElementById('modalTitle').textContent = 'Add Student';
        //     document.getElementById('studentForm').reset();
        // });

        if (openUploadBtn) {
            openUploadBtn.addEventListener('click', () => {
                uploadModal.classList.remove('hidden');
            });
        }


        // Close modals
        // [closeModalBtn, cancelBtn].forEach(btn => {
        //     btn.addEventListener('click', () => {
        //         studentModal.classList.add('hidden');
        //     });
        // });

        [closeUploadBtn, cancelUploadBtn].forEach(btn => {
            btn.addEventListener('click', () => {
                uploadModal.classList.add('hidden');
            });
        });

        // Close modals on outside click
        [studentModal, uploadModal].forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });

        // Filter functionality - only on Apply Filters button click
        $('#applyFilters').on('click', function() {
            studentsTable.ajax.reload();
        });

        $('#resetFilters').on('click', function() {
            $('#searchFilter').val('');
            $('#locationFilter').val('');
            $('#priorityFilter').val('');
            $('#courseFilter').val('');
            $('#progressFilter').val('');
            $('#fromDate').val('');
            $('#toDate').val('');
            studentsTable.ajax.reload();
        });

        // Dropdown functionality for DataTables dynamic content
        $(document).on('click', 'button[onclick*="toggleDropdown"]', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const button = this;
            const onclickAttr = $(this).attr('onclick');
            const match = onclickAttr.match(/toggleDropdown\((\d+)\)/);

            if (match) {
                const id = match[1];
                const dropdown = document.getElementById(`dropdown-${id}`);
                const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');

                // Close all other dropdowns and reset their styles
                allDropdowns.forEach(dd => {
                    if (dd !== dropdown) {
                        dd.classList.add('hidden');
                        dd.style.position = '';
                        dd.style.top = '';
                        dd.style.bottom = '';
                        dd.style.left = '';
                        dd.style.right = '';
                        dd.style.marginTop = '';
                        dd.style.marginBottom = '';
                    }
                });

                if (dropdown) {
                    // If dropdown is currently visible, just hide it
                    if (!dropdown.classList.contains('hidden')) {
                        dropdown.classList.add('hidden');
                        dropdown.style.position = '';
                        dropdown.style.top = '';
                        dropdown.style.bottom = '';
                        dropdown.style.left = '';
                        dropdown.style.right = '';
                        dropdown.style.marginTop = '';
                        dropdown.style.marginBottom = '';
                        return;
                    }

                    // Show dropdown
                    dropdown.classList.remove('hidden');

                    // Use fixed positioning to avoid affecting table layout
                    setTimeout(() => {
                        const buttonRect = button.getBoundingClientRect();
                        const dropdownRect = dropdown.getBoundingClientRect();
                        const viewportHeight = window.innerHeight;
                        const viewportWidth = window.innerWidth;

                        // Set to fixed positioning
                        dropdown.style.position = 'fixed';

                        // Calculate vertical position
                        const spaceBelow = viewportHeight - buttonRect.bottom;
                        const spaceAbove = buttonRect.top;

                        if (spaceBelow >= dropdownRect.height || spaceBelow > spaceAbove) {
                            // Position below button
                            dropdown.style.top = (buttonRect.bottom + 4) + 'px';
                            dropdown.style.bottom = 'auto';
                        } else {
                            // Position above button
                            dropdown.style.bottom = (viewportHeight - buttonRect.top + 4) + 'px';
                            dropdown.style.top = 'auto';
                        }

                        // Calculate horizontal position (align to right edge of button)
                        const rightEdge = buttonRect.right;
                        if (rightEdge >= dropdownRect.width) {
                            dropdown.style.left = (rightEdge - dropdownRect.width) + 'px';
                            dropdown.style.right = 'auto';
                        } else {
                            dropdown.style.left = buttonRect.left + 'px';
                            dropdown.style.right = 'auto';
                        }
                    }, 10);
                }
            }
        });

        // Close dropdowns when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.relative').length) {
                document.querySelectorAll('[id^="dropdown-"]').forEach(dd => {
                    dd.classList.add('hidden');
                });
            }
        });

        // Prevent dropdown from closing when clicking inside it
        $(document).on('click', '[id^="dropdown-"]', function(e) {
            e.stopPropagation();
        });

        function toggleDropdown(id) {
            event.stopPropagation();
            const button = event.currentTarget;
            const dropdown = document.getElementById(`dropdown-${id}`);

            // Close all other dropdowns
            document.querySelectorAll('[id^="dropdown-"]').forEach(d => {
                if (d.id !== `dropdown-${id}`) {
                    d.classList.add('hidden');
                    // Reset positioning
                    d.style.position = '';
                    d.style.top = '';
                    d.style.bottom = '';
                    d.style.left = '';
                    d.style.right = '';
                    d.style.marginTop = '';
                    d.style.marginBottom = '';
                }
            });

            // If dropdown is currently visible, just hide it
            if (!dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
                // Reset positioning
                dropdown.style.position = '';
                dropdown.style.top = '';
                dropdown.style.bottom = '';
                dropdown.style.left = '';
                dropdown.style.right = '';
                dropdown.style.marginTop = '';
                dropdown.style.marginBottom = '';
                return;
            }

            // Show dropdown first
            dropdown.classList.remove('hidden');

            // Use fixed positioning to avoid affecting table layout
            setTimeout(() => {
                const buttonRect = button.getBoundingClientRect();
                const dropdownRect = dropdown.getBoundingClientRect();
                const viewportHeight = window.innerHeight;
                const viewportWidth = window.innerWidth;

                // Set to fixed positioning
                dropdown.style.position = 'fixed';

                // Calculate vertical position
                const spaceBelow = viewportHeight - buttonRect.bottom;
                const spaceAbove = buttonRect.top;

                if (spaceBelow >= dropdownRect.height || spaceBelow > spaceAbove) {
                    // Position below button
                    dropdown.style.top = (buttonRect.bottom + 4) + 'px';
                    dropdown.style.bottom = 'auto';
                } else {
                    // Position above button
                    dropdown.style.bottom = (viewportHeight - buttonRect.top + 4) + 'px';
                    dropdown.style.top = 'auto';
                }

                // Calculate horizontal position (align to right edge of button)
                const rightEdge = buttonRect.right;
                if (rightEdge >= dropdownRect.width) {
                    dropdown.style.left = (rightEdge - dropdownRect.width) + 'px';
                    dropdown.style.right = 'auto';
                } else {
                    dropdown.style.left = buttonRect.left + 'px';
                    dropdown.style.right = 'auto';
                }
            }, 10);
        }

        // Edit student function
        function editStudent(id, name, email, phone, address, courseId) {
            document.getElementById('modalTitle').textContent = 'Edit Student';
            document.getElementById('studentName').value = name;
            document.getElementById('studentEmail').value = email;
            document.getElementById('studentPhone').value = phone;
            document.getElementById('studentAddress').value = address;
            document.getElementById('studentCourse').value = courseId;
            studentModal.classList.remove('hidden');
        }

        // Filter toggle functionality
        document.getElementById('toggleFilters').addEventListener('click', function() {
            const filterContent = document.getElementById('filterContent');
            const filterIcon = document.getElementById('filterIcon');

            filterContent.classList.toggle('hidden');
            filterIcon.classList.toggle('rotate-180');
        });

        // Student details function
        function showStudentDetails(id, name, email, phone, address) {
            Swal.fire({
                title: 'Student Details',
                html: `
                    <div class="text-left space-y-3">
                        <div><strong>Name:</strong> ${name}</div>
                        <div><strong>Email:</strong> ${email}</div>
                        <div><strong>Phone:</strong> ${phone || 'Not provided'}</div>
                        <div><strong>Address:</strong> ${address || 'Not provided'}</div>
                    </div>
                `,
                icon: 'info',
                confirmButtonText: 'Close',
                confirmButtonColor: '#1E293B'
            });
        }

        // Delete student function
        function deleteStudent(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/students/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Deleted!', 'Student has been deleted.', 'success');
                                studentsTable.ajax.reload();
                            } else {
                                Swal.fire('Error!', 'Failed to delete student.', 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error!', 'An error occurred.', 'error');
                        });
                }
            });
        }

        // Update Student Status
        function updateStudentStatus(id, newStatus) {
            fetch(`/admin/students/update-status/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success('Status updated successfully');
                    } else {
                        toastr.error('Failed to update status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('An error occurred');
                });
        }

        // Assign Coordinator Functions
        function assignCoordinator(studentId) {
            document.getElementById('selectedStudentId').value = studentId;
            loadCoordinators();
            document.getElementById('coordinatorModal').classList.remove('hidden');
        }

        function closeCoordinatorModal() {
            document.getElementById('coordinatorModal').classList.add('hidden');
        }

        function loadCoordinators() {
            fetch('/admin/students/coordinators')
                .then(response => response.json())
                .then(coordinators => {
                    const select = document.getElementById('coordinatorSelect');
                    select.innerHTML = '<option value="">Unassign Coordinator</option>';
                    coordinators.forEach(coordinator => {
                        select.innerHTML += `<option value="${coordinator.id}">${coordinator.name}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error loading coordinators:', error);
                    toastr.error('Failed to load coordinators');
                });
        }

        document.getElementById('coordinatorForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const studentId = document.getElementById('selectedStudentId').value;
            const coordinatorId = document.getElementById('coordinatorSelect').value;

            fetch(`/admin/students/assign-coordinator/${studentId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        coordinator_id: coordinatorId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success(data.message);
                        closeCoordinatorModal();
                        studentsTable.ajax.reload();
                    } else {
                        toastr.error('Failed to assign coordinator');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('An error occurred');
                });
        });

        // Close modal on outside click
        document.getElementById('coordinatorModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCoordinatorModal();
            }
        });

        // Sourcing Coordinator Assignment Functions
        let selectedStudents = [];

        // Multi-select functionality
        $(document).on('change', '.student-checkbox', function() {
            const studentId = $(this).val();
            if ($(this).is(':checked')) {
                selectedStudents.push(studentId);
            } else {
                selectedStudents = selectedStudents.filter(id => id !== studentId);
            }
            updateBulkAssignButton();
        });

        $('#selectAll, #headerSelectAll').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('.student-checkbox').prop('checked', isChecked);

            if (isChecked) {
                selectedStudents = [];
                $('.student-checkbox').each(function() {
                    selectedStudents.push($(this).val());
                });
            } else {
                selectedStudents = [];
            }
            updateBulkAssignButton();
        });

        function updateBulkAssignButton() {
            const bulkBtn = $('#bulkAssignBtn');
            if (selectedStudents.length > 0) {
                bulkBtn.prop('disabled', false).text(`Assign ${selectedStudents.length} Selected`);
            } else {
                bulkBtn.prop('disabled', true).text('Assign Selected to Sourcing Coordinator');
            }
        }

        $('#bulkAssignBtn').on('click', function() {
            if (selectedStudents.length > 0) {
                loadSourcingCoordinators();
                document.getElementById('sourcingCoordinatorModal').classList.remove('hidden');
            }
        });

        function assignSourcingCoordinator(studentId) {
            selectedStudents = [studentId];
            loadSourcingCoordinators();
            document.getElementById('sourcingCoordinatorModal').classList.remove('hidden');
        }

        function closeSourcingCoordinatorModal() {
            document.getElementById('sourcingCoordinatorModal').classList.add('hidden');
        }

        function loadSourcingCoordinators() {
            fetch('/admin/students/sourcing-coordinators')
                .then(response => response.json())
                .then(coordinators => {
                    const select = document.getElementById('sourcingCoordinatorSelect');
                    select.innerHTML = '<option value="">Select Coordinator</option>';
                    coordinators.forEach(coordinator => {
                        select.innerHTML += `<option value="${coordinator.id}">${coordinator.name}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error loading sourcing coordinators:', error);
                    toastr.error('Failed to load sourcing coordinators');
                });
        }

        document.getElementById('sourcingCoordinatorForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const sourcingCoordinatorId = document.getElementById('sourcingCoordinatorSelect').value;

            if (!sourcingCoordinatorId) {
                toastr.error('Please select a sourcing coordinator');
                return;
            }

            if (selectedStudents.length === 0) {
                toastr.error('No students selected');
                return;
            }

            fetch('/admin/student-assignments/bulk', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        student_ids: selectedStudents,
                        sourcing_coordinator_id: sourcingCoordinatorId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success(data.success);
                        closeSourcingCoordinatorModal();
                        studentsTable.ajax.reload();
                        selectedStudents = [];
                        $('.student-checkbox').prop('checked', false);
                        $('#selectAll, #headerSelectAll').prop('checked', false);
                        updateBulkAssignButton();
                    } else {
                        toastr.error(data.error || 'Failed to assign students');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('An error occurred');
                });
        });

        // Close sourcing coordinator modal on outside click
        document.getElementById('sourcingCoordinatorModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeSourcingCoordinatorModal();
            }
        });
    </script>

    <style>
        /* DataTables pagination styling */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.25rem 0.75rem;
            margin: 0 0.125rem;
            border-radius: 0.375rem;
            background-color: #e5e7eb;
            color: #374151;
            border: none;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #d1d5db;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: var(--brand);
            color: white;
        }

        .dataTables_wrapper .dataTables_paginate {
            text-align: right;
        }

        /* Dropdown menu styles */
        .dropdown-container {
            position: relative;
        }

        .dropdown-menu {
            position: absolute;
            min-width: 8rem;
            white-space: nowrap;
        }

        /* Ensure table cells don't clip dropdowns */
        table tbody tr td {
            overflow: visible !important;
        }

        /* Ensure table wrapper allows overflow */
        .dataTables_wrapper {
            overflow: visible !important;
        }

        /* Ensure table container allows overflow for dropdowns */
        .overflow-x-auto {
            overflow-y: visible !important;
        }
    </style>
@endsection
