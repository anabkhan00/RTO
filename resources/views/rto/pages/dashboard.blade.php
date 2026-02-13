      @extends('rto.master_layout.index')
      @section('page-title', 'Dashboard')
      @section('content')
          <div class="w-full p-3 flex flex-nowrap gap-6">
              <!-- Total Students Card -->
              <div class="flex-1">
                  <a href="/rto/students" class="block flex-1 hover:shadow-lg transition-shadow cursor-pointer">
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
                  </a>

                  {{-- <a href="/rto/students?status=completed" class="block flex-1"> --}}
                  <a href="#" class="block flex-1 hover:shadow-lg transition-shadow cursor-pointer">
                      <!-- Completed Placements Card -->
                      <div
                          class="w-full bg-white rounded-lg h-48 shadow p-4 flex flex-col items-center justify-center mt-2">
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
              </div>
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
                  {{-- <a href="/rto/students?status=active" class="block"> --}}
                  <a href="#" class="block">
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
                  {{-- <a href="/rto/students?status=booked" class="block"> --}}
                  <a href="#" class="block">
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
                  {{-- <a href="/rto/students?status=flagged" class="block"> --}}
                  <a href="#" class="block">
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
                  {{-- <a href="/rto/students?status=awaiting" class="block"> --}}
                  <a href="#" class="block">
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

                  <!-- Placement Performance Lines -->
                  <div class="space-y-4">
                      <div>
                          <div class="flex justify-between text-xs mb-2">
                              <span class="text-gray-700">Completed Placements</span>
                              <span class="font-medium text-brand">85%</span>
                          </div>
                          <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                              <div class="bg-[#00AB03] h-1.5 rounded-full" style="width: 85%;"></div>
                          </div>
                      </div>

                      <div>
                          <div class="flex justify-between text-xs mb-2">
                              <span class="text-gray-700">Active Placements</span>
                              <span class="font-medium text-brand">65%</span>
                          </div>
                          <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                              <div class="bg-[#00A8AB] h-1.5 rounded-full" style="width: 65%;"></div>
                          </div>
                      </div>

                      <div>
                          <div class="flex justify-between text-xs mb-2">
                              <span class="text-gray-700">Booked Placements</span>
                              <span class="font-medium text-brand">45%</span>
                          </div>
                          <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                              <div class="bg-[#FBBF24] h-1.5 rounded-full" style="width: 45%;"></div>
                          </div>
                      </div>

                      <div>
                          <div class="flex justify-between text-xs mb-2">
                              <span class="text-gray-700">Awaiting Placements</span>
                              <span class="font-medium text-brand">25%</span>
                          </div>
                          <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                              <div class="bg-[#AB6C00] h-1.5 rounded-full" style="width: 25%;"></div>
                          </div>
                      </div>

                      <div>
                          <div class="flex justify-between text-xs mb-2">
                              <span class="text-gray-700">Flagged Placements</span>
                              <span class="font-medium text-brand">3%</span>
                          </div>
                          <div class="w-full bg-gray-200 rounded-full h-1.5 overflow-hidden">
                              <div class="bg-[#D60404] h-1.5 rounded-full" style="width: 3%;"></div>
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
                      <button class="border border-gold text-dark text-xs px-3 py-1.5 rounded-md font-medium">
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
              <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                  <div class="p-4 border-b border-gray-200">
                      <h2 class="text-lg font-semibold text-brand">Students Overview</h2>
                  </div>
                  <div class="p-4">

                      <!-- Filter Section -->
                      <div class="mb-6">
                          <div class="border-b border-gray-200 pb-4">
                              <button id="dashToggleFilters" class="flex items-center justify-between w-full text-left">
                                  <h3 class="text-lg font-semibold text-gray-800">Filters</h3>
                                  <i id="dashFilterIcon"
                                      class="bi bi-chevron-down text-gray-500 transition-transform"></i>
                              </button>
                          </div>
                          <div id="dashFilterContent" class="hidden pt-4">
                              <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                  <div>
                                      <input type="text" id="dashSearchFilter"
                                          placeholder="Search by name or email..."
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
                                          class="bg-gray-500 text-white text-xs px-3 py-1.5 rounded-md hover:bg-gray-600 transition-colors font-medium">
                                          Reset Filters
                                      </button>
                                  </div>
                              </div>
                          </div>
                      </div>

                  </div>
                  <!-- Table -->
                  <div class="overflow-x-auto">
                      <table id="studentsTable" class="min-w-full">
                          <thead class="bg-gray-50">
                              <tr>
                                  <th
                                      class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                                      Name</th>
                                  {{-- <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            RTO</th> --}}
                                  <th
                                      class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                                      Industry</th>
                                  {{-- <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Sectors</th> --}}
                                  {{-- <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Email</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Phone</th> --}}
                                  <th
                                      class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                                      Course</th>
                                  <th
                                      class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                                      Days Left</th>
                                  <th
                                      class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                                      Progress</th>
                                  {{-- <th
                                      class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                                      Address</th> --}}
                                  {{-- <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Assign Coordinator</th> --}}
                                  <th
                                      class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                                      Created At</th>
                                  <th
                                      class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                                      Actions</th>
                              </tr>
                          </thead>
                          <tbody class="bg-white divide-y divide-gray-200">
                              @foreach ($students as $index => $student)
                                  <tr class="hover:bg-gray-50 transition-colors cursor-pointer"
                                      onclick="window.location.href='{{ route('rto.student-documents.index', $student->id) }}'">
                                      <!-- Name with Priority Badge -->
                                      <td class="px-4 py-3 whitespace-nowrap">
                                          <span class="text-sm font-semibold text-gray-900">
                                              {{ $student->name }}
                                          </span>
                                      </td>
                                      <!-- RTO -->
                                      {{-- <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{ $student->rto_number ?? '-----' }}</td> --}}
                                      <!-- Industry -->

                                      
                                      @php
                                          // Pastel color palette
                                          $palette = [
                                              [
                                                  'bg' => 'bg-blue-50',
                                                  'text' => 'text-blue-700',
                                                  'border' => 'border-blue-100',
                                              ],
                                              [
                                                  'bg' => 'bg-purple-50',
                                                  'text' => 'text-purple-700',
                                                  'border' => 'border-purple-100',
                                              ],
                                              [
                                                  'bg' => 'bg-emerald-50',
                                                  'text' => 'text-emerald-700',
                                                  'border' => 'border-emerald-100',
                                              ],
                                              [
                                                  'bg' => 'bg-orange-50',
                                                  'text' => 'text-orange-700',
                                                  'border' => 'border-orange-100',
                                              ],
                                              [
                                                  'bg' => 'bg-pink-50',
                                                  'text' => 'text-pink-700',
                                                  'border' => 'border-pink-100',
                                              ],
                                              [
                                                  'bg' => 'bg-indigo-50',
                                                  'text' => 'text-indigo-700',
                                                  'border' => 'border-indigo-100',
                                              ],
                                              [
                                                  'bg' => 'bg-teal-50',
                                                  'text' => 'text-teal-700',
                                                  'border' => 'border-teal-100',
                                              ],
                                              [
                                                  'bg' => 'bg-cyan-50',
                                                  'text' => 'text-cyan-700',
                                                  'border' => 'border-cyan-100',
                                              ],
                                          ];

                                          // Progress status mapping
                                          $progressColors = [
                                              'Assigned' => [
                                                  'bg' => 'bg-gray-50',
                                                  'text' => 'text-gray-700',
                                                  'border' => 'border-gray-100',
                                              ],
                                              'Interview' => [
                                                  'bg' => 'bg-orange-50',
                                                  'text' => 'text-orange-700',
                                                  'border' => 'border-orange-100',
                                              ],
                                              'Placed' => [
                                                  'bg' => 'bg-emerald-50',
                                                  'text' => 'text-emerald-700',
                                                  'border' => 'border-emerald-100',
                                              ],
                                              'Completed' => [
                                                  'bg' => 'bg-indigo-50',
                                                  'text' => 'text-indigo-700',
                                                  'border' => 'border-indigo-100',
                                              ],
                                          ];

                                          // Days left color logic
                                          $daysLeft = rand(10, 300);
                                          $daysColor =
                                              $daysLeft > 150
                                                  ? [
                                                      'bg' => 'bg-emerald-50',
                                                      'text' => 'text-emerald-700',
                                                      'border' => 'border-emerald-100',
                                                  ]
                                                  : ($daysLeft >= 30
                                                      ? [
                                                          'bg' => 'bg-orange-50',
                                                          'text' => 'text-orange-700',
                                                          'border' => 'border-orange-100',
                                                      ]
                                                      : [
                                                          'bg' => 'bg-red-50',
                                                          'text' => 'text-red-700',
                                                          'border' => 'border-red-100',
                                                      ]);

                                          // Dynamic assignments
                                          $industry = $student->industry ?? 'Healthcare';
                                          $courseName = $student->course->name ?? 'No Course';
                                          $progress = 'Completed';

                                          $industryColor = $palette[abs(crc32($industry)) % count($palette)];
                                          $courseColor = $palette[abs(crc32($courseName)) % count($palette)];
                                          $progressColor = $progressColors[$progress] ?? $palette[6];
                                      @endphp

                                      <td class="px-4 py-3 whitespace-nowrap">
                                          <span
                                              class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full {{ $industryColor['bg'] }} {{ $industryColor['text'] }} {{ $industryColor['border'] }} border shadow-sm">
                                              {{ $industry }}
                                          </span>
                                      </td>
                                      <!-- Sectors -->
                                      {{-- <td class="px-4 py-3 whitespace-nowrap">
                            <a href="#" class="text-brand hover:text-gold text-sm font-medium">
                                VIEW / EDIT
                                <i class="bi bi-layers ml-1"></i>
                            </a>
                        </td> --}}
                                      <!-- Email -->
                                      {{-- <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{ $student->email }}</td>
                        <!-- Phone -->
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{ $student->phone ?? '-----' }}
                        </td> --}}
                                      <!-- Course -->

                                      <td class="px-4 py-3 whitespace-nowrap">
                                          <span
                                              class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full {{ $courseColor['bg'] }} {{ $courseColor['text'] }} {{ $courseColor['border'] }} border shadow-sm">
                                              {{ $courseName }}
                                          </span>
                                      </td>

                                      <!-- Days Left -->
                                      <td class="px-4 py-3 whitespace-nowrap">
                                          <span
                                              class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full {{ $daysColor['bg'] }} {{ $daysColor['text'] }} {{ $daysColor['border'] }} border shadow-sm">
                                              @if ($daysLeft > 150)
                                              @elseif($daysLeft >= 30)
                                              @else
                                              @endif
                                              {{ $daysLeft }} Days left
                                          </span>
                                      </td>

                                      <!-- Progress -->
                                      <td class="px-4 py-3 whitespace-nowrap">
                                          <span
                                              class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full {{ $progressColor['bg'] }} {{ $progressColor['text'] }} {{ $progressColor['border'] }} border shadow-sm">
                                              <i class="bi bi-person mr-1"></i>
                                              {{ $progress }}
                                          </span>
                                      </td>
                                      <!-- Address -->
                                      {{-- <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                      {{ $student->address ?? '-----' }}</td> --}}
                                      <!-- Assign Coordinator -->
                                      {{-- <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="text-sm text-gray-900 mr-2">Admin</span>
                                <a href="#" class="text-brand hover:text-gold text-xs font-medium">change</a>
                            </div>
                        </td> --}}
                                      <!-- Created At -->
                                      <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                          {{ $student->created_at->format('j M Y') }}</td>
                                      <!-- Actions -->
                                      <td class="px-4 py-3 whitespace-nowrap text-sm font-medium"
                                          onclick="event.stopPropagation()">
                                          <div class="relative">
                                              <button onclick="toggleDropdown({{ $index }})"
                                                  class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">
                                                  <i class="bi bi-three-dots-vertical"></i>
                                              </button>
                                              <div id="dropdown-{{ $index }}"
                                                  class="hidden absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg z-10 border">
                                                  <a href="#" onclick="deleteStudent({{ $student->id }})"
                                                      class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md">
                                                      <i class="bi bi-trash mr-2"></i>Delete
                                                  </a>
                                              </div>
                                          </div>
                                      </td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>

          <!-- Map Section -->
          <div class="bg-white rounded-lg shadow-sm p-6 mb-6 mt-6">
              <div class="flex justify-between items-center mb-4">
                  <h2 class="text-lg font-semibold text-brand">Students & Industries Map</h2>
                  <div class="flex gap-2">
                      <button id="toggleStudents" class="bg-blue-500 text-white text-xs px-3 py-1.5 rounded-md hover:bg-blue-600 transition-colors">
                          <i class="bi bi-people mr-1"></i>Students
                      </button>
                      <button id="toggleIndustries" class="bg-green-500 text-white text-xs px-3 py-1.5 rounded-md hover:bg-green-600 transition-colors">
                          <i class="bi bi-building mr-1"></i>Industries
                      </button>
                  </div>
              </div>
              <div id="placementMap" class="w-full h-[500px] rounded-xl shadow-lg border border-gray-200"></div>
              <div class="mt-3 flex items-center justify-between">
                  <div class="flex gap-4 text-xs text-gray-600">
                      <div class="flex items-center">
                          <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                          <span>Assigned Students ({{ $mapStudents?->count() ?? 0 }})</span>
                      </div>
                      <div class="flex items-center">
                          <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                          <span>Industries ({{ $mapIndustries?->count() ?? 0 }})</span>
                      </div>
                  </div>
                  <p class="text-xs text-gray-500">Click markers for details</p>
              </div>
          </div>

          <style>
              /* DataTables styling */
              .dataTables_wrapper .dataTables_paginate .paginate_button {
                  padding: 0.25rem 0.75rem;
                  margin: 0 0.125rem;
                  border-radius: 0.375rem;
                  background-color: #e5e7eb;
                  color: #374151;
                  border: none;
              }

              .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
                  background-color: #d1d5db;
              }

              .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                  background-color: var(--brand);
                  color: white;
              }

              .dataTables_wrapper .dataTables_paginate {
                  text-align: right;
              }
          </style>
          <script>
              // Line Chart
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
                              label: "Don't Have Workplace",
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
              // Initialize DataTable
              const table = $('#studentsTable').DataTable({
                  "pageLength": 25,
                  "searching": false,
                  "ordering": true,
                  "info": false,
                  "lengthChange": false,
                  "columnDefs": [{
                      "orderable": false,
                      "targets": [6]
                  }],
                  "dom": 'rt<"flex justify-end mt-4"p>',
                  "scrollX": true
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

              // Dashboard dropdown toggle
              function toggleDropdown(index) {
                  const dropdown = document.getElementById(`dropdown-${index}`);
                  const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');

                  allDropdowns.forEach(dd => {
                      if (dd !== dropdown) {
                          dd.classList.add('hidden');
                      }
                  });

                  dropdown.classList.toggle('hidden');
              }

              document.addEventListener('click', (e) => {
                  if (!e.target.closest('[onclick^="toggleDropdown"]')) {
                      const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');
                      allDropdowns.forEach(dd => dd.classList.add('hidden'));
                  }
              });

              // Dashboard filter toggle functionality
              document.getElementById('dashToggleFilters').addEventListener('click', function() {
                  const filterContent = document.getElementById('dashFilterContent');
                  const filterIcon = document.getElementById('dashFilterIcon');

                  filterContent.classList.toggle('hidden');
                  filterIcon.classList.toggle('rotate-180');
              });

              function initPlacementMap() {
                  if (typeof google === 'undefined' || !google.maps) {
                      console.warn('Google Maps API not loaded');
                      return;
                  }

                  const mapElement = document.getElementById('placementMap');
                  if (!mapElement) return;

                  const mapOptions = {
                      center: { lat: -33.8688, lng: 151.2093 },
                      zoom: 11,
                      gestureHandling: 'greedy',
                      disableDefaultUI: true,
                      zoomControl: true,
                      fullscreenControl: true,
                      styles: [{
                          featureType: 'poi',
                          elementType: 'labels',
                          stylers: [{ visibility: 'off' }]
                      }, {
                          featureType: 'transit',
                          stylers: [{ visibility: 'off' }]
                      }, {
                          featureType: 'road',
                          elementType: 'geometry',
                          stylers: [{ color: '#f8f9fa' }]
                      }, {
                          featureType: 'water',
                          elementType: 'geometry',
                          stylers: [{ color: '#c9d6e8' }]
                      }, {
                          featureType: 'landscape',
                          elementType: 'geometry',
                          stylers: [{ color: '#f5f5f5' }]
                      }]
                  };

                  const map = new google.maps.Map(mapElement, mapOptions);

                  const students = @json($mapStudents ?? []);
                  const industries = @json($mapIndustries ?? []);

                  let studentMarkers = [];
                  let industryMarkers = [];

                  students.forEach((student, index) => {
                      setTimeout(() => {
                          const marker = new google.maps.Marker({
                              position: { lat: parseFloat(student.latitude), lng: parseFloat(student.longitude) },
                              map: map,
                              title: student.name,
                              animation: google.maps.Animation.DROP,
                              icon: {
                                  url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" fill="#3b82f6"/>
                                          <circle cx="12" cy="9" r="2.5" fill="white"/>
                                      </svg>
                                  `),
                                  scaledSize: new google.maps.Size(24, 24),
                                  anchor: new google.maps.Point(12, 24)
                              }
                          });

                          const course = student.course ? student.course.name : 'No Course';
                          const status = student.student_detail ? student.student_detail.progress_status : 'Active';
                          const infoWindow = new google.maps.InfoWindow({
                              content: `<div style="font-family: system-ui, sans-serif; padding: 8px;"><strong>${student.name}</strong><br><span style="color: #666; font-size: 13px;">${course}</span><br><small style="color: #3b82f6;">Status: ${status}</small></div>`
                          });

                          marker.addListener('click', () => infoWindow.open(map, marker));
                          studentMarkers.push(marker);
                      }, index * 200);
                  });

                  industries.forEach((industry, index) => {
                      setTimeout(() => {
                          const marker = new google.maps.Marker({
                              position: { lat: parseFloat(industry.latitude), lng: parseFloat(industry.longitude) },
                              map: map,
                              title: industry.name,
                              animation: google.maps.Animation.DROP,
                              icon: {
                                  url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" fill="#059669"/>
                                          <circle cx="12" cy="9" r="2.5" fill="white"/>
                                      </svg>
                                  `),
                                  scaledSize: new google.maps.Size(24, 24),
                                  anchor: new google.maps.Point(12, 24)
                              }
                          });

                          const infoWindow = new google.maps.InfoWindow({
                              content: `<div style="font-family: system-ui, sans-serif; padding: 8px;"><strong>${industry.name}</strong><br><span style="color: #666; font-size: 13px;">${industry.contact_person || 'No Contact'}</span><br><small style="color: #059669;">Industry Partner</small></div>`
                          });

                          marker.addListener('click', () => infoWindow.open(map, marker));
                          industryMarkers.push(marker);
                      }, (students.length + index) * 200);
                  });

                  document.getElementById('toggleStudents').addEventListener('click', function() {
                      const visible = studentMarkers.length > 0 ? studentMarkers[0].getVisible() : false;
                      studentMarkers.forEach(marker => marker.setVisible(!visible));
                      this.classList.toggle('bg-blue-300', !visible);
                      this.classList.toggle('bg-blue-500', visible);
                  });

                  document.getElementById('toggleIndustries').addEventListener('click', function() {
                      const visible = industryMarkers.length > 0 ? industryMarkers[0].getVisible() : false;
                      industryMarkers.forEach(marker => marker.setVisible(!visible));
                      this.classList.toggle('bg-green-300', !visible);
                      this.classList.toggle('bg-green-500', visible);
                  });
              }

              // Radial Progress Chart (Multi-layered)
              const radialCtx = document.getElementById('radialChart');
              new Chart(radialCtx, {
                  type: 'doughnut',
                  data: {
                      datasets: [{
                              data: [85, 15],
                              backgroundColor: ['#00AB03', '#f5f5f5'],
                              cutout: '85%',
                              borderWidth: 0
                          },
                          {
                              data: [65, 35],
                              backgroundColor: ['#00A8AB', '#f5f5f5'],
                              cutout: '75%',
                              borderWidth: 0
                          },
                          {
                              data: [45, 55],
                              backgroundColor: ['#FBBF24', '#f5f5f5'],
                              cutout: '65%',
                              borderWidth: 0
                          },
                          {
                              data: [25, 75],
                              backgroundColor: ['#AB6C00', '#f5f5f5'],
                              cutout: '55%',
                              borderWidth: 0
                          },
                          {
                              data: [3, 97],
                              backgroundColor: ['#D60404', '#f5f5f5'],
                              cutout: '45%',
                              borderWidth: 0
                          }
                      ]
                  },
                  options: {
                      responsive: true,
                      maintainAspectRatio: false,
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
      <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places&callback=initPlacementMap" async defer></script>
      @endsection

