      @extends('admin.master_layout.index')
      @section('content')
<div class="w-full p-3">
        <div class="w-full  bg-white rounded-lg shadow p-4 flex items-center justify-between">
  <!-- LEFT: Icon + Text -->
  <div class="flex items-center gap-3">
    <div class="  rounded-md flex items-center justify-center">
      <!-- 🎓 Graduation cap icon -->
       <img src="{{ asset('assets/images/stucomp.svg') }}" class="w-10">
    </div>
    <div>
      <p  class="font-semibold text-brand text-sm">43234</p>
      <p class="text-xs text-gray-500">Total Students</p>
    </div>
  </div>

  <!-- RIGHT: Progress Bar + Percentage -->
  <div class="flex-1 ml-6">
    <div class="flex justify-between text-sm text-gray-700 mb-1">
      <span></span>
      <span  class="font-medium text-brand text-xs">80%</span>
    </div>
    <div class="w-full bg-gray-200 rounded-full h-1 overflow-hidden">
      <div class="bg-[#0014AB] h-1 rounded-full" style="width: 80%;"></div>
    </div>
  </div>
</div>

</div>
          <div class="w-full flex flex-wrap">
              <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
                  <div class="bg-white shadow-md rounded-md p-4">
                    <div class="flex items-center justify-center w-full">
                          <img src="{{ asset('assets/images/dashclock.svg') }}" class="w-10">
                      
                      </div>
                      <div class="flex items-center mt-3 justify-center w-full">
                       
                          <p class="font-semibold text-brand text-xs">Awaiting Placements</p>
                      </div>
                      <div class="w-full max-w-md mt-2">
  <div class="flex justify-between text-sm font-medium text-gray-700 mb-1">
    <span class="font-medium text-brand text-xs">3142</span>
    <span class="font-medium text-brand text-xs">80%</span>
  </div>
  <div class="w-full bg-gray-200 rounded-full h-1 overflow-hidden">
    <div class="bg-[#AB6C00] h-1 rounded-full" style="width: 80%;"></div>
  </div>
</div>

                  </div>
              </div>
   <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
                  <div class="bg-white shadow-md rounded-md p-4">
                    <div class="flex items-center justify-center w-full">
                          <img src="{{ asset('assets/images/booked.svg') }}" class="w-10">
                      
                      </div>
                      <div class="flex items-center mt-3 justify-center w-full">
                       
                          <p class="font-semibold text-brand text-xs">Appointment Booked </p>
                      </div>
                      <div class="w-full max-w-md mt-2">
  <div class="flex justify-between text-sm font-medium text-gray-700 mb-1">
    <span class="font-medium text-brand text-xs">3142</span>
    <span class="font-medium text-brand text-xs">80%</span>
  </div>
  <div class="w-full bg-gray-200 rounded-full h-1 overflow-hidden">
    <div class="bg-[#FBBF24] h-1 rounded-full" style="width: 80%;"></div>
  </div>
</div>

                  </div>
              </div>
           <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
                  <div class="bg-white shadow-md rounded-md p-4">
                    <div class="flex items-center justify-center w-full">
                          <img src="{{ asset('assets/images/Started.svg') }}" class="w-10">
                      
                      </div>
                      <div class="flex items-center mt-3 justify-center w-full">
                       
                          <p class="font-semibold text-brand text-xs">Placement Started </p>
                      </div>
                      <div class="w-full max-w-md mt-2">
  <div class="flex justify-between text-sm font-medium text-gray-700 mb-1">
    <span class="font-medium text-brand text-xs">3142</span>
    <span class="font-medium text-brand text-xs">80%</span>
  </div>
  <div class="w-full bg-gray-200 rounded-full h-1 overflow-hidden">
    <div class="bg-[#00A8AB] h-1 rounded-full" style="width: 80%;"></div>
  </div>
</div>

                  </div>
              </div>
          <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
                  <div class="bg-white shadow-md rounded-md p-4">
                    <div class="flex items-center justify-center w-full">
                          <img src="{{ asset('assets/images/Placement.svg') }}" class="w-10">
                      
                      </div>
                      <div class="flex items-center mt-3 justify-center w-full">
                       
                          <p class="font-semibold text-brand text-xs">Placement Completed </p>
                      </div>
                      <div class="w-full max-w-md mt-2">
  <div class="flex justify-between text-sm font-medium text-gray-700 mb-1">
    <span class="font-medium text-brand text-xs">3142</span>
    <span class="font-medium text-brand text-xs">80%</span>
  </div>
  <div class="w-full bg-gray-200 rounded-full h-1 overflow-hidden">
    <div class="bg-[#00AB03] h-1 rounded-full" style="width: 80%;"></div>
  </div>
</div>

                  </div>
              </div>
          </div>



  <div class=" rounded-xl p-2 flex flex-col md:flex-row gap-6 w-full max-w-6xl">

    <!-- 📊 LEFT: Line Chart -->
    <div class="bg-white rounded-lg p-3 flex-1 shadow-sm">
      <div class="flex justify-between items-center mb-3">
        <h2 class="font-semibold text-sm text-brand">Students Referral Outcome</h2>
        <button class="border border-gold text-dark text-xs px-3 py-1 rounded-md">
          This Month
        </button>
      </div>

      <canvas id="lineChart" height="100"></canvas>

      <div class="flex justify-center gap-6 mt-4 text-sm">
        <div class="flex items-center font-semibold text-brand text-xs gap-2">
          <span class="w-3 h-3 bg-green-500 rounded-full"></span> Hired
        </div>
        <div class="flex items-center font-semibold text-brand text-xs gap-2">
          <span class="w-3 h-3 bg-blue-500 rounded-full"></span> Pending
        </div>
        <div class="flex items-center font-semibold text-brand text-xs gap-2">
          <span class="w-3 h-3 bg-red-500 rounded-full"></span> Rejected
        </div>
      </div>
    </div>

<div class="bg-[#d4b373] rounded-lg flex flex-col items-center justify-center p-6 w-full md:w-1/3">
  <h3 class="font-semibold text-sm text-brand  mb-3">Target vs Achieved</h3>
  <div class="relative w-52 h-52 flex items-center justify-center">
    <canvas id="gaugeChart"></canvas>
    <div class="absolute inset-0 flex flex-col items-center justify-center translate-y-6">
      <p id="gaugeValue" class="text-xl font-bold text-brand">0%</p>
      <p class="font-semibold text-sm text-brand">achieved</p>
    </div>
  </div>
</div>


  </div>
       
        
      <div class="flex flex-wrap">
                         <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/3 p-3">
                  <div class="bg-white shadow-md  rounded-md p-4">
                      <!-- RIGHT: User Info + Profile -->
                      <div class="flex  items-center w-full pb-2 border-b border-mycolr gap-3">
                          <div class="">
                             <img src="{{ asset('assets/images/realestate.svg') }}" class="w-10 " />
                          </div>
                          <div class="text-left ">
                              <p class="font-semibold text-sm"> Real Estate</p>
                              <p class="text-xs text-gray-500">info@techsoft.com</p>
                          </div>

                      </div>
                      <div class="w-full mt-3">
                          <p class="flex items-center font-medium text-brand text-xs"><img
                                  src="{{ asset('assets/images/location.svg') }}" class="w-3 me-3">Sydney, Australia</p>
                          <p class="flex items-center font-medium text-brand text-xs mt-2"><img
                                  src="{{ asset('assets/images/beeg.svg') }}" class="w-3 me-3">Full Time and Part time Available</p>
                      </div>
                    
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
                          <p class="flex items-center font-medium text-brand text-xs"><img
                                  src="{{ asset('assets/images/location.svg') }}" class="w-3 me-3">Brisbane, Australia</p>
                          <p class="flex items-center font-medium text-brand text-xs mt-2"><img
                                  src="{{ asset('assets/images/beeg.svg') }}" class="w-3 me-3">Only Full Time</p>
                      </div>
                
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
      <script>
    // 📈 Line Chart
    const ctx = document.getElementById('lineChart');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [
          {
            label: 'Hired',
            data: [15, 18, 13, 20, 17, 23, 19],
            borderColor: '#22c55e',
            tension: 0.4,
            fill: false
          },
          {
            label: 'Pending',
            data: [8, 12, 17, 14, 25, 30, 20],
            borderColor: '#2563eb',
            tension: 0.4,
            fill: false
          },
          {
            label: 'Rejected',
            data: [5, 9, 11, 13, 9, 7, 10],
            borderColor: '#ef4444',
            tension: 0.4,
            fill: false
          }
        ]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
          y: {
            beginAtZero: true,
            grid: { color: '#eee' },
            ticks: { stepSize: 5 }
          },
          x: {
            grid: { display: false }
          }
        }
      }
    });
 const gaugeCtx = document.getElementById('gaugeChart');
  const valueEl = document.getElementById('gaugeValue');

  // 🕹️ Gauge Chart (No white circles)
  const gaugeChart = new Chart(gaugeCtx, {
    type: 'doughnut',
    data: {
      datasets: [{
        data: [0, 100], // start from 0%
        backgroundColor: ['#ffffff', '#000000'], // white fill, black base
        borderWidth: 0,
        cutout: '70%', // thickness
        circumference: 180,
        rotation: 270
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        tooltip: { enabled: false }
      },
      animation: {
        duration: 2000,
        easing: 'easeOutQuart',
        onProgress(animation) {
          const progress = Math.round((animation.currentStep / animation.numSteps) * 80);
          valueEl.textContent = progress + '%';
          gaugeChart.data.datasets[0].data = [progress, 100 - progress];
          gaugeChart.update('none');
        }
      }
    }
  });

  // 🔥 Trigger smooth fill to 80%
  setTimeout(() => {
    gaugeChart.data.datasets[0].data = [80, 20];
    gaugeChart.update();
  }, 100);
  </script>
      @endsection
