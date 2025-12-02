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
                        <i class="bi bi-phone mr-1"></i> Address
                    </label>
                    <input type="text" name="address" value="{{ old('address', $coordinator->address) }}" placeholder="Enter Address"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('address') border-red-500 @enderror" />
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
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
@endsection
