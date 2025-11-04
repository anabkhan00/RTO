@extends('rto.master_layout.index')

@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">E-Signature Management</h1>
                <p class="text-gray-600 mt-1">Create and manage your electronic signature</p>
            </div>
        </div>
    </div>

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
                    {{-- <button id="updateBtn" class="bg-brand text-white px-4 py-2 rounded-lg hover:bg-gold transition-colors">
                        <i class="bi bi-pencil mr-1"></i>Update
                    </button> --}}
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

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        let signaturePad;
        let isUpdateMode = false;
        const hasSignature = {{ $signature ? 'true' : 'false' }};

        $(document).ready(function() {
            // Initialize signature pad
            const canvas = document.getElementById('signaturePad');
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

            // Toggle signature type
            $('input[name="signature_type"]').on('change', function() {
                if ($(this).val() === 'drawn') {
                    $('#drawSection').removeClass('hidden');
                    $('#uploadSection').addClass('hidden');
                } else {
                    $('#drawSection').addClass('hidden');
                    $('#uploadSection').removeClass('hidden');
                }
            });

            // Clear signature pad
            $('#clearBtn').on('click', function() {
                signaturePad.clear();
            });

            // Update mode
            $('#updateBtn').on('click', function() {
                isUpdateMode = true;
                $('#formTitle').text('Update Signature');
                $('#saveText').text('Update Signature');
                $('#cancelBtn').removeClass('hidden');
            });

            // Cancel update
            $('#cancelBtn').on('click', function() {
                isUpdateMode = false;
                $('#formTitle').text('Create Signature');
                $('#saveText').text('Save Signature');
                $('#cancelBtn').addClass('hidden');
                signaturePad.clear();
                $('#signatureFile').val('');
            });

            // Save signature
            $('#saveBtn').on('click', function() {
                const signatureType = $('input[name="signature_type"]:checked').val();
                let formData = new FormData();

                formData.append('signature_type', signatureType);
                formData.append('_token', '{{ csrf_token() }}');

                if (signatureType === 'drawn') {
                    if (signaturePad.isEmpty()) {
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
            $('#deleteBtn').on('click', function() {
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
        });
    </script>
@endsection
