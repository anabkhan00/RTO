@extends('admin.master_layout.index')
@section('page-title', 'Student Documents')

@section('title', 'Student Documents - ' . $student->name)

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold text-brand mb-6">Documents for {{ $student->name }}</h2>

        <!-- Coordinator Assignment Section -->
        @if (auth()->user()->role === 'admin')
            <div class="mb-8">
                <h3 class="text-lg font-medium text-brand mb-4">Assigned Coordinator</h3>
                <div class="bg-white rounded-lg border p-6 shadow-sm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Placement Coordinator</label>
                            <select id="placementCoordinator"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                                <option value="">Select Placement Coordinator</option>
                                @foreach ($placementCoordinators as $coordinator)
                                    <option value="{{ $coordinator->id }}"
                                        {{ $student->placement_coordinator_id == $coordinator->id ? 'selected' : '' }}>
                                        {{ $coordinator->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sourcing Coordinator</label>
                            <select id="sourcingCoordinator"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                                <option value="">Select Sourcing Coordinator</option>
                                @foreach ($sourcingCoordinators as $coordinator)
                                    <option value="{{ $coordinator->id }}"
                                        {{ $student->sourcing_coordinator_id == $coordinator->id ? 'selected' : '' }}>
                                        {{ $coordinator->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button onclick="assignCoordinators()"
                            class="bg-brand text-white text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors font-medium">
                            Update Assignments
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Student Update Section -->
        <div class="mb-8">
            <h3 class="text-lg font-medium text-brand mb-4">Student Information</h3>
            <form action="{{ route('admin.students.update', $student->id) }}" method="POST" enctype="multipart/form-data"
                class="bg-white rounded-lg border p-6 shadow-sm">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-12 gap-6">
                    <!-- Student Info -->
                    <div class="col-span-12 lg:col-span-7">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white"
                                    {{ auth()->user()->role === 'coordinator' && auth()->user()->coordinator_type !== 'placement' ? 'disabled' : '' }}>
                                    <option value="active"
                                        {{ old('student_status', $student->student_status ?? 'active') == 'active' ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="inactive"
                                        {{ old('student_status', $student->student_status ?? '') == 'inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                    <option value="blocked"
                                        {{ old('student_status', $student->student_status ?? '') == 'blocked' ? 'selected' : '' }}>
                                        Blocked</option>
                                </select>
                            </div>

                            <!-- Address -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                <input type="text" name="address" value="{{ old('address', $student->address) }}"
                                    required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand" />
                            </div>

                            <!-- Gender -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                                <select name="gender"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender', $student->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <!-- Transport -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Transport</label>
                                <input type="text" name="transport" value="{{ old('transport', $student->transport) }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand" />
                            </div>

                            <!-- Medical Condition -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Medical Condition</label>
                                <textarea name="medical_condition" rows="2"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">{{ old('medical_condition', $student->medical_condition) }}</textarea>
                            </div>

                            <!-- Placement Data -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Placement Data</label>
                                <textarea name="placement_data" rows="2"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">{{ old('placement_data', $student->placement_data) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Image -->
                    <div class="col-span-12 lg:col-span-5">
                        <div class="space-y-6">
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
                    @unless (auth()->user()->role === 'coordinator')
                        <button type="submit"
                            class="bg-brand text-white text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors font-medium">
                            Update
                        </button>
                    @endunless
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

                            <button type="submit"
                                class="bg-brand text-white text-xs px-3 py-1.5 mt-3 rounded-md hover:bg-gold transition-colors font-medium">
                                Save Note
                            </button>
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
            <h3 class="text-lg font-medium text-brand mb-4">Location</h3>
            <div class="location-tab-content block bg-white rounded-lg border shadow-sm p-4">
                <div id="studentMap" class="w-full h-64 rounded-lg border border-gray-300"></div>
                <p class="text-xs text-gray-500 mt-3">Student location marker displayed on map</p>
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
                                                            @if (auth()->user()->role !== 'coordinator')
                                                                <button class="delete-document"
                                                                    data-id="{{ $document->id }}">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            @endif
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
                                @unless (auth()->user()->role === 'coordinator' && auth()->user()->coordinator_type === 'sourcing')
                                    <button type="submit" id="uploadBtn"
                                        class="bg-brand text-white text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors font-medium">
                                        <span id="uploadText"><i class="bi bi-upload mr-2"></i>Upload Documents</span>
                                        <span id="uploadLoader" class="hidden">
                                            <i class="bi bi-arrow-clockwise animate-spin mr-2"></i>Uploading...
                                        </span>
                                    </button>
                                @endunless
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Appointment Calendar Section -->
        {{-- <div class="mb-8">
            <h3 class="text-lg font-medium text-brand mb-4">Appointment Calendar</h3>
            <div class="bg-white rounded-lg border shadow-sm p-4">
                @if (auth()->user()->role === 'admin' || auth()->user()->coordinator_type === 'placement')
                <div class="mb-4">
                    <button onclick="openAppointmentModal()" class="bg-brand text-white px-4 py-2 rounded-md hover:bg-gold transition-colors text-sm">
                        <i class="fas fa-plus mr-2"></i>Add Appointment
                    </button>
                </div>
                @endif

                <div id="calendar"></div>
                <div id="appointmentsList" class="mt-4 space-y-2"></div>
            </div>
        </div> --}}

        <!-- Student Status Display -->
        {{-- <div class="mb-6">
            <div class="bg-white rounded-lg border shadow-sm p-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-brand">Student Status</h3>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $student->student_status === 'active' ? 'bg-green-100 text-green-800' :
                           ($student->student_status === 'blocked' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                        <i class="bi bi-{{ $student->student_status === 'active' ? 'check-circle' : ($student->student_status === 'blocked' ? 'x-circle' : 'pause-circle') }} mr-1"></i>
                        {{ ucfirst($student->student_status ?? 'active') }}
                    </span>
                </div>
            </div>
        </div> --}}

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Profile Image Dropzone functionality
            const dropzone = document.getElementById('profileDropzone');
            const fileInput = document.getElementById('profileImageInput');
            const dropzoneContent = document.getElementById('dropzoneContent');
            const imagePreview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            const removeBtn = document.getElementById('removeImage');

            if (dropzone && fileInput) {
                dropzone.addEventListener('click', () => fileInput.click());

                dropzone.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    dropzone.classList.add('border-brand', 'bg-blue-50');
                });

                dropzone.addEventListener('dragleave', () => {
                    dropzone.classList.remove('border-brand', 'bg-blue-50');
                });

                dropzone.addEventListener('drop', (e) => {
                    e.preventDefault();
                    dropzone.classList.remove('border-brand', 'bg-blue-50');
                    const files = e.dataTransfer.files;
                    if (files.length > 0) {
                        handleFile(files[0]);
                    }
                });

                fileInput.addEventListener('change', (e) => {
                    if (e.target.files.length > 0) {
                        handleFile(e.target.files[0]);
                    }
                });

                function handleFile(file) {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            previewImg.src = e.target.result;
                            dropzoneContent.classList.add('hidden');
                            imagePreview.classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    }
                }

                if (removeBtn) {
                    removeBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        fileInput.value = '';
                        dropzoneContent.classList.remove('hidden');
                        imagePreview.classList.add('hidden');
                    });
                }
            }

            // Notes form functionality
            const notesForm = document.getElementById('notesForm');
            if (notesForm) {
                notesForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const textarea = document.querySelector('textarea[name="content"]');
                    if (!textarea) {
                        toastr.error('Form element not found');
                        return;
                    }

                    const noteContent = textarea.value.trim();
                    if (!noteContent) {
                        toastr.error('Please enter a note');
                        return;
                    }

                    $.ajax({
                        url: `/admin/students/{{ $student->id }}/notes`,
                        method: 'POST',
                        data: {
                            content: noteContent,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                const roleColors = {
                                    'admin': 'bg-red-50 border-red-200 text-red-800',
                                    'rto': 'bg-blue-50 border-blue-200 text-blue-800',
                                    'coordinator': 'bg-green-50 border-green-200 text-green-800'
                                };
                                const roleColor = roleColors[response.note.author_role] ||
                                    'bg-gray-50 border-gray-200 text-gray-800';

                                const noteHtml = `
                                    <div class="p-3 rounded-lg border ${roleColor}">
                                        <div class="flex justify-between items-start mb-2">
                                            <span class="text-xs font-medium uppercase tracking-wide">${response.note.author_role}</span>
                                            <span class="text-xs opacity-75">${response.note.created_at}</span>
                                        </div>
                                        <p class="text-sm mb-1">${response.note.content}</p>
                                        <p class="text-xs opacity-75">by ${response.note.author_name}</p>
                                    </div>
                                `;

                                const notesDisplay = document.getElementById('allNotesDisplay');
                                const emptyState = notesDisplay.querySelector('.text-center');
                                if (emptyState) {
                                    emptyState.remove();
                                }
                                notesDisplay.insertAdjacentHTML('afterbegin', noteHtml);

                                textarea.value = '';
                                toastr.success('Note added successfully');
                            }
                        },
                        error: function(xhr) {
                            toastr.error('Failed to save note');
                        }
                    });
                });
            }

            // Map initialization
            const leafletCSSLink = document.createElement('link');
            leafletCSSLink.rel = 'stylesheet';
            leafletCSSLink.href = 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css';
            document.head.appendChild(leafletCSSLink);

            const leafletScript = document.createElement('script');
            leafletScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js';
            leafletScript.onload = function() {
                const studentLat = {{ $student->latitude ?? 34.0522 }};
                const studentLng = {{ $student->longitude ?? -118.2437 }};
                const studentName = '{{ $student->name }}';

                const map = L.map('studentMap').setView([studentLat, studentLng], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors',
                    maxZoom: 19
                }).addTo(map);

                const marker = L.marker([studentLat, studentLng]).addTo(map);
                marker.bindPopup(`<strong>${studentName}</strong><br>Student Location`);
                marker.openPopup();
            };
            document.head.appendChild(leafletScript);

            // Document upload functionality
            $('form[enctype="multipart/form-data"]').on('submit', function(e) {
                e.preventDefault();

                const uploadBtn = $('#uploadBtn');
                const uploadText = $('#uploadText');
                const uploadLoader = $('#uploadLoader');

                uploadBtn.prop('disabled', true);
                uploadText.addClass('hidden');
                uploadLoader.removeClass('hidden');

                const formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        if (response.success && response.document_ids) {
                            $('#uploadedDocuments').val(response.document_ids.join(','));
                            $('#checklistModal').removeClass('hidden');
                        } else {
                            location.reload();
                        }
                        uploadBtn.prop('disabled', false);
                        uploadText.removeClass('hidden');
                        uploadLoader.addClass('hidden');
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Error uploading documents!');
                        uploadBtn.prop('disabled', false);
                        uploadText.removeClass('hidden');
                        uploadLoader.addClass('hidden');
                    }
                });
            });

            // Checklist form submission
            $('#checklistForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '/admin/student-documents/assign-types/{{ $student->id }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#checklistModal').addClass('hidden');
                        location.reload();
                    },
                    error: function() {
                        toastr.error('Error assigning document types!');
                    }
                });
            });

            // Skip and close modal
            $('#skipChecklist, #closeChecklistModal').on('click', function() {
                $('#checklistModal').addClass('hidden');
                location.reload();
            });

            // Delete document
            $(document).on('click', '.delete-document', function() {
                const documentId = $(this).data('id');
                const documentCard = $(this).closest('.bg-gray-50');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/rto/student-documents/${documentId}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    documentCard.remove();
                                    toastr.success('Document deleted successfully!');
                                    location.reload();
                                }
                            },
                            error: function() {
                                toastr.error('Error deleting document!');
                            }
                        });
                    }
                });
            });
        });

        // Appointment Functions
        function openAppointmentModal(appointment = null) {
            if (appointment) {
                $('#appointmentModalTitle').text('Edit Appointment');
                $('#appointmentId').val(appointment.id);
                $('#appointmentTitle').val(appointment.title);
                $('#appointmentDate').val(appointment.date);
                $('#appointmentTime').val(appointment.time);
                $('#appointmentNotes').val(appointment.notes || '');
            } else {
                $('#appointmentModalTitle').text('Add Appointment');
                $('#appointmentForm')[0].reset();
                $('#appointmentId').val('');
            }
            $('#appointmentModal').removeClass('hidden');
        }

        function closeAppointmentModal() {
            $('#appointmentModal').addClass('hidden');
        }

        $('#appointmentForm').on('submit', function(e) {
            e.preventDefault();

            const id = $('#appointmentId').val();
            const data = {
                student_id: {{ $student->id }},
                title: $('#appointmentTitle').val(),
                date: $('#appointmentDate').val(),
                time: $('#appointmentTime').val(),
                notes: $('#appointmentNotes').val(),
                _token: '{{ csrf_token() }}'
            };

            const url = id ? `/admin/appointments/${id}` : '{{ route('admin.appointments.store') }}';
            const method = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                data: data,
                success: function() {
                    toastr.success('Appointment saved');
                    closeAppointmentModal();
                    loadAppointments();
                }
            });
        });

        function loadAppointments() {
            $.ajax({
                url: '{{ route('admin.appointments.by-student', $student->id) }}',
                success: function(appointments) {
                    let html = '';
                    const canEdit =
                        {{ auth()->user()->role === 'admin' || auth()->user()->coordinator_type === 'placement' ? 'true' : 'false' }};

                    appointments.forEach(apt => {
                        html += `<div class="flex justify-between items-center p-3 border rounded">
                            <div>
                                <div class="text-sm font-medium">${apt.title}</div>
                                <div class="text-xs text-gray-500">${apt.date} at ${apt.time}</div>
                                ${apt.notes ? `<div class="text-xs text-gray-600 mt-1">${apt.notes}</div>` : ''}
                                <div class="text-xs text-gray-400 mt-1">By: ${apt.creator.name}</div>
                            </div>
                            ${canEdit ? `<div class="flex gap-2">
                                        <button onclick='openAppointmentModal(${JSON.stringify(apt)})'
                                                class="text-blue-600 hover:text-blue-800 text-xs">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="deleteAppointment(${apt.id})"
                                                class="text-red-600 hover:text-red-800 text-xs">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>` : ''}
                        </div>`;
                    });
                    $('#appointmentsList').html(html ||
                        '<p class="text-gray-500 text-sm">No appointments scheduled</p>');
                }
            });
        }

        function deleteAppointment(id) {
            if (!confirm('Delete this appointment?')) return;

            $.ajax({
                url: `/admin/appointments/${id}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function() {
                    toastr.success('Appointment deleted');
                    loadAppointments();
                }
            });
        }

        // Availability Functions
        function openAvailabilityModal() {
            const availability = @json($student->student_availability ?? []);

            // Reset form
            document.querySelectorAll('.availability-checkbox').forEach(checkbox => {
                const day = checkbox.dataset.day;
                const isEnabled = availability[day] && availability[day].enabled;
                checkbox.checked = isEnabled;

                const timesDiv = document.getElementById(`times-${day}`);
                timesDiv.style.display = isEnabled ? 'block' : 'none';

                if (isEnabled && availability[day]) {
                    const startInput = timesDiv.querySelector('input[type="time"]:first-child');
                    const endInput = timesDiv.querySelector('input[type="time"]:last-child');
                    startInput.value = availability[day].start || '09:00';
                    endInput.value = availability[day].end || '17:00';
                }
            });

            document.getElementById('availabilityModal').classList.remove('hidden');
        }

        function closeAvailabilityModal() {
            document.getElementById('availabilityModal').classList.add('hidden');
        }

        // Handle checkbox changes
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('availability-checkbox')) {
                const day = e.target.dataset.day;
                const timesDiv = document.getElementById(`times-${day}`);
                if (timesDiv) {
                    timesDiv.classList.toggle('hidden', !e.target.checked);
                }
            }
        });

        document.getElementById('availabilityForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const availability = {};

            document.querySelectorAll('.availability-checkbox').forEach(checkbox => {
                const day = checkbox.dataset.day;
                if (checkbox.checked) {
                    const timesDiv = document.getElementById(`times-${day}`);
                    const startInput = timesDiv.querySelector('input[type="time"]:first-child');
                    const endInput = timesDiv.querySelector('input[type="time"]:last-child');

                    availability[day] = {
                        enabled: true,
                        start: startInput.value,
                        end: endInput.value
                    };
                }
            });

            fetch(`/admin/students/{{ $student->id }}/availability`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        student_availability: availability
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        toastr.success('Availability updated successfully');
                        closeAvailabilityModal();
                        loadCalendlyCalendar();
                    } else {
                        toastr.error('Failed to update availability');
                    }
                })
                .catch(err => {
                    console.error(err);
                    toastr.error('Failed to update availability');
                });
        });

        function loadCalendlyCalendar() {
            const availability = @json($student->student_availability ?? []);
            const calendarDiv = document.getElementById('calendlyCalendar');

            if (!calendarDiv) return;

            const days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
            const dayLabels = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

            if (Object.keys(availability).length === 0) {
                calendarDiv.innerHTML = `
                    <div class="text-center py-12">
                        <i class="bi bi-calendar-x text-4xl text-gray-300 mb-4"></i>
                        <h4 class="text-lg font-medium text-gray-900 mb-2">No availability set</h4>
                        <p class="text-gray-500 mb-4">Set your weekly schedule to show available time slots</p>
                        <button onclick="openAvailabilityModal()" class="bg-brand text-white px-4 py-2 rounded-lg hover:bg-gold transition-colors text-sm font-medium">
                            <i class="bi bi-calendar-plus mr-2"></i>Set Availability
                        </button>
                    </div>
                `;
                return;
            }

            let html = '';

            days.forEach((day, index) => {
                const dayAvail = availability[day];
                const isAvailable = dayAvail && dayAvail.enabled;

                html += `
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:border-brand transition-colors">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full mr-3 ${isAvailable ? 'bg-green-500' : 'bg-gray-300'}"></div>
                            <div>
                                <h4 class="font-medium text-gray-900">${dayLabels[index]}</h4>
                                ${isAvailable ? `
                                            <p class="text-sm text-gray-600">${formatTime(dayAvail.start)} - ${formatTime(dayAvail.end)}</p>
                                        ` : '<p class="text-sm text-gray-500">Unavailable</p>'}
                            </div>
                        </div>
                        <div class="flex items-center">
                            ${isAvailable ? `
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="bi bi-check-circle mr-1"></i>Available
                                        </span>
                                    ` : `
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <i class="bi bi-x-circle mr-1"></i>Unavailable
                                        </span>
                                    `}
                        </div>
                    </div>
                `;
            });

            calendarDiv.innerHTML = html;
        }

        function formatTime(time) {
            const [hours, minutes] = time.split(':');
            const hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const displayHour = hour % 12 || 12;
            return `${displayHour}:${minutes} ${ampm}`;
        }

        // Coordinator Assignment Function
        function assignCoordinators() {
            const placementCoordinatorId = document.getElementById('placementCoordinator').value;
            const sourcingCoordinatorId = document.getElementById('sourcingCoordinator').value;

            fetch('{{ route('admin.student-documents.assign-coordinator', $student->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        placement_coordinator_id: placementCoordinatorId,
                        sourcing_coordinator_id: sourcingCoordinatorId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success('Coordinators assigned successfully');
                    } else {
                        toastr.error('Failed to assign coordinators');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('An error occurred');
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadAppointments();
            loadCalendlyCalendar();

            if (window.location.hash === '#document-section') {
                const element = document.getElementById('document-section');
                if (element) {
                    // Smooth scroll + thoda top se offset (navbar ke liye)
                    element.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });

                    // Optional: thoda highlight effect (jaise flash)
                    // element.style.transition = 'background-color 0.6s';
                    // element.style.backgroundColor = '#f0fdf4'; // light green
                    setTimeout(() => {
                        element.style.backgroundColor = '';
                    }, 2000);
                }
            }
        });
    </script>

    <style>
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }
    </style>
    <!-- FullCalendar CSS/JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

    <style>
        .fc-event {
            cursor: pointer;
            border: none !important;
        }

        .fc-timegrid-event {
            background-color: #d4af37 !important;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .fc-timegrid-event:hover {
            background-color: #c19b2e !important;
        }

        .fc-header-toolbar {
            margin-bottom: 1.5rem !important;
        }

        .fc-button-primary {
            background-color: #ffffff !important;
            border-color: #e5e7eb !important;
            color: #374151 !important;
        }

        .fc-button-primary:hover {
            background-color: #f3f4f6 !important;
            border-color: #d1d5db !important;
        }

        .fc-button-active {
            background-color: #f3f4f6 !important;
            border-color: #d1d5db !important;
            color: #111827 !important;
        }

        .fc-day-today {
            background-color: transparent !important;
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

            // Only initialize if calendar element exists (e.g. if student is active)
            if (calendarEl) {
                var studentId = {{ $student->id }};
                var saveBtn = document.getElementById('saveBtn');

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
                    firstDay: 1, // Monday
                    height: '100%',

                    // Fetch events
                    events: function(info, successCallback, failureCallback) {
                        fetch(
                                `{{ route('admin.weekly-schedules.availability', $student->id) }}?start=${info.startStr}&end=${info.endStr}`
                                )
                            .then(response => response.json())
                            .then(data => successCallback(data))
                            .catch(error => failureCallback(error));
                    },

                    // Interaction Handlers
                    select: function(info) {
                        calendar.addEvent({
                            title: 'Available',
                            start: info.startStr,
                            end: info.endStr,
                            allDay: false
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
                        }

                        // On initial load, calculate summary
                        ,
                    eventsSet: function() {
                        updateSummary();
                    }
                });

                calendar.render();

                // Summary Calculation
                function updateSummary() {
                    var events = calendar.getEvents();
                    var totalHours = 0;
                    var listHtml = '';

                    // Sort events by start time
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

                // Save Functionality
                saveBtn.addEventListener('click', function() {
                    var viewStart = calendar.view.activeStart;
                    // Format as YYYY-MM-DD in local time to avoid timezone shifts
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

                    fetch('{{ route('admin.weekly-schedules.save', $student->id) }}', {
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
@endsection
