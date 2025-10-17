@extends('admin.master_layout.index')

@section('content')
<div class="p-6">
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-2xl font-semibold text-gray-800">Create Users</h2>
        </div>
        
        <div class="p-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.create-users') }}" class="space-y-4">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                        <select name="role" id="roleSelect" required onchange="toggleFields()"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold focus:border-transparent">
                            <option value="">Select Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ ucfirst($role->name === 'user' ? 'student' : $role->name) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                        <input type="text" name="name" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold focus:border-transparent"
                            placeholder="Enter Name">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold focus:border-transparent"
                            placeholder="Enter Email">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold focus:border-transparent"
                            placeholder="Enter Password">
                    </div>
                </div>

                <!-- Student Address Field -->
                <div id="studentField" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                    <input type="text" name="address"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold focus:border-transparent"
                        placeholder="Enter Address">
                </div>

                <!-- RTO Number Field -->
                <div id="rtoField" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">RTO Number</label>
                    <input type="text" name="rto_number"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gold focus:border-transparent"
                        placeholder="Enter RTO Number">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-brand text-white rounded-lg hover:bg-gold transition">
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleFields() {
    const roleSelect = document.getElementById('roleSelect');
    const studentField = document.getElementById('studentField');
    const rtoField = document.getElementById('rtoField');
    
    // Hide all fields first
    studentField.classList.add('hidden');
    rtoField.classList.add('hidden');
    
    // Show relevant field based on selection
    if (roleSelect.value === 'user') {
        studentField.classList.remove('hidden');
    } else if (roleSelect.value === 'rto') {
        rtoField.classList.remove('hidden');
    }
}
</script>
@endsection