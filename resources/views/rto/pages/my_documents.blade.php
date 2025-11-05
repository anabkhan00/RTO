@extends('rto.master_layout.index')
@section('page-title', 'Documents')
<style>
    .bg-blue-100,
    .bg-purple-100,
    .bg-green-100,
    .bg-orange-100,
    .bg-pink-100,
    .bg-indigo-100,
    .bg-teal-100,
    .bg-rose-100 {
        background-color: rgba(0, 0, 0, 0.03) !important;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
</style>
@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Document Management</h1>
                <p class="text-gray-600 mt-1">Manage your documents and student submissions</p>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="p-4 border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <button id="myDocumentsTab"
                    class="tab-button active py-2 px-1 border-b-2 border-brand font-medium text-sm text-brand">
                    My Documents
                </button>
                <button id="studentsDocumentsTab"
                    class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Students Documents
                </button>
                <button id="eSignTab"
                    class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    ESign
                </button>
            </nav>
        </div>

        <!-- My Documents Tab Content -->
        <div id="myDocumentsContent" class="tab-content p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Upload Section -->
                <div class="lg:col-span-1">
                    <div class="bg-gradient-to-br from-brand to-gold p-6 rounded-xl text-white">
                        <h3 class="text-lg font-semibold mb-4"><i class="bi bi-cloud-upload mr-2"></i>Quick Upload</h3>
                        <form method="POST" action="/rto/my-documents" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <div>
                                <input type="text" name="label" placeholder="Document label" required
                                    class="w-full bg-white/20 border border-white/30 text-white placeholder-white/70 text-sm rounded-lg p-3 focus:ring-2 focus:ring-white/50 focus:outline-none" />
                            </div>
                            <div>
                                <input type="file" name="files[]" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip"
                                    required
                                    class="w-full bg-white/20 border border-white/30 text-white text-sm rounded-lg p-3 focus:ring-2 focus:ring-white/50 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-white file:text-brand hover:file:bg-gray-100" />
                            </div>
                            <button type="submit" id="uploadBtn"
                                class="w-full bg-white text-brand font-semibold py-3 rounded-lg hover:bg-gray-100 transition-colors">
                                <span id="uploadText"><i class="bi bi-upload mr-2"></i>Upload</span>
                                <span id="uploadLoader" class="hidden"><i
                                        class="bi bi-arrow-clockwise animate-spin mr-2"></i>Uploading...</span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Documents List -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl border border-gray-200">
                        <div class="p-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-brand"><i class="bi bi-files mr-2"></i>My Documents
                                ({{ $documents->count() }})</h3>
                        </div>
                        <div class="p-4">
                            @if ($documents->count() > 0)
                                <div class="space-y-3 max-h-96 overflow-y-auto">
                                    @foreach ($documents as $document)
                                        <div
                                            class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-10 h-10 bg-brand/10 rounded-lg flex items-center justify-center">
                                                    <i class="bi bi-file-earmark-text text-brand"></i>
                                                </div>
                                                <div>
                                                    <p class="font-medium text-sm text-gray-900">{{ $document->label }}</p>
                                                    <p class="text-xs text-gray-500">
                                                        {{ Str::limit($document->original_name, 30) }} •
                                                        {{ number_format($document->file_size / 1024, 1) }} KB</p>
                                                </div>
                                            </div>
                                            <div class="flex gap-2">
                                                <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank"
                                                    class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-200 transition-colors">
                                                    <i class="bi bi-eye text-xs"></i>
                                                </a>
                                                <button
                                                    class="w-8 h-8 bg-red-100 text-red-600 rounded-lg flex items-center justify-center hover:bg-red-200 transition-colors delete-document"
                                                    data-id="{{ $document->id }}">
                                                    <i class="bi bi-trash text-xs"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <i class="bi bi-file-earmark-plus text-4xl text-gray-300 mb-3"></i>
                                    <p class="text-gray-500">No documents uploaded yet</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="studentsDocumentsContent" class="tab-content hidden">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="p-6">
                    <!-- Filters -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div>
                            <input type="text" id="docSearchFilter" placeholder="Search by name or email..."
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                        </div>
                        <div>
                            <select id="docCourseFilter"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                                <option value="">All Courses</option>
                                <option value="Web Development">Web Development</option>
                                <option value="Graphic Design">Graphic Design</option>
                                <option value="Mobile Apps">Mobile Apps</option>
                                <option value="Data Science">Data Science</option>
                            </select>
                        </div>
                        <div>
                            <select id="docStatusFilter"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                                <option value="">All Status</option>
                                <option value="Complete">Complete</option>
                                <option value="Incomplete">Incomplete</option>
                            </select>
                        </div>
                        <div>
                            <button id="docResetFilters"
                                class="w-full bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors text-sm">
                                Reset Filters
                            </button>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table id="studentsTable" class="min-w-full table-fixed w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b col-student" style="width: 25%;">Student</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b col-contact" style="width: 25%;">Contact</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider border-b col-status" style="width: 40%;">Document Status</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider border-b col-actions" style="width: 25%;">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($students as $index => $student)
                                @php
                                    $palette = [
                                        [
                                            'bg' => 'bg-blue-50',
                                            'text' => 'text-blue-700',
                                            'border' => 'border-blue-100',
                                        ],
                                        [
                                            'bg' => 'bg-purple-50',
                                            'text' => 'text-purple-700',
                                            'border' => 'border-purple-100',
                                        ],
                                        [
                                            'bg' => 'bg-emerald-50',
                                            'text' => 'text-emerald-700',
                                            'border' => 'border-emerald-100',
                                        ],
                                        [
                                            'bg' => 'bg-orange-50',
                                            'text' => 'text-orange-700',
                                            'border' => 'border-orange-100',
                                        ],
                                        [
                                            'bg' => 'bg-pink-50',
                                            'text' => 'text-pink-700',
                                            'border' => 'border-pink-100',
                                        ],
                                        [
                                            'bg' => 'bg-indigo-50',
                                            'text' => 'text-indigo-700',
                                            'border' => 'border-indigo-100',
                                        ],
                                        [
                                            'bg' => 'bg-teal-50',
                                            'text' => 'text-teal-700',
                                            'border' => 'border-teal-100',
                                        ],
                                        [
                                            'bg' => 'bg-cyan-50',
                                            'text' => 'text-cyan-700',
                                            'border' => 'border-cyan-100',
                                        ],
                                    ];

                                    $progressColors = [
                                        'Assigned' => [
                                            'bg' => 'bg-gray-50',
                                            'text' => 'text-gray-700',
                                            'border' => 'border-gray-100',
                                        ],
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

                                    $industry = $student->industry ?? 'Healthcare';
                                    $courseName = $student->course->name ?? 'No Course';
                                    $progress = 'Completed';
                                    $industryColor = $palette[abs(crc32($industry)) % count($palette)];
                                    $courseColor = $palette[abs(crc32($courseName)) % count($palette)];
                                    $progressColor = $progressColors[$progress] ?? $palette[6];
                                    $completedCount = 0;
                                    $totalCount = $checklists->count();
                                @endphp

                                <tr class="hover:bg-gray-50 transition-colors">
                                    <!-- Student -->
                                    <td class="px-4 py-3 whitespace-nowrap col-student">
                                        <div class="flex items-center">
                                            {{-- <div
                                                class="h-10 w-10 rounded-full bg-gradient-to-br from-brand to-gold flex items-center justify-center text-white font-semibold text-sm mr-3">
                                                {{ substr($student->name, 0, 1) }}
                                            </div> --}}
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $student->course->name ?? 'No Course' }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Contact -->
                                    <td class="px-4 py-3 whitespace-nowrap col-contact">
                                        <div class="text-sm text-gray-900">{{ $student->email }}</div>
                                        <div class="text-xs text-gray-500">{{ $student->phone ?? 'No phone' }}</div>
                                    </td>

                                    <!-- Document Status -->
                                    <td class="px-4 py-3 text-center col-status">
                                        <div class="document-status-container">
                                            <div class="status-icons-grid">
                                                @foreach ($checklists as $checklist)
                                                    @php
                                                        $hasDocument =
                                                            $student->studentDocuments
                                                                ->filter(function ($doc) use ($checklist) {
                                                                    return $doc->checklist_ids &&
                                                                        in_array($checklist->id, $doc->checklist_ids);
                                                                })
                                                                ->count() > 0;
                                                        if ($hasDocument) {
                                                            $completedCount++;
                                                        }
                                                    @endphp
                                                    <div class="group relative">
                                                        <div class="status-icon {{ $hasDocument ? 'success' : 'failure' }}">
                                                            <i class="bi {{ $hasDocument ? 'bi-check' : 'bi-x' }} text-white" style="font-size: 10px;"></i>
                                                        </div>
                                                        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">
                                                            {{ $checklist->name }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="status-counter {{ $completedCount == $totalCount ? 'complete' : 'incomplete' }}">
                                                {{ $completedCount }}/{{ $totalCount }}
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-4 py-3 text-right col-actions">
                                        <div class="relative inline-block text-left">
                                            <button onclick="toggleDropdown({{ $index }})"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <div id="dropdown-{{ $index }}"
                                                class="hidden absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg z-10 border">
                                                <button
                                                    onclick="openUploadModal({{ $student->id }}, '{{ $student->name }}')"
                                                    class="block w-full text-left px-4 py-2 text-sm text-brand hover:bg-gray-50 rounded-md">
                                                    <i class="bi bi-upload mr-2"></i>Upload
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- ESign Tab Content -->
        <div id="eSignContent" class="tab-content hidden p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Current Signature Display -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-brand mb-4">
                        <i class="bi bi-pen mr-2"></i>Current Signature
                    </h3>

                    @if($signature)
                        <div class="border border-gray-200 rounded-lg p-4 mb-4">
                            <img src="{{ asset($signature->signature_path) }}"
                                 alt="Current Signature"
                                 class="max-w-full h-auto max-h-32 mx-auto">
                        </div>
                        <div class="flex gap-2">
                            <button id="updateBtn" class="bg-brand text-white px-4 py-2 rounded-lg hover:bg-gold transition-colors">
                                <i class="bi bi-pencil mr-1"></i>Update
                            </button>
                            <button id="deleteBtn" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                                <i class="bi bi-trash mr-1"></i>Delete
                            </button>
                        </div>
                    @else
                        <div class="text-center py-8 border border-gray-200 rounded-lg">
                            <i class="bi bi-pen text-4xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500">No signature created yet</p>
                        </div>
                    @endif
                </div>

                <!-- Signature Creation/Update Form -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-brand mb-4">
                        <i class="bi bi-plus-circle mr-2"></i><span id="formTitle">Create Signature</span>
                    </h3>

                    <!-- Signature Type Selection -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Signature Method</label>
                        <div class="flex gap-4">
                            <label class="flex items-center">
                                <input type="radio" name="signature_type" value="drawn" checked class="mr-2">
                                <span class="text-sm">Draw Signature</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="signature_type" value="uploaded" class="mr-2">
                                <span class="text-sm">Upload Image</span>
                            </label>
                        </div>
                    </div>

                    <!-- Draw Signature Section -->
                    <div id="drawSection">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Draw Your Signature</label>
                        <div class="border border-gray-300 rounded-lg">
                            <canvas id="signaturePad" width="400" height="200" class="w-full"></canvas>
                        </div>
                        <div class="flex gap-2 mt-2">
                            <button id="clearBtn" class="bg-gray-500 text-white px-3 py-1 rounded text-sm hover:bg-gray-600">
                                Clear
                            </button>
                        </div>
                    </div>

                    <!-- Upload Signature Section -->
                    <div id="uploadSection" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Signature Image</label>
                        <input type="file" id="signatureFile" accept="image/png,image/jpg,image/jpeg"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        <p class="text-xs text-gray-500 mt-1">Accepted formats: PNG, JPG, JPEG (Max: 2MB)</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex gap-2">
                        <button id="saveBtn" class="bg-brand text-white px-4 py-2 rounded-lg hover:bg-gold transition-colors">
                            <i class="bi bi-check-circle mr-1"></i><span id="saveText">Save Signature</span>
                        </button>
                        @if($signature)
                            <button id="cancelBtn" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors hidden">
                                Cancel
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Document Upload Modal -->
    <div id="studentUploadModal" class="fixed inset-0 bg-black/50 flex justify-center items-center hidden z-50">
        <div class="bg-white w-full max-w-lg rounded-xl shadow-2xl overflow-hidden relative">
            <div class="bg-gradient-to-r from-brand to-gold px-6 py-4">
                <h2 id="modalStudentName" class="text-xl font-semibold text-white flex items-center">
                    <i class="bi bi-upload mr-2"></i> Upload Documents for Student
                </h2>
                <button id="closeStudentModal" class="absolute top-4 right-4 text-white hover:text-gray-200 text-2xl">
                    &times;
                </button>
            </div>
            <div class="p-6">
                <form id="studentDocumentForm" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <input type="hidden" id="studentId" name="student_id">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="bi bi-file-earmark mr-1"></i> Document Label
                        </label>
                        <input type="text" name="label" placeholder="Enter document label" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="bi bi-file-earmark mr-1"></i> Select Files (Max 50MB each)
                        </label>
                        <input type="file" name="files[]" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip"
                            required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand" />
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <button type="button" id="cancelStudentUpload"
                            class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" id="studentUploadBtn"
                            class="px-6 py-2 bg-brand text-white rounded-lg hover:bg-gold transition-colors">
                            <span id="studentUploadText"><i class="bi bi-upload mr-1"></i> Upload Documents</span>
                            <span id="studentUploadLoader" class="hidden">
                                <i class="bi bi-arrow-clockwise animate-spin mr-2"></i>Uploading...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
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
                <input type="hidden" id="checklistStudentId" name="student_id" value="">

                <div class="space-y-3 mb-6">
                    @foreach ($checklists as $checklist)
                        <label class="flex items-center">
                            <input type="checkbox" name="checklist_ids[]" value="{{ $checklist->id }}"
                                class="mr-3 checklist-checkbox">
                            <span class="text-sm">{{ $checklist->name }}</span>
                        </label>
                    @endforeach
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" id="skipChecklist"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Skip
                    </button>
                    <button type="submit" class="px-4 py-2 bg-brand text-white rounded-md hover:bg-gold">
                        Save Types
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Initialize DataTables for students table with fixed layout and explicit column widths
            const docTable = $('#studentsTable').DataTable({
                pageLength: 10,
                searching: false,
                ordering: false,
                info: false,
                lengthChange: false,
                dom: 'rt<"flex justify-end mt-4"p>',
                scrollX: false,
                autoWidth: false,
                columnDefs: [
                    { targets: 0, width: '20%', className: 'col-student' },
                    { targets: 1, width: '20%', className: 'col-contact' },
                    // { targets: 2, width: '52%', className: 'col-status text-center' },
                    { targets: 3, width: '8%', className: 'col-actions text-right' }
                ]
            });

            // Force DataTables to recalculate column widths so header/body align correctly
            // Run adjust a couple times (immediate + slight delay) and on resize
            try {
                docTable.columns.adjust();
                setTimeout(function() { docTable.columns.adjust(); }, 60);

                let dtResizeTimer = null;
                $(window).on('resize', function() {
                    clearTimeout(dtResizeTimer);
                    dtResizeTimer = setTimeout(function() {
                        docTable.columns.adjust();
                    }, 120);
                });
            } catch (e) {
                // ignore if DataTables not available
                console.warn('DataTables adjust failed', e);
            }

            // Custom filtering for documents table
            $('#docSearchFilter').on('keyup', function() {
                docTable.search(this.value).draw();
            });

            $('#docCourseFilter').on('change', function() {
                docTable.column(0).search(this.value).draw();
            });

            $('#docStatusFilter').on('change', function() {
                docTable.column(2).search(this.value).draw();
            });

            $('#docResetFilters').on('click', function() {
                $('#docSearchFilter').val('');
                $('#docCourseFilter').val('');
                $('#docStatusFilter').val('');
                docTable.search('').columns().search('').draw();
            });

            // Tab functionality
            $('.tab-button').on('click', function() {
                const tabId = $(this).attr('id');

                // Remove active class from all tabs
                $('.tab-button').removeClass('active border-brand text-brand').addClass(
                    'border-transparent text-gray-500');

                // Add active class to clicked tab
                $(this).addClass('active border-brand text-brand').removeClass(
                    'border-transparent text-gray-500');

                // Hide all tab contents
                $('.tab-content').addClass('hidden');

                // Show corresponding content
                if (tabId === 'myDocumentsTab') {
                    $('#myDocumentsContent').removeClass('hidden');
                } else if (tabId === 'studentsDocumentsTab') {
                    $('#studentsDocumentsContent').removeClass('hidden');
                } else if (tabId === 'eSignTab') {
                    $('#eSignContent').removeClass('hidden');
                }
            });

            $('form').on('submit', function() {
                const uploadBtn = $('#uploadBtn');
                const uploadText = $('#uploadText');
                const uploadLoader = $('#uploadLoader');

                uploadBtn.prop('disabled', true);
                uploadText.addClass('hidden');
                uploadLoader.removeClass('hidden');
            });

            $(document).on('click', '.delete-document', function() {
                const documentId = $(this).data('id');
                const documentCard = $(this).closest('.bg-white');

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
                            url: `/rto/my-documents/${documentId}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    documentCard.remove();
                                    toastr.success('Document deleted successfully!');
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

        // Dropdown toggle functionality
        function toggleDropdown(index) {
            const dropdown = document.getElementById(`dropdown-${index}`);
            const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');

            // Close all other dropdowns
            allDropdowns.forEach(dd => {
                if (dd !== dropdown) {
                    dd.classList.add('hidden');
                }
            });

            // Toggle current dropdown
            dropdown.classList.toggle('hidden');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('[onclick^="toggleDropdown"]')) {
                const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');
                allDropdowns.forEach(dd => dd.classList.add('hidden'));
            }
        });

        // Student document upload modal functions
        function openUploadModal(studentId, studentName) {
            $('#studentId').val(studentId);
            $('#modalStudentName').html(`<i class="bi bi-upload mr-2"></i> Upload Documents for ${studentName}`);
            $('#studentUploadModal').removeClass('hidden');
        }

        $('#closeStudentModal, #cancelStudentUpload').on('click', function() {
            $('#studentUploadModal').addClass('hidden');
        });

        $('#studentUploadModal').on('click', function(e) {
            if (e.target === this) {
                $(this).addClass('hidden');
            }
        });

        // Handle student document form submission
        $('#studentDocumentForm').on('submit', function(e) {
            e.preventDefault();

            const studentId = $('#studentId').val();
            const uploadBtn = $('#studentUploadBtn');
            const uploadText = $('#studentUploadText');
            const uploadLoader = $('#studentUploadLoader');

            uploadBtn.prop('disabled', true);
            uploadText.addClass('hidden');
            uploadLoader.removeClass('hidden');

            const formData = new FormData(this);

            $.ajax({
                url: `/rto/student-documents/${studentId}`,
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
                        $('#checklistStudentId').val(studentId);
                        $('#studentUploadModal').addClass('hidden');

                        // Get existing checklist IDs for this student and disable them
                        $.get(`/rto/student-documents/${studentId}/existing-checklists`, function(
                            data) {
                            $('.checklist-checkbox').prop('checked', false).prop('disabled',
                                false);
                            $('.checklist-checkbox').next('span').removeClass('text-gray-400');

                            if (data.existing_checklist_ids && data.existing_checklist_ids
                                .length > 0) {
                                data.existing_checklist_ids.forEach(function(checklistId) {
                                    const checkbox = $(
                                        `.checklist-checkbox[value="${checklistId}"]`
                                    );
                                    checkbox.prop('checked', true).prop('disabled',
                                        true);
                                    checkbox.next('span').addClass('text-gray-400');
                                });
                            }
                        });

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

        // Handle checklist form submission
        $('#checklistForm').on('submit', function(e) {
            e.preventDefault();

            const studentId = $('#checklistStudentId').val();

            $.ajax({
                url: `/rto/student-documents/assign-types/${studentId}`,
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

        // Handle skip button
        $('#skipChecklist, #closeChecklistModal').on('click', function() {
            $('#checklistModal').addClass('hidden');
            location.reload();
        });

        // E-Signature functionality
        let signaturePad;
        let isUpdateMode = false;
        const hasSignature = {{ $signature ? 'true' : 'false' }};

        // Initialize signature pad when ESign tab is clicked
        $('#eSignTab').on('click', function() {
            setTimeout(function() {
                if (!signaturePad) {
                    const canvas = document.getElementById('signaturePad');
                    if (canvas) {
                        signaturePad = new SignaturePad(canvas, {
                            backgroundColor: 'rgba(255, 255, 255, 0)',
                            penColor: 'rgb(0, 0, 0)'
                        });

                        // Resize canvas
                        function resizeCanvas() {
                            const ratio = Math.max(window.devicePixelRatio || 1, 1);
                            canvas.width = canvas.offsetWidth * ratio;
                            canvas.height = canvas.offsetHeight * ratio;
                            canvas.getContext("2d").scale(ratio, ratio);
                            signaturePad.clear();
                        }
                        resizeCanvas();
                    }
                }
            }, 100);
        });

        // Toggle signature type
        $(document).on('change', 'input[name="signature_type"]', function() {
            if ($(this).val() === 'drawn') {
                $('#drawSection').removeClass('hidden');
                $('#uploadSection').addClass('hidden');
            } else {
                $('#drawSection').addClass('hidden');
                $('#uploadSection').removeClass('hidden');
            }
        });

        // Clear signature pad
        $(document).on('click', '#clearBtn', function() {
            if (signaturePad) {
                signaturePad.clear();
            }
        });

        // Update mode
        $(document).on('click', '#updateBtn', function() {
            isUpdateMode = true;
            $('#formTitle').text('Update Signature');
            $('#saveText').text('Update Signature');
            $('#cancelBtn').removeClass('hidden');
        });

        // Cancel update
        $(document).on('click', '#cancelBtn', function() {
            isUpdateMode = false;
            $('#formTitle').text('Create Signature');
            $('#saveText').text('Save Signature');
            $('#cancelBtn').addClass('hidden');
            if (signaturePad) {
                signaturePad.clear();
            }
            $('#signatureFile').val('');
        });

        // Save signature
        $(document).on('click', '#saveBtn', function() {
            const signatureType = $('input[name="signature_type"]:checked').val();
            let formData = new FormData();

            formData.append('signature_type', signatureType);
            formData.append('_token', '{{ csrf_token() }}');

            if (signatureType === 'drawn') {
                if (!signaturePad || signaturePad.isEmpty()) {
                    toastr.error('Please draw your signature first');
                    return;
                }
                formData.append('signature_data', signaturePad.toDataURL());
            } else {
                const fileInput = document.getElementById('signatureFile');
                if (!fileInput.files[0]) {
                    toastr.error('Please select a signature image');
                    return;
                }
                formData.append('signature_file', fileInput.files[0]);
            }

            const url = isUpdateMode ?
                `/rto/esignature/{{ $signature ? $signature->id : '' }}` :
                '/rto/esignature';

            if (isUpdateMode) {
                formData.append('_method', 'PUT');
            }

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    toastr.success(response.success);
                    setTimeout(() => location.reload(), 1500);
                },
                error: function(xhr) {
                    const error = xhr.responseJSON?.error || 'An error occurred';
                    toastr.error(error);
                }
            });
        });

        // Delete signature
        $(document).on('click', '#deleteBtn', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/rto/esignature/{{ $signature ? $signature->id : '' }}',
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            toastr.success(response.success);
                            setTimeout(() => location.reload(), 1500);
                        },
                        error: function(xhr) {
                            const error = xhr.responseJSON?.error || 'An error occurred';
                            toastr.error(error);
                        }
                    });
                }
            });
        });

        // Handle ESign form submission
        $('#eSignForm').on('submit', function(e) {
            e.preventDefault();

            const title = $('#eSignTitle').val();
            const content = $('#eSignContentText').val();

            if (!title || !content) {
                toastr.error('Please fill in all fields');
                return;
            }

            // Create ESign document card
            const eSignCard = `
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-brand/10 rounded-lg flex items-center justify-center">
                            <i class="bi bi-file-earmark-text text-brand"></i>
                        </div>
                        <div>
                            <p class="font-medium text-sm text-gray-900">${title}</p>
                            <p class="text-xs text-gray-500">Created: ${new Date().toLocaleDateString()}</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-200 transition-colors">
                            <i class="bi bi-eye text-xs"></i>
                        </button>
                        <button class="w-8 h-8 bg-red-100 text-red-600 rounded-lg flex items-center justify-center hover:bg-red-200 transition-colors">
                            <i class="bi bi-trash text-xs"></i>
                        </button>
                    </div>
                </div>
            `;

            // Add to list
            const eSignList = $('#eSignList');
            if (eSignList.find('.text-center').length) {
                eSignList.html(eSignCard);
            } else {
                eSignList.prepend(eSignCard);
            }

            // Reset form
            $('#eSignForm')[0].reset();
            toastr.success('ESign document created successfully!');
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

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
    <style>
        /* === DataTables + layout fixes (plain CSS) === */
        /* Enforce fixed table layout so header and body column widths match */
        #studentsTable {
            table-layout: fixed !important;
            width: 100% !important;
            border-collapse: collapse !important;
        }

        /* Prevent body content from changing column widths; allow headers to wrap */
        #studentsTable tbody td {
            box-sizing: border-box;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            vertical-align: middle;
        }

        /* Allow header cells to wrap so long header text doesn't get squashed */
        #studentsTable thead th,
        .dataTables_wrapper .dataTables_scrollHeadInner table thead th {
            white-space: normal !important;
            overflow: visible !important;
            text-overflow: clip !important;
            line-height: 1.2;
            padding-top: 0.65rem;
            padding-bottom: 0.65rem;
        }

        /* Sticky/pinned Actions column (keeps header and body aligned to the right) */
        #studentsTable th.col-actions,
        #studentsTable td.col-actions {
            position: -webkit-sticky; /* Safari */
            position: sticky;
            right: 0;
            background: white;
            z-index: 5;
            min-width: 80px;
            width: 8% !important;
            text-align: right !important;
            padding-right: 1.25rem !important;
        }

        /* Ensure the head cell sits above body cells when sticky */
        #studentsTable thead th.col-actions { z-index: 6; }

        /* Status column: wider, centered content */
        #studentsTable th.col-status,
        #studentsTable td.col-status {
            width: 52% !important;
            min-width: 200px;
            text-align: center !important;
            vertical-align: middle;
            white-space: normal; /* allow wrapping inside status grid on small screens */
        }

        /* Student / Contact columns: fixed percentages */
        #studentsTable th.col-student,
        #studentsTable td.col-student { width: 20% !important; min-width: 140px; }
        #studentsTable th.col-contact,
        #studentsTable td.col-contact { width: 20% !important; min-width: 140px; }

        /* Document Status Icons Grid Layout */
        .document-status-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 6px 8px;
            gap: 6px;
        }

        .status-icons-grid {
            display: grid;
            grid-template-columns: repeat(10, 20px);
            gap: 6px;
            justify-content: center;
            align-items: center;
        }

        /* Tailwind equivalent: use utilities where possible
           Example: <div class="grid gap-1 justify-center" style="grid-template-columns:repeat(5,20px)"> */

        .status-icon {
            width: 15px;
            height: 15px;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 10px;
            line-height: 1;
        }

        .status-icon.success { background-color: #28a745; }
        .status-icon.failure { background-color: #dc3545; }

        .status-counter { font-size: 11px; font-weight: 600; text-align: center; }
        .status-counter.complete { color: #28a745; }
        .status-counter.incomplete { color: #fd7e14; }

        /* Consistent row height but allow wrapping in status column on small screens */
        #studentsTable tbody tr { min-height: 64px; }

        /* Responsive: allow the icons to wrap and the counter to remain centered */
        @media (max-width: 768px) {
            .status-icons-grid { grid-template-columns: repeat(4, 18px); gap: 5px; }
            .status-icon { width: 18px; height: 18px; }
            #studentsTable th, #studentsTable td { white-space: normal; }
            #studentsTable th.col-actions, #studentsTable td.col-actions { min-width: 64px; }
        }

        /* DataTables pagination styling */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.25rem 0.75rem;
            margin: 0 0.125rem;
            border-radius: 0.375rem;
            background-color: #e5e7eb;
            color: #374151;
            border: none;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #d1d5db;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: var(--brand);
            color: white;
        }

        .dataTables_wrapper .dataTables_paginate {
            text-align: right;
        }
    </style>
@endsection
