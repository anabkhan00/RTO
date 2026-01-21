@extends('admin.master_layout.index')
@section('page-title', 'RTO Students')
@section('content')
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $rto->name }} - Students</h1>
                <p class="text-gray-600 mt-1">Students enrolled under this RTO</p>
            </div>
            <a href="{{ route('admin.rtos') }}"
                class="bg-gray-500 text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gray-600 transition-colors">
                <i class="bi bi-arrow-left mr-1"></i> Back to RTOs
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Student</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Email</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Course</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Status</th>
                        <th class="text-center py-3 px-4 text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-brand flex items-center justify-center text-white font-semibold text-xs mr-3">
                                        {{ substr($student->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-medium">{{ $student->name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-sm">{{ $student->email }}</td>
                            <td class="py-3 px-4 text-sm">{{ $student->course->name ?? 'N/A' }}</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full {{ $student->status ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200' }} border">
                                    {{ $student->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <a href="{{ route('admin.student-documents.index', $student->id) }}" 
                                    class="text-blue-600 hover:text-blue-800 text-sm">
                                    <i class="bi bi-file-earmark-text"></i> Documents
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500">
                                No students found for this RTO
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
