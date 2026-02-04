@extends('admin.master_layout.index')
@section('page-title', 'Assigned Requests')

@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Assigned Requests</h1>
                <p class="text-gray-600 mt-1">Manage placement requests assigned by coordinators</p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-brand">{{ $stats['total'] }}</p>
                <p class="text-gray-600 text-xs">Total Requests</p>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <button class="tab-btn active border-b-2 border-brand text-brand py-4 px-1 text-sm font-medium" data-tab="all">
                    All ({{ $stats['total'] }})
                </button>
                <button class="tab-btn border-b-2 border-transparent text-gray-500 hover:text-gray-700 py-4 px-1 text-sm font-medium" data-tab="pending">
                    Pending ({{ $stats['pending'] }})
                </button>
                <button class="tab-btn border-b-2 border-transparent text-gray-500 hover:text-gray-700 py-4 px-1 text-sm font-medium" data-tab="in_progress">
                    In Progress ({{ $stats['in_progress'] }})
                </button>
                <button class="tab-btn border-b-2 border-transparent text-gray-500 hover:text-gray-700 py-4 px-1 text-sm font-medium" data-tab="completed">
                    Completed ({{ $stats['completed'] }})
                </button>
            </nav>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow-sm mb-6 p-4">
        <div class="flex gap-4">
            <div class="flex-1">
                <input type="text" id="searchInput" placeholder="Search by student name or email..."
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
            </div>
            <button id="searchBtn" class="bg-brand text-white text-xs px-3 py-2 rounded-md hover:bg-gold transition-colors font-medium">
                <i class="bi bi-search mr-1"></i>Search
            </button>
            <button id="resetBtn" class="bg-gray-500 text-white text-xs px-3 py-2 rounded-md hover:bg-gray-600 transition-colors font-medium">
                Reset
            </button>
        </div>
    </div>

    <!-- Requests Grid -->
    <div id="requestsGrid" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach($requests as $request)
        <div class="bg-white rounded-lg shadow-sm border hover:shadow-md transition-shadow request-card" data-status="{{ $request->status }}">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="font-semibold text-gray-900">{{ $request->industry_preference ?: 'General' }} Placement Request</h3>
                        <p class="text-sm text-gray-600">Assigned by: {{ $request->placementCoordinator->name }}</p>
                        <p class="text-xs text-gray-500">{{ $request->assigned_at->diffForHumans() }}</p>
                    </div>
                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full
                        @if($request->status === 'pending') bg-orange-50 text-orange-700 border-orange-100 border
                        @elseif($request->status === 'in_progress') bg-blue-50 text-blue-700 border-blue-100 border
                        @elseif($request->status === 'completed') bg-emerald-50 text-emerald-700 border-emerald-100 border
                        @else bg-gray-50 text-gray-700 border-gray-100 border @endif">
                        {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                    </span>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                    <h4 class="font-medium text-gray-900 mb-2">Student Details</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Name:</span>
                            <span class="font-medium">{{ $request->student->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Phone:</span>
                            <span class="font-medium">{{ $request->student->phone ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Location:</span>
                            <span class="font-medium">{{ $request->student->address ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Course:</span>
                            <span class="font-medium">{{ $request->student->course->name ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                @if($request->student->documents && $request->student->documents->count() > 0)
                <div class="mb-4">
                    <h4 class="font-medium text-gray-900 mb-2">Documents Status</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($request->student->documents->take(3) as $document)
                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-emerald-50 text-emerald-700">
                            <i class="bi bi-check-circle mr-1"></i>{{ $document->document_type }}
                        </span>
                        @endforeach
                        @if($request->student->documents->count() > 3)
                        <span class="text-xs text-gray-500">+{{ $request->student->documents->count() - 3 }} more</span>
                        @endif
                    </div>
                </div>
                @endif

                @if($request->special_requirements)
                <div class="mb-4">
                    <h4 class="font-medium text-gray-900 mb-2">Special Requirements</h4>
                    <p class="text-sm text-gray-600">{{ $request->special_requirements }}</p>
                </div>
                @endif

                @if($request->progress_notes && $request->status !== 'pending')
                <div class="mb-4">
                    <h4 class="font-medium text-gray-900 mb-2">Progress Notes</h4>
                    <div class="bg-blue-50 rounded-lg p-3">
                        <p class="text-sm text-blue-800">{{ $request->progress_notes }}</p>
                        @if($request->started_at)
                        <p class="text-xs text-blue-600 mt-1">Updated {{ $request->updated_at->diffForHumans() }}</p>
                        @endif
                    </div>
                </div>
                @endif

                <div class="flex gap-2">
                    @if($request->status === 'pending')
                    <button class="flex-1 bg-brand text-white font-medium text-xs px-3 py-2 rounded-md hover:bg-gold transition-colors" onclick="startRequest({{ $request->id }})">
                        <i class="bi bi-play mr-1"></i>Start Working
                    </button>
                    @elseif($request->status === 'in_progress')
                    <button class="flex-1 bg-emerald-600 text-white font-medium text-xs px-3 py-2 rounded-md hover:bg-emerald-700 transition-colors" onclick="updateProgress({{ $request->id }})">
                        <i class="bi bi-pencil mr-1"></i>Update Progress
                    </button>
                    <button class="bg-green-600 text-white font-medium text-xs px-3 py-2 rounded-md hover:bg-green-700 transition-colors" onclick="markComplete({{ $request->id }})">
                        <i class="bi bi-check mr-1"></i>Complete
                    </button>
                    @else
                    <button class="flex-1 bg-gray-100 text-gray-700 font-medium text-xs px-3 py-2 rounded-md" disabled>
                        <i class="bi bi-check-circle mr-1"></i>Completed
                    </button>
                    @endif
                    <button class="bg-gray-100 text-gray-700 font-medium text-xs px-3 py-2 rounded-md hover:bg-gray-200 transition-colors" onclick="viewFullProfile({{ $request->id }})">
                        <i class="bi bi-person mr-1"></i>Full Profile
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($requests->isEmpty())
    <div class="bg-white rounded-lg shadow-sm p-8 text-center">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="bi bi-clipboard-x text-gray-400 text-2xl"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 mb-2">No Requests Found</h3>
        <p class="text-gray-600">You don't have any assigned requests at the moment.</p>
    </div>
    @endif

    <!-- Student Profile Modal -->
    <div id="studentProfileModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-screen overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-800">Student Profile</h2>
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

    <!-- Progress Update Modal -->
    <div id="progressModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-800">Update Progress</h2>
                        <button onclick="closeProgressModal()" class="text-gray-400 hover:text-gray-600">
                            <i class="bi bi-x-lg text-xl"></i>
                        </button>
                    </div>

                    <form id="progressForm">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Progress Notes</label>
                            <textarea id="progressNotes" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand" placeholder="Enter progress notes..."></textarea>
                        </div>

                        <div class="flex gap-3">
                            <button type="button" class="flex-1 bg-brand text-white font-medium text-xs px-3 py-2 rounded-md hover:bg-gold transition-colors" onclick="saveProgress()">
                                Save Progress
                            </button>
                            <button type="button" class="bg-gray-500 text-white text-xs px-3 py-2 rounded-md hover:bg-gray-600 transition-colors font-medium" onclick="closeProgressModal()">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentRequestId = null;
        let currentStatus = 'all';

        // Tab switching
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.tab-btn').forEach(b => {
                    b.classList.remove('active', 'border-brand', 'text-brand');
                    b.classList.add('border-transparent', 'text-gray-500');
                });
                this.classList.add('active', 'border-brand', 'text-brand');
                this.classList.remove('border-transparent', 'text-gray-500');

                currentStatus = this.dataset.tab;
                filterRequests();
            });
        });

        // Search functionality
        document.getElementById('searchBtn').addEventListener('click', filterRequests);
        document.getElementById('resetBtn').addEventListener('click', function() {
            document.getElementById('searchInput').value = '';
            filterRequests();
        });

        function filterRequests() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.request-card');

            cards.forEach(card => {
                const status = card.dataset.status;
                const text = card.textContent.toLowerCase();

                const statusMatch = currentStatus === 'all' || status === currentStatus;
                const searchMatch = searchTerm === '' || text.includes(searchTerm);

                if (statusMatch && searchMatch) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Request actions
        function startRequest(id) {
            updateRequestStatus(id, 'in_progress', 'Started working on this request');
        }

        function updateProgress(id) {
            currentRequestId = id;
            document.getElementById('progressModal').classList.remove('hidden');
        }

        function markComplete(id) {
            if (confirm('Are you sure you want to mark this request as completed?')) {
                updateRequestStatus(id, 'completed', 'Request completed successfully');
            }
        }

        function saveProgress() {
            const notes = document.getElementById('progressNotes').value;
            if (!notes.trim()) {
                alert('Please enter progress notes');
                return;
            }

            updateRequestStatus(currentRequestId, 'in_progress', notes);
            closeProgressModal();
        }

        function updateRequestStatus(id, status, notes) {
            fetch(`/admin/student-assignments/${id}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    status: status,
                    progress_notes: notes
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.error || 'An error occurred');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the request');
            });
        }

        function viewFullProfile(id) {
            fetch(`/admin/student-assignments/${id}`)
            .then(response => response.json())
            .then(data => {
                const student = data.student;
                const studentDetail = student.student_detail || {};

                document.getElementById('modalContent').innerHTML = `
                    <div class="space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Full Name</label>
                                <p class="mt-1 text-sm text-gray-900">${student.name}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="mt-1 text-sm text-gray-900">${student.email}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Phone</label>
                                <p class="mt-1 text-sm text-gray-900">${student.phone || 'N/A'}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Course</label>
                                <p class="mt-1 text-sm text-gray-900">${student.course ? student.course.name : 'N/A'}</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Address</label>
                            <p class="mt-1 text-sm text-gray-900">${student.address || 'N/A'}</p>
                        </div>

                        ${student.documents && student.documents.length > 0 ? `
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Documents</label>
                            <div class="mt-2 flex flex-wrap gap-2">
                                ${student.documents.map(doc => `
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-emerald-50 text-emerald-700">
                                        <i class="bi bi-check-circle mr-1"></i>${doc.document_type}
                                    </span>
                                `).join('')}
                            </div>
                        </div>
                        ` : ''}

                        ${data.special_requirements ? `
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Special Requirements</label>
                            <p class="mt-1 text-sm text-gray-900">${data.special_requirements}</p>
                        </div>
                        ` : ''}
                    </div>
                `;

                document.getElementById('studentProfileModal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading student profile');
            });
        }

        function closeModal() {
            document.getElementById('studentProfileModal').classList.add('hidden');
        }

        function closeProgressModal() {
            document.getElementById('progressModal').classList.add('hidden');
            document.getElementById('progressNotes').value = '';
            currentRequestId = null;
        }
    </script>
@endsection
