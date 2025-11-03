@extends('rto.master_layout.index')
@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-brand">Document Management</h2>
        </div>

        <!-- Tab Navigation -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8">
                <button id="myDocumentsTab"
                    class="tab-button active py-2 px-1 border-b-2 border-brand font-medium text-sm text-brand">
                    My Documents
                </button>
                <button id="studentsDocumentsTab"
                    class="tab-button py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Students Documents
                </button>
            </nav>
        </div>

        <!-- My Documents Tab Content -->
        <div id="myDocumentsContent" class="tab-content">
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
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-brand">
                        <i class="bi bi-people mr-2"></i>Students Document Status
                    </h3>
                </div>

                <!-- Important: overflow wrapper only on the table container -->
                <div class="overflow-x-auto">
                    <table id="studentsTable" class="min-w-full table-fixed border-collapse">
                        <colgroup>
                            <col style="width: 25%;">
                            <col style="width: 25%;">
                            <col style="width: 35%;">
                            <col style="width: 15%;">
                        </colgroup>
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                    Student</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                    Contact</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                    Document Status</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider border-b border-gray-200">
                                    Actions</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($students as $student)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="h-10 w-10 rounded-full bg-gradient-to-br from-brand to-gold flex items-center justify-center text-white font-semibold text-sm mr-3">
                                                {{ substr($student->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $student->course->name ?? 'No Course' }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $student->email }}</div>
                                        <div class="text-xs text-gray-500">{{ $student->phone ?? 'No phone' }}</div>
                                    </td>

                                    <td class="px-4 py-3 whitespace-nowrap text-center">
                                        <div class="inline-flex flex-wrap gap-1 justify-center items-center">
                                            @php
                                                $completedCount = 0;
                                                $totalCount = $checklists->count();
                                            @endphp
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
                                                    <div
                                                        class="w-6 h-6 {{ $hasDocument ? 'bg-green-500' : 'bg-red-500' }} rounded-full flex items-center justify-center">
                                                        <i
                                                            class="bi {{ $hasDocument ? 'bi-check' : 'bi-x' }} text-white text-xs"></i>
                                                    </div>
                                                    <div
                                                        class="absolute bottom-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">
                                                        {{ $checklist->name }}
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div
                                                class="ml-2 text-xs font-medium {{ $completedCount == $totalCount ? 'text-green-600' : 'text-orange-600' }}">
                                                {{ $completedCount }}/{{ $totalCount }}
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-4 py-3 whitespace-nowrap text-center">
                                        <button onclick="openUploadModal({{ $student->id }}, '{{ $student->name }}')"
                                            class="inline-flex items-center px-3 py-1 bg-brand text-white rounded-lg hover:bg-gold text-xs font-medium transition-colors">
                                            <i class="bi bi-upload mr-1"></i>Upload
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
            // Initialize DataTables for students table
            $('#studentsTable').DataTable({
                "pageLength": 10,
                "searching": true,
                "ordering": true,
                "columnDefs": [{
                    "orderable": false,
                    "targets": [2, 3]
                }],
                "dom": '<"top"lf><"dataTables_scroll overflow-x-auto"rt><"bottom"ip>',
                "scrollX": true,
                "language": {
                    "search": "Search students:",
                    "lengthMenu": "Show _MENU_ students",
                    "info": "Showing _START_ to _END_ of _TOTAL_ students",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": "Next",
                        "previous": "Previous"
                    }
                }
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
<style>
/* DataTables alignment fix */
#studentsTable {
    table-layout: fixed !important;
    border-collapse: collapse !important;
}

#studentsTable thead th,
#studentsTable tbody td {
    box-sizing: border-box;
}

/* Ensure DataTables wrapper doesn't break alignment */
.dataTables_wrapper .dataTables_scroll {
    overflow-x: auto;
}

.dataTables_wrapper .dataTables_scrollHead,
.dataTables_wrapper .dataTables_scrollBody {
    overflow: visible;
}

.dataTables_wrapper .dataTables_scrollHead table,
.dataTables_wrapper .dataTables_scrollBody table {
    table-layout: fixed !important;
    width: 100% !important;
}

/* Fix for DataTables header/body sync */
.dataTables_wrapper .dataTables_scrollHeadInner {
    width: 100% !important;
}

.dataTables_wrapper .dataTables_scrollHeadInner table {
    width: 100% !important;
    margin: 0 !important;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
.animate-spin {
    animation: spin 1s linear infinite;
}
</style>
@endsection
