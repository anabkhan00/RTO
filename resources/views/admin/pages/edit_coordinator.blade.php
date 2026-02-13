@extends('admin.master_layout.index')
@section('page-title', 'Coordinator Details')
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #d4b373 !important;
        border: 1px solid #c19b2e !important;
        color: white !important;
    }
</style>
@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-brand/10 flex items-center justify-center">
                    <i class="bi bi-person-badge text-brand text-lg"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Edit Coordinator</h1>
                    {{-- <p class="text-gray-600 mt-1">Update coordinator details</p> --}}
                </div>
            </div>
            <a href="{{ route('admin.coordinators') }}"
                class="bg-gray-500 text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gray-600 transition-colors">
                <i class="bi bi-arrow-left mr-1"></i> Back to Coordinators
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('admin.coordinators.update', $coordinator->id) }}" class="space-y-6" data-client-validate="coordinator" novalidate>
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-person mr-1 text-brand"></i> Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $coordinator->name) }}" placeholder="Enter Coordinator Name" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('name') border-red-500 @enderror" />
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-envelope mr-1 text-blue-600"></i> Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email', $coordinator->email) }}" placeholder="Enter Email" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('email') border-red-500 @enderror" />
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-shield-lock mr-1 text-amber-600"></i> Password
                    </label>
                    <input type="password" name="password" placeholder="Leave blank to keep current password"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('password') border-red-500 @enderror" />
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-code-square mr-1 text-red-500"></i> Code <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="code" value="{{ old('code', $coordinator->coordinatorDetail->code ?? '') }}" placeholder="Enter Coordinator Code" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('code') border-red-500 @enderror" />
                    @error('code')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-person-badge mr-1 text-indigo-600"></i> Role <span class="text-red-500">*</span>
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

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-geo-alt mr-1 text-rose-600"></i> Address
                    </label>
                    <input type="text" name="address" value="{{ old('address', $coordinator->address) }}" placeholder="Enter Address"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('address') border-red-500 @enderror" />
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- RTO Assignment Section (Only for Placement Coordinators) -->
            <div id="rto-assignment-section" class="{{ old('role_type', $coordinator->getRoleNames()->first()) == 'placement_coordinator' ? '' : 'hidden' }}">
                <div class="border-t pt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-building mr-1 text-brand"></i> Assign RTOs
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
                     Update
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const forms = document.querySelectorAll('form[data-client-validate="coordinator"]');

            forms.forEach((form) => {
                form.addEventListener('submit', (e) => {
                    let firstInvalid = null;

                    form.querySelectorAll('.js-client-error').forEach((el) => el.remove());

                    form.querySelectorAll('[required]').forEach((field) => {
                        const isCheckbox = field.type === 'checkbox' || field.type === 'radio';
                        const isEmpty = isCheckbox ? !field.checked : field.value.trim() === '';

                        if (isEmpty) {
                            e.preventDefault();
                            field.classList.add('border-red-500');

                            const error = document.createElement('p');
                            error.className = 'text-red-500 text-xs mt-1 js-client-error';
                            error.textContent = 'This field is required.';
                            field.insertAdjacentElement('afterend', error);

                            if (!firstInvalid) {
                                firstInvalid = field;
                            }
                        } else {
                            field.classList.remove('border-red-500');
                        }
                    });

                    if (firstInvalid) {
                        firstInvalid.focus();
                    }
                });

                form.querySelectorAll('[required]').forEach((field) => {
                    field.addEventListener('input', () => {
                        field.classList.remove('border-red-500');
                        const next = field.nextElementSibling;
                        if (next && next.classList.contains('js-client-error')) {
                            next.remove();
                        }
                    });
                });
            });
        });
    </script>
@endsection
