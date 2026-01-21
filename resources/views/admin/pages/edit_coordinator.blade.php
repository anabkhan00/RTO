@extends('admin.master_layout.index')
@section('page-title', 'Edit Coordinator')
@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Edit Coordinator</h1>
                <p class="text-gray-600 mt-1">Update coordinator details</p>
            </div>
            <a href="{{ route('admin.coordinators') }}"
                class="bg-gray-500 text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gray-600 transition-colors">
                <i class="bi bi-arrow-left mr-1"></i> Back to Coordinators
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('admin.coordinators.update', $coordinator->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-person mr-1"></i> Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $coordinator->name) }}" placeholder="Enter Coordinator Name" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('name') border-red-500 @enderror" />
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-envelope mr-1"></i> Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email', $coordinator->email) }}" placeholder="Enter Email" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('email') border-red-500 @enderror" />
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-code-square mr-1"></i> Code <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="code" value="{{ old('code', $coordinator->coordinatorDetail->code ?? '') }}" placeholder="Enter Coordinator Code" required
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
                        <option value="sourcing_coordinator" {{ old('role_type', $coordinator->getRoleNames()->first()) == 'sourcing_coordinator' ? 'selected' : '' }}>Sourcing Coordinator</option>
                        <option value="placement_coordinator" {{ old('role_type', $coordinator->getRoleNames()->first()) == 'placement_coordinator' ? 'selected' : '' }}>Placement Coordinator</option>
                    </select>
                    @error('role_type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-phone mr-1"></i> Phone
                    </label>
                    <input type="text" name="phone" value="{{ old('phone', $coordinator->phone) }}" placeholder="Enter Phone Number"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('phone') border-red-500 @enderror" />
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-geo-alt mr-1"></i> Address
                    </label>
                    <input type="text" name="address" value="{{ old('address', $coordinator->address) }}" placeholder="Enter Address"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('address') border-red-500 @enderror" />
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div> --}}
            </div>

            <!-- RTO Assignment Section (Only for Placement Coordinators) -->
            <div id="rto-assignment-section" class="{{ old('role_type', $coordinator->getRoleNames()->first()) == 'placement_coordinator' ? '' : 'hidden' }}">
                <div class="border-t pt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-building mr-1"></i> Assign RTOs
                    </label>
                    <select name="rto_ids[]" id="rto_select" multiple class="w-full">
                        @foreach($rtos as $rto)
                            <option value="{{ $rto->id }}" {{ $coordinator->assignedRtos->contains($rto->id) ? 'selected' : '' }}>
                                {{ $rto->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex gap-3 pt-4 border-t">
                <button type="submit"
                    class="bg-brand text-white text-sm px-4 py-2 rounded-md hover:bg-gold transition-colors font-medium">
                     Update Coordinator
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
                allowClear: true
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
