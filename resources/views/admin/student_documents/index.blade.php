@extends('admin.master_layout.index')
@section('page-title', 'Student Documents')

@section('title', 'Student Documents - ' . $student->name)

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold text-brand mb-6">Documents for {{ $student->name }}</h2>

        <!-- Student Update Section -->
        <div class="mb-8">
            <h3 class="text-lg font-medium text-brand mb-4">Student Information</h3>
            <form action="{{ route('admin.students.update', $student->id) }}" method="POST" enctype="multipart/form-data"
                class="bg-white rounded-lg border p-6 shadow-sm">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-12 gap-6">

                    <!-- Student Info -->
                    <div class="col-span-12 lg:col-span-8">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                <input type="text" name="name" value="{{ old('name', $student->name) }}" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand" />
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="email" value="{{ old('email', $student->email) }}" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand" />
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                <input type="text" name="phone" value="{{ old('phone', $student->phone) }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand" />
                            </div>

                            <!-- Emergency Contact -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Emergency Contact No
                                </label>
                                <input type="text" name="emergency_contact"
                                    value="{{ old('emergency_contact', $student->studentDetail->emergency_contact ?? '') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
               focus:ring-2 focus:ring-brand focus:border-brand" />
                            </div>

                            <!-- Placement Hours -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Placement Hours
                                </label>
                                <input type="number" name="placement_hours"
                                    value="{{ old('placement_hours', $student->studentDetail->placement_hours ?? '') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
               focus:ring-2 focus:ring-brand focus:border-brand" />
                            </div>


                            <!-- RTO -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="bi bi-building mr-1"></i> RTO
                                </label>
                                <select name="rto_id" id="studentRto"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                                    <option value="">Select RTO</option>
                                    @foreach ($rtos as $rto)
                                        <option value="{{ $rto->id }}"
                                            {{ old('rto_id', $studentRtoId) == $rto->id ? 'selected' : '' }}>
                                            {{ $rto->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <!-- Priority -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2"><i class="bi bi-flag mr-1"></i>
                                    Priority</label>
                                <select name="priority"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                                    <option value="">Select Priority</option>
                                    <option value="high_priority"
                                        {{ old('priority', $student->studentDetail->priority ?? '') == 'high_priority' ? 'selected' : '' }}>
                                        High Priority</option>
                                    <option value="medium_priority"
                                        {{ old('priority', $student->studentDetail->priority ?? '') == 'medium_priority' ? 'selected' : '' }}>
                                        Medium Priority</option>
                                    <option value="low_priority"
                                        {{ old('priority', $student->studentDetail->priority ?? '') == 'low_priority' ? 'selected' : '' }}>
                                        Low Priority</option>
                                </select>
                            </div>

                            <!-- Course -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                                <select name="course_id"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                                    <option value="">Select Course</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}"
                                            {{ old('course_id', $student->course_id) == $course->id ? 'selected' : '' }}>
                                            {{ $course->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Industry -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2"><i class="bi bi-book mr-1"></i>
                                    Industry</label>
                                <select name="industry_id"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                                    <option value="">Select Industry</option>
                                    @foreach ($industries as $industry)
                                        <option value="{{ $industry->id }}"
                                            {{ old('industry_id', $student->studentDetail->industry_id ?? '') == $industry->id ? 'selected' : '' }}>
                                            {{ $industry->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Progress Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2"><i
                                        class="bi bi-clipboard-check mr-1"></i> Progress Status</label>
                                <select name="progress_status"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                                    <option value="awaiting_placements"
                                        {{ old('progress_status', $student->studentDetail->progress_status ?? '') == 'awaiting_placements' ? 'selected' : '' }}>
                                        Awaiting Placements</option>
                                    <option value="booked_placements"
                                        {{ old('progress_status', $student->studentDetail->progress_status ?? '') == 'booked_placements' ? 'selected' : '' }}>
                                        Booked Placements</option>
                                    <option value="active_placements"
                                        {{ old('progress_status', $student->studentDetail->progress_status ?? '') == 'active_placements' ? 'selected' : '' }}>
                                        Active Placements</option>
                                    <option value="completed_placements"
                                        {{ old('progress_status', $student->studentDetail->progress_status ?? '') == 'completed_placements' ? 'selected' : '' }}>
                                        Completed Placements</option>
                                    <option value="flagged_placements"
                                        {{ old('progress_status', $student->studentDetail->progress_status ?? '') == 'flagged_placements' ? 'selected' : '' }}>
                                        Flagged Placements</option>
                                </select>
                            </div>

                            <!-- Student Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2"><i
                                        class="bi bi-person-check mr-1"></i> Student Status</label>
                                <select name="student_status"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                                    <option value="active"
                                        {{ old('student_status', $student->studentDetail->student_status ?? 'active') == 'active' ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="inactive"
                                        {{ old('student_status', $student->studentDetail->student_status ?? '') == 'inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                    <option value="blocked"
                                        {{ old('student_status', $student->studentDetail->student_status ?? '') == 'blocked' ? 'selected' : '' }}>
                                        Blocked</option>
                                </select>
                            </div>

                            <!-- Address -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                <input type="text" name="address" id="addressInput"
                                    value="{{ old('address', $student->address) }}" required
                                    placeholder="Start typing address..."
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand" />
                                <input type="hidden" name="latitude" id="latitudeInput"
                                    value="{{ old('latitude', $student->latitude) }}">
                                <input type="hidden" name="longitude" id="longitudeInput"
                                    value="{{ old('longitude', $student->longitude) }}">
                            </div>

                            <!-- Gender -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                                <select name="gender"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                                    <option value="">Select Gender</option>
                                    <option value="male"
                                        {{ old('gender', $student->studentDetail->gender ?? '') == 'male' ? 'selected' : '' }}>
                                        Male</option>
                                    <option value="female"
                                        {{ old('gender', $student->studentDetail->gender ?? '') == 'female' ? 'selected' : '' }}>
                                        Female</option>
                                    <option value="other"
                                        {{ old('gender', $student->studentDetail->gender ?? '') == 'other' ? 'selected' : '' }}>
                                        Other</option>
                                </select>
                            </div>

                            <!-- Transport -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Transport</label>
                                <input type="text" name="transport"
                                    value="{{ old('transport', $student->studentDetail->transport ?? '') }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand" />
                            </div>

                            <!-- Medical Condition -->
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Medical Condition</label>
                                <textarea name="medical_condition" rows="2"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">{{ old('medical_condition', $student->studentDetail->medical_condition ?? '') }}</textarea>
                            </div>

                            <!-- Placement Data -->
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Placement Data</label>
                                <textarea name="placement_data" rows="2"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">{{ old('placement_data', $student->studentDetail->placement_data ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <!-- Profile Image -->
                    <div class="col-span-12 lg:col-span-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Profile Image</h4>
                            <div id="profileDropzone"
                                class="border-2 border-dashed border-gray-300 rounded-lg p-12 text-center hover:border-brand transition-colors cursor-pointer bg-gray-50 hover:bg-blue-50">
                                <div id="dropzoneContent">
                                    <i class="bi bi-cloud-upload text-5xl text-gray-300 mb-3"></i>
                                    <p class="text-sm text-gray-600 font-medium">Drop image here or click to upload</p>
                                    <p class="text-xs text-gray-500 mt-2">PNG, JPG, GIF up to 5MB</p>
                                </div>
                                <div id="imagePreview" class="{{ $student->profile_image ? '' : 'hidden' }}">
                                    <img id="previewImg" src="{{ $student->profile_image_url ?? '' }}"
                                        class="max-w-full h-48 mx-auto rounded-lg object-cover shadow-sm" />
                                    <button type="button" id="removeImage"
                                        class="mt-3 px-3 py-1 text-xs bg-red-50 text-red-600 hover:bg-red-100 rounded-md transition-colors">
                                        <i class="bi bi-trash mr-1"></i>Remove Image
                                    </button>
                                </div>
                            </div>
                            <input type="file" id="profileImageInput" name="profile_image" accept="image/*"
                                class="hidden" />
                            <p class="text-xs text-gray-400 mt-2">Use high-quality portrait images for best results</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between mt-4 items-center"> @php
                    $status = 'Interview';
                    $statusColors = [
                        'Assigned' => ['bg' => 'bg-gray-50', 'text' => 'text-gray-700', 'border' => 'border-gray-100'],
                        'Interview' => [
                            'bg' => 'bg-orange-50',
                            'text' => 'text-orange-700',
                            'border' => 'border-orange-100',
                        ],
                        'Placed' => [
                            'bg' => 'bg-emerald-50',
                            'text' => 'text-emerald-700',
                            'border' => 'border-emerald-100',
                        ],
                        'Completed' => [
                            'bg' => 'bg-indigo-50',
                            'text' => 'text-indigo-700',
                            'border' => 'border-indigo-100',
                        ],
                    ];
                    $colors = $statusColors[$status] ?? $statusColors['Assigned'];
                @endphp <span
                        class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-full {{ $colors['bg'] }} {{ $colors['text'] }} {{ $colors['border'] }} border shadow">
                        {{ $status }} </span>
                    @can('students.edit')
                        <button type="submit"
                            class="bg-brand text-white text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors font-medium">
                            Update
                        </button>
                    @endcan
                </div>
            </form>

        </div>

        <div class="mb-8">
            <h3 class="text-lg font-medium text-brand mb-4">Notes</h3>
            <div class="location-tab-content block bg-white rounded-lg border shadow-sm p-4">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">
                    <!-- All Notes Display -->
                    <div class="lg:col-span-2">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">All Notes</h4>
                        <div class="bg-gray-50 rounded-lg border border-gray-200 p-4 min-h-32 max-h-64 overflow-y-auto space-y-3"
                            id="allNotesDisplay">
                            @if (count($notes) > 0)
                                @foreach ($notes as $note)
                                    @php
                                        $roleColors = [
                                            'admin' => 'bg-red-50 border-red-200 text-red-800',
                                            'rto' => 'bg-blue-50 border-blue-200 text-blue-800',
                                            'coordinator' => 'bg-green-50 border-green-200 text-green-800',
                                        ];
                                        $roleColor =
                                            $roleColors[$note->author_role] ??
                                            'bg-gray-50 border-gray-200 text-gray-800';
                                    @endphp
                                    <div class="p-3 rounded-lg border {{ $roleColor }}">
                                        <div class="flex justify-between items-start mb-2">
                                            <span
                                                class="text-xs font-medium uppercase tracking-wide">{{ $note->author_role }}</span>
                                            <span
                                                class="text-xs opacity-75">{{ $note->created_at->format('M j, Y') }}</span>
                                        </div>
                                        <p class="text-sm mb-1">{{ $note->content }}</p>
                                        <p class="text-xs opacity-75">by {{ $note->author->name }}</p>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-8">
                                    <i class="bi bi-sticky text-2xl text-gray-300 mb-2"></i>
                                    <p class="text-gray-400 italic text-sm">No notes added yet</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Add Notes Form -->
                    <div class="flex flex-col h-full">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Add Note</h4>

                        <form id="notesForm" class="flex-grow">
                            @csrf
                            <textarea name="content" placeholder="Add a note about this student..."
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand"
                                rows="4" required></textarea>
                            @can('students.edit')
                                <button type="submit"
                                    class="bg-brand text-white text-xs px-3 py-1.5 mt-3 rounded-md hover:bg-gold transition-colors font-medium">
                                    Save Note
                                </button>
                            @endcan
                        </form>

                        <!-- Role Legend -->
                        <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                            <h5 class="text-xs font-medium text-gray-700 mb-2">Note Colors:</h5>
                            <div class="space-y-1 text-xs">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 bg-red-100 border border-red-200 rounded"></div>
                                    <span>Admin</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 bg-blue-100 border border-blue-200 rounded"></div>
                                    <span>RTO</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 bg-green-100 border border-green-200 rounded"></div>
                                    <span>Coordinator</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Map & Notes Section -->
        <div class="mb-8">
            <h3 class="text-lg font-medium text-brand mb-4">Industries Within 20km Radius</h3>
            <div class="location-tab-content block bg-white rounded-lg border shadow-sm p-4">
                <div id="industryMap" class="w-full h-[420px] rounded-xl shadow-lg border border-gray-200"></div>
                {{-- <div class="mt-3 flex items-center justify-between">
                    <p class="text-xs text-gray-500">Industries available within 20 km radius of student location</p>
                    <div class="flex items-center text-xs text-gray-600">
                        <div class="w-3 h-3 bg-blue-200 border border-blue-400 rounded-full mr-2"></div>
                        <span>20km Coverage Area</span>
                    </div>
                </div> --}}
            </div>
        </div>

        <!-- Document Management Section (Checklist & Upload) -->
        <div id="document-section" class="mb-8">
            <h3 class="text-lg font-medium text-brand mb-4">Document Management</h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Checklist Status Card -->
                <div class="bg-white rounded-lg border shadow-sm">
                    <div class="p-4 border-b">
                        <h3 class="text-lg font-medium text-brand flex items-center">
                            <i class="bi bi-list-check mr-2"></i>Document Checklist
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">
                            {{ $checklists ? $checklists->count() : 0 }} required documents
                        </p>

                    </div>
                    @if ($checklists)
                        <div class="p-4 max-h-96 overflow-y-auto">
                            <div class="space-y-2">
                                @foreach ($checklists as $checklist)
                                    @php
                                        $documents = $student->studentDocuments->filter(function ($doc) use (
                                            $checklist,
                                        ) {
                                            return $doc->checklist_ids && in_array($checklist->id, $doc->checklist_ids);
                                        });
                                        $hasDocument = $documents->count() > 0;
                                    @endphp

                                    <div class="rounded hover:bg-gray-50">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                @if ($hasDocument)
                                                    <i class="bi bi-check-circle-fill text-green-500 text-sm"></i>
                                                @else
                                                    <i class="bi bi-circle text-gray-400 text-sm"></i>
                                                @endif

                                                <span
                                                    class="text-sm {{ $hasDocument ? 'text-green-700 font-medium' : 'text-gray-700' }}">
                                                    {{ $checklist->name }}
                                                </span>
                                            </div>

                                            @if ($hasDocument)
                                                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">
                                                    {{ $documents->count() }}
                                                </span>
                                            @endif
                                        </div>

                                        @if ($hasDocument)
                                            <div class="mt-2 ml-6 space-y-1">
                                                @foreach ($documents as $document)
                                                    <div
                                                        class="flex items-center justify-between text-xs bg-gray-50 p-2 rounded">
                                                        <span class="text-gray-600 truncate">{{ $document->label }}</span>
                                                        <div class="flex gap-2">
                                                            <a href="{{ asset('storage/' . $document->file_path) }}"
                                                                target="_blank">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                            <a href="{{ asset('storage/' . $document->file_path) }}"
                                                                download>
                                                                <i class="bi bi-download"></i>
                                                            </a>
                                                            @can('documents.delete')
                                                                <button class="delete-document"
                                                                    data-id="{{ $document->id }}">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-gray-500 p-4">No document checklist assigned to this course.</p>
                    @endif

                </div>

                <!-- Upload Documents Card -->
                <div class="bg-white rounded-lg border shadow-sm">
                    <div class="p-4 border-b">
                        <h3 class="text-lg font-medium text-brand flex items-center">
                            <i class="bi bi-cloud-upload mr-2"></i>Upload Documents
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Upload multiple files (Max 50MB each)</p>
                    </div>
                    <div class="p-4">
                        @can('documents.upload')
                            <form action="{{ route('admin.student-documents.store', $student->id) }}" method="POST"
                                enctype="multipart/form-data" class="space-y-4">
                                @csrf

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Document Label</label>
                                    <input type="text" name="label" placeholder="Enter document label" required
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand" />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Files</label>
                                    <input type="file" name="files[]" multiple
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip" required
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand" />
                                    <p class="text-xs text-gray-500 mt-1">Supported: PDF, DOC, DOCX, JPG, PNG, ZIP</p>
                                </div>

                                <div class="pt-2 flex">
                                    <button type="submit" id="uploadBtn"
                                        class="bg-brand text-white text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors font-medium">
                                        <span id="uploadText"><i class="bi bi-upload mr-2"></i>Upload Documents</span>
                                        <span id="uploadLoader" class="hidden">
                                            <i class="bi bi-arrow-clockwise animate-spin mr-2"></i>Uploading...
                                        </span>
                                    </button>
                                </div>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Availability Section (FullCalendar) -->
        <div class="mb-8">
            <h3 class="text-lg font-medium text-brand mb-4">Student Availability</h3>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Calendar Area -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-lg border shadow-sm p-4 h-[600px]">
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
                            <button id="saveBtn"
                                class="w-full px-4 py-2 rounded-lg text-white font-medium flex justify-center items-center gap-2"
                                style="background-color: #d4af37;" onmouseover="this.style.backgroundColor='#c19b2e'"
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

    <!-- Appointment Modal -->
    <div id="appointmentModal" class="fixed inset-0 bg-black/50 flex justify-center items-center hidden z-50">
        <div class="bg-white w-full max-w-md rounded-xl shadow-2xl p-6 relative">
            <button onclick="closeAppointmentModal()"
                class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">
                &times;
            </button>
            <h3 class="text-xl font-semibold text-brand mb-4" id="appointmentModalTitle">Add Appointment</h3>
            <form id="appointmentForm">
                <input type="hidden" id="appointmentId">
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                    <input type="text" id="appointmentTitle" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                    <input type="date" id="appointmentDate" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Time</label>
                    <input type="time" id="appointmentTime" required
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-brand focus:border-brand">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea id="appointmentNotes" rows="3"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-1 focus:ring-brand focus:border-brand"></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit"
                        class="bg-brand text-white px-4 py-2 rounded-md hover:bg-gold transition-colors text-sm">
                        Save
                    </button>
                    <button type="button" onclick="closeAppointmentModal()"
                        class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>



    <!-- Checklist Modal -->
    <div id="checklistModal" class="fixed inset-0 bg-black/50 flex justify-center items-center hidden z-50">
        <div class="bg-white w-full max-w-lg rounded-xl shadow-2xl p-6 relative">
            <button id="closeChecklistModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">
                &times;
            </button>

            <h3 class="text-xl font-semibold text-brand mb-4">Select Document Types</h3>

            <form id="checklistForm" method="POST">
                @csrf
                <input type="hidden" id="uploadedDocuments" name="document_ids" value="">

                <div class="space-y-3 mb-6">
                    @if ($checklists)
                        @foreach ($checklists as $checklist)
                            <label class="flex items-center">
                                <input type="checkbox" name="checklist_ids[]" value="{{ $checklist->id }}"
                                    class="mr-3">
                                <span class="text-sm">{{ $checklist->name }}</span>
                            </label>
                        @endforeach
                    @else
                        <p class="text-sm text-gray-500">No checklists available.</p>
                    @endif

                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" id="skipChecklist"
                        class="bg-gray-500 text-white text-xs px-3 py-1.5 rounded-md hover:bg-gray-600 font-medium">
                        Skip
                    </button>
                    <button type="submit"
                        class="bg-brand text-white text-xs px-3 py-1.5 rounded-md hover:bg-gold font-medium">
                        Save Types
                    </button>
                </div>
            </form>
        </div>
    </div>

@push('styles')
<link rel="stylesheet" href="{{ asset('public/assets/css/student-documents.css') }}">
@endpush

@push('vendor-scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
@include('includes.google-maps')
@endpush

@push('scripts')
@php
    $studentMap = [
        'name' => $student->name,
        'lat'  => $student->latitude,
        'lng'  => $student->longitude,
    ];

    $industryMap = $nearbyIndustries->map(function ($i) {
        return [
            'id'       => $i->id,
            'name'     => $i->name,
            'type'     => $i->type ?? 'Industry',
            'lat'      => $i->latitude,
            'lng'      => $i->longitude,
            'distance' => round($i->distance, 2),
        ];
    })->values();

    $authUserMap = [
        'role' => auth()->user()->role,
        'coordinator_type' => auth()->user()->coordinator_type ?? null,
    ];
@endphp

<script>
    window.studentId  = @json($student->id);
    window.student    = @json($studentMap);
    window.industries = @json($industryMap);
    window.authUser   = @json($authUserMap);
</script>

<script src="{{ asset('public/assets/js/student-documents.js') }}"></script>
@endpush

@endsection
