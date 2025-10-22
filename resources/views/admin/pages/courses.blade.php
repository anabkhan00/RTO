@extends('admin.master_layout.index')
@section('content')
    <div class="w-full flex justify-end mb-4">
        <button class="bg-brand text-white flex font-medium text-sm px-5 py-2 rounded-md hover:bg-gold" id="openModalBtn">
            + Add Course
        </button>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table id="coursesTable" class="min-w-full border-collapse w-full">
            <thead>
                <tr class="text-left text-brand font-normal text-sm border-b">
                    <th class="p-3 whitespace-nowrap">Course Code</th>
                    <th class="p-3 whitespace-nowrap">Course Name</th>
                    <th class="p-3 whitespace-nowrap">Credit Hours</th>
                    {{-- <th class="p-3 whitespace-nowrap">No of Students</th> --}}
                    <th class="p-3 whitespace-nowrap">Create Date</th>
                    <th class="p-3 whitespace-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $course)
                <tr class="border-b font-medium text-xs hover:bg-gray-50">
                    <td class="p-3 whitespace-nowrap">{{ $course->code }}</td>
                    <td class="p-3 whitespace-nowrap">{{ $course->name }}</td>
                    <td class="p-3 whitespace-nowrap">{{ $course->placement_hours }}</td>
                    {{-- <td class="p-3 whitespace-nowrap">{{ $course->no_of_students }}</td> --}}
                    <td class="p-3 whitespace-nowrap">{{ $course->created_at->format('d M Y') }}</td>
                    <td class="p-3 whitespace-nowrap">
                        <button onclick="editCourse({{ $course->id }}, '{{ $course->name }}', '{{ $course->code }}', {{ $course->placement_hours }}, {{ $course->no_of_students }})" class="text-blue-500 hover:text-blue-700 mr-2">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <button onclick="deleteCourse({{ $course->id }})" class="text-red-500 hover:text-red-700">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                        <form id="delete-form-{{ $course->id }}" method="POST" action="/admin/courses/{{ $course->id }}" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Modal -->
    <div id="courseModal" class="fixed inset-0 bg-black/50 flex justify-center items-center hidden z-50">
        <div class="bg-white w-full max-w-4xl rounded-xl shadow-2xl p-10 relative max-h-[90vh] overflow-y-auto">
            <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">
                &times;
            </button>

            <h2 id="modalTitle" class="text-2xl font-semibold text-brand pb-3">Add Course</h2>

            <form id="courseForm" method="POST" action="{{ route('admin.courses') }}" class="space-y-4">
                @csrf
                <input type="hidden" id="courseId" name="_method" value="">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-brand">Course Code <span class="text-red-500">*</span></label>
                        <input type="text" name="code" id="courseCode" placeholder="Enter Course Code" required
                            class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-brand">Course Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="courseName" placeholder="Enter Course Name" required
                            class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-brand">Credit Hours <span class="text-red-500">*</span></label>
                        <input type="number" name="placement_hours" id="coursePlacementHours" placeholder="Enter Credit Hours" min="0" required
                            class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>

                    {{-- <div>
                        <label class="block text-sm font-medium text-brand">No of Students <span class="text-red-500">*</span></label>
                        <input type="number" name="no_of_students" id="courseNoOfStudents" placeholder="Enter Number of Students" min="0" required
                            class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div> --}}
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" id="cancelBtn" class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2 bg-brand text-white rounded-md hover:bg-gold">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

<script>
const modal = document.getElementById('courseModal');
const openBtn = document.getElementById('openModalBtn');
const closeBtn = document.getElementById('closeModalBtn');
const cancelBtn = document.getElementById('cancelBtn');
const form = document.getElementById('courseForm');
const modalTitle = document.getElementById('modalTitle');

openBtn.addEventListener('click', () => {
    resetForm();
    modalTitle.textContent = 'Add Course';
    form.action = '{{ route("admin.courses") }}';
    document.getElementById('courseId').value = '';
    modal.classList.remove('hidden');
});

closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
cancelBtn.addEventListener('click', () => modal.classList.add('hidden'));

function editCourse(id, name, code, placementHours, noOfStudents) {
    modalTitle.textContent = 'Edit Course';
    form.action = `/admin/courses/${id}`;
    document.getElementById('courseId').value = 'PUT';
    document.getElementById('courseName').value = name;
    document.getElementById('courseCode').value = code;
    document.getElementById('coursePlacementHours').value = placementHours;
    document.getElementById('courseNoOfStudents').value = noOfStudents;
    modal.classList.remove('hidden');
}

function resetForm() {
    form.reset();
    document.getElementById('courseId').value = '';
}

function deleteCourse(id) {
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
            document.getElementById('delete-form-' + id).submit();
        }
    });
}

$(document).ready(function() {
    $('#coursesTable').DataTable({
        "pageLength": 25,
        "searching": true,
        "ordering": true,
        "columnDefs": [
            { "orderable": false, "targets": [4] }
        ],
        "dom": '<"top"lf><"dataTables_scroll overflow-x-auto"rt><"bottom"ip>',
        "scrollX": true,
        "language": {
            "search": "Search:",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        }
    });
});
</script>
  @endsection
