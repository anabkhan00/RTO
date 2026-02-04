@extends('admin.master_layout.index')
@section('page-title', 'All Assignments')

@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">All Assignments</h1>
                <p class="text-gray-600 mt-1">View all student assignment requests across coordinators</p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-brand">{{ $requests->total() }}</p>
                <p class="text-gray-600 text-xs">Total Assignments</p>
            </div>
        </div>
    </div>

    <!-- Assignments Table -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Placement Coordinator</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sourcing Coordinator</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($requests as $request)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-brand text-white flex items-center justify-center text-sm font-medium">
                                        {{ substr($request->student->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $request->student->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $request->student->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $request->placementCoordinator->name }}</div>
                            <div class="text-sm text-gray-500">{{ $request->placementCoordinator->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $request->sourcingCoordinator->name }}</div>
                            <div class="text-sm text-gray-500">{{ $request->sourcingCoordinator->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full
                                @if($request->status === 'pending') bg-orange-50 text-orange-700 border-orange-100 border
                                @elseif($request->status === 'in_progress') bg-blue-50 text-blue-700 border-blue-100 border
                                @elseif($request->status === 'completed') bg-emerald-50 text-emerald-700 border-emerald-100 border
                                @else bg-gray-50 text-gray-700 border-gray-100 border @endif">
                                {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $request->assigned_at->format('M d, Y') }}
                            <div class="text-xs text-gray-400">{{ $request->assigned_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="viewAssignment({{ $request->id }})" class="text-brand hover:text-gold">
                                <i class="bi bi-eye mr-1"></i>View
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="bi bi-clipboard-x text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">No Assignments Found</h3>
                            <p class="text-gray-600">No student assignments have been created yet.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($requests->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $requests->links() }}
        </div>
        @endif
    </div>

    <!-- Assignment Details Modal -->
    <div id="assignmentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-screen overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-800">Assignment Details</h2>
                        <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                            <i class="bi bi-x-lg text-xl"></i>
                        </button>
                    </div>

                    <div id="modalContent">
                        <!-- Dynamic content will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewAssignment(id) {
            fetch(`/admin/student-assignments/${id}`)
            .then(response => response.json())
            .then(data => {
                const student = data.student;
                const studentDetail = student.student_detail || {};

                document.getElementById('modalContent').innerHTML = `
                    <div class="space-y-6">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="font-medium text-gray-900 mb-3">Assignment Information</h3>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Status:</span>
                                    <span class="ml-2 inline-flex items-center px-2 py-1 text-xs font-medium rounded-full
                                        ${data.status === 'pending' ? 'bg-orange-50 text-orange-700' : 
                                          data.status === 'in_progress' ? 'bg-blue-50 text-blue-700' : 
                                          data.status === 'completed' ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-50 text-gray-700'}">
                                        ${data.status.charAt(0).toUpperCase() + data.status.slice(1).replace('_', ' ')}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Assigned:</span>
                                    <span class="ml-2 font-medium">${new Date(data.assigned_at).toLocaleDateString()}</span>
                                </div>
                                ${data.started_at ? `
                                <div>
                                    <span class="text-gray-600">Started:</span>
                                    <span class="ml-2 font-medium">${new Date(data.started_at).toLocaleDateString()}</span>
                                </div>
                                ` : ''}
                                ${data.completed_at ? `
                                <div>
                                    <span class="text-gray-600">Completed:</span>
                                    <span class="ml-2 font-medium">${new Date(data.completed_at).toLocaleDateString()}</span>
                                </div>
                                ` : ''}
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="font-medium text-gray-900 mb-3">Student Details</h3>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Name:</span>
                                    <span class="ml-2 font-medium">${student.name}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Email:</span>
                                    <span class="ml-2 font-medium">${student.email}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Phone:</span>
                                    <span class="ml-2 font-medium">${student.phone || 'N/A'}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Course:</span>
                                    <span class="ml-2 font-medium">${student.course ? student.course.name : 'N/A'}</span>
                                </div>
                            </div>
                            ${student.address ? `
                            <div class="mt-3">
                                <span class="text-gray-600">Address:</span>
                                <span class="ml-2 font-medium">${student.address}</span>
                            </div>
                            ` : ''}
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="font-medium text-gray-900 mb-3">Coordinators</h3>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Placement Coordinator:</span>
                                    <div class="mt-1">
                                        <div class="font-medium">${data.placement_coordinator.name}</div>
                                        <div class="text-gray-500">${data.placement_coordinator.email}</div>
                                    </div>
                                </div>
                                <div>
                                    <span class="text-gray-600">Sourcing Coordinator:</span>
                                    <div class="mt-1">
                                        <div class="font-medium">${data.sourcing_coordinator.name}</div>
                                        <div class="text-gray-500">${data.sourcing_coordinator.email}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        ${data.industry_preference ? `
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="font-medium text-gray-900 mb-2">Industry Preference</h3>
                            <p class="text-sm text-gray-700">${data.industry_preference}</p>
                        </div>
                        ` : ''}

                        ${data.special_requirements ? `
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="font-medium text-gray-900 mb-2">Special Requirements</h3>
                            <p class="text-sm text-gray-700">${data.special_requirements}</p>
                        </div>
                        ` : ''}

                        ${data.progress_notes ? `
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h3 class="font-medium text-blue-900 mb-2">Progress Notes</h3>
                            <p class="text-sm text-blue-800">${data.progress_notes}</p>
                            <p class="text-xs text-blue-600 mt-2">Last updated: ${new Date(data.updated_at).toLocaleString()}</p>
                        </div>
                        ` : ''}

                        ${student.documents && student.documents.length > 0 ? `
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="font-medium text-gray-900 mb-3">Documents</h3>
                            <div class="flex flex-wrap gap-2">
                                ${student.documents.map(doc => `
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-emerald-50 text-emerald-700">
                                        <i class="bi bi-check-circle mr-1"></i>${doc.document_type}
                                    </span>
                                `).join('')}
                            </div>
                        </div>
                        ` : ''}
                    </div>
                `;

                document.getElementById('assignmentModal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading assignment details');
            });
        }

        function closeModal() {
            document.getElementById('assignmentModal').classList.add('hidden');
        }
    </script>
@endsection