@extends('admin.master_layout.index')
@section('page-title', 'Roles')
@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Roles Management</h1>
                <p class="text-gray-600 mt-1">Manage system roles and permissions</p>
            </div>
        </div>
    </div>

    <!-- Add Role Form -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Add New Role</h3>
        <form method="POST" action="{{ route('admin.roles') }}" class="flex gap-4">
            @csrf
            <input type="text" name="name" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand" placeholder="Role Name" required>
            <button type="submit" class="bg-brand text-white text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors font-medium">Add Role</button>
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search by Role Name</label>
                    <input type="text" id="searchFilter" placeholder="Search roles..."
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

    <!-- Roles Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table id="rolesTable" class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Role Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Permissions</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Created At</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($roles as $index => $role)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span id="role-name-{{ $role->id }}" class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-indigo-50 text-indigo-700 border-indigo-100 border shadow-sm">
                                    {{ $role->name }}
                                </span>
                                <form id="edit-form-{{ $role->id }}" method="POST" action="/admin/roles/{{ $role->id }}" class="hidden">
                                    @csrf
                                    @method('PUT')
                                    <div class="flex gap-2">
                                        <input type="text" name="name" value="{{ $role->name }}" class="px-2 py-1 border border-gray-300 rounded text-sm" required>
                                        <button type="submit" class="bg-green-600 text-white text-xs px-2 py-1 rounded font-medium">Save</button>
                                        <button type="button" onclick="cancelEdit({{ $role->id }})" class="bg-gray-500 text-white text-xs px-2 py-1 rounded font-medium">Cancel</button>
                                    </div>
                                </form>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($role->permissions as $permission)
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-blue-50 text-blue-700 border-blue-100 border">
                                            {{ $permission->name }}
                                        </span>
                                    @endforeach
                                    @if($role->permissions->count() == 0)
                                        <span class="text-gray-400 text-xs">No permissions assigned</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{ $role->created_at->format('j M Y') }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <div class="relative">
                                    <button onclick="toggleDropdown({{ $index }})"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <div id="dropdown-{{ $index }}"
                                        class="hidden absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg z-10 border">
                                        <button onclick="editRole({{ $role->id }})"
                                            class="block w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 rounded-md">
                                            <i class="bi bi-pencil mr-2"></i>Edit
                                        </button>
                                        @if(!in_array($role->name, ['admin', 'user', 'rto', 'coordinator']))
                                            <button onclick="deleteRole({{ $role->id }})"
                                                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md">
                                                <i class="bi bi-trash mr-2"></i>Delete
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <form id="delete-form-{{ $role->id }}" method="POST" action="/admin/roles/{{ $role->id }}" class="hidden">
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
function editRole(id) {
    document.getElementById('role-name-' + id).classList.add('hidden');
    document.getElementById('edit-form-' + id).classList.remove('hidden');
}

function cancelEdit(id) {
    document.getElementById('role-name-' + id).classList.remove('hidden');
    document.getElementById('edit-form-' + id).classList.add('hidden');
}

function deleteRole(id) {
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
    const rolesTable = $('#rolesTable').DataTable({
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
    const applyFilters = document.getElementById('applyFilters');
    const resetFilters = document.getElementById('resetFilters');

    function filterTable() {
        const searchTerm = searchFilter.value.toLowerCase();

        rolesTable.rows().every(function() {
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
        rolesTable.rows().every(function() {
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