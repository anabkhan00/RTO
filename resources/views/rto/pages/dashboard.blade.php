      @extends('rto.master_layout.index')
      @section('content')
          <div class="w-full p-3 flex gap-6">
              <!-- Total Students Card -->
              <a href="/rto/students" class="block flex-1">
                  <div class="w-full bg-white rounded-lg h-48 shadow p-4 flex flex-col items-center justify-center">
                      <div class="flex items-center justify-center">
                          <img src="{{ asset('assets/images/stucomp.svg') }}" class="w-10">
                      </div>
                      <div class="flex flex-col items-center mt-3">
                          <p class="font-semibold text-brand text-xs">Total Students</p>
                      </div>
                      <div class="w-full max-w-xs mt-3">
                          <div class="flex justify-between text-sm font-medium text-gray-700 mb-1">
                              <span class="font-medium text-brand text-xs">43,234</span>
                              <span class="font-medium text-brand text-xs">80%</span>
                          </div>
                          <div class="w-full bg-gray-200 rounded-full h-1 overflow-hidden">
                              <div class="bg-[#0014AB] h-1 rounded-full" style="width: 80%;"></div>
                          </div>
                      </div>
                  </div>

                  <!-- Completed Placements Card -->
                  <div class="w-full bg-white rounded-lg h-48 shadow p-4 flex flex-col items-center justify-center mt-2">
                      <div class="flex items-center justify-center">
                          <img src="{{ asset('assets/images/Placement.svg') }}" class="w-10">
                      </div>
                      <div class="flex flex-col items-center mt-3">
                          <p class="font-semibold text-brand text-xs">Completed Placements</p>
                      </div>
                      <div class="w-full max-w-xs mt-3">
                          <div class="flex justify-between text-sm font-medium text-gray-700 mb-1">
                              <span class="font-medium text-brand text-xs">2,156</span>
                              <span class="font-medium text-brand text-xs">85%</span>
                          </div>
                          <div class="w-full bg-gray-200 rounded-full h-1 overflow-hidden">
                              <div class="bg-[#00AB03] h-1 rounded-full" style="width: 85%;"></div>
                          </div>
                      </div>
                  </div>
              </a>

              <!-- Overall Employee Performance Card -->
              <div class="bg-white rounded-lg shadow p-4 flex-1">
                  <div class="flex items-center justify-between mb-3">
                      <h2 class="font-semibold text-sm text-brand">Overall Employee Performance</h2>
                      <i class="bi bi-info-circle text-gray-400"></i>
                  </div>
                  <div class="text-right">
                      <p class="text-green-600 text-xs font-semibold">+13.38%</p>
                      <p class="text-gray-500 text-xs">past month</p>
                  </div>
                  <div class="flex justify-center items-center">
                      <!-- Chart Container -->
                      <div class="relative w-64 h-64">
                          <canvas id="radialChart"></canvas>
                          <div class="absolute inset-0 flex flex-col items-center justify-center">
                              <p class="text-2xl font-bold text-brand">32%</p>
                              <p class="text-sm text-gray-600">Avg</p>
                          </div>
                      </div>
                  </div>
              </div>
          </div>


          <div class="w-full flex flex-wrap">
              <!-- Active Placements -->
              <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
                  <a href="/rto/students?status=active" class="block">
                      <div class="bg-white shadow-md rounded-md p-4 hover:shadow-lg transition-shadow cursor-pointer">
                          <div class="flex items-center justify-center w-full">
                              <img src="{{ asset('assets/images/Started.svg') }}" class="w-10">
                          </div>
                          <div class="flex items-center mt-3 justify-center w-full">
                              <p class="font-semibold text-brand text-xs">Active Placements</p>
                          </div>
                          <div class="w-full max-w-md mt-2">
                              <div class="flex justify-between text-sm font-medium text-gray-700 mb-1">
                                  <span class="font-medium text-brand text-xs">1,245</span>
                                  <span class="font-medium text-brand text-xs">65%</span>
                              </div>
                              <div class="w-full bg-gray-200 rounded-full h-1 overflow-hidden">
                                  <div class="bg-[#00A8AB] h-1 rounded-full" style="width: 65%;"></div>
                              </div>
                          </div>
                      </div>
                  </a>
              </div>

              <!-- Booked Placements -->
              <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
                  <a href="/rto/students?status=booked" class="block">
                      <div class="bg-white shadow-md rounded-md p-4 hover:shadow-lg transition-shadow cursor-pointer">
                          <div class="flex items-center justify-center w-full">
                              <img src="{{ asset('assets/images/booked.svg') }}" class="w-10">
                          </div>
                          <div class="flex items-center mt-3 justify-center w-full">
                              <p class="font-semibold text-brand text-xs">Booked Placements</p>
                          </div>
                          <div class="w-full max-w-md mt-2">
                              <div class="flex justify-between text-sm font-medium text-gray-700 mb-1">
                                  <span class="font-medium text-brand text-xs">892</span>
                                  <span class="font-medium text-brand text-xs">45%</span>
                              </div>
                              <div class="w-full bg-gray-200 rounded-full h-1 overflow-hidden">
                                  <div class="bg-[#FBBF24] h-1 rounded-full" style="width: 45%;"></div>
                              </div>
                          </div>
                      </div>
                  </a>
              </div>

              <!-- Flagged Placements -->
              <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
                  <a href="/rto/students?status=flagged" class="block">
                      <div class="bg-white shadow-md rounded-md p-4 hover:shadow-lg transition-shadow cursor-pointer">
                          <div class="flex items-center justify-center w-full">
                              <img src="{{ asset('assets/images/flagged.svg') }}" class="w-10">
                          </div>
                          <div class="flex items-center mt-3 justify-center w-full">
                              <p class="font-semibold text-brand text-xs">Flagged Placements</p>
                          </div>
                          <div class="w-full max-w-md mt-2">
                              <div class="flex justify-between text-sm font-medium text-gray-700 mb-1">
                                  <span class="font-medium text-brand text-xs">67</span>
                                  <span class="font-medium text-brand text-xs">3%</span>
                              </div>
                              <div class="w-full bg-gray-200 rounded-full h-1 overflow-hidden">
                                  <div class="bg-[#D60404] h-1 rounded-full" style="width: 3%;"></div>
                              </div>
                          </div>
                      </div>
                  </a>
              </div>

              <!-- Awaiting Placements -->
              <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
                  <a href="/rto/students?status=awaiting" class="block">
                      <div class="bg-white shadow-md rounded-md p-4 hover:shadow-lg transition-shadow cursor-pointer">
                          <div class="flex items-center justify-center w-full">
                              <img src="{{ asset('assets/images/dashclock.svg') }}" class="w-10">
                          </div>
                          <div class="flex items-center mt-3 justify-center w-full">
                              <p class="font-semibold text-brand text-xs">Awaiting Placements</p>
                          </div>
                          <div class="w-full max-w-md mt-2">
                              <div class="flex justify-between text-sm font-medium text-gray-700 mb-1">
                                  <span class="font-medium text-brand text-xs">534</span>
                                  <span class="font-medium text-brand text-xs">25%</span>
                              </div>
                              <div class="w-full bg-gray-200 rounded-full h-1 overflow-hidden">
                                  <div class="bg-[#AB6C00] h-1 rounded-full" style="width: 25%;"></div>
                              </div>
                          </div>
                      </div>
                  </a>
              </div>
          </div>


          <div class="w-full p-3 flex gap-6">
              <!-- Overall Employee Performance Card -->
              <div class="bg-white rounded-lg shadow p-4 flex-1">
                  <div class="flex items-center justify-between mb-3">
                      <h2 class="font-semibold text-sm text-brand">Overall Employee Performance</h2>
                      <i class="bi bi-info-circle text-gray-400"></i>
                  </div>

                  <div class="text-right mb-4">
                      <p class="text-green-600 text-xs font-semibold">+8.24%</p>
                      <p class="text-gray-500 text-xs">past month</p>
                  </div>

                  <!-- Added spacing between all performance lines -->
                  <div class="space-y-4"> <!-- was space-y-3 -->
                      <div>
                          <div class="flex justify-between text-xs mb-2">
                              <span class="text-gray-700">Performance A</span>
                              <span class="font-medium text-brand">70%</span>
                          </div>
                          <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden"> <!-- slightly thicker -->
                              <div class="bg-[#D60404] h-1.5 rounded-full" style="width: 70%;"></div>
                          </div>
                      </div>

                      <div>
                          <div class="flex justify-between text-xs mb-2">
                              <span class="text-gray-700">Performance B</span>
                              <span class="font-medium text-brand">40%</span>
                          </div>
                          <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                              <div class="bg-[#FF8C00] h-1.5 rounded-full" style="width: 40%;"></div>
                          </div>
                      </div>

                      <div>
                          <div class="flex justify-between text-xs mb-2">
                              <span class="text-gray-700">Performance C</span>
                              <span class="font-medium text-brand">25%</span>
                          </div>
                          <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                              <div class="bg-[#FFD700] h-1.5 rounded-full" style="width: 25%;"></div>
                          </div>
                      </div>

                      <div>
                          <div class="flex justify-between text-xs mb-2">
                              <span class="text-gray-700">Performance D</span>
                              <span class="font-medium text-brand">15%</span>
                          </div>
                          <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                              <div class="bg-[#00A8AB] h-1.5 rounded-full" style="width: 15%;"></div>
                          </div>
                      </div>

                      <div>
                          <div class="flex justify-between text-xs mb-2">
                              <span class="text-gray-700">Performance E</span>
                              <span class="font-medium text-brand">90%</span>
                          </div>
                          <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                              <div class="bg-[#00AB03] h-1.5 rounded-full" style="width: 90%;"></div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>


          <div class="rounded-xl p-2 flex flex-col md:flex-row gap-6 w-full max-w-6xl">
              <!-- 📈 LEFT: Line Chart -->
              <div class="bg-white rounded-lg p-3 flex-1 shadow-sm">
                  <div class="flex justify-between items-center mb-3">
                      <h2 class="font-semibold text-sm text-brand">Students Referral Outcome</h2>
                      <button class="border border-gold text-dark text-xs px-3 py-1 rounded-md">
                          This Month
                      </button>
                  </div>

                  <canvas id="lineChart" height="100"></canvas>

                  <div class="flex justify-center gap-4 mt-4 text-xs flex-wrap">
                      <div class="flex items-center font-semibold text-brand gap-2">
                          <span class="w-3 h-3 bg-[#0014AB] rounded-full"></span> In Progress
                      </div>
                      <div class="flex items-center font-semibold text-brand gap-2">
                          <span class="w-3 h-3 bg-[#D60404] rounded-full"></span> Agreement Pending
                      </div>
                      <div class="flex items-center font-semibold text-brand gap-2">
                          <span class="w-3 h-3 bg-[#00AB03] rounded-full"></span> Workplace Started
                      </div>
                      <div class="flex items-center font-semibold text-brand gap-2">
                          <span class="w-3 h-3 bg-[#000000] rounded-full"></span> Don't Have Workplace
                      </div>
                      <div class="flex items-center font-semibold text-brand gap-2">
                          <span class="w-3 h-3 bg-[#00A8AB] rounded-full"></span> Appointment
                      </div>
                  </div>
              </div>


          </div>



          <!-- Students Table Section -->
          <div class="w-full mt-6">
              <div class="bg-white rounded-lg shadow-sm p-6">
                  <h2 class="text-lg font-semibold text-brand mb-4">Students Overview</h2>

                  <!-- Filters -->
                  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                      <div>
                          <input type="text" id="dashSearchFilter" placeholder="Search by name or email..."
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                      </div>
                      <div>
                          <select id="dashProgressFilter"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                              <option value="">All Progress</option>
                              <option value="Assigned">Assigned</option>
                              <option value="Interview">Interview</option>
                              <option value="Placed">Placed</option>
                          </select>
                      </div>
                      <div>
                          <select id="dashIndustryFilter"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                              <option value="">All Industries</option>
                              <option value="Healthcare">Healthcare</option>
                              <option value="Tech">Tech</option>
                              <option value="Marketing">Marketing</option>
                          </select>
                      </div>
                      <div>
                          <button id="dashResetFilters"
                              class="w-full bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors text-sm">
                              Reset Filters
                          </button>
                      </div>
                  </div>

                  <!-- Table -->
                  <div class="overflow-x-auto">
                      <table id="dashStudentsDataTable" class="min-w-full" style="table-layout: fixed;">
                          <colgroup>
                              <col style="width: 20%;">
                              <col style="width: 18%;">
                              <col style="width: 22%;">
                              <col style="width: 15%;">
                              <col style="width: 12%;">
                              <col style="width: 13%;">
                          </colgroup>
                          <thead class="bg-gray-50">
                              <tr>
                                  <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Name</th>
                                  <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Industry</th>
                                  <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Email</th>
                                  <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Phone</th>
                                  <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Progress</th>
                                  <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Coordinator</th>
                              </tr>
                          </thead>
                          <tbody class="bg-white divide-y divide-gray-200">
                              <!-- Data will be populated by DataTables -->
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>

          <!-- Student Location Map -->
          <div class="w-full mt-6">
              <div class="bg-white rounded-lg p-4 shadow-sm">
                  <h2 class="font-semibold text-sm text-brand mb-4">Student Placement Locations</h2>
                  <div id="map" class="w-full h-96 rounded-lg"></div>
                  <div class="flex justify-center gap-6 mt-4 text-sm">
                      <div class="flex items-center font-semibold text-brand text-xs gap-2">
                          <span class="w-3 h-3 bg-[#00A8AB] rounded-full"></span> Active Placements
                      </div>
                      <div class="flex items-center font-semibold text-brand text-xs gap-2">
                          <span class="w-3 h-3 bg-[#00AB03] rounded-full"></span> Completed Placements
                      </div>
                  </div>
              </div>
          </div>

          <style>
              /* DataTables styling */
              #dashStudentsDataTable_wrapper .dataTables_paginate .paginate_button {
                  padding: 0.25rem 0.75rem;
                  margin: 0 0.125rem;
                  border-radius: 0.375rem;
                  background-color: #e5e7eb;
                  color: #374151;
                  border: none;
              }
              #dashStudentsDataTable_wrapper .dataTables_paginate .paginate_button:hover {
                  background-color: #d1d5db;
              }
              #dashStudentsDataTable_wrapper .dataTables_paginate .paginate_button.current {
                  background-color: var(--brand);
                  color: white;
              }
              #dashStudentsDataTable tbody tr:hover {
                  background-color: #f9fafb;
              }
          </style>
          <script>
              // 📈 Line Chart
              const ctx = document.getElementById('lineChart');
              new Chart(ctx, {
                  type: 'line',
                  data: {
                      labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                      datasets: [{
                              label: 'In Progress',
                              data: [25, 28, 23, 30, 27, 33, 29],
                              borderColor: '#0014AB',
                              tension: 0.4,
                              fill: false
                          },
                          {
                              label: 'Agreement Pending',
                              data: [5, 7, 4, 8, 6, 9, 7],
                              borderColor: '#D60404',
                              tension: 0.4,
                              fill: false
                          },
                          {
                              label: 'Workplace Started',
                              data: [2, 3, 1, 4, 2, 5, 3],
                              borderColor: '#00AB03',
                              tension: 0.4,
                              fill: false
                          },
                          {
                              label: 'Don\'t Have Workplace',
                              data: [1, 1, 0, 2, 1, 2, 1],
                              borderColor: '#000000',
                              tension: 0.4,
                              fill: false
                          },
                          {
                              label: 'Appointment',
                              data: [3, 4, 2, 5, 3, 6, 4],
                              borderColor: '#00A8AB',
                              tension: 0.4,
                              fill: false
                          }
                      ]
                  },
                  options: {
                      responsive: true,
                      plugins: {
                          legend: {
                              display: false
                          }
                      },
                      scales: {
                          y: {
                              beginAtZero: true,
                              grid: {
                                  color: '#eee'
                              },
                              ticks: {
                                  stepSize: 5
                              }
                          },
                          x: {
                              grid: {
                                  display: false
                              }
                          }
                      }
                  }
              });
              // Dashboard Students DataTable
              const dashStudentsData = [
                  ['Nicole Wegmann', 'Healthcare Solutions', 'nicole.wegmann@email.com', '+92-300-1234567', 'Assigned', 'Zain'],
                  ['Chenoa Dick', 'Tech Innovations', 'chenoa.dick@email.com', '+92-301-2345678', 'Interview', 'Bilal'],
                  ['Amanda Hinds', 'Digital Marketing', 'amanda.hinds@email.com', '+92-302-3456789', 'Placed', 'Nico'],
                  ['Emma Nightwork', 'Healthcare Solutions', 'emma.nightwork@email.com', '+92-303-4567890', 'Interview', 'Melanie'],
                  ['Sarah Johnson', 'Tech Innovations', 'sarah.johnson@email.com', '+92-304-5678901', 'Assigned', 'Ahmed'],
                  ['Michael Brown', 'Creative Studios', 'michael.brown@email.com', '+92-305-6789012', 'Interview', 'Fatima'],
                  ['Lisa Wilson', 'Healthcare Solutions', 'lisa.wilson@email.com', '+92-306-7890123', 'Placed', 'Hassan'],
                  ['David Miller', 'Digital Marketing', 'david.miller@email.com', '+92-307-8901234', 'Interview', 'Ayesha'],
                  ['Jennifer Davis', 'Tech Innovations', 'jennifer.davis@email.com', '+92-308-9012345', 'Assigned', 'Omar'],
                  ['Robert Garcia', 'Creative Studios', 'robert.garcia@email.com', '+92-309-0123456', 'Interview', 'Zara'],
                  ['Maria Rodriguez', 'Healthcare Solutions', 'maria.rodriguez@email.com', '+92-310-1234567', 'Placed', 'Usman'],
                  ['James Wilson', 'Tech Innovations', 'james.wilson@email.com', '+92-311-2345678', 'Assigned', 'Hina'],
                  ['Anna Thompson', 'Digital Marketing', 'anna.thompson@email.com', '+92-312-3456789', 'Interview', 'Tariq'],
                  ['Mark Anderson', 'Creative Studios', 'mark.anderson@email.com', '+92-313-4567890', 'Placed', 'Nadia'],
                  ['Sophie Martin', 'Healthcare Solutions', 'sophie.martin@email.com', '+92-314-5678901', 'Assigned', 'Kamran']
              ];

              // Initialize DataTable
              const table = $('#dashStudentsDataTable').DataTable({
                  data: dashStudentsData,
                  pageLength: 10,
                  scrollX: true,
                  columnDefs: [
                      {
                          targets: 0,
                          render: function(data, type, row) {
                              return `<div class="flex items-center">
                                  <div class="h-8 w-8 rounded-full bg-brand flex items-center justify-center text-white font-semibold text-xs mr-3">
                                      ${data.charAt(0)}
                                  </div>
                                  <span class="text-sm font-medium text-gray-900">${data}</span>
                              </div>`;
                          }
                      },
                      {
                          targets: 4,
                          render: function(data, type, row) {
                              const colorClass = data === 'Assigned' ? 'bg-gray-100 text-gray-800' :
                                               data === 'Interview' ? 'bg-orange-100 text-orange-800' :
                                               'bg-green-100 text-green-800';
                              return `<span class="inline-flex px-2 py-1 text-xs font-medium rounded-full ${colorClass}">${data}</span>`;
                          }
                      }
                  ],
                  dom: 'rt<"flex items-center justify-between mt-4"<"text-sm text-gray-700"i><"flex gap-2"p>>',
                  language: {
                      info: 'Showing _START_ to _END_ of _TOTAL_ results',
                      paginate: {
                          previous: 'Previous',
                          next: 'Next'
                      }
                  }
              });

              // Custom filtering
              $('#dashSearchFilter').on('keyup', function() {
                  table.search(this.value).draw();
              });

              $('#dashProgressFilter').on('change', function() {
                  table.column(4).search(this.value).draw();
              });

              $('#dashIndustryFilter').on('change', function() {
                  table.column(1).search(this.value).draw();
              });

              $('#dashResetFilters').on('click', function() {
                  $('#dashSearchFilter').val('');
                  $('#dashProgressFilter').val('');
                  $('#dashIndustryFilter').val('');
                  table.search('').columns().search('').draw();
              });

              // 🗺️ Initialize Google Map
              function initMap() {
                  const map = new google.maps.Map(document.getElementById('map'), {
                      zoom: 6,
                      center: {
                          lat: -25.274398,
                          lng: 133.775136
                      }, // Australia center
                      styles: [{
                              featureType: 'all',
                              elementType: 'geometry.fill',
                              stylers: [{
                                  color: '#f5f5f5'
                              }]
                          },
                          {
                              featureType: 'water',
                              elementType: 'geometry',
                              stylers: [{
                                  color: '#e9e9e9'
                              }]
                          }
                      ]
                  });

                  // Student locations (dummy data)
                  const students = [{
                          lat: -33.8688,
                          lng: 151.2093,
                          type: 'active',
                          name: 'John Smith'
                      }, // Sydney
                      {
                          lat: -37.8136,
                          lng: 144.9631,
                          type: 'completed',
                          name: 'Sarah Johnson'
                      }, // Melbourne
                      {
                          lat: -27.4698,
                          lng: 153.0251,
                          type: 'active',
                          name: 'Mike Wilson'
                      }, // Brisbane
                      {
                          lat: -31.9505,
                          lng: 115.8605,
                          type: 'completed',
                          name: 'Emma Davis'
                      }, // Perth
                      {
                          lat: -34.9285,
                          lng: 138.6007,
                          type: 'active',
                          name: 'Chris Brown'
                      }, // Adelaide
                      {
                          lat: -42.8821,
                          lng: 147.3272,
                          type: 'completed',
                          name: 'Lisa Garcia'
                      }, // Hobart
                      {
                          lat: -12.4634,
                          lng: 130.8456,
                          type: 'active',
                          name: 'David Miller'
                      }, // Darwin
                      {
                          lat: -35.2809,
                          lng: 149.1300,
                          type: 'completed',
                          name: 'Anna Wilson'
                      }, // Canberra
                      {
                          lat: -23.6980,
                          lng: 133.8807,
                          type: 'active',
                          name: 'Tom Anderson'
                      }, // Alice Springs
                      {
                          lat: -19.2590,
                          lng: 146.8169,
                          type: 'completed',
                          name: 'Maria Rodriguez'
                      } // Townsville
                  ];

                  // Add markers for each student
                  students.forEach(student => {
                      const marker = new google.maps.Marker({
                          position: {
                              lat: student.lat,
                              lng: student.lng
                          },
                          map: map,
                          title: `${student.name} - ${student.type}`,
                          icon: {
                              path: google.maps.SymbolPath.CIRCLE,
                              scale: 8,
                              fillColor: student.type === 'active' ? '#00A8AB' : '#00AB03',
                              fillOpacity: 0.8,
                              strokeColor: '#ffffff',
                              strokeWeight: 2
                          },
                          animation: google.maps.Animation.BOUNCE
                      });

                      // Stop bouncing after 2 seconds
                      setTimeout(() => {
                          marker.setAnimation(null);
                      }, 2000);

                      // Add info window
                      const infoWindow = new google.maps.InfoWindow({
                          content: `<div class="p-2"><strong>${student.name}</strong><br>Status: ${student.type}</div>`
                      });

                      marker.addListener('click', () => {
                          infoWindow.open(map, marker);
                      });
                  });
              }

              // Load Google Maps API and initialize
              function loadGoogleMaps() {
                  const script = document.createElement('script');
                  script.src = 'https://maps.googleapis.com/maps/api/js?callback=initMap';
                  script.async = true;
                  script.defer = true;
                  document.head.appendChild(script);
              }

              // Initialize map when page loads
              setTimeout(loadGoogleMaps, 500);


              // Radial Progress Chart (Multi-layered)
              const radialCtx = document.getElementById('radialChart');
              new Chart(radialCtx, {
                  type: 'doughnut',
                  data: {
                      datasets: [{
                              data: [70, 30],
                              backgroundColor: ['#D60404', '#f5f5f5'],
                              cutout: '85%',
                              borderWidth: 0
                          },
                          {
                              data: [40, 60],
                              backgroundColor: ['#FBBF24', '#f5f5f5'],
                              cutout: '75%',
                              borderWidth: 0
                          },
                          {
                              data: [25, 75],
                              backgroundColor: ['#FCD34D', '#f5f5f5'],
                              cutout: '65%',
                              borderWidth: 0
                          },
                          {
                              data: [15, 85],
                              backgroundColor: ['#00A8AB', '#f5f5f5'],
                              cutout: '55%',
                              borderWidth: 0
                          },
                          {
                              data: [90, 10],
                              backgroundColor: ['#00AB03', '#f5f5f5'],
                              cutout: '45%',
                              borderWidth: 0
                          }
                      ]
                  },
                  options: {
                      responsive: true,
                      maintainAspectRatio: false, // ⚠️ allow flexible resizing
                      plugins: {
                          legend: {
                              display: false
                          },
                          tooltip: {
                              enabled: false
                          }
                      },
                      rotation: -90,
                      animation: {
                          duration: 2000,
                          easing: 'easeOutQuart'
                      }
                  }
              });
          </script>
      @endsection
