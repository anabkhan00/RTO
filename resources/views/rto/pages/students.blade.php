@extends('rto.master_layout.index')
@section('content')
    <div class="w-full flex justify-between mb-4">
        <div class="flex gap-3">
            <button class="bg-brand text-white flex font-medium text-sm px-5 py-2 rounded-md hover:bg-gold" id="openModalBtn">
                + Add Student
            </button>
            <button class="bg-green-600 text-white flex font-medium text-sm px-5 py-2 rounded-md hover:bg-green-700" id="openUploadBtn">
                <i class="bi bi-upload mr-2"></i> Upload CSV
            </button>
            <a href="/rto/students/csv-format" class="bg-gray-600 text-white flex font-medium text-sm px-5 py-2 rounded-md hover:bg-gray-700">
                <i class="bi bi-download mr-2"></i> CSV Format
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table id="studentsTable" class="min-w-full border-collapse w-full">
            <thead>
                <tr class="text-left text-brand font-normal text-sm border-b">
                    <th class="p-3 whitespace-nowrap">Name</th>
                    <th class="p-3 whitespace-nowrap">Email</th>
                    <th class="p-3 whitespace-nowrap">Phone</th>
                    <th class="p-3 whitespace-nowrap">Course</th>
                    <th class="p-3 whitespace-nowrap">Address</th>
                    <th class="p-3 whitespace-nowrap">Joined Date</th>
                    <th class="p-3 whitespace-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr class="border-b font-medium text-xs hover:bg-gray-50">
                    <td class="p-3 whitespace-nowrap">{{ $student->name }}</td>
                    <td class="p-3 whitespace-nowrap">{{ $student->email }}</td>
                    <td class="p-3 whitespace-nowrap">{{ $student->phone ?? 'N/A' }}</td>
                    <td class="p-3 whitespace-nowrap">{{ $student->course ? $student->course->code : 'N/A' }}</td>
                    <td class="p-3 whitespace-nowrap">{{ $student->address ?? 'N/A' }}</td>
                    <td class="p-3 whitespace-nowrap">{{ $student->created_at->format('d M Y') }}</td>
                    <td class="p-3 whitespace-nowrap">
                        <button onclick="editStudent({{ $student->id }}, '{{ $student->name }}', '{{ $student->email }}', '{{ $student->phone }}', '{{ addslashes($student->address) }}', {{ $student->course_id ?? 'null' }})" class="text-blue-500 hover:text-blue-700 mr-2">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <a href="{{ route('rto.student-documents.index', $student->id) }}" class="text-green-500 hover:text-green-700 mr-2">
                            <i class="bi bi-file-earmark-text"></i>
                        </a>
                        <button onclick="deleteStudent({{ $student->id }})" class="text-red-500 hover:text-red-700">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                        <form id="delete-form-{{ $student->id }}" method="POST" action="/rto/students/{{ $student->id }}" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Add/Edit Student Modal -->
    <div id="studentModal" class="fixed inset-0 bg-black/50 flex justify-center items-center hidden z-50">
        <div class="bg-white w-full max-w-2xl rounded-xl shadow-2xl p-10 relative">
            <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">
                &times;
            </button>

            <h2 id="modalTitle" class="text-2xl font-semibold text-brand pb-3">Add Student</h2>

            <form id="studentForm" method="POST" action="/rto/students" class="space-y-4">
                @csrf
                <input type="hidden" id="studentId" name="_method" value="">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-brand">Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="studentName" placeholder="Enter Student Name" required
                            class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-brand">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="studentEmail" placeholder="Enter Email" required
                            class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-brand">Phone</label>
                        <input type="text" name="phone" id="studentPhone" placeholder="Enter Phone Number"
                            class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-brand">Course</label>
                        <select name="course_id" id="studentCourse"
                            class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200">
                            <option value="">Select Course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->code }} - {{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-brand">Address</label>
                    <textarea name="address" id="studentAddress" placeholder="Enter Address" rows="3"
                        class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200"></textarea>
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

    <!-- CSV Upload Modal -->
    <div id="uploadModal" class="fixed inset-0 bg-black/50 flex justify-center items-center hidden z-50">
        <div class="bg-white w-full max-w-lg rounded-xl shadow-2xl p-10 relative">
            <button id="closeUploadBtn" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">
                &times;
            </button>

            <h2 class="text-2xl font-semibold text-brand pb-3">Upload Students CSV</h2>

            <form method="POST" action="/rto/students/upload" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-brand mb-2">Select CSV File</label>
                    <input type="file" name="csv_file" accept=".csv" required
                        class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                </div>

                <div class="bg-gray-50 p-3 rounded text-sm">
                    <p class="font-medium text-brand mb-2">CSV Format:</p>
                    <p class="text-gray-600">name,email,phone,address,course_code</p>
                    <p class="text-gray-600 text-xs mt-1">First row should contain headers</p>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" id="cancelUploadBtn" class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('studentModal');
        const uploadModal = document.getElementById('uploadModal');
        const openBtn = document.getElementById('openModalBtn');
        const openUploadBtn = document.getElementById('openUploadBtn');
        const closeBtn = document.getElementById('closeModalBtn');
        const closeUploadBtn = document.getElementById('closeUploadBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const cancelUploadBtn = document.getElementById('cancelUploadBtn');
        const form = document.getElementById('studentForm');
        const modalTitle = document.getElementById('modalTitle');

        openBtn.addEventListener('click', () => {
            resetForm();
            modalTitle.textContent = 'Add Student';
            form.action = '/rto/students';
            document.getElementById('studentId').value = '';
            modal.classList.remove('hidden');
        });

        openUploadBtn.addEventListener('click', () => uploadModal.classList.remove('hidden'));
        closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
        closeUploadBtn.addEventListener('click', () => uploadModal.classList.add('hidden'));
        cancelBtn.addEventListener('click', () => modal.classList.add('hidden'));
        cancelUploadBtn.addEventListener('click', () => uploadModal.classList.add('hidden'));

        function editStudent(id, name, email, phone, address, courseId) {
            modalTitle.textContent = 'Edit Student';
            form.action = `/rto/students/${id}`;
            document.getElementById('studentId').value = 'PUT';
            document.getElementById('studentName').value = name;
            document.getElementById('studentEmail').value = email;
            document.getElementById('studentPhone').value = phone || '';
            document.getElementById('studentAddress').value = address || '';
            document.getElementById('studentCourse').value = courseId || '';
            modal.classList.remove('hidden');
        }

        function resetForm() {
            form.reset();
            document.getElementById('studentId').value = '';
        }

        function deleteStudent(id) {
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
            $('#studentsTable').DataTable({
                "pageLength": 25,
                "searching": true,
                "ordering": true,
                "columnDefs": [
                    { "orderable": false, "targets": [5] }
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
