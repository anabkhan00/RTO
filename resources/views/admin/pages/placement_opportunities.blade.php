@extends('admin.master_layout.index')

@section('title', 'Placement Opportunities')

@section('content')
<div class="p-4 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-medium text-gray-800">Placement Opportunities</h1>
                <p class="text-sm text-gray-500">Manage industry placement slots</p>
            </div>
            <a href="{{ route('admin.placement-opportunities.create') }}" class="bg-brand text-white px-4 py-2 rounded-md hover:bg-gold transition-colors text-sm">
                <i class="fas fa-plus mr-2"></i>Create Opportunity
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-sm border">
            <div class="p-4 border-b">
                <h2 class="text-base font-medium text-gray-700">Your Opportunities</h2>
            </div>
            <div class="p-4">
                @if($opportunities->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($opportunities as $opportunity)
                    <div class="border rounded-lg p-4 hover:shadow-sm transition-shadow">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="font-medium text-gray-800">{{ $opportunity->industry->name }}</h3>
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 text-xs rounded-md {{ $opportunity->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $opportunity->status ? 'Active' : 'Inactive' }}
                                </span>
                                <button onclick="toggleStatus({{ $opportunity->id }})" class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-toggle-{{ $opportunity->status ? 'on' : 'off' }}"></i>
                                </button>
                            </div>
                        </div>

                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Total Slots:</span>
                                <span class="font-medium">{{ $opportunity->total_slots }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Filled:</span>
                                <span class="font-medium text-red-600">{{ $opportunity->filled_slots }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Available:</span>
                                <span class="font-medium text-green-600">{{ $opportunity->available_slots }}</span>
                            </div>
                        </div>

                        @if($opportunity->requirements)
                        <div class="mb-4">
                            <p class="text-xs text-gray-600 mb-1">Requirements:</p>
                            <p class="text-xs text-gray-800 bg-gray-50 p-2 rounded">{{ $opportunity->requirements }}</p>
                        </div>
                        @endif

                        <div class="flex space-x-2">
                            <a href="{{ route('admin.placement-opportunities.students', $opportunity->id) }}" class="flex-1 bg-brand text-white px-3 py-1.5 rounded text-xs text-center hover:bg-gold transition-colors">
                                View Students ({{ $opportunity->filled_slots }})
                            </a>
                        </div>
                        <div class="flex space-x-2 mt-2">
                            <a href="{{ route('admin.placement-opportunities.edit', $opportunity->id) }}" class="flex-1 bg-gray-100 text-gray-700 px-3 py-1.5 rounded text-xs text-center hover:bg-gray-200 transition-colors">
                                Edit
                            </a>
                            <button onclick="deleteOpportunity({{ $opportunity->id }})" class="flex-1 bg-red-100 text-red-700 px-3 py-1.5 rounded text-xs hover:bg-red-200 transition-colors">
                                Delete
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <i class="fas fa-briefcase text-gray-300 text-4xl mb-4"></i>
                    <p class="text-gray-500 mb-4">No placement opportunities created yet</p>
                    <a href="{{ route('admin.placement-opportunities.create') }}" class="bg-brand text-white px-4 py-2 rounded-md hover:bg-gold transition-colors text-sm">
                        Create Your First Opportunity
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function toggleStatus(id) {
    $.ajax({
        url: `/admin/placement-opportunities/${id}/toggle-status`,
        method: 'PATCH',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function() {
            location.reload();
        }
    });
}

function deleteOpportunity(id) {
    if (confirm('Are you sure you want to delete this opportunity?')) {
        $.ajax({
            url: `/admin/placement-opportunities/${id}`,
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function() {
                location.reload();
            }
        });
    }
}
</script>
@endsection
