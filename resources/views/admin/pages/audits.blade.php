@extends('admin.master_layout.index')
@section('page-title', 'Audit History')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-brand">Audit History</h2>
        </div>

        <!-- Filters -->
        <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-6 gap-4">
            <select name="auditable_type" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <option value="">All Types</option>
                <option value="App\Models\User" {{ request('auditable_type') == 'App\Models\User' ? 'selected' : '' }}>Users</option>
                <option value="App\Models\StudentDetail" {{ request('auditable_type') == 'App\Models\StudentDetail' ? 'selected' : '' }}>Student Details</option>
                <option value="App\Models\StudentDocument" {{ request('auditable_type') == 'App\Models\StudentDocument' ? 'selected' : '' }}>Documents</option>
                <option value="App\Models\StudentNote" {{ request('auditable_type') == 'App\Models\StudentNote' ? 'selected' : '' }}>Notes</option>
                <option value="App\Models\StudentAppointment" {{ request('auditable_type') == 'App\Models\StudentAppointment' ? 'selected' : '' }}>Appointments</option>
                <option value="App\Models\Course" {{ request('auditable_type') == 'App\Models\Course' ? 'selected' : '' }}>Courses</option>
                <option value="App\Models\Industry" {{ request('auditable_type') == 'App\Models\Industry' ? 'selected' : '' }}>Industries</option>
                <option value="App\Models\RtoDetail" {{ request('auditable_type') == 'App\Models\RtoDetail' ? 'selected' : '' }}>RTO Details</option>
                <option value="App\Models\CoordinatorDetail" {{ request('auditable_type') == 'App\Models\CoordinatorDetail' ? 'selected' : '' }}>Coordinator Details</option>
                <option value="App\Models\PlacementOpportunity" {{ request('auditable_type') == 'App\Models\PlacementOpportunity' ? 'selected' : '' }}>Placement Opportunities</option>
                <option value="App\Models\PlacementAssignment" {{ request('auditable_type') == 'App\Models\PlacementAssignment' ? 'selected' : '' }}>Placement Assignments</option>
                <option value="App\Models\Contract" {{ request('auditable_type') == 'App\Models\Contract' ? 'selected' : '' }}>Contracts</option>
                <option value="App\Models\Esignature" {{ request('auditable_type') == 'App\Models\Esignature' ? 'selected' : '' }}>E-Signatures</option>
            </select>

            <select name="event" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <option value="">All Events</option>
                <option value="created" {{ request('event') == 'created' ? 'selected' : '' }}>Created</option>
                <option value="updated" {{ request('event') == 'updated' ? 'selected' : '' }}>Updated</option>
                <option value="deleted" {{ request('event') == 'deleted' ? 'selected' : '' }}>Deleted</option>
            </select>

            <input type="date" name="from_date" value="{{ request('from_date') }}" placeholder="From Date" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
            <input type="date" name="to_date" value="{{ request('to_date') }}" placeholder="To Date" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
            
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="border border-gray-300 rounded-lg px-3 py-2 text-sm">

            <button type="submit" class="bg-brand text-white px-4 py-2 rounded-lg hover:bg-gold transition-colors text-sm">
                <i class="bi bi-filter mr-2"></i>Filter
            </button>
        </form>

        <!-- Audit Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Changes</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Timestamp</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($audits as $audit)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $audit->event == 'created' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $audit->event == 'updated' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $audit->event == 'deleted' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($audit->event) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ class_basename($audit->auditable_type) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $audit->user->name ?? 'System' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                @if($audit->event == 'updated')
                                    @foreach($audit->getModified() as $field => $values)
                                        <div class="mb-1">
                                            <strong>{{ ucfirst(str_replace('_', ' ', $field)) }}:</strong>
                                            <span class="text-red-600">{{ $values['old'] ?? 'null' }}</span>
                                            →
                                            <span class="text-green-600">{{ $values['new'] ?? 'null' }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    {{ $audit->event == 'created' ? 'Record created' : 'Record deleted' }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $audit->created_at->format('M d, Y H:i:s') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <button onclick="viewAuditDetails({{ $audit->id }})" class="text-brand hover:text-gold">
                                    <i class="bi bi-eye"></i> View
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No audit records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $audits->links() }}
        </div>
    </div>

    <!-- Audit Details Modal -->
    <div id="auditModal" class="fixed inset-0 bg-black/50 flex justify-center items-center hidden z-50">
        <div class="bg-white w-full max-w-2xl rounded-xl shadow-2xl p-6 relative max-h-[80vh] overflow-y-auto">
            <button onclick="closeAuditModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">
                &times;
            </button>
            <h3 class="text-xl font-semibold text-brand mb-4">Audit Details</h3>
            <div id="auditDetails"></div>
        </div>
    </div>

    <script>
        function viewAuditDetails(id) {
            fetch(`/admin/audits/${id}`)
                .then(response => response.json())
                .then(data => {
                    let html = `
                        <div class="space-y-4">
                            <div><strong>Event:</strong> ${data.event}</div>
                            <div><strong>Type:</strong> ${data.auditable_type}</div>
                            <div><strong>User:</strong> ${data.user ? data.user.name : 'System'}</div>
                            <div><strong>IP Address:</strong> ${data.ip_address || 'N/A'}</div>
                            <div><strong>User Agent:</strong> ${data.user_agent || 'N/A'}</div>
                            <div><strong>Timestamp:</strong> ${new Date(data.created_at).toLocaleString()}</div>
                            <div><strong>Old Values:</strong><pre class="bg-gray-100 p-2 rounded mt-2">${JSON.stringify(data.old_values, null, 2)}</pre></div>
                            <div><strong>New Values:</strong><pre class="bg-gray-100 p-2 rounded mt-2">${JSON.stringify(data.new_values, null, 2)}</pre></div>
                        </div>
                    `;
                    document.getElementById('auditDetails').innerHTML = html;
                    document.getElementById('auditModal').classList.remove('hidden');
                });
        }

        function closeAuditModal() {
            document.getElementById('auditModal').classList.add('hidden');
        }
    </script>
@endsection
