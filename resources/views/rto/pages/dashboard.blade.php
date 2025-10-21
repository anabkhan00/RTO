@extends('rto.master_layout.index')
@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="bi bi-people text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-brand">Total Students</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalStudents }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="bi bi-book text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-brand">Active Courses</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $activeCourses }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="bi bi-calendar text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-brand">This Month</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $thisMonthStudents }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="bi bi-trophy text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-brand">Completed</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $completedStudents }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-brand mb-4">Recent Students</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse">
                <thead>
                    <tr class="text-left text-brand font-normal text-sm border-b">
                        <th class="p-3">Name</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Joined Date</th>
                        <th class="p-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentStudents as $student)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">{{ $student->name }}</td>
                        <td class="p-3">{{ $student->email }}</td>
                        <td class="p-3">{{ $student->created_at->format('d M Y') }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Active</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-3 text-center text-gray-500">No students found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection