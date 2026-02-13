@extends('admin.master_layout.index')
@section('page-title', 'Find Placements')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin/find-placements.css') }}">
@endpush

@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Find Placements</h1>
                <p class="text-gray-600 mt-1">Locate students and industries for optimal placement matching</p>
            </div>
            <div class="flex gap-3">
                <div class="text-center stats-card">
                    <p class="text-xl font-bold text-blue-600">{{ $students->count() }}</p>
                    <p class="text-gray-600 text-xs">Students</p>
                </div>
                <div class="text-center stats-card">
                    <p class="text-xl font-bold text-green-600">{{ $industries->count() }}</p>
                    <p class="text-gray-600 text-xs">Industries</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Placement Map</h2>
            <div class="flex gap-2 map-controls">
                <button id="toggleStudents" class="toggle-button flex items-center px-3 py-2 text-xs font-medium rounded-md bg-blue-500 text-white hover:bg-blue-600 transition-colors">
                    <div class="marker-dot bg-blue-500 mr-2"></div>
                    Students
                </button>
                <button id="toggleIndustries" class="toggle-button flex items-center px-3 py-2 text-xs font-medium rounded-md bg-green-500 text-white hover:bg-green-600 transition-colors">
                    <div class="marker-dot bg-green-500 mr-2"></div>
                    Industries
                </button>
            </div>
        </div>
        <div id="placementMap" class="w-full h-96 rounded-lg border placement-map-container"></div>
    </div>
@endsection

@push('vendor-scripts')
@include('includes.google-maps', ['callback' => 'initPlacementMap'])
@endpush

@push('scripts')
<script src="{{ asset('/assets/js/admin/find-placements.js') }}"></script>
<script>
    // Set dynamic data for map
    window.placementStudents = @json($students ?? []);
    window.placementIndustries = @json($industries ?? []);
</script>
@endpush

