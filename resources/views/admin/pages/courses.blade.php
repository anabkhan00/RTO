@extends('admin.master_layout.index')
@section('page-title', 'Courses')
@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Courses Management</h1>
                <p class="text-gray-600 mt-1">Manage and track all courses</p>
            </div>
            <button id="openModalBtn"
                class="bg-brand text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors">
                Add Course
            </button>
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search by Name/Code</label>
                    <input type="text" id="searchFilter" placeholder="Search courses..."
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select id="statusFilter"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                        <option value="">All Status</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
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

    <!-- Courses Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table id="coursesTable" class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Course Code</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Course Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Credit Hours</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Description</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($courses as $index => $course)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-blue-50 text-blue-700 border-blue-100 border shadow-sm">
                                    {{ $course->code }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $course->name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{ $course->credit_hours ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ Str::limit($course->description ?? 'N/A', 40) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if($course->status)
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-emerald-50 text-emerald-700 border-emerald-100 border shadow-sm">
                                        <i class="bi bi-check-circle mr-1"></i>Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-red-50 text-red-700 border-red-100 border shadow-sm">
                                        <i class="bi bi-x-circle mr-1"></i>Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <div class="relative">
                                    <button onclick="toggleDropdown({{ $index }})"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <div id="dropdown-{{ $index }}"
                                        class="hidden absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg z-10 border">
                                        <button onclick="editCourse({{ $course->id }}, '{{ $course->name }}', '{{ $course->code }}', '{{ $course->credit_hours }}', '{{ addslashes($course->description) }}', {{ $course->status ? 'true' : 'false' }})"
                                            class="block w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 rounded-md">
                                            <i class="bi bi-pencil mr-2"></i>Edit
                                        </button>
                                        <button onclick="deleteCourse({{ $course->id }})"
                                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md">
                                            <i class="bi bi-trash mr-2"></i>Delete
                                        </button>
                                    </div>
                                </div>
                                <form id="delete-form-{{ $course->id }}" method="POST" action="/admin/courses/{{ $course->id }}" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div id="courseModal" class="fixed inset-0 bg-black/50 flex justify-center items-center hidden z-50">
        <div class="bg-white w-full max-w-4xl rounded-xl shadow-2xl p-10 relative max-h-[90vh] overflow-y-auto">
            <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">
                &times;
            </button>

            <h2 id="modalTitle" class="text-2xl font-semibold text-brand pb-3">Add Course</h2>

            <form id="courseForm" method="POST" action="{{ route('admin.courses') }}" class="space-y-4">
                @csrf
                <input type="hidden" id="courseId" name="_method" value="">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-brand">Course Code <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="code" id="courseCode" placeholder="Enter Course Code" required
                            class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-brand">Course Name <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" id="courseName" placeholder="Enter Course Name" required
                            class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-brand">Credit Hours</label>
                        <input type="text" name="credit_hours" id="courseCreditHours"
                            placeholder="Enter Credit Hours"
                            class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-brand">Status</label>
                        <select name="status" id="courseStatus"
                            class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-brand">Description</label>
                    <textarea name="description" id="courseDescription" placeholder="Enter Course Description" rows="3"
                        class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200"></textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" id="cancelBtn"
                        class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2 bg-brand text-white rounded-md hover:bg-gold">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('courseModal');
        const openBtn = document.getElementById('openModalBtn');
        const closeBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const form = document.getElementById('courseForm');
        const modalTitle = document.getElementById('modalTitle');

        openBtn.addEventListener('click', () => {
            resetForm();
            modalTitle.textContent = 'Add Course';
            form.action = '{{ route('admin.courses') }}';
            document.getElementById('courseId').value = '';
            modal.classList.remove('hidden');
        });

        closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
        cancelBtn.addEventListener('click', () => modal.classList.add('hidden'));

        function editCourse(id, name, code, creditHours, description, status) {
            modalTitle.textContent = 'Edit Course';
            form.action = `/admin/courses/${id}`;
            document.getElementById('courseId').value = 'PUT';
            document.getElementById('courseName').value = name;
            document.getElementById('courseCode').value = code;
            document.getElementById('courseCreditHours').value = creditHours || '';
            document.getElementById('courseDescription').value = description || '';
            document.getElementById('courseStatus').value = status ? '1' : '0';
            modal.classList.remove('hidden');
        }

        function resetForm() {
            form.reset();
            document.getElementById('courseId').value = '';
        }

        function deleteCourse(id) {
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
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        // Filter toggle functionality
        document.getElementById('toggleFilters').addEventListener('click', function() {
            const filterContent = document.getElementById('filterContent');
            const filterIcon = document.getElementById('filterIcon');
            filterContent.classList.toggle('hidden');
            filterIcon.classList.toggle('rotate-180');
        });

        // Dropdown toggle functionality
        function toggleDropdown(index) {
            const dropdown = document.getElementById(`dropdown-${index}`);
            const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');
            allDropdowns.forEach(dd => {
                if (dd !== dropdown) {
                    dd.classList.add('hidden');
                }
            });
            dropdown.classList.toggle('hidden');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('[onclick^="toggleDropdown"]')) {
                const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');
                allDropdowns.forEach(dd => dd.classList.add('hidden'));
            }
        });

        $(document).ready(function() {
            const coursesTable = $('#coursesTable').DataTable({
                "pageLength": 25,
                "searching": false,
                "ordering": true,
                "info": false,
                "lengthChange": false,
                "columnDefs": [{
                    "orderable": false,
                    "targets": [5]
                }],
                "dom": 'rt<"flex justify-end mt-4"p>',
                "scrollX": true
            });

            // Filter functionality
            const searchFilter = document.getElementById('searchFilter');
            const statusFilter = document.getElementById('statusFilter');
            const applyFilters = document.getElementById('applyFilters');
            const resetFilters = document.getElementById('resetFilters');

            function filterTable() {
                const searchTerm = searchFilter.value.toLowerCase();
                const selectedStatus = statusFilter.value;

                coursesTable.rows().every(function() {
                    const row = this.node();
                    const code = row.cells[0].textContent.toLowerCase();
                    const name = row.cells[1].textContent.toLowerCase();
                    const status = row.cells[4].textContent;

                    let showRow = true;

                    if (searchTerm && !code.includes(searchTerm) && !name.includes(searchTerm)) {
                        showRow = false;
                    }

                    if (selectedStatus && !status.includes(selectedStatus)) {
                        showRow = false;
                    }

                    if (showRow) {
                        $(row).show();
                    } else {
                        $(row).hide();
                    }
                });
            }

            searchFilter.addEventListener('input', filterTable);
            statusFilter.addEventListener('change', filterTable);
            applyFilters.addEventListener('click', filterTable);

            resetFilters.addEventListener('click', () => {
                searchFilter.value = '';
                statusFilter.value = '';
                coursesTable.rows().every(function() {
                    $(this.node()).show();
                });
            });
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
    </style>
@endsection
