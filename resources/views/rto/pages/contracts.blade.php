@extends('rto.master_layout.index')
@section('page-title', 'Contracts')
@section('content')
    <div class="space-y-6">
        <!-- Header with E-Signature Status -->
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-bold text-gray-800">My Contracts</h1>
                    <p class="text-gray-600 text-sm mt-1">Review and sign your contracts</p>
                </div>
                <div class="flex items-center gap-3">
                    @if($signature)
                        <div class="flex items-center gap-2 text-sm">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="bi bi-check-circle text-green-600 text-sm"></i>
                            </div>
                            <span class="text-green-700 font-medium">E-Signature Ready</span>
                        </div>
                        <a href="{{ route('rto.my-documents') }}?tab=eSignTab"
                            class="bg-gray-100 text-gray-700 text-xs px-3 py-1.5 rounded-md hover:bg-gray-200 transition-colors font-medium">
                            <i class="bi bi-pen mr-1"></i>Manage E-Sign
                        </a>
                    @else
                        <div class="flex items-center gap-2 text-sm">
                            <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                                <i class="bi bi-exclamation-triangle text-orange-600 text-sm"></i>
                            </div>
                            <span class="text-orange-700 font-medium">E-Signature Required</span>
                        </div>
                        <a href="{{ route('rto.my-documents') }}#eSignTab"
                            class="bg-orange-600 text-white text-xs px-3 py-1.5 rounded-md hover:bg-orange-700 transition-colors font-medium">
                            <i class="bi bi-plus-circle mr-1"></i>Create E-Signature
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Contracts Grid -->
        @if($contracts->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                @foreach($contracts as $contract)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <!-- Contract Header -->
                        <div class="p-4 border-b bg-gray-50">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                        <i class="bi bi-file-earmark-pdf text-red-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900 text-sm">{{ $contract->title }}</h3>
                                        <p class="text-xs text-gray-500">{{ number_format($contract->file_size / 1024, 0) }}KB • {{ $contract->created_at->format('M j, Y') }}</p>
                                    </div>
                                </div>
                                @if($contract->is_signed)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-medium">
                                        <i class="bi bi-check-circle mr-1"></i>Signed
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-medium">
                                        <i class="bi bi-clock mr-1"></i>Pending
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Contract Actions -->
                        <div class="p-4">
                            @if($contract->is_signed)
                                <div class="mb-3">
                                    <p class="text-xs text-green-600 font-medium">
                                        <i class="bi bi-calendar-check mr-1"></i>Signed on {{ $contract->signed_at->format('M j, Y g:i A') }}
                                    </p>
                                </div>
                                <a href="{{ route('rto.contracts.view', $contract) }}" target="_blank"
                                    class="w-full bg-green-600 text-white text-xs px-3 py-2 rounded-md hover:bg-green-700 transition-colors font-medium flex items-center justify-center">
                                    <i class="bi bi-download mr-2"></i>Download Signed Contract
                                </a>
                            @else
                                <div class="space-y-2">
                                    <a href="{{ asset('storage/' . $contract->file_path) }}" target="_blank"
                                        class="w-full bg-blue-600 text-white text-xs px-3 py-2 rounded-md hover:bg-blue-700 transition-colors font-medium flex items-center justify-center">
                                        <i class="bi bi-eye mr-2"></i>Preview Contract
                                    </a>
                                    @if($signature)
                                        <button onclick="signContract({{ $contract->id }})"
                                            class="w-full bg-brand text-white text-xs px-3 py-2 rounded-md hover:bg-gold transition-colors font-medium flex items-center justify-center">
                                            <i class="bi bi-pen-fill mr-2"></i>Sign Contract
                                        </button>
                                    @else
                                        <button onclick="showESignWarning()"
                                            class="w-full bg-gray-300 text-gray-600 text-xs px-3 py-2 rounded-md cursor-not-allowed font-medium flex items-center justify-center">
                                            <i class="bi bi-lock mr-2"></i>E-Signature Required
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-lg shadow-sm p-12">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-file-earmark-text text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No contracts available</h3>
                    <p class="text-gray-500 text-sm">Contracts uploaded by admin will appear here for your review and signature.</p>
                </div>
            </div>
        @endif
    </div>

    <script>
        function signContract(contractId) {
            Swal.fire({
                title: 'Sign Contract',
                text: 'Are you sure you want to sign this contract with your e-signature?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1E293B',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Yes, Sign Contract',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/rto/contracts/${contractId}/sign`,
                        type: 'POST',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function(response) {
                            if (response.success) {
                                toastr.success('Contract signed successfully!');
                                setTimeout(() => location.reload(), 1500);
                            }
                        },
                        error: function(xhr) {
                            const error = xhr.responseJSON?.error || 'An error occurred';
                            toastr.error(error);
                        }
                    });
                }
            });
        }

        function showESignWarning() {
            Swal.fire({
                title: 'E-Signature Required',
                text: 'Please create your e-signature first to sign contracts.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1E293B',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Create E-Signature',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route("rto.my-documents") }}#eSignTab';
                }
            });
        }
    </script>
@endsection
