  @extends('admin.master_layout.index')
@section('content')
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            @foreach ($errors->all() as $error)
                <p class="text-sm">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="w-full flex justify-end mb-4">
        <button class="bg-brand text-white flex font-medium text-sm px-5 py-2 rounded-md hover:bg-gold" id="openModalBtn">
            + Add Industry
        </button>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table id="industriesTable" class="min-w-full border-collapse w-full">
            <thead>
                <tr class="text-left text-brand font-normal text-sm border-b">
                    <th class="p-3 whitespace-nowrap">Industry Name</th>
                    <th class="p-3 whitespace-nowrap">Email</th>
                    <th class="p-3 whitespace-nowrap">Phone</th>
                    <th class="p-3 whitespace-nowrap">Address</th>
                    <th class="p-3 whitespace-nowrap">CPN</th>
                    <th class="p-3 whitespace-nowrap">Status</th>
                    <th class="p-3 whitespace-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($industries as $industry)
                <tr class="border-b font-medium text-xs hover:bg-gray-50">
                    <td class="p-3 whitespace-nowrap">{{ $industry->name }}</td>
                    <td class="p-3 whitespace-nowrap">{{ $industry->email }}</td>
                    <td class="p-3 whitespace-nowrap">{{ $industry->phone }}</td>
                    <td class="p-3 whitespace-nowrap">{{ Str::limit($industry->address, 30) }}</td>
                    <td class="p-3 whitespace-nowrap">{{ $industry->contact_person }}</td>
                    <td class="p-3 whitespace-nowrap">
                        <form method="POST" action="/admin/Industries/{{ $industry->id }}/toggle-status" class="inline">
                            @csrf
                            @method('PATCH')
                            <div class="flex items-center space-x-2">
                                <span class="w-2.5 h-2.5 rounded-full {{ $industry->status ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                <select name="status" onchange="this.form.submit()" class="{{ $industry->status ? 'text-green-500' : 'text-red-500' }} font-medium bg-transparent border-none focus:ring-0 cursor-pointer">
                                    <option value="1" {{ $industry->status ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$industry->status ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </form>
                    </td>
                    <td class="p-3 whitespace-nowrap">
                        <button onclick="editIndustry({{ $industry->id }}, '{{ $industry->name }}', '{{ addslashes($industry->description) }}', '{{ $industry->contact_person }}', '{{ $industry->email }}', '{{ $industry->phone }}', '{{ addslashes($industry->address) }}', '{{ $industry->website }}')" class="text-blue-500 hover:text-blue-700 mr-2">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <form method="POST" action="/admin/Industries/{{ $industry->id }}" class="inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-3 text-center text-gray-500">No industries found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Modal -->
    <div id="industryModal" class="fixed inset-0 bg-black/50 flex justify-center items-center hidden z-50">
        <div class="bg-white w-full max-w-4xl rounded-xl shadow-2xl p-10 relative max-h-[90vh] overflow-y-auto">
            <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">
                &times;
            </button>

            <h2 id="modalTitle" class="text-2xl font-semibold text-brand pb-3">Add Industry</h2>

            <form id="industryForm" method="POST" action="{{ route('admin.Industries') }}" class="space-y-4">
                @csrf
                <input type="hidden" id="industryId" name="_method" value="">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-brand">Industry Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="industryName" placeholder="Enter Industry Name" required
                            class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-brand">Contact Person <span class="text-red-500">*</span></label>
                        <input type="text" name="contact_person" id="industryContactPerson" placeholder="Enter Contact Person" required
                            class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-brand">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="industryEmail" placeholder="Enter Email" required
                            class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-brand">Phone <span class="text-red-500">*</span></label>
                        <input type="text" name="phone" id="industryPhone" placeholder="Enter Phone" required
                            class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-brand">Website</label>
                        <input type="url" name="website" id="industryWebsite" placeholder="Enter Website URL"
                            class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-brand">Address <span class="text-red-500">*</span></label>
                    <textarea name="address" id="industryAddress" placeholder="Enter Address" required rows="2"
                        class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-brand">Description <span class="text-red-500">*</span></label>
                    <textarea name="description" id="industryDescription" placeholder="Enter Industry Description" required rows="3"
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
const modal = document.getElementById('industryModal');
const openBtn = document.getElementById('openModalBtn');
const closeBtn = document.getElementById('closeModalBtn');
const cancelBtn = document.getElementById('cancelBtn');
const form = document.getElementById('industryForm');
const modalTitle = document.getElementById('modalTitle');

openBtn.addEventListener('click', () => {
    resetForm();
    modalTitle.textContent = 'Add Industry';
    form.action = '{{ route("admin.Industries") }}';
    document.getElementById('industryId').value = '';
    modal.classList.remove('hidden');
});

closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
cancelBtn.addEventListener('click', () => modal.classList.add('hidden'));

function editIndustry(id, name, description, contactPerson, email, phone, address, website) {
    modalTitle.textContent = 'Edit Industry';
    form.action = `/admin/Industries/${id}`;
    document.getElementById('industryId').value = 'PUT';
    document.getElementById('industryName').value = name;
    document.getElementById('industryDescription').value = description;
    document.getElementById('industryContactPerson').value = contactPerson;
    document.getElementById('industryEmail').value = email;
    document.getElementById('industryPhone').value = phone;
    document.getElementById('industryAddress').value = address;
    document.getElementById('industryWebsite').value = website || '';
    modal.classList.remove('hidden');
}

function resetForm() {
    form.reset();
    document.getElementById('industryId').value = '';
}

$(document).ready(function() {
    $('#industriesTable').DataTable({
        "pageLength": 10,
        "searching": true,
        "ordering": true,
        "columnDefs": [
            { "orderable": false, "targets": [6] }
        ]
    });
});
</script>
  @endsection
