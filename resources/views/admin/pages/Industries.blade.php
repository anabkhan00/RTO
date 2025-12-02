@extends('admin.master_layout.index')
@section('page-title', 'Industries')
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
                <h1 class="text-2xl font-bold text-gray-800">Industry Management</h1>
                <p class="text-gray-600 mt-1">Manage and track industries</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.industries.create') }}"
                    class="bg-brand text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors">
                    Add Industry
                </a>

                {{-- <button
                    class="bg-green-600 text-white flex items-center font-medium text-xs px-3 py-1.5 rounded-md hover:bg-green-700 transition-colors"
                    id="openUploadBtn">
                    <i class="bi bi-upload mr-2 text-sm"></i> Upload CSV
                </button>

                <a href="/admin/industries/csv-format"
                    class="bg-gray-600 text-white flex items-center font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gray-700 transition-colors">
                    <i class="bi bi-download mr-2 text-sm"></i> Download Format
                </a> --}}
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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search by Name/Description</label>
                    <input type="text" id="searchFilter" placeholder="Search industries..."
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="text" id="emailFilter" placeholder="Search email..."
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select id="statusFilter"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                        <option value="">All Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
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

    <!-- Industries Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table id="industriesTable" class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Name</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Contact Info</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Contact Person</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Status</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Created At</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- DataTables will populate this via AJAX -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- CSV Upload Modal -->
    <div id="uploadModal" class="fixed inset-0 bg-black/50 flex justify-center items-center hidden z-50">
        <div class="bg-white w-full max-w-lg rounded-xl shadow-2xl overflow-hidden relative">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <i class="bi bi-upload mr-2"></i> Upload Industries CSV
                </h2>
                <button id="closeUploadBtn" class="absolute top-4 right-4 text-white hover:text-gray-200 text-2xl">
                    &times;
                </button>
            </div>

            <div class="p-6">
                <form method="POST" action="/admin/industries/upload" enctype="multipart/form-data" class="space-y-5">
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

    <script>
        // Initialize DataTables with server-side processing
        let industriesTable = $('#industriesTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('admin.industries.data') }}",
                "type": "GET",
                "data": function(d) {
                    d.search = $('#searchFilter').val();
                    d.email = $('#emailFilter').val();
                    d.status = $('#statusFilter').val();
                    d.from_date = $('#fromDate').val();
                    d.to_date = $('#toDate').val();
                }
            },
            "columns": [{
                    "data": "name",
                    "orderable": true
                },
                {
                    "data": "contact_info",
                    "orderable": false
                },
                {
                    "data": "contact_person",
                    "orderable": true
                },
                {
                    "data": "status",
                    "orderable": true
                },
                {
                    "data": "created_at",
                    "orderable": true
                },
                {
                    "data": "actions",
                    "orderable": false
                }
            ],
            "pageLength": 25,
            "searching": false,
            "ordering": true,
            "info": false,
            "lengthChange": false,
            "dom": 'rt<"flex justify-end mt-4"p>',
            "scrollX": true,
            "createdRow": function(row, data, dataIndex) {
                $(row).addClass('hover:bg-gray-50 transition-colors cursor-pointer');

                // Prevent row click on actions column
                $(row).find('td:last-child').on('click', function(e) {
                    e.stopPropagation();
                });

                // Row click navigation
                $(row).on('click', function(e) {
                    window.location.href = data.row_url;
                });
            }
        });

        // Modal functionality
        const uploadModal = document.getElementById('uploadModal');
        const openUploadBtn = document.getElementById('openUploadBtn');
        const closeUploadBtn = document.getElementById('closeUploadBtn');
        const cancelUploadBtn = document.getElementById('cancelUploadBtn');

        openUploadBtn.addEventListener('click', () => {
            uploadModal.classList.remove('hidden');
        });

        [closeUploadBtn, cancelUploadBtn].forEach(btn => {
            btn.addEventListener('click', () => {
                uploadModal.classList.add('hidden');
            });
        });

        uploadModal.addEventListener('click', (e) => {
            if (e.target === uploadModal) {
                uploadModal.classList.add('hidden');
            }
        });

        // Filter functionality
        $('#applyFilters').on('click', function() {
            industriesTable.ajax.reload();
        });

        $('#resetFilters').on('click', function() {
            $('#searchFilter').val('');
            $('#emailFilter').val('');
            $('#statusFilter').val('');
            $('#fromDate').val('');
            $('#toDate').val('');
            industriesTable.ajax.reload();
        });

        // Dropdown functionality for DataTables dynamic content
        $(document).on('click', 'button[onclick*="toggleDropdown"]', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const onclickAttr = $(this).attr('onclick');
            const match = onclickAttr.match(/toggleDropdown\((\d+)\)/);

            if (match) {
                const id = match[1];
                const dropdown = document.getElementById(`dropdown-${id}`);
                const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');

                allDropdowns.forEach(dd => {
                    if (dd !== dropdown) {
                        dd.classList.add('hidden');
                    }
                });

                if (dropdown) {
                    dropdown.classList.toggle('hidden');
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

        // Global function for onclick attributes
        function toggleDropdown(id) {
            const dropdown = document.getElementById(`dropdown-${id}`);
            if (!dropdown) return;

            // Close other dropdowns
            document.querySelectorAll('[id^="dropdown-"]').forEach(dd => {
                if (dd !== dropdown) dd.classList.add('hidden');
            });

            // Toggle this dropdown
            dropdown.classList.toggle('hidden');
        }


        // Filter toggle functionality
        document.getElementById('toggleFilters').addEventListener('click', function() {
            const filterContent = document.getElementById('filterContent');
            const filterIcon = document.getElementById('filterIcon');

            filterContent.classList.toggle('hidden');
            filterIcon.classList.toggle('rotate-180');
        });

        // Toggle Status function
        function toggleStatus(id) {
            Swal.fire({
                title: 'Toggle Status?',
                text: "This will change the industry's status",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, toggle it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/industries/${id}/toggle-status`;
                    form.innerHTML = `
                        @csrf
                        @method('PATCH')
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // Delete Industry function
        function deleteIndustry(id) {
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
                    // Create and submit delete form
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/industries/${id}`;
                    form.innerHTML = `
                        @csrf
                        @method('DELETE')
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
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
