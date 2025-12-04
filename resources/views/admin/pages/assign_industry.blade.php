@extends('admin.master_layout.index')

@section('page-title', 'Assign Industries')

@section('content')
<div class="p-4 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-medium text-gray-800 mb-1">Industry Assignment</h1>
            <p class="text-sm text-gray-500">Assign students to industries efficiently</p>
        </div>

        <!-- Industry Selection Panel -->
        <div class="bg-white rounded-lg shadow-sm border p-4 mb-6">
            <h2 class="text-base font-medium text-gray-700 mb-3 flex items-center">
                <i class="fas fa-industry text-brand text-sm mr-2"></i>
                Select Industry
            </h2>
            <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-2">
                @foreach($industries as $industry)
                <div class="industry-card cursor-pointer p-2 rounded-lg border hover:border-brand hover:shadow-sm transition-all duration-200 bg-white"
                     data-industry-id="{{ $industry->id }}" data-industry-name="{{ $industry->name }}">
                    <div class="text-center">
                        <div class="w-8 h-8 bg-brand rounded-lg flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-building text-white text-xs"></i>
                        </div>
                        <h3 class="text-xs text-gray-700 font-medium truncate" title="{{ $industry->name }}">{{ $industry->name }}</h3>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Students Grid -->
        <div class="bg-white rounded-lg shadow-sm border p-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-base font-medium text-gray-700 flex items-center">
                    <i class="fas fa-users text-brand text-sm mr-2"></i>
                    Students
                </h2>
                <div class="flex items-center space-x-3">
                    <button id="selectAllBtn" class="px-3 py-1.5 bg-gray-100 text-gray-600 rounded-md hover:bg-gray-200 transition-colors text-xs">
                        Select All
                    </button>
                    <button id="assignBtn" class="px-4 py-1.5 bg-brand text-white rounded-md hover:bg-gold transition-all disabled:opacity-50 disabled:cursor-not-allowed text-xs" disabled>
                        Assign Selected
                    </button>
                </div>
            </div>

            <!-- Search -->
            <div class="mb-4">
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Search students..."
                           class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-brand focus:border-brand text-sm">
                    <i class="fas fa-search absolute left-2.5 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs"></i>
                </div>
            </div>

            <!-- Students Grid -->
            <div id="studentsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3">
                @foreach($students as $student)
                <div class="student-card bg-white rounded-lg p-3 border hover:shadow-sm transition-all duration-200 cursor-pointer"
                     data-student-id="{{ $student->id }}" data-student-name="{{ $student->name }}">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-brand rounded-full flex items-center justify-center text-white text-xs font-medium mr-2">
                                {{ substr($student->name, 0, 1) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-sm font-medium text-gray-800 truncate">{{ $student->name }}</h3>
                                <p class="text-xs text-gray-500 truncate">{{ $student->email }}</p>
                            </div>
                        </div>
                        <input type="checkbox" class="student-checkbox w-4 h-4 text-brand rounded focus:ring-brand">
                    </div>

                    <!-- Assigned Industries -->
                    <div class="assigned-industries">
                        @if($student->assignedIndustries->count() > 0)
                            <div class="flex flex-wrap gap-1">
                                @foreach($student->assignedIndustries as $industry)
                                <span class="inline-flex items-center px-2 py-0.5 text-xs rounded-md bg-brand/10 text-brand border border-brand/20">
                                    <span class="truncate max-w-20">{{ $industry->name }}</span>
                                    <button class="ml-1 text-brand hover:text-red-500 remove-industry"
                                            data-student-id="{{ $student->id }}" data-industry-id="{{ $industry->id }}">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                </span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-400 text-xs">No industries assigned</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Success Toast -->
{{-- <div id="successToast" class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg transform translate-x-full transition-transform duration-300 z-50">
    <div class="flex items-center">
        <i class="fas fa-check-circle mr-2 text-sm"></i>
        <span class="text-sm">Assignment successful!</span>
    </div>
</div> --}}

<style>
.industry-card.selected {
    border-color: var(--brand-color, #d4af37);
    background-color: #fef3c7;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.student-card.selected {
    border-color: var(--brand-color, #d4af37);
    background-color: #fef3c7;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.student-card:hover {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.industry-card:hover {
    box-shadow: 0 1px 6px rgba(0, 0, 0, 0.1);
}

.max-w-20 {
    max-width: 5rem;
}
</style>

<script>
let selectedIndustry = null;
let selectedStudents = [];

$(document).ready(function() {
    // Industry selection
    $('.industry-card').click(function() {
        $('.industry-card').removeClass('selected');
        $(this).addClass('selected');
        selectedIndustry = {
            id: $(this).data('industry-id'),
            name: $(this).data('industry-name')
        };
        updateAssignButton();
    });

    // Student selection
    $('.student-card').click(function(e) {
        if (e.target.type !== 'checkbox') {
            const checkbox = $(this).find('.student-checkbox');
            checkbox.prop('checked', !checkbox.prop('checked'));
        }
        updateStudentSelection();
    });

    $('.student-checkbox').change(function() {
        updateStudentSelection();
    });

    // Select all functionality
    $('#selectAllBtn').click(function() {
        const allChecked = $('.student-checkbox:checked').length === $('.student-checkbox').length;
        $('.student-checkbox').prop('checked', !allChecked);
        updateStudentSelection();
        $(this).text(allChecked ? 'Select All' : 'Deselect All');
    });

    // Search functionality
    $('#searchInput').on('input', function() {
        const searchTerm = $(this).val().toLowerCase();
        $('.student-card').each(function() {
            const studentName = $(this).data('student-name').toLowerCase();
            if (studentName.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Assign button
    $('#assignBtn').click(function() {
        if (selectedIndustry && selectedStudents.length > 0) {
            assignStudents();
        }
    });

    // Remove industry assignment
    $('.remove-industry').click(function(e) {
        e.stopPropagation();
        const studentId = $(this).data('student-id');
        const industryId = $(this).data('industry-id');
        removeAssignment(studentId, industryId, $(this));
    });
});

function updateStudentSelection() {
    selectedStudents = [];
    $('.student-checkbox:checked').each(function() {
        const card = $(this).closest('.student-card');
        selectedStudents.push(card.data('student-id'));
        card.addClass('selected');
    });

    $('.student-checkbox:not(:checked)').each(function() {
        $(this).closest('.student-card').removeClass('selected');
    });

    updateAssignButton();
}

function updateAssignButton() {
    const btn = $('#assignBtn');
    if (selectedIndustry && selectedStudents.length > 0) {
        btn.prop('disabled', false);
        btn.text(`Assign ${selectedStudents.length} student(s) to ${selectedIndustry.name}`);
    } else {
        btn.prop('disabled', true);
        btn.text('Assign Selected');
    }
}

function assignStudents() {
    $.ajax({
        url: '{{ route("admin.student-industry.bulk-assign") }}',
        method: 'POST',
        data: {
            student_ids: selectedStudents,
            industry_id: selectedIndustry.id,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            showSuccessToast();
            setTimeout(() => location.reload(), 1000);
        },
        error: function() {
            alert('Error assigning students');
        }
    });
}

function removeAssignment(studentId, industryId, element) {
    $.ajax({
        url: '{{ route("admin.student-industry.remove") }}',
        method: 'POST',
        data: {
            student_id: studentId,
            industry_id: industryId,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            element.closest('span').fadeOut(300, function() {
                $(this).remove();
            });
        },
        error: function() {
            alert('Error removing assignment');
        }
    });
}

function showSuccessToast() {
    const toast = $('#successToast');
    toast.removeClass('translate-x-full');
    setTimeout(() => {
        toast.addClass('translate-x-full');
    }, 3000);
}
</script>
@endsection
