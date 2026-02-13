// Extracted from resources/views/admin/pages/students.blade.php
function getCsrfToken() {
    return (
        window.studentsPageConfig?.csrf ||
        document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
        ''
    );
}

const studentsPageConfig = window.studentsPageConfig || {};

// Initialize DataTables with server-side processing
let columns = [];
if (studentsPageConfig.hasPlacementCoordinatorRole) {
    columns.push({
        data: "checkbox",
        orderable: false
    });
}

columns = columns.concat([
    {
        data: "name",
        orderable: true
    },
    {
        data: "industry",
        orderable: false
    },
    {
        data: "course",
        orderable: false
    },
    {
        data: "progress",
        orderable: false
    },
    {
        data: "status",
        orderable: false
    },
    {
        data: "coordinator",
        orderable: false
    },
    {
        data: "address",
        orderable: true
    },
    {
        data: "created_at",
        orderable: true
    }
]);

if (studentsPageConfig.isAdmin) {
    columns.push({
        data: "actions",
        orderable: false
    });
}

let studentsTable = $('#studentsTable').DataTable({
    "processing": true,
    "serverSide": true,
    "ajax": {
        "url": studentsPageConfig.dataUrl || "/admin/students/data",
        "type": "GET",
        "data": function (d) {
            d.search = $('#searchFilter').val();
            d.location = $('#locationFilter').val();
            d.priority = $('#priorityFilter').val();
            d.course = $('#courseFilter').val();
            d.progress = $('#progressFilter').val();
            d.from_date = $('#fromDate').val();
            d.to_date = $('#toDate').val();
            if (studentsPageConfig.rtoId) {
                d.rto_id = studentsPageConfig.rtoId;
            }
        }
    },
    "columns": columns,
    "pageLength": 25,
    "searching": false,
    "ordering": true,
    "info": false,
    "lengthChange": false,
    "dom": 'rt<"flex justify-end mt-4"p>',
    "language": {
        "processing": "Processing..."
    },
    "createdRow": function (row, data, dataIndex) {
        $(row).addClass('hover:bg-gray-50 transition-colors cursor-pointer');

        // Prevent row click on actions column and checkbox column
        $(row).find('td:last-child, td:first-child').on('click', function (e) {
            e.stopPropagation();
        });

        // Row click navigation
        $(row).on('click', function (e) {
            window.location.href = data.row_url;
        });
    }
});

// Modal functionality
const studentModal = document.getElementById('studentModal');
const uploadModal = document.getElementById('uploadModal');
// const openModalBtn = document.getElementById('openModalBtn');
const openUploadBtn = document.getElementById('openUploadBtn');
// const closeModalBtn = document.getElementById('closeModalBtn');
const closeUploadBtn = document.getElementById('closeUploadBtn');
const cancelBtn = document.getElementById('cancelBtn');
const cancelUploadBtn = document.getElementById('cancelUploadBtn');

// Open modals
// openModalBtn.addEventListener('click', () => {
//     studentModal.classList.remove('hidden');
//     document.getElementById('modalTitle').textContent = 'Add Student';
//     document.getElementById('studentForm').reset();
// });

if (openUploadBtn) {
    openUploadBtn.addEventListener('click', () => {
        uploadModal.classList.remove('hidden');
    });
}


// Close modals
// [closeModalBtn, cancelBtn].forEach(btn => {
//     btn.addEventListener('click', () => {
//         studentModal.classList.add('hidden');
//     });
// });

[closeUploadBtn, cancelUploadBtn].forEach(btn => {
    btn.addEventListener('click', () => {
        uploadModal.classList.add('hidden');
    });
});

// Close modals on outside click
[studentModal, uploadModal].forEach(modal => {
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });
});

// Filter functionality - only on Apply Filters button click
$('#applyFilters').on('click', function () {
    studentsTable.ajax.reload();
});

$('#resetFilters').on('click', function () {
    $('#searchFilter').val('');
    $('#locationFilter').val('');
    $('#priorityFilter').val('');
    $('#courseFilter').val('');
    $('#progressFilter').val('');
    $('#fromDate').val('');
    $('#toDate').val('');
    studentsTable.ajax.reload();
});

// Dropdown functionality for DataTables dynamic content
$(document).on('click', 'button[onclick*="toggleDropdown"]', function (e) {
    e.preventDefault();
    e.stopPropagation();

    const button = this;
    const onclickAttr = $(this).attr('onclick');
    const match = onclickAttr.match(/toggleDropdown\((\d+)\)/);

    if (match) {
        const id = match[1];
        const dropdown = document.getElementById(`dropdown-${id}`);
        const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');

        // Close all other dropdowns and reset their styles
        allDropdowns.forEach(dd => {
            if (dd !== dropdown) {
                dd.classList.add('hidden');
                dd.style.position = '';
                dd.style.top = '';
                dd.style.bottom = '';
                dd.style.left = '';
                dd.style.right = '';
                dd.style.marginTop = '';
                dd.style.marginBottom = '';
            }
        });

        if (dropdown) {
            // If dropdown is currently visible, just hide it
            if (!dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
                dropdown.style.position = '';
                dropdown.style.top = '';
                dropdown.style.bottom = '';
                dropdown.style.left = '';
                dropdown.style.right = '';
                dropdown.style.marginTop = '';
                dropdown.style.marginBottom = '';
                return;
            }

            // Show dropdown
            dropdown.classList.remove('hidden');

            // Use fixed positioning to avoid affecting table layout
            setTimeout(() => {
                const buttonRect = button.getBoundingClientRect();
                const dropdownRect = dropdown.getBoundingClientRect();
                const viewportHeight = window.innerHeight;
                const viewportWidth = window.innerWidth;

                // Set to fixed positioning
                dropdown.style.position = 'fixed';

                // Calculate vertical position
                const spaceBelow = viewportHeight - buttonRect.bottom;
                const spaceAbove = buttonRect.top;

                if (spaceBelow >= dropdownRect.height || spaceBelow > spaceAbove) {
                    // Position below button
                    dropdown.style.top = (buttonRect.bottom + 4) + 'px';
                    dropdown.style.bottom = 'auto';
                } else {
                    // Position above button
                    dropdown.style.bottom = (viewportHeight - buttonRect.top + 4) + 'px';
                    dropdown.style.top = 'auto';
                }

                // Calculate horizontal position (align to right edge of button)
                const rightEdge = buttonRect.right;
                if (rightEdge >= dropdownRect.width) {
                    dropdown.style.left = (rightEdge - dropdownRect.width) + 'px';
                    dropdown.style.right = 'auto';
                } else {
                    dropdown.style.left = buttonRect.left + 'px';
                    dropdown.style.right = 'auto';
                }
            }, 10);
        }
    }
});

// Close dropdowns when clicking outside
$(document).on('click', function (e) {
    if (!$(e.target).closest('.relative').length) {
        document.querySelectorAll('[id^="dropdown-"]').forEach(dd => {
            dd.classList.add('hidden');
        });
    }
});

// Prevent dropdown from closing when clicking inside it
$(document).on('click', '[id^="dropdown-"]', function (e) {
    e.stopPropagation();
});

function toggleDropdown(id) {
    event.stopPropagation();
    const button = event.currentTarget;
    const dropdown = document.getElementById(`dropdown-${id}`);

    // Close all other dropdowns
    document.querySelectorAll('[id^="dropdown-"]').forEach(d => {
        if (d.id !== `dropdown-${id}`) {
            d.classList.add('hidden');
            // Reset positioning
            d.style.position = '';
            d.style.top = '';
            d.style.bottom = '';
            d.style.left = '';
            d.style.right = '';
            d.style.marginTop = '';
            d.style.marginBottom = '';
        }
    });

    // If dropdown is currently visible, just hide it
    if (!dropdown.classList.contains('hidden')) {
        dropdown.classList.add('hidden');
        // Reset positioning
        dropdown.style.position = '';
        dropdown.style.top = '';
        dropdown.style.bottom = '';
        dropdown.style.left = '';
        dropdown.style.right = '';
        dropdown.style.marginTop = '';
        dropdown.style.marginBottom = '';
        return;
    }

    // Show dropdown first
    dropdown.classList.remove('hidden');

    // Use fixed positioning to avoid affecting table layout
    setTimeout(() => {
        const buttonRect = button.getBoundingClientRect();
        const dropdownRect = dropdown.getBoundingClientRect();
        const viewportHeight = window.innerHeight;
        const viewportWidth = window.innerWidth;

        // Set to fixed positioning
        dropdown.style.position = 'fixed';

        // Calculate vertical position
        const spaceBelow = viewportHeight - buttonRect.bottom;
        const spaceAbove = buttonRect.top;

        if (spaceBelow >= dropdownRect.height || spaceBelow > spaceAbove) {
            // Position below button
            dropdown.style.top = (buttonRect.bottom + 4) + 'px';
            dropdown.style.bottom = 'auto';
        } else {
            // Position above button
            dropdown.style.bottom = (viewportHeight - buttonRect.top + 4) + 'px';
            dropdown.style.top = 'auto';
        }

        // Calculate horizontal position (align to right edge of button)
        const rightEdge = buttonRect.right;
        if (rightEdge >= dropdownRect.width) {
            dropdown.style.left = (rightEdge - dropdownRect.width) + 'px';
            dropdown.style.right = 'auto';
        } else {
            dropdown.style.left = buttonRect.left + 'px';
            dropdown.style.right = 'auto';
        }
    }, 10);
}

// Edit student function
function editStudent(id, name, email, phone, address, courseId) {
    document.getElementById('modalTitle').textContent = 'Edit Student';
    document.getElementById('studentName').value = name;
    document.getElementById('studentEmail').value = email;
    document.getElementById('studentPhone').value = phone;
    document.getElementById('studentAddress').value = address;
    document.getElementById('studentCourse').value = courseId;
    studentModal.classList.remove('hidden');
}

// Filter toggle functionality
document.getElementById('toggleFilters').addEventListener('click', function () {
    const filterContent = document.getElementById('filterContent');
    const filterIcon = document.getElementById('filterIcon');

    filterContent.classList.toggle('hidden');
    filterIcon.classList.toggle('rotate-180');
});

// Student details function
function showStudentDetails(id, name, email, phone, address) {
    Swal.fire({
        title: 'Student Details',
        html: `
                    <div class="text-left space-y-3">
                        <div><strong>Name:</strong> ${name}</div>
                        <div><strong>Email:</strong> ${email}</div>
                        <div><strong>Phone:</strong> ${phone || 'Not provided'}</div>
                        <div><strong>Address:</strong> ${address || 'Not provided'}</div>
                    </div>
                `,
        icon: 'info',
        confirmButtonText: 'Close',
        confirmButtonColor: '#1E293B'
    });
}

// Delete student function
function deleteStudent(id) {
    const studentId = String(id ?? '').trim();
    if (!studentId || studentId === 'undefined' || studentId === 'null') {
        Swal.fire('Error!', 'Invalid student id for delete.', 'error');
        return;
    }

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/students/${studentId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(async (response) => {
                    const data = await response.json();
                    if (!response.ok) throw data;

                    if (data.success) {
                        Swal.fire('Deleted!', data.message || 'Student has been deleted.', 'success');
                        studentsTable.ajax.reload(null, false);
                    } else {
                        Swal.fire('Error!', data.message || 'Failed to delete student.', 'error');
                    }
                })
                .catch((err) => {
                    console.error(err);
                    Swal.fire('Error!', err?.message || 'An error occurred.', 'error');
                });

        }
    });
}

// Handle delete links from dropdown with explicit data attribute.
$(document).on('click', '.delete-student', function (e) {
    e.preventDefault();
    e.stopPropagation();
    const studentId = $(this).data('student-id');
    deleteStudent(studentId);
});

// Update Student Status
function updateStudentStatus(id, newStatus) {
    fetch(`/admin/students/update-status/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken()
        },
        body: JSON.stringify({
            status: newStatus
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success('Status updated successfully');
            } else {
                toastr.error('Failed to update status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('An error occurred');
        });
}

// Assign Coordinator Functions
function assignCoordinator(studentId) {
    document.getElementById('selectedStudentId').value = studentId;
    loadCoordinators();
    document.getElementById('coordinatorModal').classList.remove('hidden');
}

function closeCoordinatorModal() {
    document.getElementById('coordinatorModal').classList.add('hidden');
}

function loadCoordinators() {
    fetch('/admin/students/coordinators')
        .then(response => response.json())
        .then(coordinators => {
            const select = document.getElementById('coordinatorSelect');
            select.innerHTML = '<option value="">Unassign Coordinator</option>';
            coordinators.forEach(coordinator => {
                select.innerHTML += `<option value="${coordinator.id}">${coordinator.name}</option>`;
            });
        })
        .catch(error => {
            console.error('Error loading coordinators:', error);
            toastr.error('Failed to load coordinators');
        });
}

document.getElementById('coordinatorForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const studentId = document.getElementById('selectedStudentId').value;
    const coordinatorId = document.getElementById('coordinatorSelect').value;

    fetch(`/admin/students/assign-coordinator/${studentId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken()
        },
        body: JSON.stringify({
            coordinator_id: coordinatorId
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success(data.message);
                closeCoordinatorModal();
                studentsTable.ajax.reload();
            } else {
                toastr.error('Failed to assign coordinator');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('An error occurred');
        });
});

// Close modal on outside click
document.getElementById('coordinatorModal').addEventListener('click', function (e) {
    if (e.target === this) {
        closeCoordinatorModal();
    }
});

// Sourcing Coordinator Assignment Functions
let selectedStudents = [];

// Multi-select functionality
$(document).on('change', '.student-checkbox', function () {
    const studentId = $(this).val();
    if ($(this).is(':checked')) {
        selectedStudents.push(studentId);
    } else {
        selectedStudents = selectedStudents.filter(id => id !== studentId);
    }
    updateBulkAssignButton();
});

$('#selectAll, #headerSelectAll').on('change', function () {
    const isChecked = $(this).is(':checked');
    $('.student-checkbox').prop('checked', isChecked);

    if (isChecked) {
        selectedStudents = [];
        $('.student-checkbox').each(function () {
            selectedStudents.push($(this).val());
        });
    } else {
        selectedStudents = [];
    }
    updateBulkAssignButton();
});

function updateBulkAssignButton() {
    const bulkBtn = $('#bulkAssignBtn');
    if (selectedStudents.length > 0) {
        bulkBtn.prop('disabled', false).text(`Assign ${selectedStudents.length} Selected`);
    } else {
        bulkBtn.prop('disabled', true).text('Assign Selected to Sourcing Coordinator');
    }
}

$('#bulkAssignBtn').on('click', function () {
    if (selectedStudents.length > 0) {
        loadSourcingCoordinators();
        document.getElementById('sourcingCoordinatorModal').classList.remove('hidden');
    }
});

function assignSourcingCoordinator(studentId) {
    selectedStudents = [studentId];
    loadSourcingCoordinators();
    document.getElementById('sourcingCoordinatorModal').classList.remove('hidden');
}

function closeSourcingCoordinatorModal() {
    document.getElementById('sourcingCoordinatorModal').classList.add('hidden');
}

function loadSourcingCoordinators() {
    fetch('/admin/students/sourcing-coordinators')
        .then(response => response.json())
        .then(coordinators => {
            const select = document.getElementById('sourcingCoordinatorSelect');
            select.innerHTML = '<option value="">Select Coordinator</option>';
            coordinators.forEach(coordinator => {
                select.innerHTML += `<option value="${coordinator.id}">${coordinator.name}</option>`;
            });
        })
        .catch(error => {
            console.error('Error loading sourcing coordinators:', error);
            toastr.error('Failed to load sourcing coordinators');
        });
}

document.getElementById('sourcingCoordinatorForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const sourcingCoordinatorId = document.getElementById('sourcingCoordinatorSelect').value;

    if (!sourcingCoordinatorId) {
        toastr.error('Please select a sourcing coordinator');
        return;
    }

    if (selectedStudents.length === 0) {
        toastr.error('No students selected');
        return;
    }

    fetch('/admin/student-assignments/bulk', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken()
        },
        body: JSON.stringify({
            student_ids: selectedStudents,
            sourcing_coordinator_id: sourcingCoordinatorId
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success(data.success);
                closeSourcingCoordinatorModal();
                studentsTable.ajax.reload();
                selectedStudents = [];
                $('.student-checkbox').prop('checked', false);
                $('#selectAll, #headerSelectAll').prop('checked', false);
                updateBulkAssignButton();
            } else {
                toastr.error(data.error || 'Failed to assign students');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('An error occurred');
        });
});

// Close sourcing coordinator modal on outside click
document.getElementById('sourcingCoordinatorModal').addEventListener('click', function (e) {
    if (e.target === this) {
        closeSourcingCoordinatorModal();
    }
});

