      @extends('rto.master_layout.index')
      @section('content')
          <div class="w-full p-3">
            <a href="/rto/students" class="block">
              <div class="w-full  bg-white rounded-lg shadow p-4 flex items-center justify-between">
                  <!-- LEFT: Icon + Text -->
                  <div class="flex items-center gap-3">
                      <div class="  rounded-md flex items-center justify-center">
                          <!-- 🎓 Graduation cap icon -->
                          <img src="{{ asset('assets/images/stucomp.svg') }}" class="w-10">
                      </div>
                      <div>
                          <p class="font-semibold text-brand text-sm">43234</p>
                          <p class="text-xs text-gray-500">Total Students</p>
                      </div>
                  </div>

                  <!-- RIGHT: Progress Bar + Percentage -->
                  <div class="flex-1 ml-6">
                      <div class="flex justify-between text-sm text-gray-700 mb-1">
                          <span></span>
                          <span class="font-medium text-brand text-xs">80%</span>
                      </div>
                      <div class="w-full bg-gray-200 rounded-full h-1 overflow-hidden">
                          <div class="bg-[#0014AB] h-1 rounded-full" style="width: 80%;"></div>
                      </div>
                  </div>
              </div>
            </a>

          </div>
          <div class="w-full flex flex-wrap">
              <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/5 p-2">
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
              <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/5 p-2">
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
              <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/5 p-2">
                  <a href="/rto/students?status=completed" class="block">
                      <div class="bg-white shadow-md rounded-md p-4 hover:shadow-lg transition-shadow cursor-pointer">
                          <div class="flex items-center justify-center w-full">
                              <img src="{{ asset('assets/images/Placement.svg') }}" class="w-10">
                          </div>
                          <div class="flex items-center mt-3 justify-center w-full">
                              <p class="font-semibold text-brand text-xs">Completed Placements</p>
                          </div>
                          <div class="w-full max-w-md mt-2">
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
              <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/5 p-2">
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
              <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/5 p-2">
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

                  <div class="flex justify-center gap-6 mt-4 text-sm">
                      <div class="flex items-center font-semibold text-brand text-xs gap-2">
                          <span class="w-3 h-3 bg-[#00A8AB] rounded-full"></span> Active
                      </div>
                      <div class="flex items-center font-semibold text-brand text-xs gap-2">
                          <span class="w-3 h-3 bg-[#00AB03] rounded-full"></span> Completed
                      </div>
                  </div>
              </div>

              <div class="bg-[#d4b373] rounded-lg flex flex-col items-center justify-center p-6 w-full md:w-1/3">
                  <h3 class="font-semibold text-sm text-brand mb-3">Target vs Achieved</h3>
                  <div class="relative w-52 h-52 flex items-center justify-center">
                      <canvas id="gaugeChart"></canvas>
                      <div class="absolute inset-0 flex flex-col items-center justify-center translate-y-6">
                          <p id="gaugeValue" class="text-xl font-bold text-brand">0%</p>
                          <p class="font-semibold text-sm text-brand">achieved</p>
                      </div>
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

          <script>
              // 📈 Line Chart
              const ctx = document.getElementById('lineChart');
              new Chart(ctx, {
                  type: 'line',
                  data: {
                      labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                      datasets: [{
                              label: 'Active',
                              data: [15, 18, 13, 20, 17, 23, 19],
                              borderColor: '#00A8AB',
                              tension: 0.4,
                              fill: false
                          },
                          {
                              label: 'Completed',
                              data: [12, 15, 10, 18, 14, 20, 16],
                              borderColor: '#00AB03',
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
                          legend: {
                              display: false
                          },
                          tooltip: {
                              enabled: false
                          }
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

              // 🗺️ Initialize Google Map
              function initMap() {
                  const map = new google.maps.Map(document.getElementById('map'), {
                      zoom: 6,
                      center: { lat: -25.274398, lng: 133.775136 }, // Australia center
                      styles: [
                          {
                              featureType: 'all',
                              elementType: 'geometry.fill',
                              stylers: [{ color: '#f5f5f5' }]
                          },
                          {
                              featureType: 'water',
                              elementType: 'geometry',
                              stylers: [{ color: '#e9e9e9' }]
                          }
                      ]
                  });

                  // Student locations (dummy data)
                  const students = [
                      { lat: -33.8688, lng: 151.2093, type: 'active', name: 'John Smith' }, // Sydney
                      { lat: -37.8136, lng: 144.9631, type: 'completed', name: 'Sarah Johnson' }, // Melbourne
                      { lat: -27.4698, lng: 153.0251, type: 'active', name: 'Mike Wilson' }, // Brisbane
                      { lat: -31.9505, lng: 115.8605, type: 'completed', name: 'Emma Davis' }, // Perth
                      { lat: -34.9285, lng: 138.6007, type: 'active', name: 'Chris Brown' }, // Adelaide
                      { lat: -42.8821, lng: 147.3272, type: 'completed', name: 'Lisa Garcia' }, // Hobart
                      { lat: -12.4634, lng: 130.8456, type: 'active', name: 'David Miller' }, // Darwin
                      { lat: -35.2809, lng: 149.1300, type: 'completed', name: 'Anna Wilson' }, // Canberra
                      { lat: -23.6980, lng: 133.8807, type: 'active', name: 'Tom Anderson' }, // Alice Springs
                      { lat: -19.2590, lng: 146.8169, type: 'completed', name: 'Maria Rodriguez' } // Townsville
                  ];

                  // Add markers for each student
                  students.forEach(student => {
                      const marker = new google.maps.Marker({
                          position: { lat: student.lat, lng: student.lng },
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
          </script>
      @endsection
