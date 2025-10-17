      @extends('admin.master_layout.index')
@section('content')
      <div class="w-full flex flex-wrap">
        <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-3">
          <div class="bg-white shadow-md flex justify-between align-center rounded-md p-4">
            <div>
              <p class="font-semibold text-gold text-3xl mb-3">56</p>
              <p class="font-medium text-brand text-sm">Total students</p>
            </div>
            <div class="flex items-center">
                
              <img src="{{ asset('assets/images/👨_🎓.svg') }}" class="w-10">
            </div>
          </div>
        </div>

        <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-3">
          <div class="bg-white shadow-md flex justify-between align-center rounded-md p-4">
            <div>
              <p class="font-semibold text-gold text-3xl mb-3">32</p>
              <p class="font-medium text-brand text-sm"> Job Referrals</p>
            </div>
            <div class="flex items-center">
              <img src="{{ asset('assets/images/💼.svg') }}" class="w-10">
            </div>
          </div>
        </div>
        <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-3">
          <div class="bg-white shadow-md flex justify-between align-center rounded-md p-4">
            <div>
              <p class="font-semibold text-gold text-3xl mb-3">16</p>
              <p class="font-medium text-brand text-sm"> Successful</p>
            </div>
            <div class="flex items-center">
              <img src="{{ asset('assets/images/✅ (1).svg') }}" class="w-10">
            </div>
          </div>
        </div>
        <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-3">
          <div class="bg-white shadow-md flex justify-between align-center rounded-md p-4">
            <div>
              <p class="font-semibold text-gold text-3xl mb-3">16</p>
              <p class="font-medium text-brand text-sm"> Pending</p>
            </div>
            <div class="flex items-center">
              <img src="{{ asset('assets/images/⏳.svg') }}" class="w-10">
            </div>
          </div>
        </div>
      </div>




      <div class="w-full p-3">
        <p class="font-semibold text-brand text-2xl">Industries</p>
      </div>
      <div class="w-full flex flex-wrap">

        <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/3 p-3">
          <div class="bg-white shadow-md  rounded-md p-4">
            <!-- RIGHT: User Info + Profile -->
            <div class="flex  items-center w-full pb-2 border-b border-mycolr gap-3">
              <div class="">
                <img src="{{ asset('assets/images/realestate.svg') }}" class="w-10 " />
              </div>
              <div class="text-left ">
                <p class="font-semibold text-sm"> Real Estate</p>
                <p class="text-xs text-gray-500">info@realestate.com</p>
              </div>

            </div>
            <div class="w-full mt-3">
              <p class="flex items-center font-medium text-brand text-xs"><img src="{{ asset('assets/images/location.svg') }}"
                  class="w-3 me-3">Sydney, Australia</p>
              <p class="flex items-center font-medium text-brand text-xs mt-2"><img src="{{ asset('assets/images/beeg.svg') }}"
                  class="w-3 me-3">Full Time and Part time Available</p>
            </div>
            {{-- <div class="w-full mt-3">
              <button type="button"
                class="w-full bg-brand text-white font-semibold py-3 text-sm rounded-md hover:bg-gold transition">
                Follow Industry
              </button>
            </div> --}}
          </div>
        </div>
        <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/3 p-3">
          <div class="bg-white shadow-md  rounded-md p-4">
            <!-- RIGHT: User Info + Profile -->
            <div class="flex  items-center w-full pb-2 border-b border-mycolr gap-3">
              <div class="">
                <img src="{{ asset('assets/images/techsoft.svg') }}" class="w-10 " />
              </div>
              <div class="text-left ">
                <p class="font-semibold text-sm"> TechSoft</p>
                <p class="text-xs text-gray-500">info@techsoft.com</p>
              </div>

            </div>
            <div class="w-full mt-3">
              <p class="flex items-center font-medium text-brand text-xs"><img src="{{ asset('assets/images/location.svg') }}"
                  class="w-3 me-3">Brisbane, Australia</p>
              <p class="flex items-center font-medium text-brand text-xs mt-2"><img src="{{ asset('assets/images/beeg.svg') }}"
                  class="w-3 me-3">Only Full Time</p>
            </div>
            {{-- <div class="w-full mt-3">
              <button type="button"
                class="w-full bg-brand text-white font-semibold py-3 text-sm rounded-md hover:bg-gold transition">
                Follow Industry
              </button>
            </div> --}}
          </div>
        </div>
        <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/3 p-3">
          <div class="bg-white shadow-md  rounded-md p-4">
            <!-- RIGHT: User Info + Profile -->
            <div class="flex  items-center w-full pb-2 border-b border-mycolr gap-3">
              <div class="">
                <img src="{{ asset('assets/images/star.svg') }}" class="w-10 " />
              </div>
              <div class="text-left ">
                <p class="font-semibold text-sm">Star Edge </p>
                <p class="text-xs text-gray-500">info@staredge.com</p>
              </div>

            </div>
            <div class="w-full mt-3">
              <p class="flex items-center font-medium text-brand text-xs"><img src="{{ asset('assets/images/location.svg') }}"
                  class="w-3 me-3">Newcastle, Australia</p>
              <p class="flex items-center font-medium text-brand text-xs mt-2"><img src="{{ asset('assets/images/beeg.svg') }}"
                  class="w-3 me-3">Full Time and Part time Available</p>
            </div>
            {{-- <div class="w-full mt-3">
              <button type="button"
                class="w-full bg-brand text-white font-semibold py-3 text-sm rounded-md hover:bg-gold transition">
                Follow Industry
              </button>
            </div> --}}
          </div>
        </div>
      </div>
      <div class="w-full p-3">
        <!-- Wrapper makes the scroll and white bg consistent -->
        <div class="bg-white rounded-lg shadow overflow-x-auto">
          <table class="min-w-full border-collapse w-full">
            <thead>
              <tr class="text-left text-brand font-normal text-sm border-b">
                <th class="p-3 whitespace-nowrap">Student Name</th>
                <th class="p-3 whitespace-nowrap">Email</th>
                <th class="p-3 whitespace-nowrap">Phone</th>
                <th class="p-3 whitespace-nowrap">Created Date</th>
                <th class="p-3 whitespace-nowrap">Action</th>
              </tr>
            </thead>
            <tbody class="">
              <tr class="border-b font-medium text-xs hover:bg-gray-50">
                <td class="p-3 whitespace-nowrap"> Jonathan</td>
                <td class="p-3 whitespace-nowrap">jonathan@gmail.com</td>
                <td class="p-3 whitespace-nowrap">61800692273</td>
             <td class="p-3 whitespace-nowrap">06, Oct 2022</td>
                <td class="p-3 text-red-500 cursor-pointer whitespace-nowrap"><i class="bi bi-trash3-fill"></i></td>
              </tr>
                <tr class="border-b font-medium text-xs hover:bg-gray-50">
                <td class="p-3 whitespace-nowrap"> Jonathan</td>
                <td class="p-3 whitespace-nowrap">jonathan@gmail.com</td>
                <td class="p-3 whitespace-nowrap">61800692273</td>
             <td class="p-3 whitespace-nowrap">06, Oct 2022</td>
                <td class="p-3 text-red-500 cursor-pointer whitespace-nowrap"><i class="bi bi-trash3-fill"></i></td>
              </tr>
                  <tr class="border-b font-medium text-xs hover:bg-gray-50">
                <td class="p-3 whitespace-nowrap"> Jonathan</td>
                <td class="p-3 whitespace-nowrap">jonathan@gmail.com</td>
                <td class="p-3 whitespace-nowrap">61800692273</td>
             <td class="p-3 whitespace-nowrap">06, Oct 2022</td>
                <td class="p-3 text-red-500 cursor-pointer whitespace-nowrap"><i class="bi bi-trash3-fill"></i></td>
              </tr>
                  <tr class="border-b font-medium text-xs hover:bg-gray-50">
                <td class="p-3 whitespace-nowrap"> Jonathan</td>
                <td class="p-3 whitespace-nowrap">jonathan@gmail.com</td>
                <td class="p-3 whitespace-nowrap">61800692273</td>
             <td class="p-3 whitespace-nowrap">06, Oct 2022</td>
                <td class="p-3 text-red-500 cursor-pointer whitespace-nowrap"><i class="bi bi-trash3-fill"></i></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      @endsection