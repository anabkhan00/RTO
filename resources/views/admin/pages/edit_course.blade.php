@extends('admin.master_layout.index')
@section('page-title', 'Course Details')
@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-brand/10 flex items-center justify-center">
                    <i class="bi bi-book text-brand text-lg"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Edit Course</h1>
                    {{-- <p class="text-gray-600 mt-1">Update course details</p> --}}
                </div>
            </div>
            <a href="{{ route('admin.courses') }}"
                class="bg-gray-500 text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gray-600 transition-colors">
                <i class="bi bi-arrow-left mr-1"></i> Back to Courses
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('admin.courses.update', $course->id) }}" class="space-y-6" data-client-validate="course" novalidate>
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-book mr-1 text-brand"></i> Course Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $course->name) }}"
                        placeholder="Enter Course Name" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('name') border-red-500 @enderror" />
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-hash mr-1 text-red-500"></i> Course Code <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="code" value="{{ old('code', $course->code) }}"
                        placeholder="Enter Course Code" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('code') border-red-500 @enderror" />
                    @error('code')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-clock mr-1 text-emerald-600"></i> Credit Hours
                    </label>
                    <input type="text" name="credit_hours" value="{{ old('credit_hours', $course->credit_hours) }}"
                        placeholder="Enter Credit Hours"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('credit_hours') border-red-500 @enderror" />
                    @error('credit_hours')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-file-text mr-1 text-indigo-600"></i> Description
                    </label>
                    <textarea name="description" placeholder="Enter Course Description"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('description') border-red-500 @enderror">{{ old('description', $course->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Document Checklist Section -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">
                    <i class="bi bi-list-check mr-2 text-amber-600"></i>Document Checklist
                </h3>
                <p class="text-sm text-gray-600 mb-4">Select documents required for this course</p>

                <label class="block text-sm font-medium text-gray-700 mb-2">Required Documents</label>
                <select name="checklist_ids[]" id="checklistSelect" multiple class="w-full">
                    @foreach($checklists as $checklist)
                        <option value="{{ $checklist->id }}"
                            {{ $course->courseChecklist && in_array($checklist->id, $course->courseChecklist->checklist_ids ?? []) ? 'selected' : '' }}>
                            {{ $checklist->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-3 pt-4 border-t">
                <button type="submit"
                    class="bg-brand text-white text-sm px-4 py-2 rounded-md hover:bg-gold transition-colors font-medium">
                    Update
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
<style>
.select2-container--default .select2-selection--multiple {
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    min-height: 38px;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #d4b373 !important;
    border: 1px solid #c19b2e !important;
    color: white !important;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('#checklistSelect').select2({
        placeholder: 'Select required documents for this course',
        allowClear: true
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('form[data-client-validate="course"]');

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
