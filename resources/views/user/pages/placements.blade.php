@extends('user.master_layout.index')

@section('title', 'My Placements')

@section('content')
<div class="p-4 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-medium text-gray-800 mb-1">My Placements</h1>
            <p class="text-sm text-gray-500">View your placement assignments and details</p>
        </div>

        @if($assignments->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($assignments as $assignment)
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-medium text-gray-800 mb-1">{{ $assignment->opportunity->industry->name }}</h3>
                        <p class="text-sm text-gray-500">Assigned by {{ $assignment->placementCoordinator->name }}</p>
                    </div>
                    <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-800 border border-green-200">
                        Active
                    </span>
                </div>

                @if($assignment->opportunity->requirements)
                <div class="mb-4">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Requirements:</h4>
                    <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-md">{{ $assignment->opportunity->requirements }}</p>
                </div>
                @endif

                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Sourced by:</span>
                        <span class="text-sm font-medium text-gray-800">{{ $assignment->opportunity->sourcingCoordinator->name }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Total Slots:</span>
                        <span class="text-sm font-medium text-gray-800">{{ $assignment->opportunity->total_slots }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Assigned Date:</span>
                        <span class="text-sm font-medium text-gray-800">{{ $assignment->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-white rounded-lg shadow-sm border p-12 text-center">
            <i class="fas fa-briefcase text-gray-300 text-5xl mb-4"></i>
            <h3 class="text-xl font-medium text-gray-800 mb-2">No Placements Yet</h3>
            <p class="text-gray-500">You haven't been assigned to any placement opportunities yet.</p>
        </div>
        @endif
    </div>
</div>
@endsection