@extends('admin.master_layout.index')

@section('title', 'Student Documents')

@section('content')
<div class="p-4 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="mb-6">
            <div class="flex items-center mb-2">
                <a href="{{ route('admin.placement-opportunities.students', $opportunity->id) }}" class="text-brand hover:text-gold mr-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-2xl font-medium text-gray-800">{{ $student->name }} - Documents</h1>
            </div>
            <p class="text-sm text-gray-500">{{ $opportunity->industry->name }} Placement</p>
        </div>

        <!-- Student Info -->
        <div class="bg-white rounded-lg shadow-sm border p-4 mb-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-brand rounded-full flex items-center justify-center text-white font-medium mr-4">
                    {{ substr($student->name, 0, 1) }}
                </div>
                <div>
                    <h3 class="font-medium text-gray-800">{{ $student->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $student->email }}</p>
                </div>
            </div>
        </div>

        <!-- Documents -->
        <div class="bg-white rounded-lg shadow-sm border">
            <div class="p-4 border-b">
                <h2 class="text-base font-medium text-gray-700">Documents</h2>
            </div>
            
            @if($documents->count() > 0)
            <div class="p-4">
                <div class="space-y-4">
                    @foreach($documents as $document)
                    <div class="flex items-center justify-between p-4 border rounded-lg">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-brand rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-file-alt text-white text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-800">{{ $document->original_name }}</h3>
                                <p class="text-sm text-gray-500">
                                    Uploaded {{ $document->created_at->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="px-2 py-1 text-xs rounded-md bg-green-100 text-green-800">
                                Uploaded
                            </span>
                            <a href="{{ Storage::url($document->file_path) }}" target="_blank" 
                               class="bg-brand text-white px-3 py-1 rounded text-xs hover:bg-gold transition-colors">
                                <i class="fas fa-eye mr-1"></i>View
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="p-8 text-center">
                <i class="fas fa-folder-open text-gray-300 text-4xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-800 mb-2">No Documents</h3>
                <p class="text-gray-500">This student hasn't uploaded any documents yet.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection