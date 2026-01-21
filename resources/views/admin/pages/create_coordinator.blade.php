@extends('admin.master_layout.index')
@section('page-title', 'Create Coordinator')
<style>
.select2-container {
        width: 100% !important;
    }
</style>
@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Create New Coordinator</h1>
                <p class="text-gray-600 mt-1">Add a new coordinator to the system</p>
            </div>
            <a href="{{ route('admin.coordinators') }}"
                class="bg-gray-500 text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gray-600 transition-colors">
                <i class="bi bi-arrow-left mr-1"></i> Back to Coordinators
            </a>
        </div>
    </div>

    <!-- Create Form -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('admin.coordinators.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-person mr-1"></i> Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter Coordinator Name" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('name') border-red-500 @enderror" />
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-envelope mr-1"></i> Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter Email" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('email') border-red-500 @enderror" />
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-code-square mr-1"></i> Code <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="code" value="{{ old('code') }}" placeholder="Enter Coordinator Code" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('code') border-red-500 @enderror" />
                    @error('code')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-person-badge mr-1"></i> Role <span class="text-red-500">*</span>
                    </label>
                    <select name="role_type" id="role_type" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all bg-white @error('role_type') border-red-500 @enderror">
                        <option value="">Select Coordinator Role</option>
                        <option value="sourcing_coordinator" {{ old('role_type') == 'sourcing_coordinator' ? 'selected' : '' }}>Sourcing Coordinator</option>
                        <option value="placement_coordinator" {{ old('role_type') == 'placement_coordinator' ? 'selected' : '' }}>Placement Coordinator</option>
                    </select>
                    @error('role_type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-phone mr-1"></i> Phone
                    </label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Enter Phone Number"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('phone') border-red-500 @enderror" />
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-geo-alt mr-1"></i> Address
                    </label>
                    <input type="text" name="address" value="{{ old('address') }}" placeholder="Enter Address"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('address') border-red-500 @enderror" />
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div> --}}
            </div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- existing fields --}}

    <div id="rto-assignment-section" class="hidden col-span-1 md:col-span-2 w-full">

        <div class="border-t pt-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="bi bi-building mr-1"></i> Assign RTOs
            </label>

            <select name="rto_ids[]" id="rto_select" multiple
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                @foreach($rtos as $rto)
                    <option value="{{ $rto->id }}">{{ $rto->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

</div>


            <div class="flex gap-3 pt-4 border-t">
                <button type="submit"
                    class="bg-brand text-white text-sm px-4 py-2 rounded-md hover:bg-gold transition-colors font-medium">
                     Create Coordinator
                </button>
                <a href="{{ route('admin.coordinators') }}"
                    class="bg-gray-500 text-white text-sm px-4 py-2 rounded-md hover:bg-gray-600 transition-colors font-medium">
                     Cancel
                </a>
            </div>
        </form>
    </div>

<script>
    $(document).ready(function() {

        $('#rto_select').select2({
            placeholder: 'Select RTOs',
            allowClear: true,
            width: '100%'   // 🔥 THIS IS REQUIRED
        });

        $('#role_type').on('change', function() {
            if ($(this).val() === 'placement_coordinator') {
                $('#rto-assignment-section').removeClass('hidden');
            } else {
                $('#rto-assignment-section').addClass('hidden');
            }
        });

    });
</script>

@endsection
