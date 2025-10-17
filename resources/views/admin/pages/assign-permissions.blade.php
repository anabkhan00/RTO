@extends('admin.master_layout.index')

@section('content')
<div class="p-6">
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-2xl font-semibold text-gray-800">Assign Permissions to Roles</h2>
        </div>
        
        <div class="p-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.assign-permissions') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Role</label>
                        <select name="role_id" id="roleSelect" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold focus:border-transparent" required>
                            <option value="">Choose Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" data-permissions="{{ $role->permissions->pluck('name')->toJson() }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Permissions</label>
                    <select name="permissions[]" id="permissionSelect" class="w-full" multiple>
                        @foreach($permissions as $permission)
                            <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-brand text-white rounded-lg hover:bg-gold transition">
                        Assign Permissions
                    </button>
                </div>
            </form>

            <!-- Current Role Permissions -->
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Current Role Permissions</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Permissions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($roles as $role)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $role->name }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($role->permissions as $permission)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ $permission->name }}</span>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
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
</style>
@endsection