@extends('admin.master_layout.index')
@section('page-title', 'Find Industries')

@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Find Industries</h1>
                <p class="text-gray-600 mt-1">Search and discover potential industry partners</p>
            </div>
            <a href="{{ route('admin.sourcing-dashboard') }}" class="bg-gray-500 text-white text-xs px-3 py-1.5 rounded-md hover:bg-gray-600 transition-colors">
                <i class="bi bi-arrow-left mr-1"></i>Back to Dashboard
            </a>
        </div>
    </div>

    <!-- Search Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search Term</label>
                <input type="text" id="searchInput" placeholder="e.g., hospitals, restaurants, tech companies"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                <input type="text" id="locationInput" placeholder="Start typing location..."
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
            </div>
            <div class="flex items-end">
                <button id="searchBtn" class="bg-brand text-white text-sm px-4 py-2 rounded-md hover:bg-gold transition-colors w-full">
                    <i class="bi bi-search mr-2"></i>Search Industries
                </button>
            </div>
        </div>
    </div>

    <!-- Map and Results Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Map -->
        <div class="bg-white rounded-lg shadow-sm p-4">
            <h3 class="text-lg font-medium text-brand mb-4">Map View</h3>
            <div id="findMap" class="w-full h-[500px] rounded-xl shadow-lg border border-gray-200"></div>
        </div>

        <!-- Results List -->
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div id="resultsHeader" class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-brand">Search Results</h3>
                <button id="backToResults" class="hidden bg-gray-500 text-white text-xs px-3 py-1.5 rounded-md hover:bg-gray-600 transition-colors" onclick="showResultsList()">
                    <i class="bi bi-arrow-left mr-1"></i>Back to Results
                </button>
            </div>
            <div id="resultsList" class="space-y-3 max-h-[500px] overflow-y-auto">
                <div class="text-center py-12 text-gray-500">
                    <i class="bi bi-search text-4xl mb-4"></i>
                    <p>Enter search terms to find industries</p>
                </div>
            </div>
            <div id="detailsView" class="hidden max-h-[500px] overflow-y-auto">
                <!-- Details will be populated here -->
            </div>
        </div>
    </div>

    <!-- Contact Modal -->
    <div id="contactModal" class="fixed inset-0 bg-black/50 flex justify-center items-center hidden z-50">
        <div class="bg-white w-full max-w-md rounded-xl shadow-2xl p-6 relative">
            <button onclick="closeContactModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">
                &times;
            </button>
            <h3 class="text-xl font-semibold text-brand mb-4">Contact Industry</h3>
            <div id="contactDetails"></div>
            <div class="mt-4 space-y-3">
                {{-- <button onclick="callIndustry()" class="w-full bg-green-500 text-white text-sm px-4 py-2 rounded-md hover:bg-green-600 transition-colors">
                    <i class="bi bi-telephone mr-2"></i>Call Now
                </button> --}}
                <button onclick="addToSystem()" class="w-full bg-brand text-white text-sm px-4 py-2 rounded-md hover:bg-gold transition-colors">
                    <i class="bi bi-plus mr-2"></i>Add to System
                </button>
            </div>
        </div>
    </div>

    <script>
        let map, service, selectedPlace;

        function initFindMap() {
            if (typeof google === 'undefined' || !google.maps) {
                console.warn('Google Maps API not loaded');
                return;
            }

            map = new google.maps.Map(document.getElementById('findMap'), {
                center: { lat: -33.8688, lng: 151.2093 },
                zoom: 12,
                gestureHandling: 'greedy',
                disableDefaultUI: true,
                zoomControl: true,
                fullscreenControl: true
            });

            service = new google.maps.places.PlacesService(map);

            // Initialize location autocomplete
            const locationInput = document.getElementById('locationInput');
            const locationAutocomplete = new google.maps.places.Autocomplete(locationInput, {
                componentRestrictions: { country: 'au' },
                types: ['(cities)']
            });

            locationAutocomplete.addListener('place_changed', function() {
                const place = locationAutocomplete.getPlace();
                if (place.geometry) {
                    map.setCenter(place.geometry.location);
                    map.setZoom(12);
                }
            });
        }

        function searchIndustries() {
            const searchTerm = document.getElementById('searchInput').value;
            const locationInput = document.getElementById('locationInput');
            const location = locationInput.value || 'Sydney, NSW';

            if (!searchTerm) {
                alert('Please enter a search term');
                return;
            }

            // If location input has a place object from autocomplete, use it
            if (locationInput.place && locationInput.place.geometry) {
                searchNearLocation(locationInput.place.geometry.location, searchTerm);
            } else {
                // Geocode the location text
                const geocoder = new google.maps.Geocoder();
                geocoder.geocode({ address: location }, (results, status) => {
                    if (status === 'OK') {
                        const center = results[0].geometry.location;
                        searchNearLocation(center, searchTerm);
                    } else {
                        alert('Location not found. Please try a different location.');
                    }
                });
            }
        }

        function searchNearLocation(location, searchTerm) {
            map.setCenter(location);

            const request = {
                location: location,
                radius: 15000, // 15km radius
                query: searchTerm
            };

            service.textSearch(request, (results, status) => {
                if (status === google.maps.places.PlacesServiceStatus.OK) {
                    displayResults(results);
                    showMarkersOnMap(results);
                } else {
                    document.getElementById('resultsList').innerHTML =
                        '<div class="text-center py-12 text-gray-500"><i class="bi bi-exclamation-circle text-4xl mb-4"></i><p>No results found. Try different search terms.</p></div>';
                }
            });
        }

        function displayResults(places) {
            const resultsList = document.getElementById('resultsList');
            resultsList.innerHTML = '';

            places.forEach((place, index) => {
                const rating = place.rating ? `⭐ ${place.rating}` : 'No rating';
                const status = place.business_status === 'OPERATIONAL' ? 'Open' : 'Status unknown';

                const resultItem = `
                    <div class="border rounded-lg p-4 hover:border-brand transition-colors cursor-pointer" onclick="showPlaceDetails(${index})">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">${place.name}</h4>
                                <p class="text-sm text-gray-600 mt-1">${place.formatted_address}</p>
                                <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
                                    <span>${rating}</span>
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded">${status}</span>
                                </div>
                            </div>
                            <button onclick="event.stopPropagation(); openContactModal(${index})"
                                class="bg-brand text-white text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors">
                                Contact
                            </button>
                        </div>
                    </div>
                `;
                resultsList.innerHTML += resultItem;
            });

            // Store places globally for access
            window.searchResults = places;
        }

        function showMarkersOnMap(places) {
            // Clear existing markers
            if (window.markers) {
                window.markers.forEach(marker => marker.setMap(null));
            }
            window.markers = [];

            places.forEach((place, index) => {
                const marker = new google.maps.Marker({
                    position: place.geometry.location,
                    map: map,
                    title: place.name,
                    icon: {
                        url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" fill="#d4af37"/>
                                <circle cx="12" cy="9" r="2.5" fill="white"/>
                            </svg>
                        `),
                        scaledSize: new google.maps.Size(24, 24),
                        anchor: new google.maps.Point(12, 24)
                    }
                });

                marker.addListener('click', () => {
                    openContactModal(index);
                });

                window.markers.push(marker);
            });
        }

        function showPlaceDetails(index) {
            const place = window.searchResults[index];

            const request = {
                placeId: place.place_id,
                fields: ['name', 'formatted_address', 'formatted_phone_number', 'website', 'rating', 'photos', 'opening_hours', 'business_status']
            };

            service.getDetails(request, (placeDetails, status) => {
                if (status === google.maps.places.PlacesServiceStatus.OK) {
                    displayPlaceDetails(placeDetails, index);
                }
            });
        }

        function displayPlaceDetails(place, index) {
            const detailsView = document.getElementById('detailsView');
            const resultsList = document.getElementById('resultsList');
            const backBtn = document.getElementById('backToResults');

            const phone = place.formatted_phone_number || 'Not available';
            const website = place.website || 'Not available';
            const rating = place.rating ? `⭐ ${place.rating}` : 'No rating';
            const hours = place.opening_hours ? (place.opening_hours.open_now ? 'Open now' : 'Closed') : 'Hours not available';

            let photosHtml = '';
            if (place.photos && place.photos.length > 0) {
                photosHtml = `<img src="${place.photos[0].getUrl({maxWidth: 300, maxHeight: 200})}" class="w-full h-48 object-cover rounded-lg mb-4" alt="${place.name}">`;
            }

            detailsView.innerHTML = `
                <div class="space-y-4">
                    ${photosHtml}
                    <div>
                        <h4 class="text-xl font-bold text-gray-900 mb-2">${place.name}</h4>
                        <p class="text-sm text-gray-600 mb-4">${place.formatted_address}</p>
                    </div>

                    <div class="grid grid-cols-1 gap-3">
                        <div class="flex items-center gap-2">
                            <i class="bi bi-telephone text-brand"></i>
                            <span class="text-sm">${phone}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="bi bi-globe text-brand"></i>
                            ${website !== 'Not available' ? `<a href="${website}" target="_blank" class="text-sm text-blue-600 hover:underline">${website}</a>` : `<span class="text-sm">${website}</span>`}
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="bi bi-star text-brand"></i>
                            <span class="text-sm">${rating}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="bi bi-clock text-brand"></i>
                            <span class="text-sm">${hours}</span>
                        </div>
                    </div>

                        <button onclick="addToSystemFromDetails(${index})" class="w-full bg-brand text-white text-sm px-4 py-2 rounded-md hover:bg-gold transition-colors">
                            <i class="bi bi-plus mr-2"></i>Add to System
                        </button>
                </div>
            `;

            resultsList.classList.add('hidden');
            detailsView.classList.remove('hidden');
            backBtn.classList.remove('hidden');

            map.setCenter(place.geometry.location);
            map.setZoom(15);
        }

        function showResultsList() {
            const detailsView = document.getElementById('detailsView');
            const resultsList = document.getElementById('resultsList');
            const backBtn = document.getElementById('backToResults');

            detailsView.classList.add('hidden');
            resultsList.classList.remove('hidden');
            backBtn.classList.add('hidden');
        }

        function callIndustryFromDetails(phone, name) {
            if (phone !== 'Not available') {
                window.open(`tel:${phone}`);
            }
            alert(`Contact logged for: ${name}`);
        }

        function addToSystemFromDetails(index) {
            const place = window.searchResults[index];
            const params = new URLSearchParams({
                name: place.name,
                address: place.formatted_address,
                latitude: place.geometry.location.lat(),
                longitude: place.geometry.location.lng()
            });

            window.location.href = '/admin/industries/create?' + params.toString();
        }

        function openContactModal(index) {
            selectedPlace = window.searchResults[index];
            const modal = document.getElementById('contactModal');
            const details = document.getElementById('contactDetails');

            details.innerHTML = `
                <div class="space-y-2">
                    <h4 class="font-medium">${selectedPlace.name}</h4>
                    <p class="text-sm text-gray-600">${selectedPlace.formatted_address}</p>
                    <p class="text-sm text-gray-600">Rating: ${selectedPlace.rating || 'N/A'}</p>
                    <p class="text-sm text-gray-600">Status: ${selectedPlace.business_status || 'Unknown'}</p>
                </div>
            `;

            modal.classList.remove('hidden');
        }

        function closeContactModal() {
            document.getElementById('contactModal').classList.add('hidden');
        }

        function callIndustry() {
            // Log contact attempt
            fetch('/admin/industry-contacts', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    place_id: selectedPlace.place_id,
                    name: selectedPlace.name,
                    address: selectedPlace.formatted_address,
                    action: 'call'
                })
            });

            alert('Contact logged. Please call: ' + selectedPlace.name);
            closeContactModal();
        }

        function addToSystem() {
            // Redirect to create industry with pre-filled data
            const params = new URLSearchParams({
                name: selectedPlace.name,
                address: selectedPlace.formatted_address,
                latitude: selectedPlace.geometry.location.lat(),
                longitude: selectedPlace.geometry.location.lng()
            });

            window.location.href = '/admin/industries/create?' + params.toString();
        }

        // Event listeners
        document.getElementById('searchBtn').addEventListener('click', searchIndustries);
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') searchIndustries();
        });

        // Initialize map when page loads
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof google !== 'undefined' && google.maps) {
                initFindMap();
            }
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB92zhVRCzKP_yXXFAko45mb6y1OAH_qgs&libraries=places,geometry&callback=initFindMap" async defer></script>
@endsection
