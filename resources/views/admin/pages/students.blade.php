  @extends('admin.master_layout.index')
@section('content')
  <div class="w-full flex justify-end mb-4">
                 <button
            class="bg-brand text-white flex font-medium text-sm px-5 py-2 rounded-md hover:bg-gold"
          >
         Download All <img src="{{ asset('assets/images/Login.svg') }}" class=" ms-3 w-4">
          </button>
    </div>
  <!-- Wrapper makes the scroll and white bg consistent -->
  <div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="min-w-full border-collapse w-full">
      <thead>
        <tr class="text-left text-brand font-normal text-sm border-b">
          <th class="p-3 whitespace-nowrap">Name</th>
          <th class="p-3 whitespace-nowrap">RTO</th>
          <th class="p-3 whitespace-nowrap">Industry </th>
              <th class="p-3 whitespace-nowrap">Expiry </th>
          <th class="p-3 whitespace-nowrap">Process</th>
          <th class="p-3 whitespace-nowrap">Action</th>
        </tr>
      </thead>
      <tbody class="">
        <tr class="border-b font-medium text-xs hover:bg-gray-50">
          <td class="p-3 whitespace-nowrap"> Neepa Patel.CSV</td>
          <td class="p-3 whitespace-nowrap">Global Training</td>
          <td class="p-3 whitespace-nowrap"><div>
            <p>Real Estate Agency</p>
            <p class="text-mycolr text-xs">0431040345</p>
          </div></td>
                   <td class="p-3 whitespace-nowrap"> 72 Days Left</td>
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
                 this.previousElementSibling.classList.toggle('bg-red-500', this.value === 'Rejected');"
    >
      <option value="Approved" selected>Approved</option>
      <option value="Rejected">Rejected</option>
    </select>
  </div>
</td>

          <td class="p-3 text-red-500 cursor-pointer whitespace-nowrap"><i class="bi bi-trash3-fill"></i></td>
        </tr>
         <tr class="border-b font-medium text-xs hover:bg-gray-50">
          <td class="p-3 whitespace-nowrap"> Neepa Patel.CSV</td>
          <td class="p-3 whitespace-nowrap">Global Training</td>
          <td class="p-3 whitespace-nowrap"><div>
            <p>Real Estate Agency</p>
            <p class="text-mycolr text-xs">0431040345</p>
          </div></td>
                   <td class="p-3 whitespace-nowrap"> 72 Days Left</td>
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
                 this.previousElementSibling.classList.toggle('bg-red-500', this.value === 'Rejected');"
    >
      <option value="Approved" selected>Approved</option>
      <option value="Rejected">Rejected</option>
    </select>
  </div>
</td>

          <td class="p-3 text-red-500 cursor-pointer whitespace-nowrap"><i class="bi bi-trash3-fill"></i></td>
        </tr>
             <tr class="border-b font-medium text-xs hover:bg-gray-50">
          <td class="p-3 whitespace-nowrap"> Neepa Patel.CSV</td>
          <td class="p-3 whitespace-nowrap">Global Training</td>
          <td class="p-3 whitespace-nowrap"><div>
            <p>Real Estate Agency</p>
            <p class="text-mycolr text-xs">0431040345</p>
          </div></td>
                   <td class="p-3 whitespace-nowrap"> 72 Days Left</td>
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
                 this.previousElementSibling.classList.toggle('bg-red-500', this.value === 'Rejected');"
    >
      <option value="Approved" selected>Approved</option>
      <option value="Rejected">Rejected</option>
    </select>
  </div>
</td>

          <td class="p-3 text-red-500 cursor-pointer whitespace-nowrap"><i class="bi bi-trash3-fill"></i></td>
        </tr>
             <tr class="border-b font-medium text-xs hover:bg-gray-50">
          <td class="p-3 whitespace-nowrap"> Neepa Patel.CSV</td>
          <td class="p-3 whitespace-nowrap">Global Training</td>
          <td class="p-3 whitespace-nowrap"><div>
            <p>Real Estate Agency</p>
            <p class="text-mycolr text-xs">0431040345</p>
          </div></td>
                   <td class="p-3 whitespace-nowrap"> 72 Days Left</td>
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
                 this.previousElementSibling.classList.toggle('bg-red-500', this.value === 'Rejected');"
    >
      <option value="Approved" selected>Approved</option>
      <option value="Rejected">Rejected</option>
    </select>
  </div>
</td>

          <td class="p-3 text-red-500 cursor-pointer whitespace-nowrap"><i class="bi bi-trash3-fill"></i></td>
        </tr>
             <tr class="border-b font-medium text-xs hover:bg-gray-50">
          <td class="p-3 whitespace-nowrap"> Neepa Patel.CSV</td>
          <td class="p-3 whitespace-nowrap">Global Training</td>
          <td class="p-3 whitespace-nowrap"><div>
            <p>Real Estate Agency</p>
            <p class="text-mycolr text-xs">0431040345</p>
          </div></td>
                   <td class="p-3 whitespace-nowrap"> 72 Days Left</td>
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
                 this.previousElementSibling.classList.toggle('bg-red-500', this.value === 'Rejected');"
    >
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
  @endsection