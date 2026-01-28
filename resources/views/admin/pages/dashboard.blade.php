      @extends('admin.master_layout.index')
      @section('page-title')
    @php
        $role = auth()->user()->getRoleNames()->first();
    @endphp

    @switch($role)
        @case('admin')
            Admin Dashboard
            @break

        @case('placement_coordinator')
            Placement Coordinator Dashboard
            @break

        @case('sourcing_coordinator')
            Sourcing Coordinator Dashboard
            @break

        @default
            Dashboard
    @endswitch
@endsection

      @section('content')
          <div class="w-full p-3 flex flex-nowrap gap-6">
              @can('students.view')
                  <!-- Total Students Card -->
                  <div class="flex-1">
                      <a href="{{ route('admin.students') }}"
                          class="block flex-1 hover:shadow-lg transition-shadow cursor-pointer">
                          <div class="w-full bg-white rounded-lg h-48 shadow p-4 flex flex-col items-center justify-center">
                              <div class="flex items-center justify-center">
                                  <img src="{{ asset('assets/images/stucomp.svg') }}" class="w-10">
                              </div>
                              <div class="flex flex-col items-center mt-3">
                                  <p class="font-semibold text-brand text-xs">Total Students</p>
                              </div>
                              <div class="w-full max-w-xs mt-3">
                                  <div class="flex justify-between text-sm font-medium text-gray-700 mb-1">
                                      <span class="font-medium text-brand text-xs">{{ $totalStudents ?? 0 }}</span>
                                      <span class="font-medium text-brand text-xs">100%</span>
                                  </div>
                                  <div class="w-full bg-gray-200 rounded-full h-1 overflow-hidden">
                                      <div class="bg-[#0014AB] h-1 rounded-full" style="width: 100%;"></div>
                                  </div>
                              </div>
                          </div>
                      </a>

                      @can('placements.view')
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
                                          <span class="font-medium text-brand text-xs">{{ $completedPlacements ?? 0 }}</span>
                                          <span class="font-medium text-brand text-xs">85%</span>
                                      </div>
                                      <div class="w-full bg-gray-200 rounded-full h-1 overflow-hidden">
                                          <div class="bg-[#00AB03] h-1 rounded-full" style="width: 85%;"></div>
                                      </div>
                                  </div>
                              </div>
                          </a>
                      @endcan
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
              @endcan
          </div>


          @can('students.view')
              <div class="w-full flex flex-wrap">
                  @can('placements.view')
                      <!-- Active Placements -->
                      <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
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
                                          <span class="font-medium text-brand text-xs">{{ $activePlacements ?? 0 }}</span>
                                          <span class="font-medium text-brand text-xs">65%</span>
                                      </div>
                                      <div class="w-full bg-gray-200 rounded-full h-1 overflow-hidden">
                                          <div class="bg-[#00A8AB] h-1 rounded-full" style="width: 65%;"></div>
                                      </div>
                                  </div>
                              </div>
                          </a>
                      </div>
                  @endcan

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
          @endcan


          @can('students.view')
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
          @endcan


          @can('students.view')
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
          @endcan

          @can('students.view')
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
                                          onclick="window.location.href='{{ route('admin.student-documents.index', $student->id) }}'">
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
          @endcan

          @can('students.view')
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
          @endcan

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
              // Initialize DataTable
              $('#studentsTable').DataTable({
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
              function toggleDashDropdown(index) {
                  const dropdown = document.getElementById(`dash-dropdown-${index}`);
                  const allDropdowns = document.querySelectorAll('[id^="dash-dropdown-"]');

                  allDropdowns.forEach(dd => {
                      if (dd !== dropdown) {
                          dd.classList.add('hidden');
                      }
                  });

                  dropdown.classList.toggle('hidden');
              }

              document.addEventListener('click', (e) => {
                  if (!e.target.closest('[onclick^="toggleDashDropdown"]')) {
                      const allDropdowns = document.querySelectorAll('[id^="dash-dropdown-"]');
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
