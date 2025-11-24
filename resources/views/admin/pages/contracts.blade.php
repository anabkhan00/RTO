@extends('admin.master_layout.index')
@section('page-title', 'Contracts')
@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-bold text-gray-800">Contract Management</h1>
                    <p class="text-gray-600 text-sm mt-1">Manage RTO contracts and agreements</p>
                </div>
                {{-- <button id="uploadBtn" class="bg-brand text-white text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors font-medium">
                    <i class="bi bi-plus-circle mr-1"></i>New Contract
                </button> --}}
            </div>
        </div>

        <!-- RTO Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach($rtos as $rto)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <!-- RTO Header -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 py-3 border-b">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="font-semibold text-gray-900 text-sm">{{ $rto->name }}</h3>
                                <p class="text-xs text-gray-500">{{ $rto->contracts->count() }} contract(s)</p>
                            </div>
                            <button onclick="openUploadModal({{ $rto->id }}, '{{ $rto->name }}')"
                                class="bg-blue-600 text-white text-xs px-2 py-1 rounded hover:bg-blue-700 transition-colors">
                                <i class="bi bi-upload"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Contracts List -->
                    <div class="p-3">
                        @if($rto->contracts->count() > 0)
                            <div class="space-y-2 max-h-48 overflow-y-auto">
                                @foreach($rto->contracts as $contract)
                                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded text-xs">
                                        <div class="flex items-center gap-2 flex-1 min-w-0">
                                            <i class="bi bi-file-earmark-pdf text-red-500 text-sm flex-shrink-0"></i>
                                            <div class="min-w-0 flex-1">
                                                <p class="font-medium text-gray-900 truncate">{{ $contract->title }}</p>
                                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                                    <span>{{ number_format($contract->file_size / 1024, 0) }}KB</span>
                                                    @if($contract->is_signed)
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-full bg-green-100 text-green-700">
                                                            <i class="bi bi-check-circle text-xs mr-1"></i>Signed
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-full bg-orange-100 text-orange-700">
                                                            <i class="bi bi-clock text-xs mr-1"></i>Pending
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex gap-1 ml-2">
                                            @if($contract->is_signed)
                                                <a href="{{ route('admin.contracts.view', $contract->id) }}" target="_blank"
                                                    class="w-6 h-6 bg-green-100 text-green-600 rounded flex items-center justify-center hover:bg-green-200 transition-colors"
                                                    title="View with E-Signature">
                                                    <i class="bi bi-file-earmark-check text-xs"></i>
                                                </a>
                                            @else
                                                <a href="{{ asset('storage/' . $contract->file_path) }}" target="_blank"
                                                    class="w-6 h-6 bg-blue-100 text-blue-600 rounded flex items-center justify-center hover:bg-blue-200 transition-colors">
                                                    <i class="bi bi-eye text-xs"></i>
                                                </a>
                                            @endif
                                            <button onclick="deleteContract({{ $contract->id }})"
                                                class="w-6 h-6 bg-red-100 text-red-600 rounded flex items-center justify-center hover:bg-red-200 transition-colors">
                                                <i class="bi bi-trash text-xs"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6">
                                <i class="bi bi-file-earmark-plus text-2xl text-gray-300 mb-2"></i>
                                <p class="text-gray-500 text-xs">No contracts yet</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Upload Modal -->
    <div id="uploadModal" class="fixed inset-0 bg-black/50 flex justify-center items-center hidden z-50">
        <div class="bg-white w-full max-w-lg rounded-xl shadow-2xl overflow-hidden relative">
            <div class="bg-gradient-to-r from-brand to-gold px-6 py-4">
                <h2 id="modalTitle" class="text-xl font-semibold text-white">Upload Contract</h2>
                <button id="closeModal" class="absolute top-4 right-4 text-white hover:text-gray-200 text-2xl">&times;</button>
            </div>
            <div class="p-6">
                <form id="contractForm" method="POST" action="{{ route('admin.contracts') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <input type="hidden" id="rtoId" name="rto_id">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Contract Title</label>
                        <input type="text" name="title" placeholder="Enter contract title" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">PDF File</label>
                        <input type="file" name="file" accept=".pdf" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                    </div>

                    <div class="flex gap-3 pt-4 border-t">
                        <button type="submit" class="bg-brand text-white text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors font-medium">
                            <i class="bi bi-upload mr-1"></i>Upload Contract
                        </button>
                        <button type="button" id="cancelBtn" class="bg-gray-500 text-white text-xs px-3 py-1.5 rounded-md hover:bg-gray-600 transition-colors font-medium">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openUploadModal(rtoId, rtoName) {
            document.getElementById('rtoId').value = rtoId;
            document.getElementById('modalTitle').textContent = `Upload Contract for ${rtoName}`;
            document.getElementById('uploadModal').classList.remove('hidden');
        }

        document.getElementById('uploadBtn').addEventListener('click', () => {
            document.getElementById('uploadModal').classList.remove('hidden');
        });

        ['closeModal', 'cancelBtn'].forEach(id => {
            document.getElementById(id).addEventListener('click', () => {
                document.getElementById('uploadModal').classList.add('hidden');
            });
        });

        function deleteContract(id) {
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
                        url: `/admin/contracts/${id}`,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function() {
                            location.reload();
                        }
                    });
                }
            });
        }
    </script>
@endsection
