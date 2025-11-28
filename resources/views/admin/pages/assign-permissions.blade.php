@extends('admin.master_layout.index')
@section('page-title', 'Assign Permissions')
@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Assign Permissions</h1>
                <p class="text-gray-600 mt-1">Assign permissions to roles and manage access controls</p>
            </div>
        </div>
    </div>

    <!-- Assignment Form -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Assign Permissions to Role</h3>
        <form method="POST" action="{{ route('admin.assign-permissions') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Role</label>
                    <select name="role_id" id="roleSelect" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white" required>
                        <option value="">Choose Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" data-permissions="{{ $role->permissions->pluck('name')->toJson() }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Permissions</label>
                    <select name="permissions[]" id="permissionSelect" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white" multiple>
                        @foreach($permissions as $permission)
                            <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex justify-start">
                <button type="submit" class="bg-brand text-white text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors font-medium">
                    Assign Permissions
                </button>
            </div>
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

    <!-- Role Permissions Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table id="rolePermissionsTable" class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Role Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Assigned Permissions</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Permission Count</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($roles as $index => $role)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-indigo-50 text-indigo-700 border-indigo-100 border shadow-sm">
                                    {{ $role->name }}
                                </span>
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
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-gray-50 text-gray-700 border-gray-100 border shadow-sm">
                                    {{ $role->permissions->count() }} permission{{ $role->permissions->count() != 1 ? 's' : '' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
// Filter toggle functionality
document.getElementById('toggleFilters').addEventListener('click', function() {
    const filterContent = document.getElementById('filterContent');
    const filterIcon = document.getElementById('filterIcon');
    filterContent.classList.toggle('hidden');
    filterIcon.classList.toggle('rotate-180');
});

$(document).ready(function() {
    // Initialize Select2
    $('#roleSelect').select2({
        placeholder: 'Choose Role',
        allowClear: true
    });
    
    $('#permissionSelect').select2({
        placeholder: 'Select Permissions',
        allowClear: true
    });
    
    // Load existing permissions when role is selected
    $('#roleSelect').on('change', function() {
        const selectedOption = $(this).find('option:selected');
        const permissions = selectedOption.data('permissions');
        
        // Clear current selection
        $('#permissionSelect').val(null).trigger('change');
        
        // Set existing permissions
        if (permissions && permissions.length > 0) {
            $('#permissionSelect').val(permissions).trigger('change');
        }
    });

    // Initialize DataTable
    const rolePermissionsTable = $('#rolePermissionsTable').DataTable({
        "pageLength": 25,
        "searching": false,
        "ordering": true,
        "info": false,
        "lengthChange": false,
        "dom": 'rt<"flex justify-end mt-4"p>',
        "scrollX": true
    });

    // Filter functionality
    const searchFilter = document.getElementById('searchFilter');
    const applyFilters = document.getElementById('applyFilters');
    const resetFilters = document.getElementById('resetFilters');

    function filterTable() {
        const searchTerm = searchFilter.value.toLowerCase();

        rolePermissionsTable.rows().every(function() {
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
        rolePermissionsTable.rows().every(function() {
            $(this.node()).show();
        });
    });
});
</script>

<style>
.select2-container--default .select2-selection--multiple {
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    min-height: 42px;
}

.select2-container--default .select2-selection--single {
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    height: 42px;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 40px;
    padding-left: 12px;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 40px;
}

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