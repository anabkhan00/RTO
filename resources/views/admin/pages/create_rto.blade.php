@extends('admin.master_layout.index')
@section('page-title', 'Create RTO')
@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Create New RTO</h1>
                <p class="text-gray-600 mt-1">Add a new registered training organization</p>
            </div>
            <a href="{{ route('admin.rtos') }}"
                class="bg-gray-500 text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gray-600 transition-colors">
                <i class="bi bi-arrow-left mr-1"></i> Back to RTOs
            </a>
        </div>
    </div>

    <!-- Create Form -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('admin.rtos.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-building mr-1"></i> RTO Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter RTO Name" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('name') border-red-500 @enderror" />
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-hash mr-1"></i> RTO Number <span class="text-red-500">*</span>
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
                        <i class="bi bi-hash mr-1"></i> RTO Code <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="code" value="{{ old('code') }}" placeholder="Enter RTO Code" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('code') border-red-500 @enderror" />
                    @error('code')
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
                        <i class="bi bi-phone mr-1"></i> Phone
                    </label>
                    <input type="number" name="phone" value="{{ old('phone') }}" placeholder="Enter Phone Number"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('phone') border-red-500 @enderror" />
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-person mr-1"></i> Contact Person
                    </label>
                    <input type="number" name="contact_person" value="{{ old('contact_person') }}"
                        placeholder="Enter Contact Person Name"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('contact_person') border-red-500 @enderror" />
                    @error('contact_person')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-globe mr-1"></i> Website
                    </label>
                    <input type="url" name="website" value="{{ old('website') }}" placeholder="https://example.com"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('website') border-red-500 @enderror" />
                    @error('website')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-globe mr-1"></i> Address
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
                    Create RTO
                </button>
                <a href="{{ route('admin.rtos') }}"
                    class="bg-gray-500 text-white text-sm px-4 py-2 rounded-md hover:bg-gray-600 transition-colors font-medium">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
