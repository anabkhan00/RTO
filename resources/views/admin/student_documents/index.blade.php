@extends('admin.master_layout.index')
@section('page-title', 'Student Documents')

@section('title', 'Student Documents - ' . $student->name)

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold text-brand mb-6">Documents for {{ $student->name }}</h2>

        <!-- Student Update Section -->
        <div class="mb-8">
            <h3 class="text-lg font-medium text-brand mb-4">Student Information</h3>

            <form action="/admin/students/{{ $student->id }}" method="POST" class="bg-white rounded-lg border p-6 shadow-sm">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-12 gap-6">
                    <!-- Student Form Fields -->
                    <div class="col-span-12 lg:col-span-7">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                <input type="text" name="name" value="{{ $student->name }}" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="email" value="{{ $student->email }}" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                <input type="text" name="phone" value="{{ $student->phone }}"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                                <select name="course_id"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                                    <option value="">Select Course</option>
                                    @foreach ($courses ?? [] as $course)
                                        <option value="{{ $course->id }}"
                                            {{ $student->course_id == $course->id ? 'selected' : '' }}>{{ $course->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                <input type="text" name="address" value="{{ $student->address }}" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand" />
                            </div>
                        </div>
                    </div>

                    <!-- Profile Image & Status -->
                    <div class="col-span-12 lg:col-span-5">
                        <div class="space-y-6">
                            <!-- Profile Image Upload - Expanded -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-3">Profile Image</h4>
                                <div id="profileDropzone"
                                    class="border-2 border-dashed border-gray-300 rounded-lg p-12 text-center hover:border-brand transition-colors cursor-pointer bg-gray-50 hover:bg-blue-50">
                                    <div id="dropzoneContent">
                                        <i class="bi bi-cloud-upload text-5xl text-gray-300 mb-3"></i>
                                        <p class="text-sm text-gray-600 font-medium">Drop image here or click to upload</p>
                                        <p class="text-xs text-gray-500 mt-2">PNG, JPG, GIF up to 5MB</p>
                                    </div>
                                    <div id="imagePreview" class="hidden">
                                        <img id="previewImg"
                                            class="max-w-full h-48 mx-auto rounded-lg object-cover shadow-sm" />
                                        <button type="button" id="removeImage"
                                            class="mt-3 px-3 py-1 text-xs bg-red-50 text-red-600 hover:bg-red-100 rounded-md transition-colors">
                                            <i class="bi bi-trash mr-1"></i>Remove Image</button>
                                    </div>
                                </div>
                                <input type="file" id="profileImageInput" name="profile_image" accept="image/*"
                                    class="hidden" />
                                <p class="text-xs text-gray-400 mt-2">Use high-quality portrait images for best results</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between mt-4 items-center">
                    @php
                        $status = 'Interview';

                        $statusColors = [
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

                        $colors = $statusColors[$status] ?? $statusColors['Assigned'];
                    @endphp

                    <span
                        class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-full {{ $colors['bg'] }} {{ $colors['text'] }} {{ $colors['border'] }} border shadow">
                        {{ $status }}
                    </span>


                    <button type="submit"
                        class="bg-brand text-white text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors font-medium">
                        Update
                    </button>
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
                        <p class="text-sm text-gray-600 mt-1">{{ $checklists->where('status', true)->count() }} required
                            documents</p>
                    </div>
                    <div class="p-4 max-h-96 overflow-y-auto">
                        <div class="space-y-2">
                            @foreach ($checklists as $checklist)
                                @php
                                    $documents = $student->studentDocuments->filter(function ($doc) use ($checklist) {
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
                                                            target="_blank" class="text-blue-500 hover:text-blue-700"
                                                            title="View">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <a href="{{ asset('storage/' . $document->file_path) }}"
                                                            download="{{ $document->original_name }}"
                                                            class="text-green-500 hover:text-green-700" title="Download">
                                                            <i class="bi bi-download"></i>
                                                        </a>
                                                        <button class="text-red-500 hover:text-red-700 delete-document"
                                                            data-id="{{ $document->id }}" title="Delete">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
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
                                <button type="submit" id="uploadBtn"
                                    class="bg-brand text-white text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors font-medium">
                                    <span id="uploadText"><i class="bi bi-upload mr-2"></i>Upload Documents</span>
                                    <span id="uploadLoader" class="hidden">
                                        <i class="bi bi-arrow-clockwise animate-spin mr-2"></i>Uploading...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
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

                <div class="space-y-3 mb-6">
                    @foreach ($checklists as $checklist)
                        <label class="flex items-center">
                            <input type="checkbox" name="checklist_ids[]" value="{{ $checklist->id }}" class="mr-3">
                            <span class="text-sm">{{ $checklist->name }}</span>
                        </label>
                    @endforeach
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

        document.addEventListener('DOMContentLoaded', function() {
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
@endsection
