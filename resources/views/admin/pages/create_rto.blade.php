@extends('admin.master_layout.index')
@section('page-title', 'Create RTO')
@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-brand/10 flex items-center justify-center">
                    <i class="bi bi-building text-brand text-lg"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Create New RTO</h1>
                    {{-- <p class="text-gray-600 mt-1">Add a new registered training organization</p> --}}
                </div>
            </div>
            <a href="{{ route('admin.rtos') }}"
                class="bg-gray-500 text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gray-600 transition-colors">
                <i class="bi bi-arrow-left mr-1"></i> Back to RTOs
            </a>
        </div>
    </div>

    <!-- Create Form -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('admin.rtos.store') }}" class="space-y-6" data-client-validate="rto" novalidate>
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-building mr-1 text-brand"></i> RTO Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter RTO Name" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('name') border-red-500 @enderror" />
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-hash mr-1 text-brand"></i> RTO Number <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="rto_number" value="{{ old('rto_number') }}" placeholder="Enter RTO Number"
                        required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('rto_number') border-red-500 @enderror" />
                    @error('rto_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-hash mr-1 text-red-500"></i> RTO Code <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="code" value="{{ old('code') }}" placeholder="Enter RTO Code" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('code') border-red-500 @enderror" />
                    @error('code')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-envelope mr-1 text-blue-600"></i> Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter Email" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('email') border-red-500 @enderror" />
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-shield-lock mr-1 text-amber-600"></i> Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password" placeholder="Enter Password" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('password') border-red-500 @enderror" />
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-phone mr-1 text-emerald-600"></i> Phone
                    </label>
                    <input type="number" name="phone" value="{{ old('phone') }}" placeholder="Enter Phone Number"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('phone') border-red-500 @enderror" />
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-person mr-1 text-indigo-600"></i> Contact Person
                    </label>
                    <input type="text" name="contact_person" value="{{ old('contact_person') }}"
                        placeholder="Enter Contact Person Name"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('contact_person') border-red-500 @enderror" />
                    @error('contact_person')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-globe mr-1 text-cyan-600"></i> Website
                    </label>
                    <input type="url" name="website" value="{{ old('website') }}" placeholder="https://example.com"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('website') border-red-500 @enderror" />
                    @error('website')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-geo-alt mr-1 text-rose-600"></i> Address
                    </label>
                    <input type="text" name="address" value="{{ old('address') }}" placeholder="Enter Address"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('address') border-red-500 @enderror" />
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex gap-3 pt-4 border-t">
                <button type="submit"
                    class="bg-brand text-white text-sm px-4 py-2 rounded-md hover:bg-gold transition-colors font-medium">
                    Create
                </button>
                <a href="{{ route('admin.rtos') }}"
                    class="bg-gray-500 text-white text-sm px-4 py-2 rounded-md hover:bg-gray-600 transition-colors font-medium">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const forms = document.querySelectorAll('form[data-client-validate="rto"]');

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
@endpush
