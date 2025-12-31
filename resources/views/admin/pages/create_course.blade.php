@extends('admin.master_layout.index')
@section('page-title', 'Create Course')
@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Create New Course</h1>
                <p class="text-gray-600 mt-1">Add a new course to the system</p>
            </div>
            <a href="{{ route('admin.courses') }}"
                class="bg-gray-500 text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gray-600 transition-colors">
                <i class="bi bi-arrow-left mr-1"></i> Back to Courses
            </a>
        </div>
    </div>

    <!-- Create Form -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('admin.courses.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-book mr-1"></i> Course Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter Course Name" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('name') border-red-500 @enderror" />
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-hash mr-1"></i> Course Code <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="code" value="{{ old('code') }}" placeholder="Enter Course Code" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('code') border-red-500 @enderror" />
                    @error('code')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-clock mr-1"></i> Credit Hours
                    </label>
                    <input type="text" name="credit_hours" value="{{ old('credit_hours') }}" placeholder="Enter Credit Hours"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('credit_hours') border-red-500 @enderror" />
                    @error('credit_hours')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="bi bi-file-text mr-1"></i> Description
                </label>
                <textarea name="description" rows="4" placeholder="Enter Course Description"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            </div>

            <!-- Document Checklist Section -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">
                    <i class="bi bi-list-check mr-2"></i>Document Checklist
                </h3>
                <p class="text-sm text-gray-600 mb-4">Select documents required for this course</p>
                
                <label class="block text-sm font-medium text-gray-700 mb-2">Required Documents</label>
                <select name="checklist_ids[]" id="checklistSelect" multiple class="w-full">
                    @foreach($checklists as $checklist)
                        <option value="{{ $checklist->id }}"
                            {{ in_array($checklist->id, old('checklist_ids', [])) ? 'selected' : '' }}>
                            {{ $checklist->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-3 pt-4 border-t">
                <button type="submit"
                    class="bg-brand text-white text-sm px-4 py-2 rounded-md hover:bg-gold transition-colors font-medium">
                     Create Course
                </button>
                <a href="{{ route('admin.courses') }}"
                    class="bg-gray-500 text-white text-sm px-4 py-2 rounded-md hover:bg-gray-600 transition-colors font-medium">
                     Cancel
                </a>
            </div>
        </form>
    </div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2-container--default .select2-selection--multiple {
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    min-height: 38px;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #d4af37;
    border: 1px solid #c19b2e;
    color: white;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#checklistSelect').select2({
        placeholder: 'Select required documents for this course',
        allowClear: true
    });
});
</script>
@endpush
