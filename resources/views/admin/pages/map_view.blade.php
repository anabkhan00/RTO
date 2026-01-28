@extends('admin.master_layout.index')
@section('page-title', 'Map View')

@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Student Location Map</h1>
                <p class="text-gray-600 mt-1">Discover students in unassigned areas and create new opportunities</p>
            </div>
            <div class="flex gap-3">
                <button class="bg-brand text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors" onclick="showUploadModal()">
                    <i class="bi bi-plus mr-1"></i>Upload Opportunity
                </button>
                <div class="flex items-center space-x-4 text-sm">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                        <span class="text-gray-600">Available Students</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                        <span class="text-gray-600">Your Opportunities</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Container -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="h-96 relative" id="mapContainer">
            <!-- Map will be rendered here -->
            <div class="absolute inset-0 bg-gray-100 flex items-center justify-center">
                <div class="text-center">
                    <i class="bi bi-geo-alt text-4xl text-gray-400 mb-2"></i>
                    <p class="text-gray-600">Interactive map will load here</p>
                    <p class="text-sm text-gray-500">Click on yellow pins to see student information</p>
                </div>
            </div>
            
            <!-- Demo Pins (Replace with actual map integration) -->
            <div class="absolute top-20 left-32 cursor-pointer" onclick="showStudentPopup(1, event)">
                <div class="w-6 h-6 bg-yellow-500 rounded-full border-2 border-white shadow-lg flex items-center justify-center">
                    <span class="text-white text-xs font-bold">3</span>
                </div>
            </div>
            
            <div class="absolute top-40 left-48 cursor-pointer" onclick="showStudentPopup(2, event)">
                <div class="w-6 h-6 bg-yellow-500 rounded-full border-2 border-white shadow-lg flex items-center justify-center">
                    <span class="text-white text-xs font-bold">5</span>
                </div>
            </div>
            
            <div class="absolute top-32 right-40 cursor-pointer" onclick="showStudentPopup(3, event)">
                <div class="w-6 h-6 bg-yellow-500 rounded-full border-2 border-white shadow-lg flex items-center justify-center">
                    <span class="text-white text-xs font-bold">2</span>
                </div>
            </div>
            
            <div class="absolute bottom-32 left-40 cursor-pointer" onclick="showStudentPopup(4, event)">
                <div class="w-6 h-6 bg-blue-500 rounded-full border-2 border-white shadow-lg flex items-center justify-center">
                    <span class="text-white text-xs font-bold">1</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Area Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
        <div class="bg-white rounded-lg shadow-sm p-6 text-center">
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                <i class="bi bi-geo-alt text-yellow-600 text-xl"></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-1">Available Areas</h3>
            <p class="text-2xl font-bold text-brand">24</p>
            <p class="text-xs text-gray-600">Unassigned locations</p>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-6 text-center">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                <i class="bi bi-people text-blue-600 text-xl"></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-1">Total Students</h3>
            <p class="text-2xl font-bold text-brand">156</p>
            <p class="text-xs text-gray-600">In visible areas</p>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-6 text-center">
            <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                <i class="bi bi-briefcase text-emerald-600 text-xl"></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-1">Your Opportunities</h3>
            <p class="text-2xl font-bold text-brand">8</p>
            <p class="text-xs text-gray-600">Active placements</p>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-6 text-center">
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                <i class="bi bi-bell text-purple-600 text-xl"></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-1">Notifications Sent</h3>
            <p class="text-2xl font-bold text-brand">42</p>
            <p class="text-xs text-gray-600">This week</p>
        </div>
    </div>

    <!-- Student Popup -->
    <div id="studentPopup" class="fixed bg-white rounded-lg shadow-xl border p-4 z-50 hidden" style="width: 300px;">
        <div class="flex justify-between items-start mb-3">
            <h4 class="font-semibold text-gray-900">Students in Area</h4>
            <button onclick="hideStudentPopup()" class="text-gray-400 hover:text-gray-600">
                <i class="bi bi-x text-lg"></i>
            </button>
        </div>
        
        <div id="popupContent">
            <!-- Dynamic content will be loaded here -->
        </div>
        
        <div class="mt-4 pt-3 border-t">
            <button class="w-full bg-brand text-white font-medium text-xs px-3 py-2 rounded-md hover:bg-gold transition-colors" onclick="uploadForArea()">
                <i class="bi bi-plus mr-1"></i>Upload Opportunity for Area
            </button>
        </div>
    </div>

    <!-- Upload Opportunity Modal -->
    <div id="uploadModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-800">Upload New Opportunity</h2>
                        <button onclick="hideUploadModal()" class="text-gray-400 hover:text-gray-600">
                            <i class="bi bi-x-lg text-xl"></i>
                        </button>
                    </div>
                    
                    <form class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Industry</label>
                            <select class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                                <option>Technology</option>
                                <option>Healthcare</option>
                                <option>Retail</option>
                                <option>Manufacturing</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Position Title</label>
                            <input type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand" placeholder="e.g. Software Developer">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Company Name</label>
                            <input type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand" placeholder="e.g. TechCorp Australia">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Available Slots</label>
                            <input type="number" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand" placeholder="e.g. 5">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                            <input type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand" placeholder="e.g. Melbourne CBD">
                        </div>
                        
                        <div class="flex gap-3 pt-4">
                            <button type="button" class="flex-1 bg-brand text-white font-medium text-xs px-3 py-2 rounded-md hover:bg-gold transition-colors" onclick="submitOpportunity()">
                                <i class="bi bi-upload mr-1"></i>Upload Opportunity
                            </button>
                            <button type="button" class="bg-gray-500 text-white text-xs px-3 py-2 rounded-md hover:bg-gray-600 transition-colors font-medium" onclick="hideUploadModal()">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Student data for different areas
        const areaStudents = {
            1: {
                area: 'Melbourne CBD',
                students: [
                    { name: 'John Smith', course: 'Certificate IV in IT', documents: 'Complete', notes: 'Available weekdays' },
                    { name: 'Sarah Wilson', course: 'Diploma in Business', documents: 'Complete', notes: 'Prefers morning shifts' },
                    { name: 'Mike Johnson', course: 'Certificate III in Retail', documents: 'Pending ID', notes: 'Has retail experience' }
                ]
            },
            2: {
                area: 'Sydney North',
                students: [
                    { name: 'Emma Davis', course: 'Certificate III in Health', documents: 'Complete', notes: 'Own transport' },
                    { name: 'David Kim', course: 'Diploma in IT', documents: 'Complete', notes: 'Bilingual (Korean)' },
                    { name: 'Lisa Chen', course: 'Certificate IV in Marketing', documents: 'Complete', notes: 'Social media skills' },
                    { name: 'Alex Brown', course: 'Certificate III in Hospitality', documents: 'Complete', notes: 'Weekend availability' },
                    { name: 'Sophie Turner', course: 'Diploma in Design', documents: 'Pending Police Check', notes: 'Creative portfolio ready' }
                ]
            },
            3: {
                area: 'Brisbane South',
                students: [
                    { name: 'James Wilson', course: 'Certificate III in Engineering', documents: 'Complete', notes: 'Manual handling certified' },
                    { name: 'Maria Garcia', course: 'Certificate IV in Aged Care', documents: 'Complete', notes: 'Fluent Spanish' }
                ]
            },
            4: {
                area: 'Perth East (Your Opportunity)',
                students: [
                    { name: 'Manufacturing Apprentice', course: 'Your uploaded opportunity', documents: 'Live', notes: '12 applications received' }
                ]
            }
        };

        function showStudentPopup(areaId, event) {
            const popup = document.getElementById('studentPopup');
            const data = areaStudents[areaId];
            
            document.getElementById('popupContent').innerHTML = `
                <div class="mb-3">
                    <h5 class="font-medium text-gray-900">${data.area}</h5>
                    <p class="text-xs text-gray-600">${data.students.length} students available</p>
                </div>
                
                <div class="space-y-2 max-h-48 overflow-y-auto">
                    ${data.students.map(student => `
                        <div class="bg-gray-50 rounded-lg p-3">
                            <div class="flex justify-between items-start mb-1">
                                <p class="font-medium text-sm text-gray-900">${student.name}</p>
                                <span class="text-xs px-2 py-1 rounded-full ${student.documents === 'Complete' ? 'bg-emerald-50 text-emerald-700' : 'bg-orange-50 text-orange-700'}">${student.documents}</span>
                            </div>
                            <p class="text-xs text-gray-600 mb-1">${student.course}</p>
                            <p class="text-xs text-gray-500">${student.notes}</p>
                        </div>
                    `).join('')}
                </div>
            `;
            
            // Position popup near the clicked pin
            const rect = event.target.getBoundingClientRect();
            popup.style.left = Math.min(rect.left, window.innerWidth - 320) + 'px';
            popup.style.top = (rect.bottom + 10) + 'px';
            
            popup.classList.remove('hidden');
        }

        function hideStudentPopup() {
            document.getElementById('studentPopup').classList.add('hidden');
        }

        function showUploadModal() {
            document.getElementById('uploadModal').classList.remove('hidden');
        }

        function hideUploadModal() {
            document.getElementById('uploadModal').classList.add('hidden');
        }

        function uploadForArea() {
            hideStudentPopup();
            showUploadModal();
        }

        function submitOpportunity() {
            alert('Opportunity uploaded successfully! Nearby placement coordinators will be notified.');
            hideUploadModal();
        }

        // Close popup when clicking outside
        document.addEventListener('click', function(event) {
            const popup = document.getElementById('studentPopup');
            if (!popup.contains(event.target) && !event.target.closest('[onclick*="showStudentPopup"]')) {
                hideStudentPopup();
            }
        });
    </script>
@endsection