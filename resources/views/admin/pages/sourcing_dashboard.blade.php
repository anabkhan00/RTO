@extends('admin.master_layout.index')
@section('page-title', 'Sourcing Coordinator Dashboard')

@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Sourcing Dashboard</h1>
                <p class="text-gray-600 mt-1">Manage placement opportunities and industry partnerships</p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-bold text-brand">{{ $totalOpportunities ?? 12 }}</p>
                <p class="text-gray-600 text-xs">Total Opportunities</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="w-full flex flex-wrap">
        <!-- Total Opportunities -->
        <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
            <div class="bg-white shadow-md rounded-md p-4 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-center w-full">
                    <img src="{{ asset('assets/images/stucomp.svg') }}" class="w-10">
                </div>
                <div class="flex items-center mt-3 justify-center w-full">
                    <p class="font-semibold text-brand text-xs">Total Opportunities</p>
                </div>
                <div class="w-full max-w-md mt-2">
                    <div class="flex justify-center text-sm font-medium text-gray-700 mb-1">
                        <span class="font-bold text-brand text-2xl">{{ $totalOpportunities ?? 12 }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Opportunities -->
        <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
            <div class="bg-white shadow-md rounded-md p-4 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-center w-full">
                    <img src="{{ asset('assets/images/Started.svg') }}" class="w-10">
                </div>
                <div class="flex items-center mt-3 justify-center w-full">
                    <p class="font-semibold text-brand text-xs">Active Opportunities</p>
                </div>
                <div class="w-full max-w-md mt-2">
                    <div class="flex justify-center text-sm font-medium text-gray-700 mb-1">
                        <span class="font-bold text-brand text-2xl">{{ $activeOpportunities ?? 8 }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Slots -->
        <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
            <div class="bg-white shadow-md rounded-md p-4 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-center w-full">
                    <img src="{{ asset('assets/images/Placement.svg') }}" class="w-10">
                </div>
                <div class="flex items-center mt-3 justify-center w-full">
                    <p class="font-semibold text-brand text-xs">Total Slots</p>
                </div>
                <div class="w-full max-w-md mt-2">
                    <div class="flex justify-center text-sm font-medium text-gray-700 mb-1">
                        <span class="font-bold text-brand text-2xl">{{ $totalSlots ?? 156 }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filled Slots -->
        <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2">
            <div class="bg-white shadow-md rounded-md p-4 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-center w-full">
                    <img src="{{ asset('assets/images/booked.svg') }}" class="w-10">
                </div>
                <div class="flex items-center mt-3 justify-center w-full">
                    <p class="font-semibold text-brand text-xs">Filled Slots</p>
                </div>
                <div class="w-full max-w-md mt-2">
                    <div class="flex justify-center text-sm font-medium text-gray-700 mb-1">
                        <span class="font-bold text-brand text-2xl">{{ $filledSlots ?? 89 }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-sm mb-6 mt-6">
        <div class="p-4 border-b border-gray-200">
            <button id="toggleFilters" class="flex items-center justify-between w-full text-left">
                <h3 class="text-lg font-semibold text-gray-800">Filters</h3>
                <i id="filterIcon" class="bi bi-chevron-down text-gray-500 transition-transform"></i>
            </button>
        </div>
        <div id="filterContent" class="hidden p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <input type="text" id="searchFilter" placeholder="Search opportunities..."
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                </div>
                <div>
                    <select id="industryFilter"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                        <option value="">All Industries</option>
                        <option value="Technology">Technology</option>
                        <option value="Healthcare">Healthcare</option>
                        <option value="Retail">Retail</option>
                        <option value="Manufacturing">Manufacturing</option>
                    </select>
                </div>
                <div>
                    <select id="statusFilter"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand bg-white">
                        <option value="">All Status</option>
                        <option value="Active">Active</option>
                        <option value="Pending">Pending</option>
                        <option value="Closed">Closed</option>
                    </select>
                </div>
                <div>
                    <input type="date" id="fromDate"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                </div>
                <div>
                    <input type="date" id="toDate"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                </div>
                <div class="flex items-end gap-2">
                    <button id="resetFilters"
                        class="bg-gray-500 text-white text-xs px-3 py-1.5 rounded-md hover:bg-gray-600 transition-colors font-medium">
                        Reset Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Placement Opportunities Overview -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold text-brand">Placement Opportunities</h2>
                <div class="flex gap-3">
                    <a href="{{ route('admin.live-appointments') }}" class="bg-brand text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors">
                        <i class="bi bi-calendar-check mr-1"></i>Live Appointments
                    </a>
                    <button class="bg-brand text-white font-medium text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors">
                        <i class="bi bi-plus mr-1"></i>New Opportunity
                    </button>
                    <button class="bg-gray-500 text-white text-xs px-3 py-1.5 rounded-md hover:bg-gray-600 transition-colors font-medium">
                        <i class="bi bi-download mr-1"></i>Export
                    </button>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Industry</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Company</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Position</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Slots</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Applications</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Filled</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Status</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Tech Industry -->
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-blue-50 text-blue-700 border-blue-100 border shadow-sm">
                                <i class="bi bi-laptop mr-1"></i>Technology
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">TechCorp Australia</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">Software Developer</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">15</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">23</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">12</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-emerald-50 text-emerald-700 border-emerald-100 border shadow-sm">
                                Active
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            <div class="flex justify-center gap-2">
                                <button class="text-brand hover:text-gold text-sm font-medium">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="text-brand hover:text-gold text-sm font-medium">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Healthcare Industry -->
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-emerald-50 text-emerald-700 border-emerald-100 border shadow-sm">
                                <i class="bi bi-heart-pulse mr-1"></i>Healthcare
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">MediCare Plus</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">Nursing Assistant</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">8</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">12</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">5</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-emerald-50 text-emerald-700 border-emerald-100 border shadow-sm">
                                Active
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            <div class="flex justify-center gap-2">
                                <button class="text-brand hover:text-gold text-sm font-medium">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="text-brand hover:text-gold text-sm font-medium">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Retail Industry -->
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-purple-50 text-purple-700 border-purple-100 border shadow-sm">
                                <i class="bi bi-shop mr-1"></i>Retail
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">RetailMax</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">Sales Associate</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">20</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">8</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">8</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-orange-50 text-orange-700 border-orange-100 border shadow-sm">
                                Pending
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            <div class="flex justify-center gap-2">
                                <button class="text-brand hover:text-gold text-sm font-medium">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="text-brand hover:text-gold text-sm font-medium">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Manufacturing Industry -->
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-orange-50 text-orange-700 border-orange-100 border shadow-sm">
                                <i class="bi bi-gear mr-1"></i>Manufacturing
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">Industrial Solutions</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">Production Worker</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">12</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">18</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">9</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-emerald-50 text-emerald-700 border-emerald-100 border shadow-sm">
                                Active
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            <div class="flex justify-center gap-2">
                                <button class="text-brand hover:text-gold text-sm font-medium">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="text-brand hover:text-gold text-sm font-medium">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Filter toggle functionality
        document.getElementById('toggleFilters').addEventListener('click', function() {
            const filterContent = document.getElementById('filterContent');
            const filterIcon = document.getElementById('filterIcon');

            filterContent.classList.toggle('hidden');
            filterIcon.classList.toggle('rotate-180');
        });

        // Reset filters functionality
        document.getElementById('resetFilters').addEventListener('click', function() {
            document.getElementById('searchFilter').value = '';
            document.getElementById('industryFilter').value = '';
            document.getElementById('statusFilter').value = '';
            document.getElementById('fromDate').value = '';
            document.getElementById('toDate').value = '';
        });
    </script>
@endsection
