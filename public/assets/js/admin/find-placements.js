// Find Placements Map Functionality
window.initPlacementMap = function() {
    if (typeof google === 'undefined' || !google.maps) {
        console.warn('Google Maps API not loaded');
        return;
    }

    const mapElement = document.getElementById('placementMap');
    if (!mapElement) return;

    // Get dynamic data from window object
    const students = window.placementStudents || [];
    const industries = window.placementIndustries || [];

    let studentMarkers = [];
    let industryMarkers = [];

    // Filter valid coordinates
    const validStudents = students.filter(s => 
        Number.isFinite(Number(s.latitude)) && Number.isFinite(Number(s.longitude))
    );
    const validIndustries = industries.filter(i => 
        Number.isFinite(Number(i.latitude)) && Number.isFinite(Number(i.longitude))
    );
    
    const firstPoint = validStudents[0] || validIndustries[0] || null;

    const mapOptions = {
        center: firstPoint
            ? { lat: Number(firstPoint.latitude), lng: Number(firstPoint.longitude) }
            : { lat: -33.8688, lng: 151.2093 },
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
    const bounds = new google.maps.LatLngBounds();

    // Extend bounds for all valid points
    validStudents.forEach(s => bounds.extend({ 
        lat: Number(s.latitude), 
        lng: Number(s.longitude) 
    }));
    validIndustries.forEach(i => bounds.extend({ 
        lat: Number(i.latitude), 
        lng: Number(i.longitude) 
    }));

    // Fit map to show all markers
    if (validStudents.length || validIndustries.length) {
        map.fitBounds(bounds);
        google.maps.event.addListenerOnce(map, 'bounds_changed', function() {
            if (map.getZoom() > 13) map.setZoom(13);
        });
    }

    // Add student markers
    validStudents.forEach((student, index) => {
        setTimeout(() => {
            const marker = new google.maps.Marker({
                position: { 
                    lat: parseFloat(student.latitude), 
                    lng: parseFloat(student.longitude) 
                },
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
                content: `<div style="font-family: system-ui, sans-serif; padding: 8px;">
                    <strong>${student.name}</strong><br>
                    <span style="color: #666; font-size: 13px;">${course}</span><br>
                    <small style="color: #3b82f6;">Status: ${status}</small>
                </div>`
            });

            marker.addListener('click', () => infoWindow.open(map, marker));
            studentMarkers.push(marker);
        }, index * 200);
    });

    // Add industry markers
    validIndustries.forEach((industry, index) => {
        setTimeout(() => {
            const marker = new google.maps.Marker({
                position: { 
                    lat: parseFloat(industry.latitude), 
                    lng: parseFloat(industry.longitude) 
                },
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
                content: `<div style="font-family: system-ui, sans-serif; padding: 8px;">
                    <strong>${industry.name}</strong><br>
                    <span style="color: #666; font-size: 13px;">${industry.contact_person || 'No Contact'}</span><br>
                    <small style="color: #059669;">Industry Partner</small>
                </div>`
            });

            marker.addListener('click', () => infoWindow.open(map, marker));
            industryMarkers.push(marker);
        }, (validStudents.length + index) * 200);
    });

    // Toggle buttons functionality
    const toggleStudentsBtn = document.getElementById('toggleStudents');
    const toggleIndustriesBtn = document.getElementById('toggleIndustries');

    if (toggleStudentsBtn) {
        toggleStudentsBtn.addEventListener('click', function() {
            const visible = studentMarkers.length > 0 ? studentMarkers[0].getVisible() : false;
            studentMarkers.forEach(marker => marker.setVisible(!visible));
            this.classList.toggle('bg-blue-300', !visible);
            this.classList.toggle('bg-blue-500', visible);
        });
    }

    if (toggleIndustriesBtn) {
        toggleIndustriesBtn.addEventListener('click', function() {
            const visible = industryMarkers.length > 0 ? industryMarkers[0].getVisible() : false;
            industryMarkers.forEach(marker => marker.setVisible(!visible));
            this.classList.toggle('bg-green-300', !visible);
            this.classList.toggle('bg-green-500', visible);
        });
    }
};