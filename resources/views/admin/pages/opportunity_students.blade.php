@extends('admin.master_layout.index')

@section('title', 'Assigned Students')

@section('content')
<div class="p-4 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="mb-6">
            <div class="flex items-center mb-2">
                <a href="{{ route('admin.placement-opportunities') }}" class="text-brand hover:text-gold mr-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="text-2xl font-medium text-gray-800">{{ $opportunity->industry->name }} - Assigned Students</h1>
            </div>
            <p class="text-sm text-gray-500">{{ $opportunity->filled_slots }} of {{ $opportunity->total_slots }} slots filled</p>
        </div>

        @if($opportunity->requirements)
        <div class="bg-white rounded-lg shadow-sm border p-4 mb-6">
            <h3 class="text-base font-medium text-gray-700 mb-2">Requirements</h3>
            <p class="text-sm text-gray-600">{{ $opportunity->requirements }}</p>
        </div>
        @endif

        <div class="bg-white rounded-lg shadow-sm border">
            <div class="p-4 border-b">
                <h2 class="text-base font-medium text-gray-700">Assigned Students</h2>
            </div>
            
            @if($assignments->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assigned By</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($assignments as $assignment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-brand rounded-full flex items-center justify-center text-white text-xs font-medium mr-3">
                                        {{ substr($assignment->student->name, 0, 1) }}
                                    </div>
                                    <span class="font-medium text-gray-800">{{ $assignment->student->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $assignment->student->email }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $assignment->placementCoordinator->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $assignment->created_at->format('M d, Y') }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.opportunity-students.documents', [$opportunity->id, $assignment->student->id]) }}" 
                                   class="bg-brand text-white px-3 py-1 rounded text-xs hover:bg-gold transition-colors">
                                    View Documents
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="p-8 text-center">
                <i class="fas fa-users text-gray-300 text-4xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-800 mb-2">No Students Assigned</h3>
                <p class="text-gray-500">No students have been assigned to this opportunity yet.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection