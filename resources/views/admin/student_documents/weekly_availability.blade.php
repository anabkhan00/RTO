@extends('admin.master_layout.index')
@section('page-title', 'Weekly Availability')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-2xl font-semibold text-brand mb-6">Weekly Availability</h2>

    <!-- Week Navigation -->
    <div class="flex items-center justify-between mb-4">
        <button id="prevWeek" class="text-gray-500 hover:text-brand transition-colors">
            <i class="bi bi-chevron-left"></i> Prev
        </button>
        <span id="weekRange" class="text-lg font-medium text-gray-700">Dec 14 – Dec 20</span>
        <button id="nextWeek" class="text-gray-500 hover:text-brand transition-colors">
            Next <i class="bi bi-chevron-right"></i>
        </button>
    </div>

    <!-- Calendar Container -->
    <div id="weeklyCalendar" class="border rounded-lg overflow-hidden"></div>

    <!-- Selected Blocks Summary -->
    <div class="mt-6">
        <h3 class="text-lg font-medium text-brand mb-4">Selected Blocks</h3>
        <div id="selectedBlocks" class="space-y-3">
            <!-- Blocks will be dynamically added here -->
        </div>
        <button id="saveAvailability" class="bg-brand text-white px-6 py-2 rounded-lg hover:bg-gold transition-colors">
            Save Availability
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('weeklyCalendar');
        const selectedBlocksEl = document.getElementById('selectedBlocks');
        const weekRangeEl = document.getElementById('weekRange');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            slotMinTime: '06:00:00',
            slotMaxTime: '22:00:00',
            editable: true,
            selectable: true,
            eventColor: '#007bff',
            events: '/students/{{ $student->id }}/availability/week',
            select: function(info) {
                const event = {
                    start: info.startStr,
                    end: info.endStr
                };
                calendar.addEvent(event);
                updateSelectedBlocks(calendar.getEvents());
            },
            eventChange: function() {
                updateSelectedBlocks(calendar.getEvents());
            },
            eventRemove: function() {
                updateSelectedBlocks(calendar.getEvents());
            }
        });

        calendar.render();

        document.getElementById('prevWeek').addEventListener('click', function() {
            calendar.prev();
            updateWeekRange();
        });

        document.getElementById('nextWeek').addEventListener('click', function() {
            calendar.next();
            updateWeekRange();
        });

        document.getElementById('saveAvailability').addEventListener('click', function() {
            const events = calendar.getEvents().map(event => ({
                start: event.start.toISOString(),
                end: event.end.toISOString()
            }));

            fetch('/students/{{ $student->id }}/availability/week', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ events })
            }).then(response => response.json()).then(data => {
                alert('Availability saved successfully!');
            }).catch(error => {
                console.error('Error saving availability:', error);
            });
        });

        function updateSelectedBlocks(events) {
            selectedBlocksEl.innerHTML = '';
            let totalHours = 0;

            events.forEach(event => {
                const start = new Date(event.start);
                const end = new Date(event.end);
                const hours = (end - start) / (1000 * 60 * 60);
                totalHours += hours;

                const blockEl = document.createElement('div');
                blockEl.className = 'flex items-center justify-between p-3 bg-gray-100 rounded-lg';
                blockEl.innerHTML = `
                    <span>${start.toLocaleString()} – ${end.toLocaleString()}</span>
                    <span>${hours.toFixed(1)} hrs</span>
                `;
                selectedBlocksEl.appendChild(blockEl);
            });

            const totalEl = document.createElement('div');
            totalEl.className = 'text-right font-medium text-gray-700';
            totalEl.textContent = `Total Hours: ${totalHours.toFixed(1)}`;
            selectedBlocksEl.appendChild(totalEl);
        }

        function updateWeekRange() {
            const start = calendar.view.activeStart;
            const end = calendar.view.activeEnd;
            weekRangeEl.textContent = `${start.toLocaleDateString()} – ${end.toLocaleDateString()}`;
        }

        updateWeekRange();
    });
</script>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
@endsection