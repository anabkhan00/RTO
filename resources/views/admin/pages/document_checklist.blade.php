@extends('admin.master_layout.index')
@section('page-title', 'Document Checklist')
@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Document Checklist Management</h1>
                <p class="text-gray-600 mt-1">Manage required document types for students</p>
            </div>
            <button id="openModalBtn"
                class="bg-brand text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors">
                Add Document Type
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search by Name</label>
                    <input type="text" id="searchFilter" placeholder="Search document types..."
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

    <!-- Document Checklist Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table id="checklistTable" class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Document Type</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Description</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($checklists as $index => $checklist)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-teal-50 text-teal-700 border-teal-100 border shadow-sm">
                                    {{ $checklist->name }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ Str::limit($checklist->description ?? 'No description', 50) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if($checklist->status)
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
                                        <button onclick="editChecklist({{ $checklist->id }}, '{{ $checklist->name }}', '{{ addslashes($checklist->description) }}')"
                                            class="block w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 rounded-md">
                                            <i class="bi bi-pencil mr-2"></i>Edit
                                        </button>
                                        <button onclick="toggleStatus({{ $checklist->id }})"
                                            class="block w-full text-left px-4 py-2 text-sm text-orange-600 hover:bg-orange-50 rounded-md">
                                            <i class="bi bi-toggle-{{ $checklist->status ? 'on' : 'off' }} mr-2"></i>{{ $checklist->status ? 'Deactivate' : 'Activate' }}
                                        </button>
                                        <button onclick="deleteChecklist({{ $checklist->id }})"
                                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md">
                                            <i class="bi bi-trash mr-2"></i>Delete
                                        </button>
                                    </div>
                                </div>
                                <form id="delete-form-{{ $checklist->id }}" method="POST" action="/admin/document-checklist/{{ $checklist->id }}" class="hidden">
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
    <div id="checklistModal" class="fixed inset-0 bg-black/50 flex justify-center items-center hidden z-50">
        <div class="bg-white w-full max-w-lg rounded-xl shadow-2xl p-10 relative">
            <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">
                &times;
            </button>

            <h2 id="modalTitle" class="text-2xl font-semibold text-brand pb-3">Add Document Type</h2>

            <form id="checklistForm" method="POST" action="/admin/document-checklist" class="space-y-4">
                @csrf
                <input type="hidden" id="checklistId" name="_method" value="">

                <div>
                    <label class="block text-sm font-medium text-brand">Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="checklistName" placeholder="Enter document type name" required
                        class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-brand">Description</label>
                    <textarea name="description" id="checklistDescription" placeholder="Enter description" rows="3"
                        class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200"></textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" id="cancelBtn" class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
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
        const modal = document.getElementById('checklistModal');
        const openBtn = document.getElementById('openModalBtn');
        const closeBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const form = document.getElementById('checklistForm');
        const modalTitle = document.getElementById('modalTitle');

        openBtn.addEventListener('click', () => {
            resetForm();
            modalTitle.textContent = 'Add Document Type';
            form.action = '/admin/document-checklist';
            document.getElementById('checklistId').value = '';
            modal.classList.remove('hidden');
        });

        closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
        cancelBtn.addEventListener('click', () => modal.classList.add('hidden'));

        function editChecklist(id, name, description) {
            modalTitle.textContent = 'Edit Document Type';
            form.action = `/admin/document-checklist/${id}`;
            document.getElementById('checklistId').value = 'PUT';
            document.getElementById('checklistName').value = name;
            document.getElementById('checklistDescription').value = description || '';
            modal.classList.remove('hidden');
        }

        function resetForm() {
            form.reset();
            document.getElementById('checklistId').value = '';
        }

        function deleteChecklist(id) {
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

        function toggleStatus(id) {
            $.ajax({
                url: `/admin/document-checklist/${id}/toggle-status`,
                type: 'PATCH',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
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
            const checklistTable = $('#checklistTable').DataTable({
                "pageLength": 25,
                "searching": false,
                "ordering": true,
                "info": false,
                "lengthChange": false,
                "columnDefs": [{
                    "orderable": false,
                    "targets": [3]
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

                checklistTable.rows().every(function() {
                    const row = this.node();
                    const name = row.cells[0].textContent.toLowerCase();
                    const status = row.cells[2].textContent;

                    let showRow = true;

                    if (searchTerm && !name.includes(searchTerm)) {
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
                checklistTable.rows().every(function() {
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