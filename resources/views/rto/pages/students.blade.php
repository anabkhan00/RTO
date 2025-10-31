@extends('rto.master_layout.index')
@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Students Management</h1>
                <p class="text-gray-600 mt-1">Manage and track your students</p>
            </div>
            <div class="flex gap-3">
                <button
                    class="bg-brand text-white flex items-center font-medium text-sm px-4 py-2 rounded-lg hover:bg-gold transition-colors"
                    id="openModalBtn">
                    <i class="bi bi-plus-circle mr-2"></i> Add Student
                </button>
                <button
                    class="bg-green-600 text-white flex items-center font-medium text-sm px-4 py-2 rounded-lg hover:bg-green-700 transition-colors"
                    id="openUploadBtn">
                    <i class="bi bi-upload mr-2"></i> Upload CSV
                </button>
                <a href="/rto/students/csv-format"
                    class="bg-gray-600 text-white flex items-center font-medium text-sm px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="bi bi-download mr-2"></i> Download Format
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Filters</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search by Name/Email</label>
                <input type="text" id="searchFilter" placeholder="Search students..."
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">RTO</label>
                <select id="rtoFilter"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                    <option value="">All RTOs</option>
                    <option value="Alfie Training">Alfie Training</option>
                    <option value="Open Colleges">Open Colleges</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                <select id="priorityFilter"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                    <option value="">All Priorities</option>
                    <option value="High Priority">High Priority</option>
                    <option value="Medium Priority">Medium Priority</option>
                    <option value="Low Priority">Low Priority</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                <select id="courseFilter"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                    <option value="">All Courses</option>
                    <option value="Web Development">Web Development</option>
                    <option value="Graphic Design">Graphic Design</option>
                    <option value="Mobile Apps">Mobile Apps</option>
                    <option value="Data Science">Data Science</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Progress Status</label>
                <select id="progressFilter"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                    <option value="">All Status</option>
                    <option value="Assigned">Assigned</option>
                    <option value="Interview">Interview</option>
                    <option value="Placed">Placed</option>
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
                    class="bg-brand text-white px-4 py-2 rounded-lg hover:bg-gold transition-colors text-sm font-medium">
                    Apply Filters
                </button>
                <button id="resetFilters"
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors text-sm font-medium">
                    Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Students Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table id="studentsTable" class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Name</th>
                        {{-- <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            RTO</th> --}}
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Industry</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Sectors</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Email</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Phone</th>
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
                            Address</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Assign Coordinator</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Created At</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($students as $index => $student)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <!-- Name with Priority Badge -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-medium rounded-full mr-2
                                    @if ($student->priority == 'High Priority') bg-red-100 text-red-800
                                    @elseif($student->priority == 'Medium Priority') bg-orange-100 text-orange-800
                                    @else bg-green-100 text-green-800 @endif">
                                        {{ $student->priority ?? 'Medium Priority' }}
                                    </span>
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <div
                                            class="h-8 w-8 rounded-full bg-brand flex items-center justify-center text-white font-semibold text-xs">
                                            {{ substr($student->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <!-- RTO -->
                            {{-- <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{ $student->rto_number ?? '-----' }}</td> --}}
                            <!-- Industry -->
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                {{ $student->industry ?? '-----' }}</td>
                            <!-- Sectors -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                <a href="#" class="text-brand hover:text-gold text-sm font-medium">
                                    VIEW / EDIT
                                    <i class="bi bi-layers ml-1"></i>
                                </a>
                            </td>
                            <!-- Email -->
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{ $student->email }}</td>
                            <!-- Phone -->
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{ $student->phone ?? '-----' }}
                            </td>
                            <!-- Course -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span
                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                @if ($student->course && $student->course->name == 'Web Development') bg-blue-100 text-blue-800
                                @elseif($student->course && $student->course->name == 'Graphic Design') bg-purple-100 text-purple-800
                                @elseif($student->course && $student->course->name == 'Mobile Apps') bg-green-100 text-green-800
                                @else bg-orange-100 text-orange-800 @endif">
                                    {{ $student->course->name ?? 'No Course' }}
                                </span>
                            </td>
                            <!-- Days Left -->
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                {{ rand(10, 300) }} Days left
                            </td>
                            <!-- Progress -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full mb-1 bg-gray-100 text-gray-800">
                                        <i class="bi bi-person mr-1"></i>
                                        Assigned
                                    </span>
                                    <div class="text-xs text-gray-600">Co- Admin</div>
                                </div>
                            </td>
                            <!-- Address -->
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                {{ $student->address ?? '-----' }}</td>
                            <!-- Assign Coordinator -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="text-sm text-gray-900 mr-2">Admin</span>
                                    <a href="#" class="text-brand hover:text-gold text-xs font-medium">change</a>
                                </div>
                            </td>
                            <!-- Created At -->
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                {{ $student->created_at->format('j M Y') }}</td>
                            <!-- Actions -->
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <div class="relative">
                                    <button onclick="toggleDropdown({{ $index }})"
                                        class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">
                                        MORE <i class="bi bi-chevron-down ml-1"></i>
                                    </button>
                                    <div id="dropdown-{{ $index }}"
                                        class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 border">
                                        {{-- <a href="#"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">View Details</a> --}}
                                        <a href="#"
                                            onclick="editStudent({{ $student->id }}, '{{ $student->name }}', '{{ $student->email }}', '{{ $student->phone }}', '{{ $student->address }}', {{ $student->course_id ?? 1 }})"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Edit Student</a>
                                        <a href="{{ route('rto.student-documents.index', $student->id) }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">View
                                            Documents</a>
                                        {{-- <a href="#"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Assign
                                            Coordinator</a> --}}
                                        <a href="#" onclick="deleteStudent({{ $student->id }})"
                                            class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Delete Student</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add/Edit Student Modal -->
    <div id="studentModal" class="fixed inset-0 bg-black/50 flex justify-center items-center hidden z-50">
        <div class="bg-white w-full max-w-2xl rounded-xl shadow-2xl overflow-hidden relative">
            <!-- Modal Header with Gradient -->
            <div class="bg-gradient-to-r from-brand to-gold px-6 py-4">
                <h2 id="modalTitle" class="text-xl font-semibold text-white flex items-center">
                    <i class="bi bi-person-plus mr-2"></i> Add Student
                </h2>
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
                                <i class="bi bi-building mr-1"></i> RTO
                            </label>
                            <select name="rto" id="studentRto"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all">
                                <option value="">Select RTO</option>
                                <option value="Alfie Training">Alfie Training</option>
                                <option value="Open Colleges">Open Colleges</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="bi bi-flag mr-1"></i> Priority
                            </label>
                            <select name="priority" id="studentPriority"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all">
                                <option value="">Select Priority</option>
                                <option value="High Priority">High Priority</option>
                                <option value="Medium Priority">Medium Priority</option>
                                <option value="Low Priority">Low Priority</option>
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
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all">
                                <option value="">Select Course</option>
                                <option value="1">Web Development</option>
                                <option value="2">Graphic Design</option>
                                <option value="3">Mobile Apps</option>
                                <option value="4">Data Science</option>
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
                                <i class="bi bi-person-check mr-1"></i> Coordinator
                            </label>
                            <select name="coordinator" id="studentCoordinator"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all">
                                <option value="">Select Coordinator</option>
                                <option value="Zain">Zain</option>
                                <option value="Bilal">Bilal</option>
                                <option value="Nico">Nico</option>
                                <option value="Melanie Teran">Melanie Teran</option>
                                <option value="Ahmed">Ahmed</option>
                                <option value="Fatima">Fatima</option>
                                <option value="Hassan">Hassan</option>
                                <option value="Ayesha">Ayesha</option>
                                <option value="Omar">Omar</option>
                                <option value="Zara">Zara</option>
                                <option value="Usman">Usman</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="bi bi-geo-alt mr-1"></i> Address
                        </label>
                        <textarea name="address" id="studentAddress" placeholder="Enter Address" rows="3"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all"></textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <button type="button" id="cancelBtn"
                            class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-6 py-2 bg-brand text-white rounded-lg hover:bg-gold transition-colors">
                            <i class="bi bi-check-circle mr-1"></i> Save Student
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
                        <p class="text-blue-700 font-mono text-sm">
                            name,email,phone,address,course_code,rto,priority,industry</p>
                        <p class="text-blue-600 text-xs mt-2">First row should contain headers</p>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <button type="button" id="cancelUploadBtn"
                            class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <i class="bi bi-upload mr-1"></i> Upload CSV
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Modal functionality
        const studentModal = document.getElementById('studentModal');
        const uploadModal = document.getElementById('uploadModal');
        const openModalBtn = document.getElementById('openModalBtn');
        const openUploadBtn = document.getElementById('openUploadBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const closeUploadBtn = document.getElementById('closeUploadBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const cancelUploadBtn = document.getElementById('cancelUploadBtn');

        // Open modals
        openModalBtn.addEventListener('click', () => {
            studentModal.classList.remove('hidden');
            document.getElementById('modalTitle').innerHTML = '<i class="bi bi-person-plus mr-2"></i> Add Student';
            document.getElementById('studentForm').reset();
        });

        openUploadBtn.addEventListener('click', () => {
            uploadModal.classList.remove('hidden');
        });

        // Close modals
        [closeModalBtn, cancelBtn].forEach(btn => {
            btn.addEventListener('click', () => {
                studentModal.classList.add('hidden');
            });
        });

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

        // Filter functionality
        const searchFilter = document.getElementById('searchFilter');
        const rtoFilter = document.getElementById('rtoFilter');
        const priorityFilter = document.getElementById('priorityFilter');
        const courseFilter = document.getElementById('courseFilter');
        const progressFilter = document.getElementById('progressFilter');
        const fromDate = document.getElementById('fromDate');
        const toDate = document.getElementById('toDate');
        const applyFilters = document.getElementById('applyFilters');
        const resetFilters = document.getElementById('resetFilters');
        const tableRows = document.querySelectorAll('#studentsTable tbody tr');

        function filterTable() {
            const searchTerm = searchFilter.value.toLowerCase();
            const selectedRto = rtoFilter.value;
            const selectedPriority = priorityFilter.value;
            const selectedCourse = courseFilter.value;
            const selectedProgress = progressFilter.value;
            const fromDateValue = fromDate.value;
            const toDateValue = toDate.value;

            tableRows.forEach(row => {
                const name = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                const rto = row.querySelector('td:nth-child(2)').textContent;
                const email = row.querySelector('td:nth-child(5)').textContent.toLowerCase();
                const course = row.querySelector('td:nth-child(7)').textContent;
                const progress = row.querySelector('td:nth-child(9)').textContent;

                let showRow = true;

                // Search filter
                if (searchTerm && !name.includes(searchTerm) && !email.includes(searchTerm)) {
                    showRow = false;
                }

                // RTO filter
                if (selectedRto && !rto.includes(selectedRto)) {
                    showRow = false;
                }

                // Priority filter
                if (selectedPriority && !row.textContent.includes(selectedPriority)) {
                    showRow = false;
                }

                // Course filter
                if (selectedCourse && !course.includes(selectedCourse)) {
                    showRow = false;
                }

                // Progress filter
                if (selectedProgress && !progress.includes(selectedProgress)) {
                    showRow = false;
                }

                row.style.display = showRow ? '' : 'none';
            });
        }

        // Real-time search
        searchFilter.addEventListener('input', filterTable);

        // Apply filters button
        applyFilters.addEventListener('click', filterTable);

        // Reset filters
        resetFilters.addEventListener('click', () => {
            searchFilter.value = '';
            rtoFilter.value = '';
            priorityFilter.value = '';
            courseFilter.value = '';
            progressFilter.value = '';
            fromDate.value = '';
            toDate.value = '';
            tableRows.forEach(row => {
                row.style.display = '';
            });
        });

        // Dropdown toggle functionality
        function toggleDropdown(index) {
            const dropdown = document.getElementById(`dropdown-${index}`);
            const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');

            // Close all other dropdowns
            allDropdowns.forEach(dd => {
                if (dd !== dropdown) {
                    dd.classList.add('hidden');
                }
            });

            // Toggle current dropdown
            dropdown.classList.toggle('hidden');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('[onclick^="toggleDropdown"]')) {
                const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');
                allDropdowns.forEach(dd => dd.classList.add('hidden'));
            }
        });

        // Edit student function
        function editStudent(id, name, email, phone, address, courseId) {
            document.getElementById('modalTitle').innerHTML = '<i class="bi bi-pencil mr-2"></i> Edit Student';
            document.getElementById('studentName').value = name;
            document.getElementById('studentEmail').value = email;
            document.getElementById('studentPhone').value = phone;
            document.getElementById('studentAddress').value = address;
            document.getElementById('studentCourse').value = courseId;
            studentModal.classList.remove('hidden');
        }

        // Delete student function
        function deleteStudent(id) {
            if (confirm('Are you sure you want to delete this student?')) {
                // Handle delete logic here
                console.log('Delete student with ID:', id);
            }
        }
    </script>
@endsection
