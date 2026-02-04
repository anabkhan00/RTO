@extends('admin.master_layout.index')
@section('page-title', 'Find Placements')

@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Find Placements</h1>
                <p class="text-gray-600 mt-1">Locate students and industries for optimal placement matching</p>
            </div>
            <div class="flex gap-3">
                <div class="text-center">
                    <p class="text-xl font-bold text-blue-600">{{ $students->count() }}</p>
                    <p class="text-gray-600 text-xs">Students</p>
                </div>
                <div class="text-center">
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
            <div class="flex gap-2">
                <button id="toggleStudents" class="flex items-center px-3 py-2 text-xs font-medium rounded-md bg-blue-500 text-white hover:bg-blue-600 transition-colors">
                    <div class="w-3 h-3 rounded-full bg-blue-300 mr-2"></div>
                    Students
                </button>
                <button id="toggleIndustries" class="flex items-center px-3 py-2 text-xs font-medium rounded-md bg-green-500 text-white hover:bg-green-600 transition-colors">
                    <div class="w-3 h-3 rounded-full bg-green-300 mr-2"></div>
                    Industries
                </button>
            </div>
        </div>
        <div id="placementMap" class="w-full h-96 rounded-lg border"></div>
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
