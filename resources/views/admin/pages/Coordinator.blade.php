  @extends('admin.master_layout.index')
  @section('content')
      @if (session('success'))
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
              + Add Coordinator
          </button>
      </div>

      <div class="bg-white rounded-lg shadow overflow-x-auto">
          <table class="min-w-full border-collapse w-full">
              <thead>
                  <tr class="text-left text-brand font-normal text-sm border-b">
                      <th class="p-3 whitespace-nowrap">Coordinator Name</th>
                      <th class="p-3 whitespace-nowrap">Email</th>
                      <th class="p-3 whitespace-nowrap">Phone</th>
                      <th class="p-3 whitespace-nowrap">Created Date</th>
                      {{-- <th class="p-3 whitespace-nowrap">Password</th> --}}
                      <th class="p-3 whitespace-nowrap">Actions</th>
                  </tr>
              </thead>
              <tbody>
                  @forelse($coordinators as $coordinator)
                      <tr class="border-b font-medium text-xs hover:bg-gray-50">
                          <td class="p-3 whitespace-nowrap">{{ $coordinator->name }}</td>
                          <td class="p-3 whitespace-nowrap">{{ $coordinator->email }}</td>
                          <td class="p-3 whitespace-nowrap">{{ $coordinator->phone }}</td>
                          <td class="p-3 whitespace-nowrap">{{ $coordinator->created_at->format('d M Y') }}</td>
                          {{-- <td class="p-3 whitespace-nowrap">
                              <form method="POST" action="/admin/Coordinator/{{ $coordinator->id }}/reset-password"
                                  class="inline">
                                  @csrf
                                  @method('PATCH')
                                  <button type="submit" class="text-blue-500 hover:text-blue-700 text-xs"
                                      onclick="return confirm('Reset password to default?')">
                                      Reset to 'password'
                                  </button>
                              </form>
                          </td> --}}
                          <td class="p-3 whitespace-nowrap">
                              <button
                                  onclick="editCoordinator({{ $coordinator->id }}, '{{ $coordinator->name }}', '{{ $coordinator->email }}', '{{ $coordinator->phone }}')"
                                  class="text-blue-500 hover:text-blue-700 mr-2">
                                  <i class="bi bi-pencil-fill"></i>
                              </button>
                              <form method="POST" action="/admin/Coordinator/{{ $coordinator->id }}" class="inline"
                                  onsubmit="return confirm('Are you sure?')">
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
                          <td colspan="6" class="p-3 text-center text-gray-500">No coordinators found</td>
                      </tr>
                  @endforelse
              </tbody>
          </table>
      </div>
      <!-- Modal -->
      <div id="coordinatorModal" class="fixed inset-0 bg-black/50 flex justify-center items-center hidden z-50">
          <div class="bg-white w-full max-w-2xl rounded-xl shadow-2xl p-10 relative">
              <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">
                  &times;
              </button>

              <h2 id="modalTitle" class="text-2xl font-semibold text-brand pb-3">Add Coordinator</h2>

              <form id="coordinatorForm" method="POST" action="{{ route('admin.Coordinator') }}" class="space-y-4">
                  @csrf
                  <input type="hidden" id="coordinatorId" name="_method" value="">

                  <div>
                      <label class="block text-sm font-medium text-brand">Coordinator Name <span
                              class="text-red-500">*</span></label>
                      <input type="text" name="name" id="coordinatorName" placeholder="Enter Coordinator Name"
                          required
                          class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                  </div>

                  <div>
                      <label class="block text-sm font-medium text-brand">Coordinator Email <span
                              class="text-red-500">*</span></label>
                      <input type="email" name="email" id="coordinatorEmail" placeholder="Enter Coordinator Email"
                          required
                          class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                  </div>

                  <div>
                      <label class="block text-sm font-medium text-brand">Phone Number <span
                              class="text-red-500">*</span></label>
                      <input type="text" name="phone" id="coordinatorPhone" placeholder="Enter Phone Number"
                          required
                          class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                  </div>

                  <div class="bg-gray-50 p-3 rounded">
                      <p class="text-sm text-gray-600">Password will be set to: <strong>password</strong></p>
                  </div>

                  <div class="flex justify-end gap-3">
                      <button type="button" id="cancelBtn"
                          class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
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
          const modal = document.getElementById('coordinatorModal');
          const openBtn = document.getElementById('openModalBtn');
          const closeBtn = document.getElementById('closeModalBtn');
          const cancelBtn = document.getElementById('cancelBtn');
          const form = document.getElementById('coordinatorForm');
          const modalTitle = document.getElementById('modalTitle');

          openBtn.addEventListener('click', () => {
              resetForm();
              modalTitle.textContent = 'Add Coordinator';
              form.action = '{{ route('admin.Coordinator') }}';
              document.getElementById('coordinatorId').value = '';
              modal.classList.remove('hidden');
          });

          closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
          cancelBtn.addEventListener('click', () => modal.classList.add('hidden'));

          function editCoordinator(id, name, email, phone) {
              modalTitle.textContent = 'Edit Coordinator';
              form.action = `/admin/Coordinator/${id}`;
              document.getElementById('coordinatorId').value = 'PUT';
              document.getElementById('coordinatorName').value = name;
              document.getElementById('coordinatorEmail').value = email;
              document.getElementById('coordinatorPhone').value = phone;
              modal.classList.remove('hidden');
          }

          function resetForm() {
              form.reset();
              document.getElementById('coordinatorId').value = '';
          }
      
      $(document).ready(function() {
          $('#coordinatorTable').DataTable({
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
