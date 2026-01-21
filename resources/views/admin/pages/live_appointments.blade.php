@extends('admin.master_layout.index')
@section('page-title', 'Live Appointments')

@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Live Appointments</h1>
                <p class="text-gray-600 mt-1">View all active placement opportunities and student applications</p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-brand" id="liveCount">8</p>
                <p class="text-gray-600 text-xs">Live Appointments</p>
            </div>
        </div>
    </div>

    <!-- Loading State -->
    <div id="loadingState" class="hidden bg-white rounded-lg shadow-sm p-8 text-center">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-brand mx-auto mb-4"></div>
        <p class="text-gray-600">Loading appointments...</p>
    </div>

    <!-- Empty State -->
    <div id="emptyState" class="hidden bg-white rounded-lg shadow-sm p-8 text-center">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="bi bi-calendar-x text-gray-400 text-2xl"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 mb-2">No Live Appointments</h3>
        <p class="text-gray-600 mb-4">There are currently no active placement opportunities available.</p>
        <button class="bg-brand text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors">
            <i class="bi bi-plus mr-1"></i>Create New Opportunity
        </button>
    </div>

    <!-- Appointments Grid -->
    <div id="appointmentsGrid" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Appointment Card 1 -->
        <div class="bg-white rounded-lg shadow-sm border hover:shadow-md transition-shadow">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="bi bi-laptop text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Software Developer Internship</h3>
                            <p class="text-sm text-gray-600">Technology Industry</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-emerald-50 text-emerald-700 border-emerald-100 border">
                        <i class="bi bi-circle-fill text-emerald-500 text-xs mr-1"></i>Live
                    </span>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-4 text-sm">
                    <div class="text-center">
                        <p class="text-gray-600">Total Slots</p>
                        <p class="font-bold text-brand text-lg">15</p>
                    </div>
                    <div class="text-center">
                        <p class="text-gray-600">Applications</p>
                        <p class="font-bold text-brand text-lg">23</p>
                    </div>
                    <div class="text-center">
                        <p class="text-gray-600">Remaining</p>
                        <p class="font-bold text-orange-600 text-lg">3</p>
                    </div>
                </div>

                <div class="border-t pt-4">
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="font-medium text-gray-900">Recent Applications</h4>
                        <button class="text-brand hover:text-gold text-xs font-medium" onclick="toggleStudentList(1)">
                            View All (23)
                        </button>
                    </div>
                    
                    <div class="space-y-2">
                        <div class="flex items-center space-x-3 p-2 bg-gray-50 rounded-lg">
                            <div class="w-8 h-8 bg-brand rounded-full flex items-center justify-center text-white text-xs font-medium">JS</div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">John Smith</p>
                                <p class="text-xs text-gray-600">Applied 2 hours ago</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 p-2 bg-gray-50 rounded-lg">
                            <div class="w-8 h-8 bg-brand rounded-full flex items-center justify-center text-white text-xs font-medium">MW</div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Maria Wilson</p>
                                <p class="text-xs text-gray-600">Applied 4 hours ago</p>
                            </div>
                        </div>
                    </div>

                    <!-- Expandable Student List -->
                    <div id="studentList1" class="hidden mt-3 space-y-2">
                        <div class="flex items-center space-x-3 p-2 bg-gray-50 rounded-lg">
                            <div class="w-8 h-8 bg-brand rounded-full flex items-center justify-center text-white text-xs font-medium">AB</div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Alex Brown</p>
                                <p class="text-xs text-gray-600">Applied 6 hours ago</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 p-2 bg-gray-50 rounded-lg">
                            <div class="w-8 h-8 bg-brand rounded-full flex items-center justify-center text-white text-xs font-medium">SD</div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Sarah Davis</p>
                                <p class="text-xs text-gray-600">Applied 8 hours ago</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t">
                    <button class="w-full bg-brand text-white font-medium text-xs px-3 py-2 rounded-md hover:bg-gold transition-colors">
                        <i class="bi bi-eye mr-1"></i>View Details
                    </button>
                </div>
            </div>
        </div>

        <!-- Appointment Card 2 -->
        <div class="bg-white rounded-lg shadow-sm border hover:shadow-md transition-shadow">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <i class="bi bi-heart-pulse text-emerald-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Nursing Assistant</h3>
                            <p class="text-sm text-gray-600">Healthcare Industry</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-emerald-50 text-emerald-700 border-emerald-100 border">
                        <i class="bi bi-circle-fill text-emerald-500 text-xs mr-1"></i>Live
                    </span>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-4 text-sm">
                    <div class="text-center">
                        <p class="text-gray-600">Total Slots</p>
                        <p class="font-bold text-brand text-lg">10</p>
                    </div>
                    <div class="text-center">
                        <p class="text-gray-600">Applications</p>
                        <p class="font-bold text-brand text-lg">18</p>
                    </div>
                    <div class="text-center">
                        <p class="text-gray-600">Remaining</p>
                        <p class="font-bold text-orange-600 text-lg">2</p>
                    </div>
                </div>

                <div class="border-t pt-4">
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="font-medium text-gray-900">Recent Applications</h4>
                        <button class="text-brand hover:text-gold text-xs font-medium" onclick="toggleStudentList(2)">
                            View All (18)
                        </button>
                    </div>
                    
                    <div class="space-y-2">
                        <div class="flex items-center space-x-3 p-2 bg-gray-50 rounded-lg">
                            <div class="w-8 h-8 bg-brand rounded-full flex items-center justify-center text-white text-xs font-medium">LJ</div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Lisa Johnson</p>
                                <p class="text-xs text-gray-600">Applied 1 hour ago</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 p-2 bg-gray-50 rounded-lg">
                            <div class="w-8 h-8 bg-brand rounded-full flex items-center justify-center text-white text-xs font-medium">DM</div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">David Miller</p>
                                <p class="text-xs text-gray-600">Applied 3 hours ago</p>
                            </div>
                        </div>
                    </div>

                    <!-- Expandable Student List -->
                    <div id="studentList2" class="hidden mt-3 space-y-2">
                        <div class="flex items-center space-x-3 p-2 bg-gray-50 rounded-lg">
                            <div class="w-8 h-8 bg-brand rounded-full flex items-center justify-center text-white text-xs font-medium">ER</div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Emma Rodriguez</p>
                                <p class="text-xs text-gray-600">Applied 5 hours ago</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t">
                    <button class="w-full bg-brand text-white font-medium text-xs px-3 py-2 rounded-md hover:bg-gold transition-colors">
                        <i class="bi bi-eye mr-1"></i>View Details
                    </button>
                </div>
            </div>
        </div>

        <!-- More appointment cards can be added here -->
    </div>

    <script>
        // Toggle student list visibility
        function toggleStudentList(cardId) {
            const studentList = document.getElementById(`studentList${cardId}`);
            studentList.classList.toggle('hidden');
        }

        // Simulate loading state (for demo)
        function showLoadingState() {
            document.getElementById('appointmentsGrid').classList.add('hidden');
            document.getElementById('emptyState').classList.add('hidden');
            document.getElementById('loadingState').classList.remove('hidden');
            
            setTimeout(() => {
                document.getElementById('loadingState').classList.add('hidden');
                document.getElementById('appointmentsGrid').classList.remove('hidden');
            }, 2000);
        }

        // Simulate empty state (for demo)
        function showEmptyState() {
            document.getElementById('appointmentsGrid').classList.add('hidden');
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('emptyState').classList.remove('hidden');
            document.getElementById('liveCount').textContent = '0';
        }

        // Demo buttons (remove in production)
        document.addEventListener('DOMContentLoaded', function() {
            // Add demo controls (remove in production)
            const header = document.querySelector('.bg-white.rounded-lg.shadow-sm.p-6.mb-6');
            const demoControls = document.createElement('div');
            demoControls.className = 'mt-4 pt-4 border-t flex gap-2';
            demoControls.innerHTML = `
                <button onclick="showLoadingState()" class="bg-gray-500 text-white text-xs px-2 py-1 rounded">Demo Loading</button>
                <button onclick="showEmptyState()" class="bg-gray-500 text-white text-xs px-2 py-1 rounded">Demo Empty</button>
                <button onclick="location.reload()" class="bg-gray-500 text-white text-xs px-2 py-1 rounded">Reset</button>
            `;
            header.appendChild(demoControls);
        });
    </script>
@endsection