@extends('rto.master_layout.index')
@section('page-title', 'Create Student')

@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Create New Student</h1>
                {{-- <p class="text-gray-600 mt-1">Add a new student to the system</p> --}}
            </div>
            <a href="{{ route('rto.students') }}"
                class="bg-gray-500 text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gray-600 transition-colors">
                Back to Students
            </a>
        </div>
    </div>

    <!-- Create Student Form -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="POST" action="{{ route('rto.students.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-person mr-1"></i> Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter Student Name"
                        required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all" />
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-envelope mr-1"></i> Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter Email" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all" />
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-phone mr-1"></i> Phone
                    </label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+1-xxx-xxx-xxxx"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all" />
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-flag mr-1"></i> Priority
                    </label>
                    <select name="priority"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all bg-white">
                        <option value="">Select Priority</option>
                        <option value="high_priority" {{ old('priority') == 'high_priority' ? 'selected' : '' }}>High
                            Priority</option>
                        <option value="medium_priority" {{ old('priority') == 'medium_priority' ? 'selected' : '' }}>Medium
                            Priority</option>
                        <option value="low_priority" {{ old('priority') == 'low_priority' ? 'selected' : '' }}>Low Priority
                        </option>
                    </select>
                    @error('priority')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-book mr-1"></i> Course
                    </label>

                    @if ($courses->isEmpty())
                        <div class="text-sm text-red-600 bg-red-50 p-3 rounded-lg">
                            No courses found.
                            <a href="{{ route('admin.courses') }}" class="text-blue-600 font-medium underline ml-1">
                                Click here to add courses
                            </a>
                        </div>
                    @else
                        <select name="course_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all bg-white">
                            <option value="">Select Course</option>

                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}"
                                    {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->name }}
                                </option>
                            @endforeach
                        </select>
                    @endif

                    @error('course_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-phone mr-1"></i> Emergency Contact
                    </label>
                    <input type="text" name="emergency_contact" value="{{ old('emergency_contact') }}" placeholder="Emergency Contact Number"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all" />
                    @error('emergency_contact')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-clock mr-1"></i> Placement Hours
                    </label>
                    <input type="number" name="placement_hours" value="{{ old('placement_hours') }}" placeholder="Enter placement hours"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all" />
                    @error('placement_hours')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-person-check mr-1"></i> Student Status
                    </label>
                    <select name="student_status"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all bg-white">
                        <option value="active" {{ old('student_status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('student_status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="blocked" {{ old('student_status') == 'blocked' ? 'selected' : '' }}>Blocked</option>
                    </select>
                    @error('student_status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-geo-alt mr-1"></i> Address <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="address" id="addressInput" value="{{ old('address') }}" placeholder="Enter Address" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all" />
                    <input type="hidden" name="latitude" id="latitudeInput" value="{{ old('latitude') }}">
                    <input type="hidden" name="longitude" id="longitudeInput" value="{{ old('longitude') }}">
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-car-front mr-1"></i> Transport
                    </label>
                    <input type="text" name="transport" value="{{ old('transport') }}"
                        placeholder="Enter Transport Details"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all" />
                    @error('transport')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-heart-pulse mr-1"></i> Medical Condition
                    </label>
                    <textarea name="medical_condition" rows="3" placeholder="Enter any medical conditions or allergies"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all">{{ old('medical_condition') }}</textarea>
                    @error('medical_condition')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="bi bi-clipboard-data mr-1"></i> Placement Data
                    </label>
                    <textarea name="placement_data" rows="3" placeholder="Enter placement-related information"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand transition-all">{{ old('placement_data') }}</textarea>
                    @error('placement_data')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex gap-3 pt-4 border-t">
                <button type="submit"
                    class="bg-brand text-white text-sm px-4 py-2 rounded-md hover:bg-gold transition-colors font-medium">
                    Create
                </button>
                <a href="{{ route('admin.students') }}"
                    class="bg-gray-500 text-white text-sm px-4 py-2 rounded-md hover:bg-gray-600 transition-colors font-medium">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    @include('includes.google-maps', ['callback' => 'initStudentAddressAutocomplete'])

    <script>
        function initStudentAddressAutocomplete() {
            if (typeof google === 'undefined' || !google.maps || !google.maps.places) {
                return;
            }

            const addressInput = document.getElementById('addressInput');
            const latInput = document.getElementById('latitudeInput');
            const lngInput = document.getElementById('longitudeInput');

            if (!addressInput || !latInput || !lngInput) {
                return;
            }

            const autocomplete = new google.maps.places.Autocomplete(addressInput);

            autocomplete.addListener('place_changed', function() {
                const place = autocomplete.getPlace();

                if (place.geometry) {
                    latInput.value = place.geometry.location.lat();
                    lngInput.value = place.geometry.location.lng();
                }
            });
        }
    </script>
@endsection
