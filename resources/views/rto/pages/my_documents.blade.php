@extends('rto.master_layout.index')
@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-brand">My Documents</h2>
        <a href="{{ route('rto.students') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 text-sm">
            <i class="bi bi-people mr-2"></i>Manage Student Documents
        </a>
    </div>

    <!-- Existing Documents Section -->
    @if($documents->count() > 0)
        <div class="mb-8">
            <h3 class="text-lg font-medium text-brand mb-4">Uploaded Documents</h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="grid gap-3">
                    @foreach($documents as $document)
                        <div class="flex items-center justify-between bg-white p-3 rounded border">
                            <div class="flex items-center gap-3">
                                <i class="bi bi-file-earmark-text text-brand text-lg"></i>
                                <div>
                                    <p class="font-medium text-sm text-brand">{{ $document->label }}</p>
                                    <p class="text-xs text-gray-500">{{ $document->original_name }} ({{ number_format($document->file_size / 1024, 1) }} KB)</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="text-blue-500 hover:text-blue-700">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <button class="text-red-500 hover:text-red-700 delete-document" data-id="{{ $document->id }}">
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

        <form method="POST" action="/rto/my-documents" enctype="multipart/form-data" class="space-y-4">
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

            <div class="flex justify-between items-center">

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
$(document).ready(function() {

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
</script>

<style>
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
.animate-spin {
    animation: spin 1s linear infinite;
}
</style>
@endsection
