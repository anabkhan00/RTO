@extends('admin.master_layout.index')

@section('title', 'Assign Students')

@section('content')
<div class="p-4 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-medium text-gray-800 mb-1">Student Assignment</h1>
            <p class="text-sm text-gray-500">Assign qualified students to placement opportunities</p>
        </div>

        <!-- Opportunities Panel -->
        <div class="bg-white rounded-lg shadow-sm border p-4 mb-6">
            <h2 class="text-base font-medium text-gray-700 mb-3 flex items-center">
                <i class="fas fa-briefcase text-brand text-sm mr-2"></i>
                Available Opportunities
            </h2>

            @if($opportunities->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($opportunities as $opportunity)
                <div class="opportunity-card border rounded-lg p-3 cursor-pointer hover:shadow-sm transition-all {{ $opportunity->available_slots == 0 ? 'opacity-50' : '' }}"
                     data-opportunity-id="{{ $opportunity->id }}"
                     data-opportunity-name="{{ $opportunity->industry->name }}"
                     data-available-slots="{{ $opportunity->available_slots }}">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-medium text-gray-800 text-sm">{{ $opportunity->industry->name }}</h3>
                        <span class="text-xs text-gray-500">by {{ $opportunity->sourcingCoordinator->name }}</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2 text-xs mb-2">
                        <div class="text-center">
                            <div class="font-medium text-gray-800">{{ $opportunity->total_slots }}</div>
                            <div class="text-gray-500">Total</div>
                        </div>
                        <div class="text-center">
                            <div class="font-medium text-red-600">{{ $opportunity->filled_slots }}</div>
                            <div class="text-gray-500">Filled</div>
                        </div>
                        <div class="text-center">
                            <div class="font-medium text-green-600">{{ $opportunity->available_slots }}</div>
                            <div class="text-gray-500">Available</div>
                        </div>
                    </div>

                    @if($opportunity->assignments->count() > 0)
                    <div class="mb-2">
                        <p class="text-xs text-gray-600 mb-1">Assigned Students:</p>
                        <div class="flex flex-wrap gap-1">
                            @foreach($opportunity->assignments as $assignment)
                            <span class="inline-flex items-center px-2 py-0.5 text-xs rounded-md bg-brand/10 text-brand">
                                {{ $assignment->student->name }}
                                <button class="ml-1 text-brand hover:text-red-500 remove-assignment"
                                        data-opportunity-id="{{ $opportunity->id }}"
                                        data-student-id="{{ $assignment->student->id }}">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($opportunity->requirements)
                    <p class="text-xs text-gray-600 bg-gray-50 p-2 rounded">{{ $opportunity->requirements }}</p>
                    @endif
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-6">
                <i class="fas fa-briefcase text-gray-300 text-3xl mb-3"></i>
                <p class="text-gray-500">No placement opportunities available</p>
            </div>
            @endif
        </div>

        <!-- Students Panel -->
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

            <div class="mb-4">
                <input type="text" id="searchInput" placeholder="Search students..."
                       class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md focus:ring-1 focus:ring-brand focus:border-brand text-sm">
                <i class="fas fa-search absolute left-2.5 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs"></i>
            </div>

            <div id="studentsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3">
                @foreach($students as $student)
                <div class="student-card bg-white rounded-lg p-3 border hover:shadow-sm transition-all cursor-pointer"
                     data-student-id="{{ $student->id }}" data-student-name="{{ $student->name }}">
                    <div class="flex items-center justify-between">
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
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
.opportunity-card.selected {
    border-color: var(--brand-color, #d4af37);
    background-color: #fef3c7;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.student-card.selected {
    border-color: var(--brand-color, #d4af37);
    background-color: #fef3c7;
}
</style>

<script>
let selectedOpportunity = null;
let selectedStudents = [];

$(document).ready(function() {
    $('.opportunity-card').click(function() {
        if ($(this).data('available-slots') == 0) return;

        $('.opportunity-card').removeClass('selected');
        $(this).addClass('selected');
        selectedOpportunity = {
            id: $(this).data('opportunity-id'),
            name: $(this).data('opportunity-name'),
            availableSlots: $(this).data('available-slots')
        };
        updateAssignButton();
    });

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

    $('#selectAllBtn').click(function() {
        const allChecked = $('.student-checkbox:checked').length === $('.student-checkbox').length;
        $('.student-checkbox').prop('checked', !allChecked);
        updateStudentSelection();
        $(this).text(allChecked ? 'Select All' : 'Deselect All');
    });

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

    $('#assignBtn').click(function() {
        if (selectedOpportunity && selectedStudents.length > 0) {
            assignStudents();
        }
    });

    $('.remove-assignment').click(function(e) {
        e.stopPropagation();
        const opportunityId = $(this).data('opportunity-id');
        const studentId = $(this).data('student-id');
        removeAssignment(opportunityId, studentId, $(this));
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
    if (selectedOpportunity && selectedStudents.length > 0) {
        if (selectedStudents.length > selectedOpportunity.availableSlots) {
            btn.prop('disabled', true);
            btn.text(`Only ${selectedOpportunity.availableSlots} slots available`);
        } else {
            btn.prop('disabled', false);
            btn.text(`Assign ${selectedStudents.length} to ${selectedOpportunity.name}`);
        }
    } else {
        btn.prop('disabled', true);
        btn.text('Assign Selected');
    }
}

function assignStudents() {
    $.ajax({
        url: '{{ route("admin.assign-students.assign") }}',
        method: 'POST',
        data: {
            opportunity_id: selectedOpportunity.id,
            student_ids: selectedStudents,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            showSuccessToast();
            setTimeout(() => location.reload(), 1000);
        },
        error: function(xhr) {
            alert(xhr.responseJSON?.error || 'Error assigning students');
        }
    });
}

function removeAssignment(opportunityId, studentId, element) {
    $.ajax({
        url: '{{ route("admin.assign-students.remove") }}',
        method: 'POST',
        data: {
            opportunity_id: opportunityId,
            student_id: studentId,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            element.closest('span').fadeOut(300, function() {
                $(this).remove();
                location.reload();
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
