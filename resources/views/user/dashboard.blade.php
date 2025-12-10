@extends('user.master_layout.index')

@section('title', 'Student Dashboard')

@section('content')
<div class="p-4 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-medium text-gray-800 mb-1">Welcome, {{ auth()->user()->name }}</h1>
            <p class="text-sm text-gray-500">Your placement dashboard</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-brand rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-briefcase text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">{{ $placementCount }}</h3>
                        <p class="text-sm text-gray-500">Placement{{ $placementCount != 1 ? 's' : '' }} Assigned</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-check-circle text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">Active</h3>
                        <p class="text-sm text-gray-500">Account Status</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-calendar text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">{{ now()->format('M Y') }}</h3>
                        <p class="text-sm text-gray-500">Current Period</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Placement Assignments -->
        <div class="bg-white rounded-lg shadow-sm border">
            <div class="p-4 border-b">
                <h2 class="text-base font-medium text-gray-700 flex items-center">
                    <i class="fas fa-industry text-brand text-sm mr-2"></i>
                    Your Placement Assignments
                </h2>
            </div>
            <div class="p-4">
                @if($assignments->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($assignments as $assignment)
                    <div class="border rounded-lg p-4 hover:shadow-sm transition-shadow">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <h3 class="font-medium text-gray-800 mb-1">{{ $assignment->opportunity->industry->name }}</h3>
                                <p class="text-xs text-gray-500">Assigned by {{ $assignment->placementCoordinator->name }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-md bg-green-100 text-green-800">
                                Active
                            </span>
                        </div>

                        @if($assignment->opportunity->requirements)
                        <div class="mb-3">
                            <p class="text-xs text-gray-600 mb-1">Requirements:</p>
                            <p class="text-xs text-gray-800 bg-gray-50 p-2 rounded">{{ $assignment->opportunity->requirements }}</p>
                        </div>
                        @endif

                        <div class="space-y-2">
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-600">Sourced by:</span>
                                <span class="font-medium">{{ $assignment->opportunity->sourcingCoordinator->name }}</span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-600">Total Slots:</span>
                                <span class="font-medium">{{ $assignment->opportunity->total_slots }}</span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-600">Assigned Date:</span>
                                <span class="font-medium">{{ $assignment->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <i class="fas fa-briefcase text-gray-300 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-800 mb-2">No Placements Yet</h3>
                    <p class="text-gray-500 mb-4">You haven't been assigned to any placement opportunities yet.</p>
                    <p class="text-sm text-gray-400">Your placement coordinator will assign you to suitable opportunities soon.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Profile Section -->
        <div class="mt-6 bg-white rounded-lg shadow-sm border">
            <div class="p-4 border-b">
                <h2 class="text-base font-medium text-gray-700 flex items-center">
                    <i class="fas fa-user text-brand text-sm mr-2"></i>
                    Profile Information
                </h2>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <p class="text-sm text-gray-800">{{ auth()->user()->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <p class="text-sm text-gray-800">{{ auth()->user()->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <p class="text-sm text-gray-800 capitalize">Student</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Member Since</label>
                        <p class="text-sm text-gray-800">{{ auth()->user()->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="/profile" class="bg-brand text-white px-4 py-2 rounded-md hover:bg-gold transition-colors text-sm">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
