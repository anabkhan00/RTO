@extends('rto.master_layout.index')

@section('title', 'Student Documents - ' . $student->name)

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold text-brand mb-6">Documents for {{ $student->name }}</h2>

        <!-- Existing Documents Section -->
        @if ($student->studentDocuments->count() > 0)
            <div class="mb-8">
                <h3 class="text-lg font-medium text-brand mb-4">Uploaded Documents</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="grid gap-3">
                        @foreach ($student->studentDocuments as $document)
                            <div class="flex items-center justify-between bg-white p-3 rounded border">
                                <div class="flex items-center gap-3">
                                    <i class="bi bi-file-earmark-text text-brand text-lg"></i>
                                    <div>
                                        <p class="font-medium text-sm text-brand">{{ $document->label }}</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $document->original_name }} — Uploaded by {{ $document->uploader->name }}
                                        </p>
                                        @if($document->checklist)
                                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mt-1">{{ $document->checklist->name }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex gap-3 items-center">
                                    {{-- View Document --}}
                                    <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank"
                                        class="text-blue-500 hover:text-blue-700" title="View Document">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    {{-- Download Document --}}
                                    <a href="{{ asset('storage/' . $document->file_path) }}"
                                        download="{{ $document->original_name }}"
                                        class="text-green-500 hover:text-green-700" title="Download Document">
                                        <i class="bi bi-download"></i>
                                    </a>

                                    {{-- Delete Document --}}
                                    <button class="text-red-500 hover:text-red-700 delete-document"
                                        data-id="{{ $document->id }}" title="Delete Document">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif


        <!-- Document Upload Section -->
        <div class="border-t pt-6">
            <h3 class="text-lg font-medium text-brand mb-4">Upload Documents</h3>

            <form action="{{ route('rto.student-documents.store', $student->id) }}" method="POST"
                enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-brand mb-1">Document Label</label>
                        <input type="text" name="label" placeholder="Enter document label" required
                            class="w-full border border-gold bg-white text-sm rounded-md p-3 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-brand mb-1">Select Files (Max 50MB each)</label>
                        <input type="file" name="files[]" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip" required
                            class="w-full border border-gold bg-white text-sm rounded-md p-3 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" id="uploadBtn" class="px-6 py-2 bg-brand text-white rounded-md hover:bg-gold">
                        <span id="uploadText">Upload Documents</span>
                        <span id="uploadLoader" class="hidden">
                            <i class="bi bi-arrow-clockwise animate-spin mr-2"></i>Uploading...
                        </span>
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
                @foreach($checklists as $checklist)
                    <label class="flex items-center">
                        <input type="checkbox" name="checklist_ids[]" value="{{ $checklist->id }}" class="mr-3">
                        <span class="text-sm">{{ $checklist->name }}</span>
                    </label>
                @endforeach
            </div>
            
            <div class="flex justify-end gap-3">
                <button type="button" id="skipChecklist" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
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
                            url: `/rto/student-documents/${documentId}`,
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
