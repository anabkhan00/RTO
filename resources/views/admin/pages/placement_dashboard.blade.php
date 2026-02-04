@extends('admin.master_layout.index')
@section('page-title', 'Placement Coordinator Dashboard')

@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Placement Dashboard</h1>
                <p class="text-gray-600 mt-1">Manage student assignments and track placement progress</p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-brand">{{ $totalPlacements ?? 0 }}</p>
                <p class="text-gray-600 text-xs">Total Placements</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="bi bi-clock-history text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-2xl font-bold text-gray-800">{{ $pendingPlacements ?? 0 }}</p>
                    <p class="text-gray-600 text-sm">Pending</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="bi bi-arrow-repeat text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-2xl font-bold text-gray-800">{{ $activePlacements ?? 0 }}</p>
                    <p class="text-gray-600 text-sm">In Progress</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="bi bi-check-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-2xl font-bold text-gray-800">{{ $totalPlacements ?? 0 }}</p>
                    <p class="text-gray-600 text-sm">Completed</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="bi bi-people text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-2xl font-bold text-gray-800">{{ $totalStudents ?? 0 }}</p>
                    <p class="text-gray-600 text-sm">Assigned Students</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-semibold text-brand">Quick Actions</h2>
            <div class="flex gap-3">
                {{-- <a href="{{ route('admin.assigned-requests') }}" class="bg-brand text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors">
                    <i class="bi bi-clipboard-check mr-1"></i>View Progress
                </a> --}}
                <a href="{{ route('admin.student-assignments') }}" class="bg-emerald-600 text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-emerald-700 transition-colors">
                    <i class="bi bi-person-plus mr-1"></i>Assign Students

                </a>
                {{-- <a href="{{ route('admin.students') }}" class="bg-blue-600 text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-blue-700 transition-colors">
                    <i class="bi bi-people mr-1"></i>All Students
                </a> --}}
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-brand">Students & Industries Map</h2>
            <div class="flex gap-2">
                <button id="toggleStudents" class="bg-blue-500 text-white text-xs px-3 py-1.5 rounded-md hover:bg-blue-600 transition-colors">
                    <i class="bi bi-people mr-1"></i>Students
                </button>
                <button id="toggleIndustries" class="bg-green-500 text-white text-xs px-3 py-1.5 rounded-md hover:bg-green-600 transition-colors">
                    <i class="bi bi-building mr-1"></i>Industries
                </button>
            </div>
        </div>
        <div id="placementMap" class="w-full h-[500px] rounded-xl shadow-lg border border-gray-200"></div>
        <div class="mt-3 flex items-center justify-between">
            <div class="flex gap-4 text-xs text-gray-600">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                    <span>Assigned Students ({{ $totalStudents ?? 0 }})</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                    <span>Industries ({{ $totalIndustries ?? 0 }})</span>
                </div>
            </div>
            <p class="text-xs text-gray-500">Click markers for details</p>
        </div>
    </div>

    <!-- Recent Assignments -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-brand">Recent Assignments</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Student</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Course</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Sourcing Coordinator</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Assigned Date</th>
                        {{-- <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Actions</th> --}}
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        $recentAssignments = \App\Models\StudentAssignmentRequest::where('placement_coordinator_id', auth()->id())
                            ->with(['student.course', 'sourcingCoordinator'])
                            ->latest()
                            ->take(10)
                            ->get();
                    @endphp
                    @forelse($recentAssignments as $assignment)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-brand flex items-center justify-center text-white font-semibold text-xs mr-3">
                                    {{ substr($assignment->student->name, 0, 1) }}
                                </div>
                                <div class="text-sm font-medium text-gray-900">{{ $assignment->student->name }}</div>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $assignment->student->course->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                            {{ $assignment->sourcingCoordinator->name ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'in_progress' => 'bg-blue-100 text-blue-800',
                                    'completed' => 'bg-green-100 text-green-800'
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$assignment->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst(str_replace('_', ' ', $assignment->status)) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                            {{ $assignment->assigned_at ? $assignment->assigned_at->format('j M Y') : $assignment->created_at->format('j M Y') }}
                        </td>
                        {{-- <td class="px-4 py-3 whitespace-nowrap text-center">
                            <a href="{{ route('admin.assigned-requests') }}" class="text-brand hover:text-gold text-sm font-medium">
                                <i class="bi bi-eye"></i> View
                            </a>
                        </td> --}}
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            No assignments found. <a href="{{ route('admin.student-assignments') }}" class="text-brand hover:text-gold">Start assigning students</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function initPlacementMap() {
            if (typeof google === 'undefined' || !google.maps) {
                console.warn('Google Maps API not loaded');
                return;
            }

            const mapElement = document.getElementById('placementMap');
            if (!mapElement) return;

            const mapOptions = {
                center: { lat: -33.8688, lng: 151.2093 },
                zoom: 11,
                gestureHandling: 'greedy',
                disableDefaultUI: true,
                zoomControl: true,
                fullscreenControl: true,
                styles: [{
                    featureType: 'poi',
                    elementType: 'labels',
                    stylers: [{ visibility: 'off' }]
                }, {
                    featureType: 'transit',
                    stylers: [{ visibility: 'off' }]
                }, {
                    featureType: 'road',
                    elementType: 'geometry',
                    stylers: [{ color: '#f8f9fa' }]
                }, {
                    featureType: 'water',
                    elementType: 'geometry',
                    stylers: [{ color: '#c9d6e8' }]
                }, {
                    featureType: 'landscape',
                    elementType: 'geometry',
                    stylers: [{ color: '#f5f5f5' }]
                }]
            };

            const map = new google.maps.Map(mapElement, mapOptions);

            // Dynamic students data from database
            const students = @json($students ?? []);
            // Dynamic industries data from database
            const industries = @json($industries ?? []);

            let studentMarkers = [];
            let industryMarkers = [];

            // Add student markers
            students.forEach((student, index) => {
                setTimeout(() => {
                    const marker = new google.maps.Marker({
                        position: { lat: parseFloat(student.latitude), lng: parseFloat(student.longitude) },
                        map: map,
                        title: student.name,
                        animation: google.maps.Animation.DROP,
                        icon: {
                            url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" fill="#3b82f6"/>
                                    <circle cx="12" cy="9" r="2.5" fill="white"/>
                                </svg>
                            `),
                            scaledSize: new google.maps.Size(24, 24),
                            anchor: new google.maps.Point(12, 24)
                        }
                    });

                    const course = student.course ? student.course.name : 'No Course';
                    const status = student.student_detail ? student.student_detail.progress_status : 'Active';
                    const infoWindow = new google.maps.InfoWindow({
                        content: `<div style="font-family: system-ui, sans-serif; padding: 8px;"><strong>${student.name}</strong><br><span style="color: #666; font-size: 13px;">${course}</span><br><small style="color: #3b82f6;">Status: ${status}</small></div>`
                    });

                    marker.addListener('click', () => infoWindow.open(map, marker));
                    studentMarkers.push(marker);
                }, index * 200);
            });

            // Add industry markers
            industries.forEach((industry, index) => {
                setTimeout(() => {
                    const marker = new google.maps.Marker({
                        position: { lat: parseFloat(industry.latitude), lng: parseFloat(industry.longitude) },
                        map: map,
                        title: industry.name,
                        animation: google.maps.Animation.DROP,
                        icon: {
                            url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" fill="#059669"/>
                                    <circle cx="12" cy="9" r="2.5" fill="white"/>
                                </svg>
                            `),
                            scaledSize: new google.maps.Size(24, 24),
                            anchor: new google.maps.Point(12, 24)
                        }
                    });

                    const infoWindow = new google.maps.InfoWindow({
                        content: `<div style="font-family: system-ui, sans-serif; padding: 8px;"><strong>${industry.name}</strong><br><span style="color: #666; font-size: 13px;">${industry.contact_person || 'No Contact'}</span><br><small style="color: #059669;">Industry Partner</small></div>`
                    });

                    marker.addListener('click', () => infoWindow.open(map, marker));
                    industryMarkers.push(marker);
                }, (students.length + index) * 200);
            });

            // Toggle buttons functionality
            document.getElementById('toggleStudents').addEventListener('click', function() {
                const visible = studentMarkers.length > 0 ? studentMarkers[0].getVisible() : false;
                studentMarkers.forEach(marker => marker.setVisible(!visible));
                this.classList.toggle('bg-blue-300', !visible);
                this.classList.toggle('bg-blue-500', visible);
            });

            document.getElementById('toggleIndustries').addEventListener('click', function() {
                const visible = industryMarkers.length > 0 ? industryMarkers[0].getVisible() : false;
                industryMarkers.forEach(marker => marker.setVisible(!visible));
                this.classList.toggle('bg-green-300', !visible);
                this.classList.toggle('bg-green-500', visible);
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places&callback=initPlacementMap" async defer></script>
@endsection
