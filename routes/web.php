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

// Admin Routes
Route::middleware(['auth', 'role:admin|coordinator'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        // Route::get('/dashboard', fn() => view('admin.pages.dashboard'))->name('dashboard');

        // RTO
        Route::controller(AdminRtoController::class)->group(function () {
            Route::get('dashboard', 'dashboard')->name('dashboard');
            Route::get('/rto', 'index')->name('add_rto');
            Route::post('/rto', 'store');
            Route::put('/rto/{id}', 'update');
            Route::delete('/rto/{id}', 'destroy');
            Route::patch('/rto/{id}/toggle-status', 'toggleStatus');
            Route::get('/rto/{id}/details', 'details');
        });

        // Students
        Route::controller(StudentController::class)->group(function () {
            Route::get('/students', 'index')->name('students');
            Route::post('/students', 'store');
            Route::put('/students/{id}', 'update');
            Route::delete('/students/{id}', 'destroy');
            Route::post('/students/upload', 'upload');
            Route::get('/students/download', 'download')->name('students.download');
            Route::get('/students/csv-format', 'csvFormat');
        });

        Route::controller(StudentNoteController::class)->prefix('students/{student}')->group(function () {
            Route::get('/notes', 'index');
            Route::post('/notes', 'store');
        });

        // Courses
        Route::controller(CourseController::class)->group(function () {
            Route::get('/courses', 'index')->name('courses');
            Route::post('/courses', 'store');
            Route::put('/courses/{id}', 'update');
            Route::delete('/courses/{id}', 'destroy');
        });

        // Industries
        Route::controller(IndustryController::class)->group(function () {
            Route::get('/industries', 'index')->name('Industries');
            Route::post('/industries', 'store');
            Route::put('/industries/{id}', 'update');
            Route::delete('/industries/{id}', 'destroy');
            Route::patch('/industries/{id}/toggle-status', 'toggleStatus');
        });

        // Coordinator
        Route::controller(CoordinatorController::class)->group(function () {
            Route::get('/coordinator', 'index')->name('Coordinator');
            Route::post('/coordinator', 'store');
            Route::put('/coordinator/{id}', 'update');
            Route::delete('/coordinator/{id}', 'destroy');
            Route::patch('/coordinator/{id}/reset-password', 'resetPassword');
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

        // Student Documents
        Route::controller(StudentDocumentController::class)->group(function () {
            Route::get('/student-documents/{student}', 'index')->name('student-documents.index');
            Route::post('/student-documents/{student}', 'store')->name('student-documents.store');
            Route::post('/student-documents/assign-types/{student}', 'assignTypes');
            Route::delete('/student-documents/{document}', 'destroy');
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
    });
