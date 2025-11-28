@extends('admin.master_layout.index')
@section('page-title', 'Permissions')
@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Permissions Management</h1>
                <p class="text-gray-600 mt-1">Manage system permissions and access controls</p>
            </div>
        </div>
    </div>

    <!-- Add Permission Form -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Add New Permission</h3>
        <form method="POST" action="{{ route('admin.permissions') }}" class="flex gap-4">
            @csrf
            <input type="text" name="name" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand" placeholder="Permission Name" required>
            <button type="submit" class="bg-brand text-white text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors font-medium">Add Permission</button>
        </form>
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search by Permission Name</label>
                    <input type="text" id="searchFilter" placeholder="Search permissions..."
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

    <!-- Permissions Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table id="permissionsTable" class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Permission Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Created At</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($permissions as $index => $permission)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span id="permission-name-{{ $permission->id }}" class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-orange-50 text-orange-700 border-orange-100 border shadow-sm">
                                    {{ $permission->name }}
                                </span>
                                <form id="edit-form-{{ $permission->id }}" method="POST" action="/admin/permissions/{{ $permission->id }}" class="hidden">
                                    @csrf
                                    @method('PUT')
                                    <div class="flex gap-2">
                                        <input type="text" name="name" value="{{ $permission->name }}" class="px-2 py-1 border border-gray-300 rounded text-sm" required>
                                        <button type="submit" class="bg-green-600 text-white text-xs px-2 py-1 rounded font-medium">Save</button>
                                        <button type="button" onclick="cancelEdit({{ $permission->id }})" class="bg-gray-500 text-white text-xs px-2 py-1 rounded font-medium">Cancel</button>
                                    </div>
                                </form>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{ $permission->created_at->format('j M Y') }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <div class="relative">
                                    <button onclick="toggleDropdown({{ $index }})"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <div id="dropdown-{{ $index }}"
                                        class="hidden absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg z-10 border">
                                        <button onclick="editPermission({{ $permission->id }})"
                                            class="block w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 rounded-md">
                                            <i class="bi bi-pencil mr-2"></i>Edit
                                        </button>
                                        <button onclick="deletePermission({{ $permission->id }})"
                                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md">
                                            <i class="bi bi-trash mr-2"></i>Delete
                                        </button>
                                    </div>
                                </div>
                                <form id="delete-form-{{ $permission->id }}" method="POST" action="/admin/permissions/{{ $permission->id }}" class="hidden">
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

<script>
function editPermission(id) {
    document.getElementById('permission-name-' + id).classList.add('hidden');
    document.getElementById('edit-form-' + id).classList.remove('hidden');
}

function cancelEdit(id) {
    document.getElementById('permission-name-' + id).classList.remove('hidden');
    document.getElementById('edit-form-' + id).classList.add('hidden');
}

function deletePermission(id) {
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
    const permissionsTable = $('#permissionsTable').DataTable({
        "pageLength": 25,
        "searching": false,
        "ordering": true,
        "info": false,
        "lengthChange": false,
        "columnDefs": [{
            "orderable": false,
            "targets": [2]
        }],
        "dom": 'rt<"flex justify-end mt-4"p>',
        "scrollX": true
    });

    // Filter functionality
    const searchFilter = document.getElementById('searchFilter');
    const applyFilters = document.getElementById('applyFilters');
    const resetFilters = document.getElementById('resetFilters');

    function filterTable() {
        const searchTerm = searchFilter.value.toLowerCase();

        permissionsTable.rows().every(function() {
            const row = this.node();
            const name = row.cells[0].textContent.toLowerCase();

            let showRow = true;

            if (searchTerm && !name.includes(searchTerm)) {
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
    applyFilters.addEventListener('click', filterTable);

    resetFilters.addEventListener('click', () => {
        searchFilter.value = '';
        permissionsTable.rows().every(function() {
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