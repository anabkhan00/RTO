@extends('rto.master_layout.index')

@section('title', 'Student Documents - ' . $student->name)

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold text-brand mb-6">Documents for {{ $student->name }}</h2>

        <!-- Student Update Section -->
        <div class="mb-8">
            <h3 class="text-lg font-medium text-brand mb-4">Student Information</h3>

            <form action="/rto/students/{{ $student->id }}" method="POST" class="bg-white rounded-lg border p-6 shadow-sm">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                        <select name="course_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                            <option value="">Select Course</option>
                            @foreach($courses ?? [] as $course)
                                <option value="{{ $course->id }}" {{ $student->course_id == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>

                     <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <input type="text" name="address" value="{{ $student->address }}" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand" />
                    </div>

                    {{-- <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <textarea name="address" rows="2"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">{{ $student->address }}</textarea>
                    </div> --}}
                </div>

                <div class="flex justify-end mt-4">
                    <button type="submit" class="px-4 py-2 bg-brand text-white rounded-lg hover:bg-gold transition-colors text-sm">
                        <i class="bi bi-check-circle mr-1"></i>Update
                    </button>
                </div>
            </form>
        </div>

        <!-- Document Management Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Checklist Status Card -->
            <div class="bg-white rounded-lg border shadow-sm">
                <div class="p-4 border-b">
                    <h3 class="text-lg font-medium text-brand flex items-center">
                        <i class="bi bi-list-check mr-2"></i>Document Checklist
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">{{ $checklists->where('status', true)->count() }} required documents</p>
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
                            <div class="p-2 rounded hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        @if ($hasDocument)
                                            <i class="bi bi-check-circle-fill text-green-500 text-sm"></i>
                                        @else
                                            <i class="bi bi-circle text-gray-400 text-sm"></i>
                                        @endif
                                        <span class="text-sm {{ $hasDocument ? 'text-green-700 font-medium' : 'text-gray-700' }}">
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
                                            <div class="flex items-center justify-between text-xs bg-gray-50 p-2 rounded">
                                                <span class="text-gray-600 truncate">{{ $document->label }}</span>
                                                <div class="flex gap-2">
                                                    <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="text-blue-500 hover:text-blue-700" title="View">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ asset('storage/' . $document->file_path) }}" download="{{ $document->original_name }}" class="text-green-500 hover:text-green-700" title="Download">
                                                        <i class="bi bi-download"></i>
                                                    </a>
                                                    <button class="text-red-500 hover:text-red-700 delete-document" data-id="{{ $document->id }}" title="Delete">
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
                    <form action="{{ route('rto.student-documents.store', $student->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Document Label</label>
                            <input type="text" name="label" placeholder="Enter document label" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Files</label>
                            <input type="file" name="files[]" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand" />
                            <p class="text-xs text-gray-500 mt-1">Supported: PDF, DOC, DOCX, JPG, PNG, ZIP</p>
                        </div>

                        <div class="pt-2">
                            <button type="submit" id="uploadBtn" class="w-full bg-brand text-white py-2 px-4 rounded-lg hover:bg-gold transition-colors text-sm font-medium">
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

            // Handle form submission with loader
            $('form[enctype="multipart/form-data"]').on('submit', function(e) {
                e.preventDefault();
                console.log('Form submitted');

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
                        console.log('Response:', response);
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
                        console.log('Error:', xhr.responseText);
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

                $.ajax({
                    url: '/rto/student-documents/assign-types/{{ $student->id }}',
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
