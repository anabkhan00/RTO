// Student Documents Page JavaScript
// Helper functions
function getCsrf() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
}

function getStudentId() {
    // 1) Best source: server-provided
    if (window.studentId) return String(window.studentId);

    // 2) fallback: if you ever add id into window.student
    if (window.student?.id) return String(window.student.id);

    // 3) fallback: try multiple URL patterns
    const path = window.location.pathname;
    const match =
        path.match(/\/students\/(\d+)/) ||
        path.match(/\/student-documents\/(\d+)/) ||
        path.match(/\/weekly-schedules\/(\d+)/);

    return match?.[1];
}


function safeQuery(selector) {
    return document.querySelector(selector);
}

// Single DOMContentLoaded init function
function init() {
    console.log('🚀 Initializing student documents page...');
    initDropzone();
    initNotes();
    initUploads();
    initCalendar();
    initAutocomplete();
    initAppointments();
    initAvailability();
    handleHashScroll();
    console.log('✅ All modules initialized');
}

// Profile Image Dropzone functionality
function initDropzone() {
    const dropzone = safeQuery('#profileDropzone');
    const fileInput = safeQuery('#profileImageInput');
    const dropzoneContent = safeQuery('#dropzoneContent');
    const imagePreview = safeQuery('#imagePreview');
    const previewImg = safeQuery('#previewImg');
    const removeBtn = safeQuery('#removeImage');

    if (!dropzone || !fileInput) return;

    dropzone.addEventListener('click', () => fileInput.click());

    dropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzone.classList.add('border-brand', 'bg-blue-50');
    });

    dropzone.addEventListener('dragleave', () => {
        dropzone.classList.remove('border-brand', 'bg-blue-50');
    });

    dropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzone.classList.remove('border-brand', 'bg-blue-50');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFile(files[0]);
        }
    });

    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            handleFile(e.target.files[0]);
        }
    });

    function handleFile(file) {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImg.src = e.target.result;
                dropzoneContent.classList.add('hidden');
                imagePreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }

    if (removeBtn) {
        removeBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            fileInput.value = '';
            dropzoneContent.classList.remove('hidden');
            imagePreview.classList.add('hidden');
        });
    }
}

// Notes form functionality
function initNotes() {
    const notesForm = safeQuery('#notesForm');
    if (!notesForm) return;

    notesForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const textarea = notesForm.querySelector('textarea[name="content"]');
        if (!textarea) {
            toastr.error('Form element not found');
            return;
        }

        const noteContent = textarea.value.trim();
        if (!noteContent) {
            toastr.error('Please enter a note');
            return;
        }

        const studentId = getStudentId();

        $.ajax({
            url: `/admin/students/${studentId}/notes`,
            method: 'POST',
            data: {
                content: noteContent,
                _token: getCsrf()
            },
            success: function(response) {
                if (response.success) {
                    const roleColors = {
                        'admin': 'bg-red-50 border-red-200 text-red-800',
                        'rto': 'bg-blue-50 border-blue-200 text-blue-800',
                        'coordinator': 'bg-green-50 border-green-200 text-green-800'
                    };
                    const roleColor = roleColors[response.note.author_role] ||
                        'bg-gray-50 border-gray-200 text-gray-800';

                    const noteHtml = `
                        <div class="p-3 rounded-lg border ${roleColor}">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-xs font-medium uppercase tracking-wide">${response.note.author_role}</span>
                                <span class="text-xs opacity-75">${response.note.created_at}</span>
                            </div>
                            <p class="text-sm mb-1">${response.note.content}</p>
                            <p class="text-xs opacity-75">by ${response.note.author_name}</p>
                        </div>
                    `;

                    const notesDisplay = safeQuery('#allNotesDisplay');
                    const emptyState = notesDisplay?.querySelector('.text-center');
                    if (emptyState) {
                        emptyState.remove();
                    }
                    notesDisplay?.insertAdjacentHTML('afterbegin', noteHtml);

                    textarea.value = '';
                    toastr.success('Note added successfully');
                }
            },
            error: function(xhr) {
                toastr.error('Failed to save note');
            }
        });
    });
}

// Document upload functionality
function initUploads() {
    $('form[enctype="multipart/form-data"]').on('submit', function(e) {
        e.preventDefault();

        const uploadBtn = $('#uploadBtn');
        const uploadText = $('#uploadText');
        const uploadLoader = $('#uploadLoader');

        uploadBtn.prop('disabled', true);
        uploadText.addClass('hidden');
        uploadLoader.removeClass('hidden');

        const formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                if (response.success && response.document_ids) {
                    $('#uploadedDocuments').val(response.document_ids.join(','));
                    $('#checklistModal').removeClass('hidden');
                } else {
                    location.reload();
                }
                uploadBtn.prop('disabled', false);
                uploadText.removeClass('hidden');
                uploadLoader.addClass('hidden');
            },
            error: function(xhr, status, error) {
                toastr.error('Error uploading documents!');
                uploadBtn.prop('disabled', false);
                uploadText.removeClass('hidden');
                uploadLoader.addClass('hidden');
            }
        });
    });

    // Checklist form submission
    $('#checklistForm').on('submit', function(e) {
        e.preventDefault();
        const studentId = getStudentId();

        $.ajax({
            url: `/admin/student-documents/assign-types/${studentId}`,
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#checklistModal').addClass('hidden');
                location.reload();
            },
            error: function() {
                toastr.error('Error assigning document types!');
            }
        });
    });

    // Skip and close modal
    $('#skipChecklist, #closeChecklistModal').on('click', function() {
        $('#checklistModal').addClass('hidden');
        location.reload();
    });

    // Delete document with event delegation
    $(document).on('click', '.delete-document', function() {
        const documentId = $(this).data('id');
        const documentCard = $(this).closest('.bg-gray-50');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/rto/student-documents/${documentId}`,
                    type: 'DELETE',
                    data: {
                        _token: getCsrf()
                    },
                    success: function(response) {
                        if (response.success) {
                            documentCard.remove();
                            toastr.success('Document deleted successfully!');
                            location.reload();
                        }
                    },
                    error: function() {
                        toastr.error('Error deleting document!');
                    }
                });
            }
        });
    });
}

// FullCalendar initialization - FIXED VERSION
function initCalendar() {
    console.log('📅 Starting FullCalendar initialization...');

    const calendarEl = safeQuery('#calendar');
    if (!calendarEl) {
        console.warn('❌ Calendar element #calendar not found');
        return;
    }
    console.log('✅ Calendar element found');

    // Wait for FullCalendar to be loaded
    const waitForFullCalendar = () => {
        if (typeof FullCalendar === 'undefined') {
            console.warn('⏳ FullCalendar not loaded yet, retrying...');
            setTimeout(waitForFullCalendar, 100);
            return;
        }
        console.log('✅ FullCalendar is loaded');

        const studentId = getStudentId();
        const saveBtn = safeQuery('#saveBtn');
        if (!studentId || !saveBtn) {
            console.warn('❌ Student ID or save button not found');
            console.log('Student ID:', studentId);
            console.log('Save button:', saveBtn);
            return;
        }
        console.log('✅ Student ID and save button found:', studentId);

        try {
            console.log('🔧 Creating FullCalendar instance...');

            // Define updateSummary function outside the calendar config to avoid scope issues
            function updateSummary() {
                console.log('📊 Updating summary...');
                const events = calendar.getEvents();
                let totalHours = 0;
                let listHtml = '';

                events.sort((a, b) => a.start - b.start);

                events.forEach(event => {
                    const start = event.start;
                    const end = event.end;
                    const diffMs = end - start;
                    const diffHrs = diffMs / (1000 * 60 * 60);
                    totalHours += diffHrs;

                    const dayName = start.toLocaleDateString('en-US', {
                        weekday: 'short'
                    });
                    const timeStr = start.toLocaleTimeString('en-US', {
                            hour: '2-digit',
                            minute: '2-digit'
                        }) +
                        ' - ' +
                        end.toLocaleTimeString('en-US', {
                            hour: '2-digit',
                            minute: '2-digit'
                        });

                    listHtml += `<div class="p-2 bg-gray-50 rounded border border-gray-100 flex justify-between">
                                    <span><strong>${dayName}</strong> ${timeStr}</span>
                                    <span class="text-gray-400">${diffHrs.toFixed(1)}h</span>
                                 </div>`;
                });

                const totalHoursDisplay = safeQuery('#totalHoursDisplay');
                const totalHoursInput = safeQuery('#totalHoursInput');
                const eventList = safeQuery('#eventList');

                if (totalHoursDisplay) totalHoursDisplay.innerText = totalHours.toFixed(1);
                if (totalHoursInput) totalHoursInput.value = totalHours.toFixed(2);
                if (eventList) {
                    eventList.innerHTML = listHtml || '<span class="text-gray-400 italic">No availability set</span>';
                }
                console.log('✅ Summary updated, total hours:', totalHours.toFixed(1));
            }

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''
                },
                slotMinTime: '06:00:00',
                slotMaxTime: '22:00:00',
                allDaySlot: false,
                selectable: true,
                editable: true,
                firstDay: 1,
                height: '100%',

                events: function(info, successCallback, failureCallback) {
                    console.log('📡 Fetching events for:', info.startStr, 'to', info.endStr);
                    fetch(`/admin/weekly-schedules/${studentId}/availability?start=${info.startStr}&end=${info.endStr}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log('✅ Events loaded:', data.length || 0, 'events');
                            successCallback(data);
                        })
                        .catch(error => {
                            console.error('❌ Error loading events:', error);
                            failureCallback(error);
                        });
                },

                select: function(info) {
                    console.log('➕ Adding event:', info.startStr, 'to', info.endStr);
                    calendar.addEvent({
                        title: 'Available',
                        start: info.startStr,
                        end: info.endStr,
                        allDay: false
                    });
                    calendar.unselect();
                    updateSummary();
                },

                eventClick: function(info) {
                    if (confirm('Remove this time slot?')) {
                        console.log('🗑️ Removing event:', info.event.title);
                        info.event.remove();
                        updateSummary();
                    }
                },

                eventDrop: function(info) {
                    console.log('🔄 Event dropped:', info.event.title);
                    updateSummary();
                },
                eventResize: function(info) {
                    console.log('📏 Event resized:', info.event.title);
                    updateSummary();
                },
                eventsSet: function() {
                    console.log('📋 Events set');
                    updateSummary();
                }
            });

            calendar.render();
            console.log('🎉 FullCalendar rendered successfully!');

            // Save button functionality
            saveBtn.addEventListener('click', function() {
                console.log('💾 Saving schedule...');
                const viewStart = calendar.view.activeStart;
                const offset = viewStart.getTimezoneOffset() * 60000;
                const localDate = new Date(viewStart.getTime() - offset);
                const weekStartStr = localDate.toISOString().split('T')[0];

                const events = calendar.getEvents().map(e => ({
                    start: e.start.toISOString(),
                    end: e.end.toISOString()
                }));

                const payload = {
                    week_start: weekStartStr,
                    total_hours: safeQuery('#totalHoursInput')?.value || '0',
                    events: events,
                    _token: getCsrf()
                };

                const originalText = saveBtn.innerHTML;
                saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
                saveBtn.disabled = true;

                fetch(`/admin/weekly-schedules/${studentId}/availability`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('✅ Schedule saved successfully');
                            toastr.success('Schedule saved successfully');
                        } else {
                            console.error('❌ Failed to save schedule:', data);
                            toastr.error('Failed to save schedule');
                        }
                    })
                    .catch(error => {
                        console.error('❌ Error saving schedule:', error);
                        toastr.error('An error occurred');
                    })
                    .finally(() => {
                        saveBtn.innerHTML = originalText;
                        saveBtn.disabled = false;
                    });
            });

        } catch (error) {
            console.error('❌ Error initializing FullCalendar:', error);
            toastr.error('Failed to initialize calendar');
        }
    };

    waitForFullCalendar();
}

// Google Maps initialization - exposed globally for callback
window.initIndustryMap = function() {
    if (typeof google === 'undefined' || !google.maps || !window.student) {
        console.warn('Google Maps API or student data not loaded');
        return;
    }

    const student = window.student;
    const industries = window.industries || [];

    if (!student.lat || !student.lng) {
        console.warn('Student coordinates not available');
        return;
    }

    const studentLat = Number(student.lat);
    const studentLng = Number(student.lng);

    if (!Number.isFinite(studentLat) || !Number.isFinite(studentLng)) {
        console.warn('Invalid student coordinates');
        return;
    }

    const mapElement = safeQuery('#industryMap');
    if (!mapElement) return;

    const map = new google.maps.Map(mapElement, {
        center: { lat: studentLat, lng: studentLng },
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
    });

    // Student marker (red)
    new google.maps.Marker({
        position: { lat: studentLat, lng: studentLng },
        map: map,
        title: student.name,
        icon: {
            url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" fill="#ef4444"/>
                    <circle cx="12" cy="9" r="2.5" fill="white"/>
                </svg>
            `),
            scaledSize: new google.maps.Size(24, 24),
            anchor: new google.maps.Point(12, 24)
        }
    });

    // Industry markers (green) - filter to 20km radius
    industries.forEach((industry, index) => {
        const lat = Number(industry.lat);
        const lng = Number(industry.lng);

        if (!Number.isFinite(lat) || !Number.isFinite(lng)) return;

        const distance = calculateDistance(studentLat, studentLng, lat, lng);
        if (distance > 20) return;

        setTimeout(() => {
            const marker = new google.maps.Marker({
                position: { lat, lng },
                map: map,
                title: industry.name,
                animation: google.maps.Animation.DROP,
                icon: {
                    url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" fill="#22c55e"/>
                            <circle cx="12" cy="9" r="2.5" fill="white"/>
                        </svg>
                    `),
                    scaledSize: new google.maps.Size(24, 24),
                    anchor: new google.maps.Point(12, 24)
                }
            });

            const infoWindow = new google.maps.InfoWindow({
                content: `<div style="font-family: system-ui, sans-serif; padding: 8px;"><strong>${industry.name}</strong><br><span style="color: #666; font-size: 13px;">${industry.contact_person || 'No Contact'}</span><br><small style="color: #22c55e;">Industry Partner</small></div>`
            });

            marker.addListener('click', () => infoWindow.open(map, marker));
        }, index * 200);
    });
};

// Calculate distance between two points (Haversine formula)
function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371;
    const dLat = deg2rad(lat2 - lat1);
    const dLon = deg2rad(lon2 - lon1);
    const a =
        Math.sin(dLat/2) * Math.sin(dLat/2) +
        Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
        Math.sin(dLon/2) * Math.sin(dLon/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    return R * c;
}

function deg2rad(deg) {
    return deg * (Math.PI/180);
}

function initAutocomplete() {
    const addressInput = safeQuery('#addressInput');
    const latitudeInput = safeQuery('#latitudeInput');
    const longitudeInput = safeQuery('#longitudeInput');
    if (!addressInput || !latitudeInput || !longitudeInput) return;

    const waitForPlaces = () => {
        if (!(window.google?.maps?.places)) {
            setTimeout(waitForPlaces, 150);
            return;
        }

        const autocomplete = new google.maps.places.Autocomplete(addressInput, {
            types: ['address'],
            componentRestrictions: { country: 'au' }
        });

        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();
            if (!place.geometry?.location) return;

            latitudeInput.value = place.geometry.location.lat();
            longitudeInput.value = place.geometry.location.lng();
        });
    };

    waitForPlaces();
}


// Appointment functions
function initAppointments() {
    const studentId = getStudentId();
    if (!studentId) return;

    window.openAppointmentModal = function(appointment = null) {
        if (appointment) {
            $('#appointmentModalTitle').text('Edit Appointment');
            $('#appointmentId').val(appointment.id);
            $('#appointmentTitle').val(appointment.title);
            $('#appointmentDate').val(appointment.date);
            $('#appointmentTime').val(appointment.time);
            $('#appointmentNotes').val(appointment.notes || '');
        } else {
            $('#appointmentModalTitle').text('Add Appointment');
            $('#appointmentForm')[0].reset();
            $('#appointmentId').val('');
        }
        $('#appointmentModal').removeClass('hidden');
    };

    window.closeAppointmentModal = function() {
        $('#appointmentModal').addClass('hidden');
    };

    $('#appointmentForm').on('submit', function(e) {
        e.preventDefault();

        const id = $('#appointmentId').val();
        const data = {
            student_id: studentId,
            title: $('#appointmentTitle').val(),
            date: $('#appointmentDate').val(),
            time: $('#appointmentTime').val(),
            notes: $('#appointmentNotes').val(),
            _token: getCsrf()
        };

        const url = id ? `/admin/appointments/${id}` : '/admin/appointments';
        const method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: data,
            success: function() {
                toastr.success('Appointment saved');
                closeAppointmentModal();
                loadAppointments();
            }
        });
    });

    window.loadAppointments = function() {
        $.ajax({
            url: `/admin/appointments/student/${studentId}`,
            success: function(appointments) {
                let html = '';
                const canEdit = window.authUser?.role === 'admin' || window.authUser?.coordinator_type === 'placement';

                appointments.forEach(apt => {
                    html += `<div class="flex justify-between items-center p-3 border rounded">
                        <div>
                            <div class="text-sm font-medium">${apt.title}</div>
                            <div class="text-xs text-gray-500">${apt.date} at ${apt.time}</div>
                            ${apt.notes ? `<div class="text-xs text-gray-600 mt-1">${apt.notes}</div>` : ''}
                            <div class="text-xs text-gray-400 mt-1">By: ${apt.creator.name}</div>
                        </div>
                        ${canEdit ? `<div class="flex gap-2">
                                            <button onclick='openAppointmentModal(${JSON.stringify(apt)})'
                                                    class="text-blue-600 hover:text-blue-800 text-xs">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button onclick="deleteAppointment(${apt.id})"
                                                    class="text-red-600 hover:text-red-800 text-xs">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>` : ''}
                    </div>`;
                });
                $('#appointmentsList').html(html ||
                    '<p class="text-gray-500 text-sm">No appointments scheduled</p>');
            }
        });
    };

    window.deleteAppointment = function(id) {
        if (!confirm('Delete this appointment?')) return;

        $.ajax({
            url: `/admin/appointments/${id}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': getCsrf()
            },
            success: function() {
                toastr.success('Appointment deleted');
                loadAppointments();
            }
        });
    };

    loadAppointments();
}

// Availability functions
function initAvailability() {
    // Handle checkbox changes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('availability-checkbox')) {
            const day = e.target.dataset.day;
            const timesDiv = document.getElementById(`times-${day}`);
            if (timesDiv) {
                timesDiv.classList.toggle('hidden', !e.target.checked);
            }
        }
    });

    // Availability form submission
    const availabilityForm = safeQuery('#availabilityForm');
    if (availabilityForm) {
        availabilityForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const studentId = getStudentId();
            if (!studentId) return;

            const availability = {};

            document.querySelectorAll('.availability-checkbox').forEach(checkbox => {
                const day = checkbox.dataset.day;
                if (checkbox.checked) {
                    const timesDiv = document.getElementById(`times-${day}`);
                    const startInput = timesDiv?.querySelector('input[type="time"]:first-child');
                    const endInput = timesDiv?.querySelector('input[type="time"]:last-child');

                    if (startInput && endInput) {
                        availability[day] = {
                            enabled: true,
                            start: startInput.value,
                            end: endInput.value
                        };
                    }
                }
            });

            fetch(`/admin/students/${studentId}/availability`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrf()
                    },
                    body: JSON.stringify({
                        student_availability: availability
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        toastr.success('Availability updated successfully');
                        closeAvailabilityModal();
                        loadCalendlyCalendar();
                    } else {
                        toastr.error('Failed to update availability');
                    }
                })
                .catch(err => {
                    console.error(err);
                    toastr.error('Failed to update availability');
                });
        });
    }

    // Load calendar on init
    loadCalendlyCalendar();
}

// Availability Functions - exposed globally for onclick handlers
window.openAvailabilityModal = function() {
    const availability = window.studentAvailability || {};

    // Reset form
    document.querySelectorAll('.availability-checkbox').forEach(checkbox => {
        const day = checkbox.dataset.day;
        const isEnabled = availability[day] && availability[day].enabled;
        checkbox.checked = isEnabled;

        const timesDiv = document.getElementById(`times-${day}`);
        if (timesDiv) {
            timesDiv.style.display = isEnabled ? 'block' : 'none';

            if (isEnabled && availability[day]) {
                const startInput = timesDiv.querySelector('input[type="time"]:first-child');
                const endInput = timesDiv.querySelector('input[type="time"]:last-child');
                if (startInput) startInput.value = availability[day].start || '09:00';
                if (endInput) endInput.value = availability[day].end || '17:00';
            }
        }
    });

    const modal = safeQuery('#availabilityModal');
    if (modal) modal.classList.remove('hidden');
};

window.closeAvailabilityModal = function() {
    const modal = safeQuery('#availabilityModal');
    if (modal) modal.classList.add('hidden');
};

window.formatTime = function(time) {
    const [hours, minutes] = time.split(':');
    const hour = parseInt(hours);
    const ampm = hour >= 12 ? 'PM' : 'AM';
    const displayHour = hour % 12 || 12;
    return `${displayHour}:${minutes} ${ampm}`;
};

window.loadCalendlyCalendar = function() {
    const availability = window.studentAvailability || {};
    const calendarDiv = safeQuery('#calendlyCalendar');

    if (!calendarDiv) return;

    const days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    const dayLabels = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    if (Object.keys(availability).length === 0) {
        calendarDiv.innerHTML = `
            <div class="text-center py-12">
                <i class="bi bi-calendar-x text-4xl text-gray-300 mb-4"></i>
                <h4 class="text-lg font-medium text-gray-900 mb-2">No availability set</h4>
                <p class="text-gray-500 mb-4">Set your weekly schedule to show available time slots</p>
                <button onclick="openAvailabilityModal()" class="bg-brand text-white px-4 py-2 rounded-lg hover:bg-gold transition-colors text-sm font-medium">
                    <i class="bi bi-calendar-plus mr-2"></i>Set Availability
                </button>
            </div>
        `;
        return;
    }

    let html = '';

    days.forEach((day, index) => {
        const dayAvail = availability[day];
        const isAvailable = dayAvail && dayAvail.enabled;

        html += `
            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:border-brand transition-colors">
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full mr-3 ${isAvailable ? 'bg-green-500' : 'bg-gray-300'}"></div>
                    <div>
                        <h4 class="font-medium text-gray-900">${dayLabels[index]}</h4>
                        ${isAvailable ? `
                                    <p class="text-sm text-gray-600">${formatTime(dayAvail.start)} - ${formatTime(dayAvail.end)}</p>
                                ` : '<p class="text-sm text-gray-500">Unavailable</p>'}
                    </div>
                </div>
                <div class="flex items-center">
                    ${isAvailable ? `
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="bi bi-check-circle mr-1"></i>Available
                                        </span>
                                    ` : `
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <i class="bi bi-x-circle mr-1"></i>Unavailable
                                        </span>
                                    `}
                </div>
            </div>
        `;
    });

    calendarDiv.innerHTML = html;
};

window.assignCoordinators = function() {
    const placementCoordinatorId = safeQuery('#placementCoordinator')?.value;
    const sourcingCoordinatorId = safeQuery('#sourcingCoordinator')?.value;
    const studentId = getStudentId();

    if (!studentId) return;

    fetch(`/admin/student-documents/assign-coordinator/${studentId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrf()
            },
            body: JSON.stringify({
                placement_coordinator_id: placementCoordinatorId,
                sourcing_coordinator_id: sourcingCoordinatorId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success('Coordinators assigned successfully');
            } else {
                toastr.error('Failed to assign coordinators');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('An error occurred');
        });
};

// Handle hash navigation to #document-section
function handleHashScroll() {
    if (window.location.hash === '#document-section') {
        const element = safeQuery('#document-section');
        if (element) {
            element.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
            setTimeout(() => {
                element.style.backgroundColor = '';
            }, 2000);
        }
    }
}

// Initialize everything when DOM is ready - SINGLE LISTENER
document.addEventListener('DOMContentLoaded', init);
