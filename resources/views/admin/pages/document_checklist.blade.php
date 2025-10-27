@extends('admin.master_layout.index')
@section('content')
    <div class="w-full flex justify-between mb-4">
        <button class="bg-brand text-white flex font-medium text-sm px-5 py-2 rounded-md hover:bg-gold" id="openModalBtn">
            + Add Document Type
        </button>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table id="checklistTable" class="min-w-full border-collapse w-full">
            <thead>
                <tr class="text-left text-brand font-normal text-sm border-b">
                    <th class="p-3 whitespace-nowrap">Name</th>
                    <th class="p-3 whitespace-nowrap">Description</th>
                    <th class="p-3 whitespace-nowrap">Status</th>
                    <th class="p-3 whitespace-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($checklists as $checklist)
                <tr class="border-b font-medium text-xs hover:bg-gray-50">
                    <td class="p-3 whitespace-nowrap">{{ $checklist->name }}</td>
                    <td class="p-3 whitespace-nowrap">{{ $checklist->description ?? 'N/A' }}</td>
                    <td class="p-3 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded {{ $checklist->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $checklist->status ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="p-3 whitespace-nowrap">
                        <button onclick="editChecklist({{ $checklist->id }}, '{{ $checklist->name }}', '{{ addslashes($checklist->description) }}')" class="text-blue-500 hover:text-blue-700 mr-2">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <button onclick="toggleStatus({{ $checklist->id }})" class="text-yellow-500 hover:text-yellow-700 mr-2">
                            <i class="bi bi-toggle-{{ $checklist->status ? 'on' : 'off' }}"></i>
                        </button>
                        <button onclick="deleteChecklist({{ $checklist->id }})" class="text-red-500 hover:text-red-700">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                        <form id="delete-form-{{ $checklist->id }}" method="POST" action="/admin/document-checklist/{{ $checklist->id }}" class="hidden">
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
    <div id="checklistModal" class="fixed inset-0 bg-black/50 flex justify-center items-center hidden z-50">
        <div class="bg-white w-full max-w-lg rounded-xl shadow-2xl p-10 relative">
            <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">
                &times;
            </button>

            <h2 id="modalTitle" class="text-2xl font-semibold text-brand pb-3">Add Document Type</h2>

            <form id="checklistForm" method="POST" action="/admin/document-checklist" class="space-y-4">
                @csrf
                <input type="hidden" id="checklistId" name="_method" value="">

                <div>
                    <label class="block text-sm font-medium text-brand">Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="checklistName" placeholder="Enter document type name" required
                        class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-brand">Description</label>
                    <textarea name="description" id="checklistDescription" placeholder="Enter description" rows="3"
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

    <script>
        const modal = document.getElementById('checklistModal');
        const openBtn = document.getElementById('openModalBtn');
        const closeBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const form = document.getElementById('checklistForm');
        const modalTitle = document.getElementById('modalTitle');

        openBtn.addEventListener('click', () => {
            resetForm();
            modalTitle.textContent = 'Add Document Type';
            form.action = '/admin/document-checklist';
            document.getElementById('checklistId').value = '';
            modal.classList.remove('hidden');
        });

        closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
        cancelBtn.addEventListener('click', () => modal.classList.add('hidden'));

        function editChecklist(id, name, description) {
            modalTitle.textContent = 'Edit Document Type';
            form.action = `/admin/document-checklist/${id}`;
            document.getElementById('checklistId').value = 'PUT';
            document.getElementById('checklistName').value = name;
            document.getElementById('checklistDescription').value = description || '';
            modal.classList.remove('hidden');
        }

        function resetForm() {
            form.reset();
            document.getElementById('checklistId').value = '';
        }

        function deleteChecklist(id) {
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

        function toggleStatus(id) {
            $.ajax({
                url: `/admin/document-checklist/${id}/toggle-status`,
                type: 'PATCH',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                }
            });
        }

        $(document).ready(function() {
            $('#checklistTable').DataTable({
                "pageLength": 25,
                "scrollX": true
            });
        });
    </script>
@endsection