  @extends('admin.master_layout.index')
  @section('content')
      <div class="w-full flex justify-end mb-4">
          <button class="bg-brand text-white flex font-medium text-sm px-5 py-2 rounded-md hover:bg-gold" id="openModalBtn">
              + Add Coordinator
          </button>
      </div>
      <!-- Wrapper makes the scroll and white bg consistent -->
      <div class="bg-white rounded-lg shadow overflow-x-auto">
          <table class="min-w-full border-collapse w-full">
              <thead>
                  <tr class="text-left text-brand font-normal text-sm border-b">
                      <th class="p-3 whitespace-nowrap"> Coordinator Name</th>
                      <th class="p-3 whitespace-nowrap"> Email</th>
                      <th class="p-3 whitespace-nowrap">Phone </th>
                      <th class="p-3 whitespace-nowrap">Created Date </th>
                      <th class="p-3 whitespace-nowrap">Process</th>
                      <th class="p-3 whitespace-nowrap">Action</th>
                  </tr>
              </thead>
              <tbody class="">
                  <tr class="border-b font-medium text-xs hover:bg-gray-50">
                      <td class="p-3 whitespace-nowrap">John Doe</td>
                      <td class="p-3 whitespace-nowrap">johndoe@gmail.com</td>
                      <td class="p-3 whitespace-nowrap">61800692273</td>
                      <td class="p-3 whitespace-nowrap"> 06, Oct 2022</td>
                      <td class="p-3 whitespace-nowrap">
                          <div class="flex items-center space-x-2">
                              <!-- Green Dot -->
                              <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>

                              <!-- Dropdown -->
                              <select
                                  class="text-green-500 font-medium bg-transparent border-none focus:ring-0 cursor-pointer"
                                  onchange="this.classList.toggle('text-green-500', this.value === 'Approved');
                 this.classList.toggle('text-red-500', this.value === 'Rejected');
                 this.previousElementSibling.classList.toggle('bg-green-500', this.value === 'Approved');
                 this.previousElementSibling.classList.toggle('bg-red-500', this.value === 'Rejected');">
                                  <option value="Approved" selected>Approved</option>
                                  <option value="Rejected">Rejected</option>
                              </select>
                          </div>
                      </td>

                      <td class="p-3 text-red-500 cursor-pointer whitespace-nowrap"><i class="bi bi-trash3-fill"></i></td>
                  </tr>
                              <tr class="border-b font-medium text-xs hover:bg-gray-50">
                      <td class="p-3 whitespace-nowrap">John Doe</td>
                      <td class="p-3 whitespace-nowrap">johndoe@gmail.com</td>
                      <td class="p-3 whitespace-nowrap">61800692273</td>
                      <td class="p-3 whitespace-nowrap"> 06, Oct 2022</td>
                      <td class="p-3 whitespace-nowrap">
                          <div class="flex items-center space-x-2">
                              <!-- Green Dot -->
                              <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>

                              <!-- Dropdown -->
                              <select
                                  class="text-green-500 font-medium bg-transparent border-none focus:ring-0 cursor-pointer"
                                  onchange="this.classList.toggle('text-green-500', this.value === 'Approved');
                 this.classList.toggle('text-red-500', this.value === 'Rejected');
                 this.previousElementSibling.classList.toggle('bg-green-500', this.value === 'Approved');
                 this.previousElementSibling.classList.toggle('bg-red-500', this.value === 'Rejected');">
                                  <option value="Approved" selected>Approved</option>
                                  <option value="Rejected">Rejected</option>
                              </select>
                          </div>
                      </td>

                      <td class="p-3 text-red-500 cursor-pointer whitespace-nowrap"><i class="bi bi-trash3-fill"></i></td>
                  </tr>
                          <tr class="border-b font-medium text-xs hover:bg-gray-50">
                      <td class="p-3 whitespace-nowrap">John Doe</td>
                      <td class="p-3 whitespace-nowrap">johndoe@gmail.com</td>
                      <td class="p-3 whitespace-nowrap">61800692273</td>
                      <td class="p-3 whitespace-nowrap"> 06, Oct 2022</td>
                      <td class="p-3 whitespace-nowrap">
                          <div class="flex items-center space-x-2">
                              <!-- Green Dot -->
                              <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>

                              <!-- Dropdown -->
                              <select
                                  class="text-green-500 font-medium bg-transparent border-none focus:ring-0 cursor-pointer"
                                  onchange="this.classList.toggle('text-green-500', this.value === 'Approved');
                 this.classList.toggle('text-red-500', this.value === 'Rejected');
                 this.previousElementSibling.classList.toggle('bg-green-500', this.value === 'Approved');
                 this.previousElementSibling.classList.toggle('bg-red-500', this.value === 'Rejected');">
                                  <option value="Approved" selected>Approved</option>
                                  <option value="Rejected">Rejected</option>
                              </select>
                          </div>
                      </td>

                      <td class="p-3 text-red-500 cursor-pointer whitespace-nowrap"><i class="bi bi-trash3-fill"></i></td>
                  </tr>
                          <tr class="border-b font-medium text-xs hover:bg-gray-50">
                      <td class="p-3 whitespace-nowrap">John Doe</td>
                      <td class="p-3 whitespace-nowrap">johndoe@gmail.com</td>
                      <td class="p-3 whitespace-nowrap">61800692273</td>
                      <td class="p-3 whitespace-nowrap"> 06, Oct 2022</td>
                      <td class="p-3 whitespace-nowrap">
                          <div class="flex items-center space-x-2">
                              <!-- Green Dot -->
                              <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>

                              <!-- Dropdown -->
                              <select
                                  class="text-green-500 font-medium bg-transparent border-none focus:ring-0 cursor-pointer"
                                  onchange="this.classList.toggle('text-green-500', this.value === 'Approved');
                 this.classList.toggle('text-red-500', this.value === 'Rejected');
                 this.previousElementSibling.classList.toggle('bg-green-500', this.value === 'Approved');
                 this.previousElementSibling.classList.toggle('bg-red-500', this.value === 'Rejected');">
                                  <option value="Approved" selected>Approved</option>
                                  <option value="Rejected">Rejected</option>
                              </select>
                          </div>
                      </td>

                      <td class="p-3 text-red-500 cursor-pointer whitespace-nowrap"><i class="bi bi-trash3-fill"></i></td>
                  </tr>
                          <tr class="border-b font-medium text-xs hover:bg-gray-50">
                      <td class="p-3 whitespace-nowrap">John Doe</td>
                      <td class="p-3 whitespace-nowrap">johndoe@gmail.com</td>
                      <td class="p-3 whitespace-nowrap">61800692273</td>
                      <td class="p-3 whitespace-nowrap"> 06, Oct 2022</td>
                      <td class="p-3 whitespace-nowrap">
                          <div class="flex items-center space-x-2">
                              <!-- Green Dot -->
                              <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>

                              <!-- Dropdown -->
                              <select
                                  class="text-green-500 font-medium bg-transparent border-none focus:ring-0 cursor-pointer"
                                  onchange="this.classList.toggle('text-green-500', this.value === 'Approved');
                 this.classList.toggle('text-red-500', this.value === 'Rejected');
                 this.previousElementSibling.classList.toggle('bg-green-500', this.value === 'Approved');
                 this.previousElementSibling.classList.toggle('bg-red-500', this.value === 'Rejected');">
                                  <option value="Approved" selected>Approved</option>
                                  <option value="Rejected">Rejected</option>
                              </select>
                          </div>
                      </td>

                      <td class="p-3 text-red-500 cursor-pointer whitespace-nowrap"><i class="bi bi-trash3-fill"></i></td>
                  </tr>

              </tbody>
          </table>
      </div>
      <div id="rtoModal" class="fixed inset-0 bg-black/50 flex justify-center items-center hidden z-50">
          <div class="bg-white w-full max-w-2xl rounded-xl shadow-2xl p-10 relative">
              <!-- Close Button -->
              <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">
                  &times;
              </button>

              <!-- Title -->
              <h2 class="text-2xl font-semibold text-brand   pb-3">
           Add Coordinator
              </h2>

              <!-- Form -->
              <form class="space-y-4">
                  <div class="flex flex-wrap -mx-3">
                      <!-- RTO Name -->
                      <div class="w-full  p-3">
                          <label class="block text-sm font-medium text-brand"> Coordinator Name <span
                                  class="text-red-500">*</span></label>
                          <input type="email" placeholder="Coordinator Name..."
                              class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                      </div>



                      <!-- Address -->
                      <div class="w-full md:w-1/2 lg:w-1/2 p-3">
                          <label class="block text-sm font-medium brand"> Coordinator Email <span
                                  class="text-red-500">*</span></label>
                          <input type="email" placeholder="   Coordinator Email..."
                              class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                      </div>

                      <!-- Contact -->
                      <div class="w-full md:w-1/2 lg:w-1/2 p-3">
                          <label class="block text-sm font-medium brand">Coordinator Phone<span
                                  class="text-red-500">*</span></label>
                          <input type="email" placeholder=" Coordinator Phone..."
                              class="w-full border border-gold bg-white text-sm rounded-md p-2 shadow-graysoft focus:shadow-graydeep focus:ring-2 focus:ring-gold focus:outline-none transition-all duration-200" />
                      </div>
                  </div>

                  <!-- Buttons -->
                  <div class="flex justify-end gap-3 w-full  ">

                      <button type="submit" class="px-6 py-2 bg-brand w-full text-white rounded-md hover:bg-gold">
                          Save
                      </button>
                  </div>
              </form>
          </div>
      </div>
  @endsection
