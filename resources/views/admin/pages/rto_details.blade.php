@extends('admin.master_layout.index')
@section('content')
    <div class="mb-4">
        <a href="/admin/rto" class="text-brand hover:text-gold">
            <i class="bi bi-arrow-left mr-2"></i>Back to RTOs
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold text-brand mb-6">RTO Details</h2>

        <!-- RTO Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label class="block text-sm font-medium text-brand">Code</label>
                <p class="text-gray-800 bg-gray-50 p-3 rounded">{{ $rto->code }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-brand">Name</label>
                <p class="text-gray-800 bg-gray-50 p-3 rounded">{{ $rto->name }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-brand">Email</label>
                <p class="text-gray-800 bg-gray-50 p-3 rounded">{{ $rto->email }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-brand">Phone</label>
                <p class="text-gray-800 bg-gray-50 p-3 rounded">{{ $rto->phone }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-brand">Contact Person</label>
                <p class="text-gray-800 bg-gray-50 p-3 rounded">{{ $rto->contact_person }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-brand">Website</label>
                <p class="text-gray-800 bg-gray-50 p-3 rounded">{{ $rto->website ?? 'N/A' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-brand">Onboard Date</label>
                <p class="text-gray-800 bg-gray-50 p-3 rounded">{{ $rto->created_at->format('d M Y') }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-brand">Status</label>
                <p class="text-gray-800 bg-gray-50 p-3 rounded">
                    <span class="px-2 py-1 rounded text-xs {{ $rto->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $rto->status ? 'Active' : 'Inactive' }}
                    </span>
                </p>
            </div>
        </div>

        <!-- Documents Section -->
        @if($rto->rtoDocuments->count() > 0)
        <div class="border-t pt-6">
            <h3 class="text-lg font-medium text-brand mb-4">Uploaded Documents</h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="grid gap-3">
                    @foreach($rto->rtoDocuments as $document)
                    <div class="flex items-center justify-between bg-white p-4 rounded border">
                        <div class="flex items-center gap-3">
                            <i class="bi bi-file-earmark-text text-brand text-xl"></i>
                            <div>
                                <p class="font-medium text-brand">{{ $document->label }}</p>
                                <p class="text-sm text-gray-500">{{ $document->file_name }}</p>
                                <p class="text-xs text-gray-400">
                                    {{ number_format($document->file_size / 1024, 1) }} KB • 
                                    Uploaded {{ $document->created_at->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ Storage::url($document->file_path) }}" target="_blank" 
                               class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                                <i class="bi bi-eye mr-1"></i>View
                            </a>
                            <a href="{{ Storage::url($document->file_path) }}" download 
                               class="px-3 py-2 bg-green-500 text-white rounded hover:bg-green-600 text-sm">
                                <i class="bi bi-download mr-1"></i>Download
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @else
        <div class="border-t pt-6">
            <h3 class="text-lg font-medium text-brand mb-4">Documents</h3>
            <div class="bg-gray-50 rounded-lg p-8 text-center">
                <i class="bi bi-file-earmark text-gray-400 text-4xl mb-2"></i>
                <p class="text-gray-500">No documents uploaded yet</p>
            </div>
        </div>
        @endif
    </div>
@endsection