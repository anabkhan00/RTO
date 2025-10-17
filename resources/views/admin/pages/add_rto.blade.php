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
        <button id="openModalBtn" class="bg-brand text-white font-medium text-sm px-5 py-2 rounded-md hover:bg-gold">
            + Add RTO
        </button>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full border-collapse w-full">
            <thead>
                <tr class="text-left text-brand font-normal text-sm border-b">
                    <th class="p-3 whitespace-nowrap">RTO Name</th>
                    <th class="p-3 whitespace-nowrap">RTO Number</th>
                    <th class="p-3 whitespace-nowrap">Email</th>
                    <th class="p-3 whitespace-nowrap">Contact Person</th>
                    <th class="p-3 whitespace-nowrap">Created Date</th>
                    <th class="p-3 whitespace-nowrap">Status</th>
                    <th class="p-3 whitespace-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rtos as $rto)
                <tr class="border-b font-medium text-xs hover:bg-gray-50">
                    <td class="p-3 whitespace-nowrap">{{ $rto->name }}</td>
                    <td class="p-3 whitespace-nowrap">{{ $rto->rto_number }}</td>
                    <td class="p-3 whitespace-nowrap">{{ $rto->email }}</td>
                    <td class="p-3 whitespace-nowrap">{{ $rto->contact_person }}</td>
                    <td class="p-3 whitespace-nowrap">{{ $rto->created_at->format('d M Y') }}</td>
                    <td class="p-3 whitespace-nowrap">
                        <form method="POST" action="/admin/rto/{{ $rto->id }}/toggle-status" class="inline">
                            @csrf
                            @method('PATCH')
                            <div class="flex items-center space-x-2">
                                <span class="w-2.5 h-2.5 rounded-full {{ $rto->status ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                <select name="status" onchange="this.form.submit()" class="{{ $rto->status ? 'text-green-500' : 'text-red-500' }} font-medium bg-transparent border-none focus:ring-0 cursor-pointer">
                                    <option value="1" {{ $rto->status ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$rto->status ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </form>
                    </td>
                    <td class="p-3 whitespace-nowrap">
                        <button onclick="editRto({{ $rto->id }}, '{{ $rto->name }}', '{{ $rto->rto_number }}', '{{ $rto->email }}', '{{ $rto->phone }}', '{{ $rto->address }}', '{{ $rto->website }}', '{{ $rto->contact_person }}')" class="text-blue-500 hover:text-blue-700 mr-2">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                        <form method="POST" action="/admin/rto/{{ $rto->id }}" class="inline" onsubmit="return confirm('Are you sure?')">
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
                    <td colspan="7" class="p-3 text-center text-gray-500">No RTOs found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Modal -->
    <div id="rtoModal" class="fixed inset-0 bg-black/50 flex justify-center items-center hidden z-50">
        <div class="bg-white w-full max-w-4xl rounded-xl shadow-2xl p-10 relative max-h-[90vh] overflow-y-auto">
            <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">
                &times;
            </button>

            <h2 id="modalTitle" class="text-2xl font-semibold text-brand pb-3">Add RTO</h2>

            <form id="rtoForm" method="POST" action="{{ route('admin.add_rto') }}" class="space-y-4">
                @csrf
                <input type="hidden" id="rtoId" name="_method" value="">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-brand">RTO Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="rtoName" placeholder="Enter RTO Name" required
                            class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-brand">RTO Number <span class="text-red-500">*</span></label>
                        <input type="text" name="rto_number" id="rtoNumber" placeholder="Enter RTO Number" required
                            class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-brand">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="rtoEmail" placeholder="Enter Email" required
                            class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-brand">Phone <span class="text-red-500">*</span></label>
                        <input type="text" name="phone" id="rtoPhone" placeholder="Enter Phone" required
                            class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-brand">Contact Person <span class="text-red-500">*</span></label>
                        <input type="text" name="contact_person" id="rtoContactPerson" placeholder="Enter Contact Person" required
                            class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-brand">Website</label>
                        <input type="url" name="website" id="rtoWebsite" placeholder="Enter Website URL"
                            class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-brand">Address <span class="text-red-500">*</span></label>
                    <textarea name="address" id="rtoAddress" placeholder="Enter Address" required rows="3"
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
const modal = document.getElementById('rtoModal');
const openBtn = document.getElementById('openModalBtn');
const closeBtn = document.getElementById('closeModalBtn');
const cancelBtn = document.getElementById('cancelBtn');
const form = document.getElementById('rtoForm');
const modalTitle = document.getElementById('modalTitle');

openBtn.addEventListener('click', () => {
    resetForm();
    modalTitle.textContent = 'Add RTO';
    form.action = '{{ route("admin.add_rto") }}';
    document.getElementById('rtoId').value = '';
    modal.classList.remove('hidden');
});

closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
cancelBtn.addEventListener('click', () => modal.classList.add('hidden'));

function editRto(id, name, rtoNumber, email, phone, address, website, contactPerson) {
    modalTitle.textContent = 'Edit RTO';
    form.action = `/admin/rto/${id}`;
    document.getElementById('rtoId').value = 'PUT';
    document.getElementById('rtoName').value = name;
    document.getElementById('rtoNumber').value = rtoNumber;
    document.getElementById('rtoEmail').value = email;
    document.getElementById('rtoPhone').value = phone;
    document.getElementById('rtoAddress').value = address;
    document.getElementById('rtoWebsite').value = website || '';
    document.getElementById('rtoContactPerson').value = contactPerson;
    modal.classList.remove('hidden');
}

function resetForm() {
    form.reset();
    document.getElementById('rtoId').value = '';
}
</script>
@endsection