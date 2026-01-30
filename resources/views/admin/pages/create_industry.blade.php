@extends('admin.master_layout.index')
@section('page-title', 'Create Industry')
@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Create New Industry</h1>
                <p class="text-gray-600 mt-1">Add a new industry to the system</p>
            </div>
            <a href="{{ route('admin.industries') }}"
                class="bg-gray-500 text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gray-600 transition-colors">
                <i class="bi bi-arrow-left mr-1"></i> Back to Industries
            </a>
        </div>
    </div>

    <!-- Create Form -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('admin.industries.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-building mr-1"></i> Industry Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', urldecode(request('name', ''))) }}" placeholder="Enter Industry Name" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('name') border-red-500 @enderror" />
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-person mr-1"></i> Contact Person
                    </label>
                    <input type="text" name="contact_person" value="{{ old('contact_person') }}" placeholder="Enter Contact Person Name"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('contact_person') border-red-500 @enderror" />
                    @error('contact_person')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-envelope mr-1"></i> Email
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter Email"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('email') border-red-500 @enderror" />
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-phone mr-1"></i> Phone
                    </label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Enter Phone Number"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('phone') border-red-500 @enderror" />
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-globe mr-1"></i> Website
                    </label>
                    <input type="url" name="website" value="{{ old('website') }}" placeholder="https://example.com"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('website') border-red-500 @enderror" />
                    @error('website')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-geo-alt mr-1"></i> Address
                    </label>
                    <input type="text" name="address" id="addressInput" value="{{ old('address', urldecode(request('address', ''))) }}" placeholder="Start typing address..."
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('address') border-red-500 @enderror" />
                    <input type="hidden" name="latitude" id="latitudeInput" value="{{ old('latitude', request('latitude', '')) }}">
                    <input type="hidden" name="longitude" id="longitudeInput" value="{{ old('longitude', request('longitude', '')) }}">
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="bi bi-file-text mr-1"></i> Description
                </label>
                <textarea name="description" rows="4" placeholder="Enter Industry Description"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Course Configuration -->
            <div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">
                        <i class="bi bi-book mr-1"></i> Course Configuration
                    </label>
                </div>
                <div id="coursesContainer" class="space-y-4 mb-4">
                    <!-- Courses will be added here -->
                </div>
                <button type="button" id="addCourse" class="bg-brand text-white text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors">
                    <i class="bi bi-plus mr-1"></i>Add Another Course
                </button>
            </div>

            <div class="flex gap-3 pt-4 border-t">
                <button type="submit"
                    class="bg-brand text-white text-sm px-4 py-2 rounded-md hover:bg-gold transition-colors font-medium">
                     Create Industry
                </button>
                <a href="{{ route('admin.industries') }}"
                    class="bg-gray-500 text-white text-sm px-4 py-2 rounded-md hover:bg-gray-600 transition-colors font-medium">
                     Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places&callback=initAutocomplete" async defer></script>

    <script>
        // =============================================================================
        // GLOBAL VARIABLES
        // =============================================================================
        let courseCount = 0;

        // =============================================================================
        // GOOGLE MAPS AUTOCOMPLETE
        // =============================================================================
        function initAutocomplete() {
            console.log('🗺️ Initializing Google Maps Autocomplete...');

            if (typeof google === 'undefined' || !google.maps || !google.maps.places) {
                console.warn('Google Maps API not loaded yet');
                return;
            }

            const addressInput = document.getElementById('addressInput');
            const latInput = document.getElementById('latitudeInput');
            const lngInput = document.getElementById('longitudeInput');

            if (addressInput && latInput && lngInput) {
                const autocomplete = new google.maps.places.Autocomplete(addressInput, {
                    componentRestrictions: { country: 'au' }
                });

                autocomplete.addListener('place_changed', function() {
                    const place = autocomplete.getPlace();

                    if (place.geometry) {
                        latInput.value = place.geometry.location.lat();
                        lngInput.value = place.geometry.location.lng();
                        console.log('✅ Address selected:', place.formatted_address);
                    }
                });

                console.log('✅ Autocomplete initialized');
            }
        }

        // =============================================================================
        // MAIN INITIALIZATION
        // =============================================================================
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🚀 Initializing Create Industry Page...');

            initCourseManagement();

            // Add first course section by default
            addCourse();

            console.log('✅ Page initialization complete');
        });

        // =============================================================================
        // COURSE MANAGEMENT
        // =============================================================================
        function initCourseManagement() {
            const addCourseBtn = document.getElementById('addCourse');

            if (!addCourseBtn) {
                console.error('Add Course button not found');
                return;
            }

            // Add course functionality
            addCourseBtn.addEventListener('click', function() {
                addCourse();
            });

            // Event delegation for dynamic buttons
            document.addEventListener('click', function(e) {
                // Remove course
                if (e.target.closest('.remove-course')) {
                    e.target.closest('.course-item').remove();
                    updateCourseNumbers();
                }

                // Add document
                if (e.target.closest('.add-document')) {
                    const courseIndex = e.target.closest('.add-document').dataset.course;
                    addDocument(courseIndex);
                }

                // Add slot
                if (e.target.closest('.add-slot')) {
                    const courseIndex = e.target.closest('.add-slot').dataset.course;
                    addSlot(courseIndex);
                }

                // Remove document
                if (e.target.closest('.remove-document')) {
                    e.target.closest('.document-item').remove();
                }

                // Remove slot
                if (e.target.closest('.remove-slot')) {
                    e.target.closest('.slot-item').remove();
                }
            });

            console.log('✅ Course management initialized');
        }

        // =============================================================================
        // ADD COURSE FUNCTION
        // =============================================================================
        function addCourse() {
            const container = document.getElementById('coursesContainer');

            const courseHtml = `
                <div class="course-item border rounded-lg p-4 bg-gray-50">
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="font-medium text-gray-800 course-title">Course ${courseCount + 1}</h4>
                        <button type="button" class="remove-course text-red-600 hover:text-red-800 text-sm">
                            <i class="bi bi-trash"></i> Remove
                        </button>
                    </div>

                    <div class="space-y-4">
                        <!-- Course Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Course *</label>
                            <select name="courses[${courseCount}][course_id]" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                                <option value="">Choose a course...</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Additional Documents -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-sm font-medium text-gray-700">Additional Documents</label>
                                <button type="button" class="add-document text-xs text-brand hover:text-gold" data-course="${courseCount}">
                                    <i class="bi bi-plus mr-1"></i>Add Document
                                </button>
                            </div>
                            <div class="documents-container space-y-2" data-course="${courseCount}">
                                <!-- Documents will be added here -->
                            </div>
                        </div>

                        <!-- Placement Slots -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-sm font-medium text-gray-700">Placement Slots</label>
                                <button type="button" class="add-slot text-xs text-brand hover:text-gold" data-course="${courseCount}">
                                    <i class="bi bi-plus mr-1"></i>Add Slot
                                </button>
                            </div>
                            <div class="slots-container space-y-2" data-course="${courseCount}">
                                <!-- Slots will be added here -->
                            </div>
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', courseHtml);
            courseCount++;

            console.log('✅ Course added:', courseCount);
        }

        // =============================================================================
        // ADD DOCUMENT FUNCTION
        // =============================================================================
        function addDocument(courseIndex) {
            const container = document.querySelector(`.documents-container[data-course="${courseIndex}"]`);

            if (!container) {
                console.error('Documents container not found for course:', courseIndex);
                return;
            }

            const docCount = container.children.length;

            const docHtml = `
                <div class="document-item flex gap-2 items-center">
                    <input type="text" name="courses[${courseIndex}][documents][${docCount}]" placeholder="Document name"
                        class="flex-1 border border-gray-300 rounded px-2 py-1 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                    <button type="button" class="remove-document text-red-600 hover:text-red-800 text-sm">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', docHtml);
            console.log('✅ Document added to course:', courseIndex);
        }

        // =============================================================================
        // ADD SLOT FUNCTION
        // =============================================================================
        function addSlot(courseIndex) {
            const container = document.querySelector(`.slots-container[data-course="${courseIndex}"]`);

            if (!container) {
                console.error('Slots container not found for course:', courseIndex);
                return;
            }

            const slotCount = container.children.length;

            const slotHtml = `
                <div class="slot-item border rounded p-3 bg-white">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Position Title</label>
                            <input type="text" name="courses[${courseIndex}][slots][${slotCount}][title]" placeholder="e.g., Software Developer"
                                class="w-full border border-gray-300 rounded px-2 py-1 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Total Slots</label>
                            <input type="number" name="courses[${courseIndex}][slots][${slotCount}][total_slots]" min="1" placeholder="10"
                                class="w-full border border-gray-300 rounded px-2 py-1 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Requirements</label>
                            <input type="text" name="courses[${courseIndex}][slots][${slotCount}][requirements]" placeholder="Basic requirements"
                                class="w-full border border-gray-300 rounded px-2 py-1 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                        </div>
                    </div>
                    <button type="button" class="remove-slot mt-2 text-xs text-red-600 hover:text-red-800">
                        <i class="bi bi-trash mr-1"></i>Remove Slot
                    </button>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', slotHtml);
            console.log('✅ Slot added to course:', courseIndex);
        }

        // =============================================================================
        // UPDATE COURSE NUMBERS
        // =============================================================================
        function updateCourseNumbers() {
            const courseItems = document.querySelectorAll('.course-item');

            courseItems.forEach((item, index) => {
                const title = item.querySelector('.course-title');
                if (title) {
                    title.textContent = `Course ${index + 1}`;
                }
            });

            console.log('✅ Course numbers updated');
        }
    </script>
@endsection
