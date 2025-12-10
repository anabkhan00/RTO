@extends('user.master_layout.index')

@section('title', 'My Documents')

@section('content')
<div class="p-4 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-medium text-gray-800 mb-1">My Documents</h1>
            <p class="text-sm text-gray-500">View and manage your documents</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm border">
            <div class="p-4 border-b">
                <h2 class="text-base font-medium text-gray-700">Document Status</h2>
            </div>
            <div class="p-4">
                @if($documents->count() > 0)
                <div class="space-y-4">
                    @foreach($documents as $document)
                    <div class="flex items-center justify-between p-4 border rounded-lg">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-brand rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-file-alt text-white text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-800">{{ $document->original_name }}</h3>
                                <p class="text-sm text-gray-500">Uploaded {{ $document->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="px-2 py-1 text-xs rounded-md bg-green-100 text-green-800">
                                Uploaded
                            </span>
                            <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="text-brand hover:text-gold">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <i class="fas fa-folder-open text-gray-300 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-800 mb-2">No Documents</h3>
                    <p class="text-gray-500">No documents have been uploaded yet.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection