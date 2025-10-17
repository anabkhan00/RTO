@extends('admin.master_layout.index')

@section('content')
<div class="p-6">
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-2xl font-semibold text-gray-800">Manage Roles</h2>
        </div>
        
        <div class="p-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Add Role Form -->
            <form method="POST" action="{{ route('admin.roles') }}" class="mb-6">
                @csrf
                <div class="flex gap-4">
                    <input type="text" name="name" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold focus:border-transparent" placeholder="Role Name" required>
                    <button type="submit" class="px-6 py-2 bg-brand text-white rounded-lg hover:bg-gold transition">Add Role</button>
                </div>
            </form>

            <!-- Roles Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Permissions</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($roles as $role)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $role->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span id="role-name-{{ $role->id }}" class="text-sm font-medium text-gray-900">{{ $role->name }}</span>
                                <form id="edit-form-{{ $role->id }}" method="POST" action="/admin/roles/{{ $role->id }}" class="hidden">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="name" value="{{ $role->name }}" class="px-2 py-1 border border-gray-300 rounded text-sm" required>
                                    <button type="submit" class="ml-2 px-2 py-1 bg-green-500 text-white rounded text-xs">Save</button>
                                    <button type="button" onclick="cancelEdit({{ $role->id }})" class="ml-1 px-2 py-1 bg-gray-500 text-white rounded text-xs">Cancel</button>
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($role->permissions as $permission)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ $permission->name }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $role->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="editRole({{ $role->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                                @if(!in_array($role->name, ['admin', 'user', 'rto']))
                                <form method="POST" action="/admin/roles/{{ $role->id }}" class="inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
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
</script>
@endsection