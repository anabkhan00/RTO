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

                <div id="documentRows">
                    <div class="document-row grid grid-cols-12 gap-3 items-center mb-4">
                        <div class="col-span-5">
                            <label class="block text-sm font-medium text-brand mb-1">Document Label</label>
                            <input type="text" name="documents[0][label]" placeholder="Enter document label" required
                                class="w-full border border-gold bg-white text-sm rounded-md p-3 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                        </div>

                        <div class="col-span-5">
                            <label class="block text-sm font-medium text-brand mb-1">Document File</label>
                            <input type="file" name="documents[0][file]" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                required
                                class="w-full border border-gold bg-white text-sm rounded-md p-3 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                        </div>

                        <div class="col-span-2 flex justify-center">
                            <button type="button" onclick="removeDocumentRow(this)"
                                class="p-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition"
                                style="display: none;">
                                <i class="bi bi-trash text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <button type="button" onclick="addDocumentRow()"
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 text-sm">
                        + Add Another Document
                    </button>

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

    <script>
        function addDocumentRow() {
            const container = document.getElementById('documentRows');
            const rowCount = container.children.length;
            const newRow = document.createElement('div');
            newRow.className = 'document-row grid grid-cols-12 gap-3 items-center mb-4';

            newRow.innerHTML = `
        <div class="col-span-5">
            <label class="block text-sm font-medium text-brand mb-1">Document Label</label>
            <input type="text" name="documents[${rowCount}][label]" placeholder="Enter document label" required
                class="w-full border border-gold bg-white text-sm rounded-md p-3 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
        </div>

        <div class="col-span-5">
            <label class="block text-sm font-medium text-brand mb-1">Document File</label>
            <input type="file" name="documents[${rowCount}][file]" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required
                class="w-full border border-gold bg-white text-sm rounded-md p-3 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
        </div>

        <div class="col-span-2 flex justify-center">
            <button type="button" onclick="removeDocumentRow(this)"
                class="p-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition">
                <i class="bi bi-trash text-sm"></i>
            </button>
        </div>
    `;

            container.appendChild(newRow);
            updateRemoveButtons();
        }

        function removeDocumentRow(button) {
            const row = button.closest('.document-row');
            row.remove();
            updateRemoveButtons();
        }

        function updateRemoveButtons() {
            const rows = document.querySelectorAll('.document-row');
            rows.forEach((row, index) => {
                const removeBtn = row.querySelector('button[onclick*="removeDocumentRow"]');
                removeBtn.style.display = index === 0 ? 'none' : 'block';
            });
        }

        $(document).ready(function() {
            updateRemoveButtons();

            // Handle form submission with loader
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
