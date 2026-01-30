<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    RtoController,
    AuthController,
    UserController,
    ProfileController,
    ContractController,
    EsignatureController,
    StudentNoteController,
    StudentDocumentController,
    RtoPersonalDocumentController
};

use App\Http\Controllers\Admin\{
    CourseController,
    StudentController,
    IndustryController,
    CoordinatorController,
    RolePermissionController,
    DocumentChecklistController,
    RtoController as AdminRtoController,
    AuditController,
    StudentAssignmentController
};


Route::get('/', function () {
    return view('admin.auth.login');
});

// Authentication Routes
Route::get('/login', function () {
    return view('admin.auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', function () {
    return view('admin.auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User Dashboard
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/placements', [UserController::class, 'placements'])->name('student.placements');
    Route::get('/documents', [UserController::class, 'documents'])->name('student.documents');
});

// RTO Dashboard
Route::middleware(['auth', 'role:rto|admin'])->prefix('rto')->group(function () {

    /** -------------------------
     *  Dashboard
     * -------------------------- */
    Route::get('/dashboard', [RtoController::class, 'dashboard'])->name('rto.dashboard');


    /** -------------------------
     *  Students
     * -------------------------- */
    Route::controller(RtoController::class)->group(function () {
        Route::get('/students', 'students')->name('rto.students');
        Route::post('/students', 'storeStudent');
        Route::put('/students/{id}', 'updateStudent');
        Route::delete('/students/{id}', 'destroyStudent');
        Route::post('/students/upload', 'uploadStudents');
        Route::get('/students/csv-format', 'csvFormat');
        // Route::post('/students/{id}/notes', 'saveStudentNotes');
    });


    /** -------------------------
     *  Student Notes
     * -------------------------- */
    Route::controller(StudentNoteController::class)->prefix('students/{student}')->group(function () {
        Route::get('/notes', 'index');
        Route::post('/notes', 'store');
    });


    /** -------------------------
     *  Student Documents
     * -------------------------- */
    Route::controller(StudentDocumentController::class)->prefix('student-documents')->group(function () {
        Route::get('/{student}', 'index')->name('rto.student-documents.index');
        Route::post('/{student}', 'store')->name('rto.student-documents.store');
        Route::get('/{student}/existing-checklists', 'getExistingChecklists');
        Route::post('/assign-types/{student}', 'assignTypes');
        Route::delete('/{document}', 'destroy');
    });


    /** -------------------------
     *  Personal Documents
     * -------------------------- */
    Route::controller(RtoPersonalDocumentController::class)->prefix('my-documents')->group(function () {
        Route::get('/', 'index')->name('rto.my-documents');
        Route::post('/', 'store');
        Route::delete('/{document}', 'destroy');
    });


    /** -------------------------
     *  Industries
     * -------------------------- */
    Route::get('/industries', [RtoController::class, 'industries'])->name('rto.industries');


    /** -------------------------
     *  E-Signature
     * -------------------------- */
    Route::controller(EsignatureController::class)->prefix('esignature')->group(function () {
        Route::get('/', 'index')->name('rto.esignature');
        Route::post('/', 'store');
        Route::put('/{esignature}', 'update');
        Route::delete('/{esignature}', 'destroy');
    });


    /** -------------------------
     *  Contracts
     * -------------------------- */
    Route::controller(ContractController::class)->prefix('contracts')->group(function () {
        Route::get('/', 'rtoIndex')->name('rto.contracts');
        Route::post('/{contract}/sign', 'signContract');
        Route::get('/{contract}/view', 'viewContract')->name('rto.contracts.view');
    });
});


// Universal Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
});

// Admin & Coordinator Routes
Route::middleware(['auth', 'role:admin|placement_coordinator|sourcing_coordinator'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('dashboard', [AdminRtoController::class, 'dashboard'])->name('dashboard');
        Route::get('sourcing-dashboard', [AdminRtoController::class, 'dashboard'])->name('sourcing-dashboard');

        // RTOs
        Route::middleware('permission:rtos.view')->group(function () {
            Route::controller(AdminRtoController::class)->group(function () {
                Route::get('/rtos', 'index')->name('rtos');
                Route::middleware('permission:rtos.create')->group(function () {
                    Route::get('/rtos/create', 'create')->name('rtos.create');
                    Route::post('/rtos', 'store')->name('rtos.store');
                });
                Route::middleware('permission:rtos.edit')->group(function () {
                    Route::get('/rtos/{id}/edit', 'edit')->name('rtos.edit');
                    Route::put('/rtos/{id}', 'update')->name('rtos.update');
                    Route::patch('/rtos/{id}/toggle-status', 'toggleStatus');
                    Route::post('/rtos/update-status/{id}', 'updateStatus');
                });
                Route::delete('/rtos/{id}', 'destroy')->middleware('permission:rtos.delete');
                Route::get('/rtos/data', 'data')->name('rtos.data');
            });
        });

        // Courses
        Route::middleware('permission:courses.view')->group(function () {
            Route::controller(CourseController::class)->group(function () {
                Route::get('/courses', 'index')->name('courses');
                Route::get('/courses/data', 'data')->name('courses.data');
                Route::middleware('permission:courses.create')->group(function () {
                    Route::get('/courses/create', 'create')->name('courses.create');
                    Route::post('/courses', 'store')->name('courses.store');
                });
                Route::get('/courses/{id}/edit', 'edit')->name('courses.edit');
                Route::middleware('permission:courses.edit')->group(function () {
                    Route::put('/courses/{id}', 'update')->name('courses.update');
                    Route::post('/courses/update-status/{id}', 'updateStatus');
                });
                Route::delete('/courses/{id}', 'destroy')->middleware('permission:courses.delete');
            });
        });

        // Coordinators
        Route::middleware('permission:coordinators.view')->group(function () {
            Route::controller(CoordinatorController::class)->group(function () {
                    Route::get('/coordinators', 'index')->name('coordinators');
                    Route::get('/coordinators/data', 'data')->name('coordinators.data');
                    Route::middleware('permission:coordinators.create')->group(function () {
                        Route::get('/coordinators/create', 'create')->name('coordinators.create');
                        Route::post('/coordinators', 'store')->name('coordinators.store');
                    });
                    Route::middleware('permission:coordinators.edit')->group(function () {
                        Route::get('/coordinators/{id}/edit', 'edit')->name('coordinators.edit');
                        Route::put('/coordinators/{id}', 'update')->name('coordinators.update');
                        Route::patch('/coordinators/{id}/toggle-status', 'toggleStatus');
                        Route::post('/coordinators/update-status/{id}', 'updateStatus');
                        Route::patch('/coordinators/{id}/reset-password', 'resetPassword')->middleware('permission:coordinators.reset_password');
                    });
                    Route::delete('/coordinators/{id}', 'destroy')->middleware('permission:coordinators.delete');
            });
        });

        // Role & Permissions
        Route::controller(RolePermissionController::class)->group(function () {
                Route::get('/roles', 'roles')->name('roles');
                Route::post('/roles', 'storeRole');
                Route::put('/roles/{id}', 'updateRole');
                Route::delete('/roles/{id}', 'deleteRole');

                Route::get('/permissions', 'permissions')->name('permissions');
                Route::post('/permissions', 'storePermission');
                Route::put('/permissions/{id}', 'updatePermission');
                Route::delete('/permissions/{id}', 'deletePermission');

                Route::get('/assign-permissions', 'assignPermissions')->name('assign-permissions');
                Route::post('/assign-permissions', 'updateRolePermissions');
            });

            // Document Checklist
            Route::controller(DocumentChecklistController::class)->group(function () {
                Route::get('/document-checklist', 'index')->name('document-checklist');
                Route::post('/document-checklist', 'store');
                Route::put('/document-checklist/{id}', 'update');
                Route::delete('/document-checklist/{id}', 'destroy');
                Route::patch('/document-checklist/{id}/toggle-status', 'toggleStatus');
            });

            // Contracts
            Route::controller(ContractController::class)->group(function () {
                Route::get('/contracts', 'adminIndex')->name('contracts');
                Route::post('/contracts', 'store');
            Route::get('/contracts/{contract}/view', 'adminViewContract')->name('contracts.view');
            Route::delete('/contracts/{contract}', 'destroy');
        });

        // Students (Placement Coordinators & Admin)
        Route::middleware('permission:students.view')->group(function () {
            Route::controller(StudentController::class)->group(function () {
                Route::get('/students', 'index')->name('students');
                Route::get('/students/data', 'data')->name('students.data');
                Route::get('/students/download', 'download')->name('students.download');
                Route::get('/students/sourcing-coordinators', 'getSourcingCoordinators')->name('students.sourcing-coordinators');
                Route::middleware('permission:students.create')->group(function () {
                    Route::get('/students/create', 'create')->name('students.create');
                    Route::post('/students', 'store')->name('students.store');
                    Route::post('/students/upload', 'upload');
                    Route::get('/students/csv-format', 'csvFormat');
                });
                Route::middleware('permission:students.edit')->group(function () {
                    Route::put('/students/{id}', 'update')->name('students.update');
                    Route::post('/students/{id}/availability', 'updateAvailability')->name('students.availability.update');
                    Route::get('/students/{id}/availability/week', 'getWeekAvailability')->name('admin.students.availability.week');
                    Route::post('/students/{id}/availability/week', 'saveWeekAvailability')->name('admin.students.availability.save');
                });
                Route::delete('/students/{id}', 'destroy')->middleware('permission:students.delete');
            });

            Route::controller(StudentNoteController::class)->prefix('students/{student}')->group(function () {
                Route::get('/notes', 'index');
                Route::post('/notes', 'store');
            });

            Route::middleware('permission:students.documents')->group(function () {
                Route::controller(StudentDocumentController::class)->group(function () {
                    Route::get('/student-documents/{student}', 'index')->name('student-documents.index');
                    Route::post('/student-documents/{student}', 'store')->name('student-documents.store');
                    Route::post('/student-documents/assign-types/{student}', 'assignTypes');
                    Route::delete('/student-documents/{document}', 'destroy');
                    Route::post('/student-documents/assign-coordinator/{student}', 'assignCoordinator')->name('student-documents.assign-coordinator');
                });
            });
        });

        // Student Assignment (Placement Coordinators & Admin)
        Route::controller(\App\Http\Controllers\Admin\StudentIndustryController::class)->group(function () {
            Route::get('/assign-students', 'index')->name('assign-students');
            Route::post('/assign-students/assign', 'assignStudents')->name('assign-students.assign');
            Route::post('/assign-students/remove', 'removeAssignment')->name('assign-students.remove');
        });

        // Placement Opportunities (Sourcing Coordinators & Admin)
        Route::controller(\App\Http\Controllers\Admin\PlacementOpportunityController::class)->group(function () {
            Route::get('/placement-opportunities/industry/{industryId}', 'getByIndustry');
            Route::post('/placement-opportunities', 'store')->name('placement-opportunities.store');
            Route::put('/placement-opportunities/{id}', 'update')->name('placement-opportunities.update');
            Route::delete('/placement-opportunities/{id}', 'destroy');
            Route::patch('/placement-opportunities/{id}/toggle-status', 'toggleStatus');
            Route::get('/placement-opportunities/{id}/students', 'viewStudents')->name('placement-opportunities.students');
            Route::get('/opportunity-students/{opportunity}/{student}/documents', 'viewStudentDocuments')->name('opportunity-students.documents');
        });

        // Industries (Sourcing Coordinators & Admin)
        Route::controller(IndustryController::class)->group(function () {
            Route::get('/industries', 'index')->name('industries');
            Route::get('/industries/create', 'create')->name('industries.create');
            Route::get('/industries/data', 'data')->name('industries.data');
            Route::post('/industries', 'store')->name('industries.store');
            Route::get('/industries/{id}/edit', 'edit')->name('industries.edit');
            Route::put('/industries/{id}', 'update')->name('industries.update');
            Route::delete('/industries/{id}', 'destroy');
            Route::patch('/industries/{id}/toggle-status', 'toggleStatus');
            Route::post('/industries/update-status/{id}', 'updateStatus');

            Route::get('/industries/{id}/availability/week', 'getWeekAvailability')->name('industries.availability.week');
            Route::post('/industries/{id}/availability/week', 'saveWeekAvailability')->name('industries.availability.save');
        });

        // Industry Keywords (All coordinators can view, SC can CRUD)
        Route::controller(\App\Http\Controllers\Admin\IndustryKeywordController::class)->group(function () {
            Route::get('/industry-keywords', 'index')->name('industry-keywords');
            Route::get('/industry-keywords/search', 'search')->name('industry-keywords.search');
            Route::get('/industry-keywords/all', 'getAll')->name('industry-keywords.all');
            Route::post('/industry-keywords', 'store')->name('industry-keywords.store');
            Route::put('/industry-keywords/{id}', 'update')->name('industry-keywords.update');
            Route::delete('/industry-keywords/{id}', 'destroy')->name('industry-keywords.destroy');
        });

        // Student Appointments (All coordinators can view, PC can CRUD)
        Route::controller(\App\Http\Controllers\Admin\StudentAppointmentController::class)->group(function () {
            Route::get('/appointments/student/{studentId}', 'getByStudent')->name('appointments.by-student');
            Route::post('/appointments', 'store')->name('appointments.store');
            Route::put('/appointments/{id}', 'update')->name('appointments.update');
            Route::delete('/appointments/{id}', 'destroy')->name('appointments.destroy');
        });

        // Weekly Schedules
        Route::controller(\App\Http\Controllers\Admin\WeeklyScheduleController::class)->group(function () {

            Route::get('/weekly-schedules/{studentId}/availability', 'getWeekAvailability')->name('weekly-schedules.availability');
            Route::post('/weekly-schedules/{studentId}/availability', 'saveWeekAvailability')->name('weekly-schedules.save');
        });

        // Audit History
        Route::middleware('permission:reports.view')->group(function () {
            Route::controller(AuditController::class)->group(function () {
                Route::get('/audits', 'index')->name('audits');
                Route::get('/audits/{id}', 'show');
                Route::get('/audits/student/{studentId}', 'studentHistory')->name('audits.student');
            });
        });

        // Student Assignments
        Route::controller(StudentAssignmentController::class)->group(function () {
            Route::get('/student-assignments', 'index')->name('student-assignments');
            Route::post('/student-assignments', 'store')->name('student-assignments.store');
            Route::post('/student-assignments/bulk', 'bulkAssign')->name('student-assignments.bulk');
            Route::get('/student-assignments/{id}', 'show')->name('student-assignments.show');
            Route::post('/student-assignments/{id}/status', 'updateStatus')->name('student-assignments.status');
            Route::get('/student-assignments/data', 'getRequestsData')->name('student-assignments.data');
        });

        // Live Appointments
        Route::get('/live-appointments', function () {
            return view('admin.pages.live_appointments');
        })->name('live-appointments');

        // Assigned Requests
        Route::get('/assigned-requests', [StudentAssignmentController::class, 'index'])->name('assigned-requests');

        // Map View
        Route::get('/map-view', function () {
            return view('admin.pages.map_view');
        })->name('map-view');

        // Find Industries (Sourcing Coordinators)
        Route::middleware('role:sourcing_coordinator|admin')->group(function () {
            Route::get('/find-industries', function () {
                return view('admin.pages.find_industries');
            })->name('find-industries');
            Route::post('/industry-contacts', function (\Illuminate\Http\Request $request) {
                // Log industry contact attempts
                \Illuminate\Support\Facades\Log::info('Industry Contact', $request->all());
                return response()->json(['success' => true]);
            });
        });
    });
