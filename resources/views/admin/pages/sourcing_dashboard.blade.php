@extends('admin.master_layout.index')
@section('page-title', 'Sourcing Coordinator Dashboard')

@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Sourcing Dashboard</h1>
                <p class="text-gray-600 mt-1">Manage placement opportunities and industry partnerships</p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-brand">{{ $totalOpportunities ?? 12 }}</p>
                <p class="text-gray-600 text-xs">Total Opportunities</p>
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
        <div id="sourcingMap" class="w-full h-[500px] rounded-xl shadow-lg border border-gray-200"></div>
        <div class="mt-3 flex items-center justify-between">
            <div class="flex gap-4 text-xs text-gray-600">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                    <span>Students ({{ $totalStudents ?? 0 }})</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                    <span>Industries ({{ $totalIndustries ?? 0 }})</span>
                </div>
            </div>
            <p class="text-xs text-gray-500">Click markers for details</p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-sm mb-6 mt-6">
        <div class="p-4 border-b border-gray-200">
            <button id="toggleFilters" class="flex items-center justify-between w-full text-left">
                <h3 class="text-lg font-semibold text-gray-800">Filters</h3>
                <i id="filterIcon" class="bi bi-chevron-down text-gray-500 transition-transform"></i>
            </button>
        </div>
        <div id="filterContent" class="hidden p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <input type="text" id="searchFilter" placeholder="Search opportunities..."
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                </div>
                <div>
                    <select id="industryFilter"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                        <option value="">All Industries</option>
                        <option value="Technology">Technology</option>
                        <option value="Healthcare">Healthcare</option>
                        <option value="Retail">Retail</option>
                        <option value="Manufacturing">Manufacturing</option>
                    </select>
                </div>
                <div>
                    <select id="statusFilter"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                        <option value="">All Status</option>
                        <option value="Active">Active</option>
                        <option value="Pending">Pending</option>
                        <option value="Closed">Closed</option>
                    </select>
                </div>
                <div>
                    <input type="date" id="fromDate"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                </div>
                <div>
                    <input type="date" id="toDate"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
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

    <!-- Industries Overview -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold text-brand">Industries</h2>
                <div class="flex gap-3">
                    @if(auth()->user()->hasRole('sourcing_coordinator'))
                    <a href="{{ route('admin.live-appointments') }}" class="bg-brand text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors">
                        <i class="bi bi-calendar-check mr-1"></i>Live Appointments
                    </a>
                    <a href="{{ route('admin.assigned-requests') }}" class="bg-emerald-600 text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-emerald-700 transition-colors">
                        <i class="bi bi-clipboard-check mr-1"></i>Assigned Requests
                    </a>
                    <a href="{{ route('admin.find-industries') }}" class="bg-orange-600 text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-orange-700 transition-colors">
                        <i class="bi bi-search mr-1"></i>Find Industries
                    </a>
                    <a href="{{ route('admin.industries.create') }}" class="bg-brand text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors">
                        <i class="bi bi-plus mr-1"></i>New Industry
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Contact</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Location</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Courses</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Status</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($industries as $industry)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-brand flex items-center justify-center text-white font-semibold text-xs mr-3">
                                    {{ substr($industry->name, 0, 1) }}
                                </div>
                                <div class="text-sm font-medium text-gray-900">{{ $industry->name }}</div>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $industry->contact_person ?? 'N/A' }}</div>
                            <div class="text-xs text-gray-500">{{ $industry->email ?? 'N/A' }}</div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                            {{ Str::limit($industry->address ?? 'N/A', 30) }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="text-xs text-gray-500">{{ $industry->courses->count() }} courses</span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full {{ $industry->status ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-red-50 text-red-700 border-red-100' }} border shadow-sm">
                                {{ $industry->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.industries.edit', $industry->id) }}" class="text-brand hover:text-gold text-sm font-medium">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            <i class="bi bi-building text-4xl mb-2"></i>
                            <p>No industries found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Google Maps API -->
    <script>
        function initSourcingMap() {
            if (typeof google === 'undefined' || !google.maps) {
                console.warn('Google Maps API not loaded');
                return;
            }

            const mapElement = document.getElementById('sourcingMap');
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

        // Filter toggle functionality
        document.getElementById('toggleFilters').addEventListener('click', function() {
            const filterContent = document.getElementById('filterContent');
            const filterIcon = document.getElementById('filterIcon');
            filterContent.classList.toggle('hidden');
            filterIcon.classList.toggle('rotate-180');
        });

        // Reset filters functionality
        document.getElementById('resetFilters').addEventListener('click', function() {
            document.getElementById('searchFilter').value = '';
            document.getElementById('industryFilter').value = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('fromDate').value = '';
            document.getElementById('toDate').value = '';
        });

        // Initialize map when page loads
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof google !== 'undefined' && google.maps) {
                initSourcingMap();
            }
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB92zhVRCzKP_yXXFAko45mb6y1OAH_qgs&libraries=places,geometry&callback=initSourcingMap" async defer></script>
@endsection
