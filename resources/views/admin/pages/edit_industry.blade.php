@extends('admin.master_layout.index')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            height: 38px;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
        }

        .select2-container--default .select2-selection--multiple {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            min-height: 38px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px;
            padding-left: 12px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #d4af37;
            border: 1px solid #c19b2e;
            color: white;
        }
    </style>
@endpush

@section('content')
    <div class="p-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-semibold" style="color: #5A5A5A;">
                        {{ isset($industry) ? 'Edit Industry' : 'Create Industry' }}</h2>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ isset($industry) ? 'Update industry information and manage placement opportunities' : 'Add new industry with courses and placement details' }}
                    </p>
                </div>
                <a href="{{ route('admin.industries') }}"
                    class="bg-gray-500 text-white text-xs px-3 py-1.5 rounded-md hover:bg-gray-600 transition-colors font-medium">
                    <i class="bi bi-arrow-left mr-2"></i>Back to Industries
                </a>
            </div>
        </div>

        <form
            action="{{ isset($industry) ? route('admin.industries.update', $industry->id) : route('admin.industries.store') }}"
            method="POST" class="space-y-6">
            @csrf
            @if (isset($industry))
                @method('PUT')
            @endif

            <!-- Basic Information -->
            <div class="bg-white rounded-lg border shadow-sm">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium" style="color: #5A5A5A;">Basic Information</h3>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Industry Name *</label>
                            <input type="text" name="name"
                                value="{{ old('name', $industry->name ?? ($prefill['name'] ?? '')) }}" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="industry_status"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                                <option value="active"
                                    {{ old('industry_status', $industry->industry_status ?? 'active') == 'active' ? 'selected' : '' }}>
                                    Active</option>
                                <option value="inactive"
                                    {{ old('industry_status', $industry->industry_status ?? '') == 'inactive' ? 'selected' : '' }}>
                                    Inactive</option>
                                <option value="blocked"
                                    {{ old('industry_status', $industry->industry_status ?? '') == 'blocked' ? 'selected' : '' }}>
                                    Blocked</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="3"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">{{ old('description', $industry->description ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-white rounded-lg border shadow-sm">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium" style="color: #5A5A5A;">Contact Information</h3>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Contact Person</label>
                            <input type="text" name="contact_person"
                                value="{{ old('contact_person', $industry->contact_person ?? '') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', $industry->email ?? '') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $industry->phone ?? '') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                            <input type="url" name="website" value="{{ old('website', $industry->website ?? '') }}"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                            <input type="text" name="address" id="addressInput"
                                value="{{ old('address', $industry->address ?? ($prefill['address'] ?? '')) }}"
                                placeholder="Start typing address..."
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                            <input type="hidden" name="latitude" id="latitudeInput"
                                value="{{ old('latitude', $industry->latitude ?? ($prefill['latitude'] ?? '')) }}">
                            <input type="hidden" name="longitude" id="longitudeInput"
                                value="{{ old('longitude', $industry->longitude ?? ($prefill['longitude'] ?? '')) }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Configuration -->
            <div class="bg-white rounded-lg border shadow-sm">
                <div class="p-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium" style="color: #5A5A5A;">Course Configuration</h3>

                    </div>
                </div>
                <div class="p-4">
                    <div id="coursesContainer" class="space-y-4">
                        @if (isset($industry) && $industry->courses->count() > 0)
                            @foreach ($industry->courses as $index => $course)
                                <div class="course-item border rounded-lg p-4 bg-gray-50">
                                    <div class="flex justify-between items-center mb-3">
                                        <h4 class="font-medium text-gray-800">Course {{ $index + 1 }}</h4>
                                        <button type="button"
                                            class="remove-course text-red-600 hover:text-red-800 text-sm">
                                            <i class="bi bi-trash"></i> Remove
                                        </button>
                                    </div>

                                    <div class="space-y-4">
                                        <!-- Course Selection -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Course
                                                *</label>
                                            <select name="courses[{{ $index }}][course_id]" required
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                                                <option value="">Choose a course...</option>
                                                @foreach ($courses as $courseOption)
                                                    <option value="{{ $courseOption->id }}"
                                                        {{ $courseOption->id == $course->id ? 'selected' : '' }}>
                                                        {{ $courseOption->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Additional Documents -->
                                        <div>
                                            <div class="flex justify-between items-center mb-2">
                                                <label class="block text-sm font-medium text-gray-700">Additional
                                                    Documents</label>
                                                <button type="button"
                                                    class="add-document text-xs text-brand hover:text-gold"
                                                    data-course="{{ $index }}">
                                                    <i class="bi bi-plus mr-1"></i>Add Document
                                                </button>
                                            </div>
                                            <div class="documents-container space-y-2" data-course="{{ $index }}">
                                                @php
                                                    $documents = json_decode(
                                                        $course->pivot->additional_documents ?? '[]',
                                                        true,
                                                    );
                                                @endphp
                                                @foreach ($documents as $docIndex => $document)
                                                    <div class="document-item flex gap-2 items-center">
                                                        <input type="text"
                                                            name="courses[{{ $index }}][documents][{{ $docIndex }}]"
                                                            value="{{ $document }}" placeholder="Document name"
                                                            class="flex-1 border border-gray-300 rounded px-2 py-1 text-sm">
                                                        <button type="button"
                                                            class="remove-document text-red-600 hover:text-red-800 text-sm">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Placement Slots -->
                                        <div>
                                            <div class="flex justify-between items-center mb-2">
                                                <label class="block text-sm font-medium text-gray-700">Placement
                                                    Slots</label>
                                                <button type="button" class="add-slot text-xs text-brand hover:text-gold"
                                                    data-course="{{ $index }}">
                                                    <i class="bi bi-plus mr-1"></i>Add Slot
                                                </button>
                                            </div>
                                            <div class="slots-container space-y-2" data-course="{{ $index }}">
                                                @php
                                                    $slots = json_decode($course->pivot->placement_slots ?? '[]', true);
                                                @endphp
                                                @foreach ($slots as $slotIndex => $slot)
                                                    <div class="slot-item border rounded p-3 bg-white">
                                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                                            <div>
                                                                <label
                                                                    class="block text-xs font-medium text-gray-600 mb-1">Position
                                                                    Title</label>
                                                                <input type="text"
                                                                    name="courses[{{ $index }}][slots][{{ $slotIndex }}][title]"
                                                                    value="{{ $slot['title'] ?? '' }}"
                                                                    placeholder="e.g., Software Developer"
                                                                    class="w-full border border-gray-300 rounded px-2 py-1 text-sm">
                                                            </div>
                                                            <div>
                                                                <label
                                                                    class="block text-xs font-medium text-gray-600 mb-1">Total
                                                                    Slots</label>
                                                                <input type="number"
                                                                    name="courses[{{ $index }}][slots][{{ $slotIndex }}][total_slots]"
                                                                    value="{{ $slot['total_slots'] ?? '' }}"
                                                                    min="1" placeholder="10"
                                                                    class="w-full border border-gray-300 rounded px-2 py-1 text-sm">
                                                            </div>
                                                            <div>
                                                                <label
                                                                    class="block text-xs font-medium text-gray-600 mb-1">Requirements</label>
                                                                <input type="text"
                                                                    name="courses[{{ $index }}][slots][{{ $slotIndex }}][requirements]"
                                                                    value="{{ $slot['requirements'] ?? '' }}"
                                                                    placeholder="Basic requirements"
                                                                    class="w-full border border-gray-300 rounded px-2 py-1 text-sm">
                                                            </div>
                                                        </div>
                                                        <button type="button"
                                                            class="remove-slot mt-2 text-xs text-red-600 hover:text-red-800">
                                                            <i class="bi bi-trash mr-1"></i>Remove Slot
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="mt-4 flex">
                        <button type="button" id="addCourse"
                            class="bg-brand text-white text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors">
                            <i class="bi bi-plus mr-1"></i>Add Another Course
                        </button>
                    </div>

                </div>
            </div>

            <!-- Availability Calendar -->
            <div class="bg-white rounded-lg border shadow-sm">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium" style="color: #5A5A5A;">Availability Schedule</h3>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                        <!-- Calendar Area -->
                        <div class="lg:col-span-3">
                            <div class="bg-white rounded-lg border shadow-sm p-1 h-[600px]">
                                <div id="calendar" class="h-full"></div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="lg:col-span-1">
                            <div class="bg-white rounded-lg border shadow-sm p-4 sticky top-6">
                                <h4 class="text-lg font-medium mb-4" style="color: #d4af37;">Week Summary</h4>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Total Hours</label>
                                    <div class="text-3xl font-bold text-gray-800" id="totalHoursDisplay">0</div>
                                    <input type="hidden" id="totalHoursInput">
                                </div>

                                <div class="space-y-3">
                                    <button type="button" id="saveScheduleBtn"
                                        class="w-full px-4 py-2 rounded-lg text-white font-medium flex justify-center items-center gap-2"
                                        style="background-color: #d4af37;"
                                        onmouseover="this.style.backgroundColor='#c19b2e'"
                                        onmouseout="this.style.backgroundColor='#d4af37'">
                                        <i class="fas fa-save"></i> Save Schedule
                                    </button>

                                    <div class="p-3 bg-blue-50 text-blue-800 rounded-lg text-xs leading-relaxed">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        <strong>Instructions:</strong><br>
                                        Click & Drag to create a slot.<br>
                                        Click a slot to delete it.<br>
                                        Resize/Move slots freely.<br>
                                        Don't forget to Save!
                                    </div>
                                </div>

                                <div class="mt-6 border-t pt-4">
                                    <h5 class="text-sm font-medium text-gray-700 mb-2">Selected Ranges</h5>
                                    <div id="eventList" class="text-xs text-gray-600 space-y-1 max-h-60 overflow-y-auto">
                                        <!-- Dynamic list -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                let courseChecklistIndex = 0;

                function addCourseChecklist() {
                    // This function is no longer used
                }

                function removeCourseChecklist(button) {
                    // This function is no longer used
                }
            </script>

            <!-- Notes -->
            {{-- <div class="bg-white rounded-lg border shadow-sm">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium" style="color: #5A5A5A;">Notes</h3>
                </div>
                <div class="p-4">
                    <textarea name="notes" rows="4" placeholder="Add any additional notes about this industry..."
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">{{ old('notes', $industry->notes ?? '') }}</textarea>
                </div>
            </div> --}}

            {{-- @if (isset($industry))
                <!-- Placement Opportunities -->
                <div class="bg-white rounded-lg border shadow-sm">
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-medium" style="color: #5A5A5A;">Placement Opportunities</h3>
                        <button type="button" onclick="openOpportunityModal()"
                            class="bg-brand text-white text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors font-medium">
                            <i class="bi bi-plus mr-2"></i>Add Opportunity
                        </button>
                    </div>
                    <div class="p-4">
                        <div id="opportunitiesList" class="space-y-3">
                            <!-- Opportunities will be loaded here -->
                        </div>
                    </div>
                </div>
            @endif --}}

            <!-- Submit Button -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.industries') }}"
                    class="bg-gray-500 text-white text-xs px-3 py-1.5 rounded-md hover:bg-gray-600 transition-colors font-medium">
                    Cancel
                </a>
                <button type="submit"
                    class="bg-brand text-white text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors font-medium">
                    {{ isset($industry) ? 'Update Industry' : 'Create Industry' }}
                </button>
            </div>
        </form>
    </div>

    @if (isset($industry))
        <!-- Opportunity Modal -->
        <div id="opportunityModal" class="fixed inset-0 bg-black/50 flex justify-center items-center hidden z-50">
            <div class="bg-white w-full max-w-md rounded-xl shadow-2xl p-6 relative">
                <button onclick="closeOpportunityModal()"
                    class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">
                    &times;
                </button>
                <h3 class="text-xl font-semibold mb-4" style="color: #d4af37;" id="opportunityModalTitle">Add Placement
                    Opportunity</h3>
                <form id="opportunityForm">
                    <input type="hidden" id="opportunityId">
                    <input type="hidden" id="industryId" value="{{ $industry->id }}">

                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                        <select id="opportunityCourse" required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                            <option value="">Select Course</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Total Slots</label>
                        <input type="number" id="totalSlots" min="1" required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Requirements</label>
                        <textarea id="requirements" rows="3"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-brand focus:border-brand"></textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="px-4 py-2 rounded-md text-white text-sm bg-brand hover:bg-gold">
                            Save
                        </button>
                        <button type="button" onclick="closeOpportunityModal()"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md text-sm hover:bg-gray-600">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function openOpportunityModal(opportunity = null) {
                if (opportunity) {
                    document.getElementById('opportunityModalTitle').textContent = 'Edit Placement Opportunity';
                    document.getElementById('opportunityId').value = opportunity.id;
                    document.getElementById('opportunityCourse').value = opportunity.course_id;
                    document.getElementById('totalSlots').value = opportunity.total_slots;
                    document.getElementById('requirements').value = opportunity.requirements || '';
                } else {
                    document.getElementById('opportunityModalTitle').textContent = 'Add Placement Opportunity';
                    document.getElementById('opportunityForm').reset();
                    document.getElementById('opportunityId').value = '';
                }
                document.getElementById('opportunityModal').classList.remove('hidden');
            }

            function closeOpportunityModal() {
                document.getElementById('opportunityModal').classList.add('hidden');
            }

            document.getElementById('opportunityForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const opportunityId = document.getElementById('opportunityId').value;
                const data = {
                    industry_id: document.getElementById('industryId').value,
                    course_id: document.getElementById('opportunityCourse').value,
                    total_slots: document.getElementById('totalSlots').value,
                    requirements: document.getElementById('requirements').value,
                    _token: '{{ csrf_token() }}'
                };

                const url = opportunityId ? `/admin/placement-opportunities/${opportunityId}` :
                    '{{ route('admin.placement-opportunities.store') }}';
                const method = opportunityId ? 'PUT' : 'POST';

                fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            toastr.success('Opportunity saved successfully');
                            closeOpportunityModal();
                            loadOpportunities();
                        } else {
                            toastr.error('Failed to save opportunity');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        toastr.error('Failed to save opportunity');
                    });
            });

            // function loadOpportunities() {
            //     const industryId = document.getElementById('industryId').value;

            //     fetch(`/admin/placement-opportunities/industry/${industryId}`)
            //         .then(res => res.json())
            //         .then(data => {
            //             const listDiv = document.getElementById('opportunitiesList');
            //             if (data.opportunities && data.opportunities.length > 0) {
            //                 listDiv.innerHTML = data.opportunities.map(opp => `
            //     <div class="border rounded-lg p-4 hover:border-brand transition-colors">
            //         <div class="flex justify-between items-start">
            //             <div class="flex-1">
            //                 <h4 class="font-medium text-gray-900">${opp.course ? opp.course.name : 'No Course'}</h4>
            //                 <p class="text-sm text-gray-600 mt-1">Total Slots: ${opp.total_slots} | Filled: ${opp.filled_slots || 0}</p>
            //                 ${opp.requirements ? `<p class="text-sm text-gray-500 mt-1">${opp.requirements}</p>` : ''}
            //                 <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium mt-2 ${opp.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'}">
            //                     ${opp.status}
            //                 </span>
            //             </div>
            //             <div class="flex gap-2 ml-4">
            //                 <button onclick='openOpportunityModal(${JSON.stringify(opp)})'
            //                         class="text-blue-600 hover:text-blue-800 text-sm">
            //                     <i class="bi bi-pencil"></i>
            //                 </button>
            //                 <button onclick="deleteOpportunity(${opp.id})"
            //                         class="text-red-600 hover:text-red-800 text-sm">
            //                     <i class="bi bi-trash"></i>
            //                 </button>
            //             </div>
            //         </div>
            //     </div>
            // `).join('');
            //             } else {
            //                 listDiv.innerHTML =
            //                     '<p class="text-gray-500 text-sm text-center py-8">No placement opportunities created yet</p>';
            //             }
            //         })
            //         .catch(err => {
            //             console.error(err);
            //             toastr.error('Failed to load opportunities');
            //         });
            // }

            // function deleteOpportunity(id) {
            //     if (!confirm('Are you sure you want to delete this opportunity?')) return;

            //     fetch(`/admin/placement-opportunities/${id}`, {
            //             method: 'DELETE',
            //             headers: {
            //                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
            //             }
            //         })
            //         .then(res => res.json())
            //         .then(data => {
            //             if (data.success) {
            //                 toastr.success('Opportunity deleted successfully');
            //                 loadOpportunities();
            //             } else {
            //                 toastr.error('Failed to delete opportunity');
            //             }
            //         })
            //         .catch(err => {
            //             console.error(err);
            //             toastr.error('Failed to delete opportunity');
            //         });
            // }

            // document.addEventListener('DOMContentLoaded', function() {
            //     @if (isset($industry))
            //         loadOpportunities();
            //     @endif
            // });
        </script>
    @endif
@endsection

<!-- Google Maps API -->
<script>
    function initAutocomplete() {
        if (typeof google === 'undefined' || !google.maps || !google.maps.places) {
            return;
        }

        const addressInput = document.getElementById('addressInput');
        const latInput = document.getElementById('latitudeInput');
        const lngInput = document.getElementById('longitudeInput');

        if (addressInput && latInput && lngInput) {
            const autocomplete = new google.maps.places.Autocomplete(addressInput, {
                componentRestrictions: {
                    country: 'au'
                }
            });

            autocomplete.addListener('place_changed', function() {
                const place = autocomplete.getPlace();
                if (place.geometry) {
                    latInput.value = place.geometry.location.lat();
                    lngInput.value = place.geometry.location.lng();
                }
            });
        }
    }
</script>
<script
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places&callback=initAutocomplete"
    async defer></script>

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            min-height: 38px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #d4af37;
            border: 1px solid #c19b2e;
            color: white;
        }
    </style>
@endpush

@push('scripts')
    <script>
        let courseCount = {{ isset($industry) && $industry->courses ? $industry->courses->count() : 0 }};

        // Add course functionality
        document.getElementById('addCourse').addEventListener('click', function() {
            const container = document.getElementById('coursesContainer');
            const courseHtml = `
            <div class="course-item border rounded-lg p-4 bg-gray-50">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="font-medium text-gray-800">Course ${courseCount + 1}</h4>
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
                            @foreach ($courses as $course)
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
        });

        // Event delegation for dynamic elements
        document.addEventListener('click', function(e) {
            // Remove course functionality
            if (e.target.closest('.remove-course')) {
                e.target.closest('.course-item').remove();
            }

            // Add document functionality
            if (e.target.closest('.add-document')) {
                const courseIndex = e.target.closest('.add-document').dataset.course;
                const container = document.querySelector(`.documents-container[data-course="${courseIndex}"]`);
                const docCount = container.children.length;

                const docHtml = `
                <div class="document-item flex gap-2 items-center">
                    <input type="text" name="courses[${courseIndex}][documents][${docCount}]" placeholder="Document name"
                        class="flex-1 border border-gray-300 rounded px-2 py-1 text-sm">
                    <button type="button" class="remove-document text-red-600 hover:text-red-800 text-sm">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;
                container.insertAdjacentHTML('beforeend', docHtml);
            }

            // Add slot functionality
            if (e.target.closest('.add-slot')) {
                const courseIndex = e.target.closest('.add-slot').dataset.course;
                const container = document.querySelector(`.slots-container[data-course="${courseIndex}"]`);
                const slotCount = container.children.length;

                const slotHtml = `
                <div class="slot-item border rounded p-3 bg-white">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Position Title</label>
                            <input type="text" name="courses[${courseIndex}][slots][${slotCount}][title]" placeholder="e.g., Software Developer"
                                class="w-full border border-gray-300 rounded px-2 py-1 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Total Slots</label>
                            <input type="number" name="courses[${courseIndex}][slots][${slotCount}][total_slots]" min="1" placeholder="10"
                                class="w-full border border-gray-300 rounded px-2 py-1 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Requirements</label>
                            <input type="text" name="courses[${courseIndex}][slots][${slotCount}][requirements]" placeholder="Basic requirements"
                                class="w-full border border-gray-300 rounded px-2 py-1 text-sm">
                        </div>
                    </div>
                    <button type="button" class="remove-slot mt-2 text-xs text-red-600 hover:text-red-800">
                        <i class="bi bi-trash mr-1"></i>Remove Slot
                    </button>
                </div>
            `;
                container.insertAdjacentHTML('beforeend', slotHtml);
            }

            // Remove document functionality
            if (e.target.closest('.remove-document')) {
                e.target.closest('.document-item').remove();
            }

            // Remove slot functionality
            if (e.target.closest('.remove-slot')) {
                e.target.closest('.slot-item').remove();
            }
        });
    </script>
@endpush

@section('scripts')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

    <style>
        .fc-event {
            cursor: pointer;
            border: none !important;
        }

        .fc-timegrid-slot {
            height: 40px !important;
            /* Taller slots */
        }

        .fc-timegrid-slot:hover {
            background-color: #f9fafb;
        }

        .fc-v-event {
            border-radius: 4px;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .fc-event-main {
            padding: 4px;
            font-size: 11px;
            font-weight: 500;
        }

        .fc-col-header-cell-cushion {
            color: #374151;
            font-weight: 600;
            text-decoration: none !important;
        }

        .fc-timegrid-slot-label {
            font-size: 12px;
            color: #6b7280;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            if (calendarEl) {
                @if (isset($industry))
                    var industryId = {{ $industry->id }};
                @else
                    var industryId = null;
                @endif
                var saveBtn = document.getElementById('saveScheduleBtn');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'timeGridWeek',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: ''
                    },
                    slotMinTime: '06:00:00',
                    slotMaxTime: '22:00:00',
                    allDaySlot: false,
                    selectable: true,
                    editable: true,
                    firstDay: 1,
                    height: '100%',

                    events: function(info, successCallback, failureCallback) {
                        if (industryId) {
                            fetch(
                                    `/admin/industries/${industryId}/availability/week?start=${info.startStr}&end=${info.endStr}`)
                                .then(response => response.json())
                                .then(data => successCallback(data))
                                .catch(error => failureCallback(error));
                        } else {
                            successCallback([]);
                        }
                    },

                    select: function(info) {
                        calendar.addEvent({
                            title: 'Available',
                            start: info.startStr,
                            end: info.endStr,
                            allDay: false,
                            color: '#3788d8'
                        });
                        calendar.unselect();
                        updateSummary();
                    },

                    eventClick: function(info) {
                        if (confirm('Remove this time slot?')) {
                            info.event.remove();
                            updateSummary();
                        }
                    },

                    eventDrop: function(info) {
                        updateSummary();
                    },
                    eventResize: function(info) {
                        updateSummary();
                    },
                    eventsSet: function() {
                        updateSummary();
                    }
                });

                calendar.render();

                function updateSummary() {
                    var events = calendar.getEvents();
                    var totalHours = 0;
                    var listHtml = '';

                    events.sort((a, b) => a.start - b.start);

                    events.forEach(event => {
                        var start = event.start;
                        var end = event.end;
                        var diffMs = end - start;
                        var diffHrs = diffMs / (1000 * 60 * 60);
                        totalHours += diffHrs;

                        var dayName = start.toLocaleDateString('en-US', {
                            weekday: 'short'
                        });
                        var timeStr = start.toLocaleTimeString('en-US', {
                                hour: '2-digit',
                                minute: '2-digit'
                            }) +
                            ' - ' +
                            end.toLocaleTimeString('en-US', {
                                hour: '2-digit',
                                minute: '2-digit'
                            });

                        listHtml += `<div class="p-2 bg-gray-50 rounded border border-gray-100 flex justify-between">
                                        <span><strong>${dayName}</strong> ${timeStr}</span>
                                        <span class="text-gray-400">${diffHrs.toFixed(1)}h</span>
                                     </div>`;
                    });

                    document.getElementById('totalHoursDisplay').innerText = totalHours.toFixed(1);
                    document.getElementById('totalHoursInput').value = totalHours.toFixed(2);
                    document.getElementById('eventList').innerHTML = listHtml ||
                        '<span class="text-gray-400 italic">No availability set</span>';
                }

                saveBtn.addEventListener('click', function() {
                    if (!industryId) {
                        alert('Please save the industry first before setting availability.');
                        return;
                    }

                    var viewStart = calendar.view.activeStart;
                    var offset = viewStart.getTimezoneOffset() * 60000;
                    var localDate = new Date(viewStart.getTime() - offset);
                    var weekStartStr = localDate.toISOString().split('T')[0];

                    var events = calendar.getEvents().map(e => {
                        return {
                            start: e.start.toISOString(),
                            end: e.end.toISOString()
                        };
                    });

                    var payload = {
                        week_start: weekStartStr,
                        total_hours: document.getElementById('totalHoursInput').value,
                        events: events,
                        _token: '{{ csrf_token() }}'
                    };

                    var originalText = saveBtn.innerHTML;
                    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
                    saveBtn.disabled = true;

                    fetch(`/admin/industries/${industryId}/availability/week`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(payload)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                toastr.success('Schedule saved successfully');
                            } else {
                                toastr.error('Failed to save schedule');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            toastr.error('An error occurred');
                        })
                        .finally(() => {
                            saveBtn.innerHTML = originalText;
                            saveBtn.disabled = false;
                        });
                });
            }
        });
    </script>
