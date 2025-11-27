@extends('rto.master_layout.index')
@section('page-title', 'Industries')
<style>
    .bg-blue-100,
    .bg-purple-100,
    .bg-green-100,
    .bg-orange-100,
    .bg-pink-100,
    .bg-indigo-100,
    .bg-teal-100,
    .bg-rose-100 {
        background-color: rgba(0, 0, 0, 0.03) !important;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
</style>
@section('content')
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Industries Management</h1>
                <p class="text-gray-600 mt-1">View and explore available industries</p>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-sm mb-6">
        <div class="p-4 border-b border-gray-200">
            <button id="toggleFilters" class="flex items-center justify-between w-full text-left">
                <h3 class="text-lg font-semibold text-gray-800">Filters</h3>
                <i id="filterIcon" class="bi bi-chevron-down text-gray-500 transition-transform"></i>
            </button>
        </div>
        <div id="filterContent" class="hidden p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search by Student Name</label>
                    <input type="text" id="studentNameFilter" placeholder="Search student name..."
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search by Industry</label>
                    <input type="text" id="industryNameFilter" placeholder="Search industry..."
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search by Address</label>
                    <input type="text" id="addressFilter" placeholder="Search address..."
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search by Phone</label>
                    <input type="text" id="phoneFilter" placeholder="Search phone..."
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand focus:border-brand">
                </div>
                <div class="flex items-end gap-2">
                    <button id="applyFilters"
                        class="bg-brand text-white text-xs px-3 py-1.5 rounded-md hover:bg-gold transition-colors font-medium">
                        Apply Filters
                    </button>
                    <button id="resetFilters"
                        class="bg-gray-500 text-white text-xs px-3 py-1.5 rounded-md hover:bg-gray-600 transition-colors font-medium">
                        Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Industries Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table id="industriesTable" class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Industry Name</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Industry Contact</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Industry Address</th>
                            <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Student Name</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Student Contact</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Student Address</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Website</th>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider border-b">
                            Assigned Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($studentIndustries as $index => $assignment)
                        @php
                            $student = $assignment->student;
                            $industry = $assignment->industry;

                            // Pastel color palette
                            $palette = [
                                ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-100'],
                                ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'border' => 'border-purple-100'],
                                ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-100'],
                                ['bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'border' => 'border-orange-100'],
                                ['bg' => 'bg-pink-50', 'text' => 'text-pink-700', 'border' => 'border-pink-100'],
                                ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'border' => 'border-indigo-100'],
                                ['bg' => 'bg-teal-50', 'text' => 'text-teal-700', 'border' => 'border-teal-100'],
                                ['bg' => 'bg-cyan-50', 'text' => 'text-cyan-700', 'border' => 'border-cyan-100'],
                            ];

                            $studentColor = $palette[abs(crc32($student->name)) % count($palette)];
                            $industryColor = $palette[abs(crc32($industry->name)) % count($palette)];
                        @endphp

                        <tr class="hover:bg-gray-50 transition-colors">
                            <!-- Industry Name -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full {{ $industryColor['bg'] }} {{ $industryColor['text'] }} {{ $industryColor['border'] }} border shadow-sm">
                                    {{ $industry->name }}
                                </span>
                            </td>
                            <!-- Industry Contact -->
                            <td class="px-4 py-3 text-sm text-gray-600">
                                <div class="space-y-1">
                                    <div class="font-medium">{{ $industry->contact_person }}</div>
                                    <div class="flex items-center">
                                        <i class="bi bi-envelope text-xs mr-1"></i>
                                        {{ $industry->email }}
                                    </div>
                                    <div class="flex items-center">
                                        <i class="bi bi-phone text-xs mr-1"></i>
                                        {{ $industry->phone }}
                                    </div>
                                </div>
                            </td>
                            <!-- Industry Address -->
                            <td class="px-4 py-3 text-sm text-gray-600">
                                {{ Str::limit($industry->address, 40) }}
                            </td>
                            <!-- Student Name -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full {{ $studentColor['bg'] }} {{ $studentColor['text'] }} {{ $studentColor['border'] }} border shadow-sm">
                                    {{ $student->name }}
                                </span>
                            </td>
                            <!-- Student Contact -->
                            <td class="px-4 py-3 text-sm text-gray-600">
                                <div class="space-y-1">
                                    <div class="flex items-center">
                                        <i class="bi bi-envelope text-xs mr-1"></i>
                                        {{ $student->email }}
                                    </div>
                                    @if($student->phone)
                                        <div class="flex items-center">
                                            <i class="bi bi-phone text-xs mr-1"></i>
                                            {{ $student->phone }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <!-- Student Address -->
                            <td class="px-4 py-3 text-sm text-gray-600">
                                {{ Str::limit($student->address ?? 'N/A', 40) }}
                            </td>
                            <!-- Website -->
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                @if($industry->website)
                                    <a href="{{ $industry->website }}" target="_blank" class="text-blue-600 hover:text-blue-800 flex items-center">
                                        <i class="bi bi-globe text-xs mr-1"></i>
                                        Visit
                                    </a>
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                            <!-- Assigned Date -->
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                {{ $assignment->created_at->format('j M Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Initialize DataTables for industries table
        $('#industriesTable').DataTable({
            "pageLength": 25,
            "searching": false,
            "ordering": true,
            "info": false,
            "lengthChange": false,
            "dom": 'rt<"flex justify-end mt-4"p>',
            "scrollX": true
        });

        // Filter functionality
        const studentNameFilter = document.getElementById('studentNameFilter');
        const industryNameFilter = document.getElementById('industryNameFilter');
        const addressFilter = document.getElementById('addressFilter');
        const phoneFilter = document.getElementById('phoneFilter');
        const applyFilters = document.getElementById('applyFilters');
        const resetFilters = document.getElementById('resetFilters');
        const tableRows = document.querySelectorAll('#industriesTable tbody tr');

        function filterTable() {
            const studentName = studentNameFilter.value.toLowerCase();
            const industryName = industryNameFilter.value.toLowerCase();
            const address = addressFilter.value.toLowerCase();
            const phone = phoneFilter.value.toLowerCase();

            tableRows.forEach(row => {
                const studentNameText = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                const studentContactText = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const studentAddressText = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const industryNameText = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                const industryContactText = row.querySelector('td:nth-child(5)').textContent.toLowerCase();
                const industryAddressText = row.querySelector('td:nth-child(6)').textContent.toLowerCase();

                let showRow = true;

                // Student name filter
                if (studentName && !studentNameText.includes(studentName)) {
                    showRow = false;
                }

                // Industry name filter
                if (industryName && !industryNameText.includes(industryName)) {
                    showRow = false;
                }

                // Address filter (both student and industry)
                if (address && !studentAddressText.includes(address) && !industryAddressText.includes(address)) {
                    showRow = false;
                }

                // Phone filter (both student and industry)
                if (phone && !studentContactText.includes(phone) && !industryContactText.includes(phone)) {
                    showRow = false;
                }

                row.style.display = showRow ? '' : 'none';
            });
        }

        // Real-time search
        [studentNameFilter, industryNameFilter, addressFilter, phoneFilter].forEach(filter => {
            filter.addEventListener('input', filterTable);
        });

        // Apply filters button
        applyFilters.addEventListener('click', filterTable);

        // Reset filters
        resetFilters.addEventListener('click', () => {
            studentNameFilter.value = '';
            industryNameFilter.value = '';
            addressFilter.value = '';
            phoneFilter.value = '';
            tableRows.forEach(row => {
                row.style.display = '';
            });
        });

        // Filter toggle functionality
        document.getElementById('toggleFilters').addEventListener('click', function() {
            const filterContent = document.getElementById('filterContent');
            const filterIcon = document.getElementById('filterIcon');

            filterContent.classList.toggle('hidden');
            filterIcon.classList.toggle('rotate-180');
        });
    </script>

    <style>
        /* DataTables pagination styling */
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
@endsection
