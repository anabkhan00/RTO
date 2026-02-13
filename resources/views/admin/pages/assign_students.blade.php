@extends('admin.master_layout.index')
@section('page-title', 'Assign Students')

@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Assign Students</h1>
                <p class="text-gray-600 mt-1">Assign students to sourcing coordinators for placement assistance</p>
            </div>
            <div class="flex gap-3">
                <button id="bulkAssignBtn" class="bg-brand text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors" disabled>
                    <i class="bi bi-people mr-1"></i>Bulk Assign (<span id="selectedCount">0</span>)
                </button>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="p-4 border-b border-gray-200">
            <button id="toggleFilters" class="flex items-center justify-between w-full text-left">
                <h3 class="text-lg font-semibold text-gray-800">Filters</h3>
                <i id="filterIcon" class="bi bi-chevron-down text-gray-500 transition-transform"></i>
            </button>
        </div>
        <div id="filterContent" class="hidden p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <input type="text" id="searchFilter" placeholder="Search students..."
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                </div>
                <div>
                    <select id="courseFilter"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                        <option value="">All Courses</option>
                        @foreach($students->pluck('course.name')->unique()->filter() as $course)
                        <option value="{{ $course }}">{{ $course }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select id="statusFilter"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                        <option value="">All Status</option>
                        <option value="available">Available</option>
                        <option value="assigned">Already Assigned</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button id="resetFilters"
                        class="bg-gray-500 text-white text-xs px-3 py-1.5 rounded-md hover:bg-gray-600 transition-colors font-medium">
                        Reset Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Students Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-brand focus:ring-brand">
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Student</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Course</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Contact</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Documents</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Status</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($students as $student)
                    @php
                        $hasActiveAssignment = $student->assignmentRequests()
                            ->whereIn('status', ['pending', 'in_progress'])
                            ->exists();
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors student-row"
                        data-student-id="{{ $student->id }}"
                        data-course="{{ $student->course->name ?? '' }}"
                        data-status="{{ $hasActiveAssignment ? 'assigned' : 'available' }}">
                        <td class="px-4 py-3">
                            @if(!$hasActiveAssignment)
                            <input type="checkbox" class="student-checkbox rounded border-gray-300 text-brand focus:ring-brand"
                                value="{{ $student->id }}">
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-brand rounded-full flex items-center justify-center text-white text-sm font-medium">
                                    {{ substr($student->name, 0, 2) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $student->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $student->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-blue-50 text-blue-700 border-blue-100 border shadow-sm">
                                {{ $student->course->name ?? 'No Course' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            <div>
                                <p>{{ $student->studentDetail->phone ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500">{{ Str::limit($student->studentDetail->address ?? 'No address', 30) }}</p>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            @if($student->documents && $student->documents->count() > 0)
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-emerald-50 text-emerald-700">
                                <i class="bi bi-check-circle mr-1"></i>{{ $student->documents->count() }} docs
                            </span>
                            @else
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-orange-50 text-orange-700">
                                <i class="bi bi-exclamation-circle mr-1"></i>No docs
                            </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($hasActiveAssignment)
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-blue-50 text-blue-700 border-blue-100 border">
                                <i class="bi bi-person-check mr-1"></i>Assigned
                            </span>
                            @else
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-emerald-50 text-emerald-700 border-emerald-100 border">
                                <i class="bi bi-person-plus mr-1"></i>Available
                            </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if(!$hasActiveAssignment)
                            <button class="bg-brand text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors"
                                onclick="assignSingleStudent({{ $student->id }})">
                                <i class="bi bi-person-plus mr-1"></i>Assign
                            </button>
                            @else
                            <span class="text-xs text-gray-500">Already Assigned</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if($students->isEmpty())
    <div class="bg-white rounded-lg shadow-sm p-8 text-center">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="bi bi-people text-gray-400 text-2xl"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 mb-2">No Students Found</h3>
        <p class="text-gray-600">No students are available for assignment at the moment.</p>
    </div>
    @endif

    <!-- Assignment Modal -->
    <div id="assignmentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-800">Assign Students</h2>
                        <button onclick="closeAssignmentModal()" class="text-gray-400 hover:text-gray-600">
                            <i class="bi bi-x-lg text-xl"></i>
                        </button>
                    </div>

                    <form id="assignmentForm">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Placement Coordinator</label>
                                <select id="sourcingCoordinatorSelect" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                                    <option value="">Select Coordinator</option>
                                    @foreach($placementCoordinators as $coordinator)
                                    <option value="{{ $coordinator->id }}">{{ $coordinator->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Industry Preference (Optional)</label>
                                <input type="text" id="industryPreference"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand"
                                    placeholder="e.g. Healthcare, Technology">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Special Requirements (Optional)</label>
                                <textarea id="specialRequirements" rows="3"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand"
                                    placeholder="Any special requirements or notes..."></textarea>
                            </div>
                        </div>

                        <div class="flex gap-3 mt-6">
                            <button type="button" class="flex-1 bg-brand text-white font-medium text-xs px-3 py-2 rounded-md hover:bg-gold transition-colors" onclick="submitAssignment()">
                                <i class="bi bi-check mr-1"></i>Assign Students
                            </button>
                            <button type="button" class="bg-gray-500 text-white text-xs px-3 py-2 rounded-md hover:bg-gray-600 transition-colors font-medium" onclick="closeAssignmentModal()">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedStudents = [];
        let isAssigning = false;

        // Filter toggle
        document.getElementById('toggleFilters').addEventListener('click', function() {
            const filterContent = document.getElementById('filterContent');
            const filterIcon = document.getElementById('filterIcon');
            filterContent.classList.toggle('hidden');
            filterIcon.classList.toggle('rotate-180');
        });

        // Select all functionality
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.student-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateSelectedCount();
        });

        // Individual checkbox handling
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('student-checkbox')) {
                updateSelectedCount();
            }
        });

        // Filter functionality
        function filterStudents() {
            const searchTerm = document.getElementById('searchFilter').value.toLowerCase();
            const courseFilter = document.getElementById('courseFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;

            const rows = document.querySelectorAll('.student-row');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const course = row.dataset.course;
                const status = row.dataset.status;

                const searchMatch = searchTerm === '' || text.includes(searchTerm);
                const courseMatch = courseFilter === '' || course === courseFilter;
                const statusMatch = statusFilter === '' || status === statusFilter;

                if (searchMatch && courseMatch && statusMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        document.getElementById('searchFilter').addEventListener('input', filterStudents);
        document.getElementById('courseFilter').addEventListener('change', filterStudents);
        document.getElementById('statusFilter').addEventListener('change', filterStudents);

        document.getElementById('resetFilters').addEventListener('click', function() {
            document.getElementById('searchFilter').value = '';
            document.getElementById('courseFilter').value = '';
            document.getElementById('statusFilter').value = '';
            filterStudents();
        });

        function updateSelectedCount() {
            const checkedBoxes = document.querySelectorAll('.student-checkbox:checked');
            const count = checkedBoxes.length;

            document.getElementById('selectedCount').textContent = count;
            document.getElementById('bulkAssignBtn').disabled = count === 0;

            selectedStudents = Array.from(checkedBoxes).map(cb => cb.value);
        }

        function assignSingleStudent(studentId) {
            selectedStudents = [studentId];
            showAssignmentModal();
        }

        document.getElementById('bulkAssignBtn').addEventListener('click', function() {
            if (selectedStudents.length > 0) {
                showAssignmentModal();
            }
        });

        function showAssignmentModal() {
            document.getElementById('assignmentModal').classList.remove('hidden');
        }

        function closeAssignmentModal() {
            document.getElementById('assignmentModal').classList.add('hidden');
            document.getElementById('assignmentForm').reset();
        }

        function submitAssignment() {
            if (isAssigning) return;

            const coordinatorId = document.getElementById('sourcingCoordinatorSelect').value;
            const industryPreference = document.getElementById('industryPreference').value;
            const specialRequirements = document.getElementById('specialRequirements').value;

            if (!coordinatorId) {
                alert('Please select a sourcing coordinator');
                return;
            }

            if (selectedStudents.length === 0) {
                alert('No students selected');
                return;
            }

            isAssigning = true;

            const url = selectedStudents.length === 1 ? '/admin/student-assignments' : '/admin/student-assignments/bulk';
            const data = selectedStudents.length === 1 ? {
                student_id: selectedStudents[0],
                sourcing_coordinator_id: coordinatorId,
                industry_preference: industryPreference,
                special_requirements: specialRequirements
            } : {
                student_ids: selectedStudents,
                sourcing_coordinator_id: coordinatorId,
                industry_preference: industryPreference,
                special_requirements: specialRequirements
            };

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.success);
                    location.reload();
                } else {
                    alert(data.error || 'An error occurred');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while assigning students');
            })
            .finally(() => {
                isAssigning = false;
                closeAssignmentModal();
            });
        }
    </script>
@endsection
