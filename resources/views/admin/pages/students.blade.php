  @extends('admin.master_layout.index')
@section('content')
    <div class="w-full flex justify-end mb-4">
        <a href="{{ route('admin.students.download') }}" class="bg-brand text-white flex font-medium text-sm px-5 py-2 rounded-md hover:bg-gold">
            Download All <img src="{{ asset('assets/images/Login.svg') }}" class="ms-3 w-4">
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table id="studentsTable" class="min-w-full border-collapse w-full">
            <thead>
                <tr class="text-left text-brand font-normal text-sm border-b">
                    <th class="p-3 whitespace-nowrap">Name</th>
                    <th class="p-3 whitespace-nowrap">Email</th>
                    <th class="p-3 whitespace-nowrap">Address</th>
                    <th class="p-3 whitespace-nowrap">Joined Date</th>
                    <th class="p-3 whitespace-nowrap">Status</th>
                    <th class="p-3 whitespace-nowrap">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                <tr class="border-b font-medium text-xs hover:bg-gray-50">
                    <td class="p-3 whitespace-nowrap">{{ $student->name }}</td>
                    <td class="p-3 whitespace-nowrap">{{ $student->email }}</td>
                    <td class="p-3 whitespace-nowrap">
                        <div>
                            <p>{{ $student->address ?? 'N/A' }}</p>
                        </div>
                    </td>
                    <td class="p-3 whitespace-nowrap">{{ $student->created_at->format('d M Y') }}</td>
                    <td class="p-3 whitespace-nowrap">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                            <span class="text-green-500 font-medium">Active</span>
                        </div>
                    </td>
                    <td class="p-3 whitespace-nowrap">
                        {{-- <button class="text-blue-500 hover:text-blue-700 mr-2" title="View Details">
                            <i class="bi bi-eye-fill"></i>
                        </button> --}}
                        <button class="text-red-500 hover:text-red-700" title="Delete" onclick="return confirm('Are you sure?')">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-3 text-center text-gray-500">No students found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#studentsTable').DataTable({
                "pageLength": 10,
                "searching": true,
                "ordering": true,
                "columnDefs": [
                    { "orderable": false, "targets": [5] }
                ]
            });
        });
    </script>
@endsection
